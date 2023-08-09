<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class ExerciseController extends BaseController
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
    // logic
    try {
      $stmt = \Model::factory('App\\Models\\Exercise', 'app');
      // filter member
      if(
        $f3->get('GET.name') != null
      ){
        $name = $f3->get('GET.name');
        $stmt = $stmt->where_like('name', '%' . $name . '%');
      }
      if(
        $f3->get('GET.body_part_id') != null
      ){
        $bodyPartId = $f3->get('GET.body_part_id');
        $stmt = $stmt->where_raw('body_part_id = ' . $bodyPartId);
      }
      // execute query
      $resp = json_encode($stmt->find_array());
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
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'), true);
    $createdIds = [];
    $news = $payload['news'];
		$edits = $payload['edits'];
    $deletes = $payload['deletes'];
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      // news
      if(count($news) > 0){
				foreach ($news as &$new) {
				  $n = \Model::factory('App\\Models\\Exercise', 'app')->create();
					$n->name = $new['name'];
          $n->image_url = $new['image_url'];
          $n->video_url = $new['video_url'];
          $n->body_part_id = intval($new['body_part_id']);
					$n->save();
				  $temp = [];
				  $temp['tempId'] = $new['id'];
	        $temp['newId'] = $n->id;
	        array_push($createdIds, array(
            'tmp' => $new['id'],
            'id' => $n->id,
          ));
				}
      }
      // edits
      if(count($edits) > 0){
				foreach ($edits as &$edit) {
          $e = \Model::factory('App\\Models\\Exercise', 'app')->find_one($edit['id']);
					$e->name = $edit['name'];
          $e->image_url = $edit['image_url'];
          $e->video_url = $edit['video_url'];
          $e->body_part_id = $edit['body_part_id'];
					$e->save();
        }
      }
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\Exercise', 'app')->find_one($delete['id']);
			    $d->delete();
				}
      }
      // commit
      \ORM::get_db('app')->commit();
      // response data
      $resp = json_encode($createdIds);
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}