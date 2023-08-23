<?php

namespace App\Controllers\Access;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\SessionAdminApiFilter;
use App\Libraries\RandomLib;

class UserMemberController extends BaseController
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

  function findOne($f3, $params)
  {
    // data
    $data = [];
    $status = 200;
    $memberId = $params['memberId'];
    $userMember = \Model::factory('App\\Models\\UserMember', 'app')
                ->where('member_id', $memberId)->find_one();
    if($userMember == false){
      $status = 404;
      $resp = 'member-has-no-user';
    }else{
      $user = \ORM::for_table('users_members', 'app')
                ->table_alias('UM')
                ->select('UM.user_id')
                ->select('UM.member_id')
                ->select('M.email')
                ->select('U.user')
                ->select('U.state')
                ->inner_join('members', array('M.id', '=', 'UM.member_id'), 'M')
                ->inner_join('users', array('U.id', '=', 'UM.user_id'), 'U')
                ->where_equal('member_id', $memberId)
                ->find_one();
      if($user == false){
        $status = 404;
        $resp = 'no-user-created';
      }else{
        $resp = json_encode(array(
          'user_id' => $user->{'user_id'},
          'member_id' => $user->{'member_id'},
          'user' => $user->{'user'},
          'state' => $user->{'state'},
          'email' => $user->{'email'},
          'password' => ($user->{'password'} == '') ? '1111111111' : \App\Libraries\RandomLib::stringNumber(10),
        ));
      }
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function update($f3)
  {
    SessionAdminApiFilter::before($f3);
    // helper
    parent::loadHelper('crypto');
    // data
    $resp = '';
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'));
    $id = $payload->{'id'}; // user_id
    $memberId = $payload->{'member_id'};
    $password = $payload->{'password'};
    $user = $payload->{'user'};
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      $proceed = true;
      // check new user name is unique except himself, but if no user, pass
      if($user != ''){
        $tmpUser = \Model::factory('App\\Models\\User', 'app')->where('user', $user)->find_one();
        if($tmpUser != false){
          if($tmpUser->id != $id){
            $proceed = false;
          }
        }
      }
      // proceed if pass two validations
      if($proceed){
        $e = \Model::factory('App\\Models\\User', 'app')->where('id', $id)->find_one();
        if($password != '1111111111'){
          $e->password = \Cripto::encrypt($password);
        }
        $e->user = $user;
        $e->save();
        $resp = '';
      }else{
        $status = 501;
        $resp = 'No se puede editar usuario del miembro porque el nombre de usuario y/o correo están en uso';
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