<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class MembershipPackageController extends BaseController
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
    $membershipId = $f3->get('GET.membership_id');
    // logic
    try {
      $rs = \Model::factory('App\\Models\\Package', 'app')
        ->where_equal('membership_id', $membershipId)
        ->find_array();
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
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'), true);
    $createdIds = [];
    $news = $payload['news'];
		$edits = $payload['edits'];
    $deletes = $payload['deletes'];
    $memberShipId = $payload['extra']['membership_id'];
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      // news
      if(count($news) > 0){
				foreach ($news as &$new) {
				  $n = \Model::factory('App\\Models\\Package', 'app')->create();
          $n->name = $new['name'];
          $n->membership_id = $memberShipId;
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
          // edit
          $e = \Model::factory('App\\Models\\Package', 'app')->find_one($edit['id']);
					$e->name = $edit['name'];
					$e->save();
	        array_push($createdIds, array(
            'tmp' => $edit['id'],
            'id' => $e->id,
          ));
					$e->save();
        }
      }
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\Package', 'app')->find_one($delete['id']);
			    $d->delete();
				}
      }
      // commit
      \ORM::get_db('app')->commit();
      // response data
      $resp = json_encode($createdIds);
    }catch (\Exception $e) {
      $status = ($status == 200) ? 500 : $status;
      $resp = json_encode($e->getMessage());
    }
    // resp
    http_response_code($status);
    echo $resp;
  }
}