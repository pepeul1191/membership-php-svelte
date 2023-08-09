<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;

class MemberObjectiveController extends BaseController
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
    $memberId = $f3->get('GET.member_id');
    // logic
    try {
      $pdo = \ORM::get_db('app');
      $query = '
        SELECT T.id AS id, T.name AS name, (CASE WHEN (P.exist = 1) THEN 1 ELSE 0 END) AS exist FROM
        (
          SELECT id, name, 0 AS exist FROM objectives
        ) T 
        LEFT JOIN 
        (
          SELECT PT.id, PT.name, 1 AS exist FROM 
          objectives PT INNER JOIN members_objectives PTP ON
          PT.id = PTP.objective_id
          WHERE PTP.member_id = %d
        ) P 
        ON P.id = T.id
      ';
      $rs = array();
      foreach($pdo->query(sprintf($query, $memberId)) as $row) {
        array_push($rs, array(
          'id' => $row['id'],
          'name' => $row['name'],
          'exist' => $row['exist'],
        ));
      }
      if($rs == false){
        $resp = 'Miembro no está registrado.';
        $status = 404;
      }else{
        $resp = json_encode($rs);
      }
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