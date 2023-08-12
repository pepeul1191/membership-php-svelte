<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;

class PackageExerciseController extends BaseController
{
  function __construct()
  {
    parent::__construct();
    parent::loadHelper('orm');
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    SessionTrueApiFilter::before($f3);
    //CsrfApiFilter::before($f3);
  }

  function list($f3)
  {
    // data
    $resp = [];
    $status = 200;
    $packageId = $f3->get('GET.package_id');
    // logic
    try {
      $pdo = \ORM::get_db('app');
      $query = '
          SELECT T.exercise_id, T.exercise, T.body_part_id, T.body_part_name,
          (CASE WHEN (P.position IS NULL) THEN 0 ELSE P.position END) AS position, 
          (CASE WHEN (P.reps IS NULL) THEN 0 ELSE P.reps END) AS reps, 
          (CASE WHEN (P.sets IS NULL) THEN 0 ELSE P.sets END) AS sets
        FROM (
          SELECT 
            E.id AS exercise_id, 
            E.name AS exercise, 
            E.body_part_id, 
            BP.name AS body_part_name, 
            0 AS position, 
            0 AS reps, 
            0 AS sets
          FROM body_parts BP 
          INNER JOIN exercises E ON BP.id = E.body_part_id
        ) T
        LEFT JOIN 
        (
          SELECT 
            E.id AS exercise_id, 
            E.name AS exercise, 
            E.body_part_id, 
            BP.name AS body_part_name,
            IFNULL(PE.position, 0) AS position, 
            IFNULL(PE.reps, 0) AS reps, 
            IFNULL(PE.sets, 0) AS sets
          FROM exercises E 
          INNER JOIN body_parts BP ON BP.id = E.body_part_id
          INNER JOIN packages_exercises PE ON PE.exercise_id = E.id
          WHERE PE.package_id = %d
        ) P 
        ON T.exercise_id = P.exercise_id ORDER BY body_part_id
      ';
      $rs = array();
      foreach($pdo->query(sprintf($query, $packageId)) as $row) {
        array_push($rs, array(
          'exercise_id' => $row['exercise_id'],
          'exercise' => $row['exercise'],
          'body_part_id' => $row['body_part_id'],
          'body_part_name' => $row['body_part_name'],
          'position' => $row['position'],
          'reps' => $row['reps'],
          'sets' => $row['sets'],
        ));
      }
      $resp = json_encode($rs);
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function save($f3)
  {
    // data
    $resp = '';
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'));
    $data = $payload->{'data'};
    $memberId = $payload->{'id'};
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      if(count($data) > 0){
				foreach ($data as &$record) {
          $objectiveId = $record->{'id'};
          $exist = $record->{'exist'};
          $e = \Model::factory('App\\Models\\MemberObjective', 'app')
            ->where('member_id', $memberId)
            ->where('objective_id', $objectiveId)
            ->find_one();
          if($exist == 0){
            if($e != false){
              $e->delete();
            }
          }else{
            if($e == false){
              $n = \Model::factory('App\\Models\\MemberObjective', 'app')->create();
              $n->member_id = $memberId;
              $n->objective_id = $objectiveId;
              $n->save();
            }
          }
        }
      }
      // commit
      \ORM::get_db('app')->commit();
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}