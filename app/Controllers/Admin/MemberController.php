<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Libraries\RandomLib;

class MemberController extends BaseController
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
      $stmt = \Model::factory('App\\Models\\Member', 'app');
      // filter member
      if(
        $f3->get('GET.name') != null
      ){
        $name = $f3->get('GET.name');
        $stmt = $stmt->where_raw('(names LIKE "%0' . $name . '%") OR (last_names LIKE "%' . $name . '%")');
      }
      if(
        $f3->get('GET.code') != null
      ){
        $stmt = $stmt->where_like('code', '%' . $f3->get('GET.code') . '%');
      }
      if(
        $f3->get('GET.email') != null
      ){
        $stmt = $stmt->where_like('email', '%' . $f3->get('GET.email') . '%');
      }
      // pages with final statement
      $pages = ceil(
        $stmt->count()
        / $f3->get('GET.step')
      );
      // pagination
      if(
        $f3->get('GET.step') != null && 
        $f3->get('GET.page') != null
      ){
        $offset = ($f3->get('GET.page') - 1) * $f3->get('GET.step');
        $stmt = $stmt->offset($offset)->limit($f3->get('GET.step'));
      }
      $rs = $stmt->find_array();
      $resp = json_encode(array(
        'list' => $rs,
        'pages' => $pages,
      ));
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
				  $n = \Model::factory('App\\Models\\Member', 'app')->create();
					$n->names = $new['names'];
          $n->last_names = $new['last_names'];
          $n->code = $new['code'];
          $n->email = $new['email'];
          $n->phone = $new['phone'];
          $n->medical_obs = $new['medical_obs'];
          $n->discipline_id = $new['discipline_id'];
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
          $e = \Model::factory('App\\Models\\Member', 'app')->find_one($edit['id']);
					$e->names = $edit['names'];
          $e->last_names = $edit['last_names'];
          $e->code = $edit['code'];
          $e->email = $edit['email'];
          $e->phone = $edit['phone'];
          $e->medical_obs = $edit['medical_obs'];
          $e->discipline_id = $edit['discipline_id'];
					$e->save();
        }
      }
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\Member', 'app')->find_one($delete['id']);
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