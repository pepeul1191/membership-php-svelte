<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\CsrfApiFilter;

class CustomException extends \Exception {}

class MemberMembershipController extends BaseController
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
      $rs = \ORM::for_table('memberships', 'app')
        ->select('memberships.id')
        ->select('memberships.beginning')
        ->select('memberships.ending')
        ->select('memberships.membership_state_id')
        ->select('membership_states.name', 'membership_state_name')
        ->inner_join('membership_states', array('membership_states.id', '=', 'memberships.membership_state_id'))
        ->where_equal('memberships.member_id', $memberId)
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
    $memberId = $payload['extra']['member_id'];
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      // news
      if(count($news) > 0){
				foreach ($news as &$new) {
				  $n = \Model::factory('App\\Models\\Membership', 'app')->create();
          // beginning date
          $beginningTimestamp = strtotime($new['beginning']);
          $beginningDate = new \DateTime();
          $beginningDate->setTimestamp($beginningTimestamp);
          $beginningDate->format('Y-m-d');
          // ending date
          $endingTimestamp = strtotime($new['ending']);
          $endingDate = new \DateTime();
          $endingDate->setTimestamp($endingTimestamp);
          $endingDate->format('Y-m-d');
          // validate ending after beginning
          if($beginningDate >= $endingDate){
            $status = 501;
            throw new CustomException('La fecha de inicio tiene que ser antes que la fecha de fin. Los cambios realizados no han sido grabados.');
          }
          // create
					$n->beginning = date('Y-m-d', strtotime($new['beginning']));
          $n->ending = date('Y-m-d', strtotime($new['ending']));
          $n->membership_state_id = 1;
          $n->member_id = $memberId;
					$n->save();
				  $temp = [];
				  $temp['tempId'] = $new['id'];
	        $temp['newId'] = $n->id;
	        array_push($createdIds, array(
            'tmp' => $new['id'],
            'id' => $n->id,
            'membership_state_name' => 'ACTIVO'
          ));
				}
      }
      // edits
      if(count($edits) > 0){
				foreach ($edits as &$edit) {
          // beginning date
          $beginningTimestamp = strtotime($edit['beginning']);
          $beginningDate = new \DateTime();
          $beginningDate->setTimestamp($beginningTimestamp);
          $beginningDate->format('Y-m-d');
          // ending date
          $endingTimestamp = strtotime($edit['ending']);
          $endingDate = new \DateTime();
          $endingDate->setTimestamp($endingTimestamp);
          $endingDate->format('Y-m-d');
          // validate ending after beginning
          if($beginningDate >= $endingDate){
            $status = 501;
            throw new CustomException('La fecha de inicio tiene que ser antes que la fecha de fin. Los cambios realizados no han sido grabados.');
          }
          // edit
          $e = \Model::factory('App\\Models\\Membership', 'app')->find_one($edit['id']);
					$e->beginning = date('Y-m-d', strtotime($edit['beginning']));
          $e->ending = date('Y-m-d', strtotime($edit['ending']));
					$e->save();
	        array_push($createdIds, array(
            'tmp' => $edit['id'],
            'id' => $e->id,
            'membership_state_name' => 'ACTIVOXD'
          ));
					$e->save();
        }
      }
      // deletes
      if(count($deletes) > 0){
				foreach ($deletes as &$delete) {
			    $d = \Model::factory('App\\Models\\Membership', 'app')->find_one($delete['id']);
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