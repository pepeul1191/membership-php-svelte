<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\CsrfFormFilter;
use App\Filters\SessionFalseFilter;
use App\Libraries\RandomLib;

class LoginController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    $path = $f3->get('PATH');
    $method = $f3->get('VERB');
    if($path == '/login' && $method == 'GET'){
      SessionFalseFilter::before($f3);
    }else if($path == '/login' && $method == 'POST'){
      CsrfFormFilter::before($f3);
    }
  }

  function index($f3) 
  {
    // session
    $_SESSION['csrfKey'] = $f3->get('csrfKey');
    $_SESSION['csrfValue'] = $f3->get('csrfValue');
    // response
    parent::loadHelper('login');
    $f3->mset(array(
      'title' => 'Inicio',
      'href' => '/login',
      'stylesheets' => stylesheetsIndex($f3->get('staticURL')),
      'javascripts' => javascriptsIndex($f3->get('staticURL')),
    ));
    http_response_code(200);
    echo $this->render('login/index', $locals);
  }

  function access($f3, $args)
  {
    // helper
    parent::loadHelper('crypto');
    parent::loadHelper('orm');
    // request
    $payload = $f3->get('POST');
    $user = $payload['user'];
    $password = $payload['password'];
    if($user == 'admin' && $password == '123'){ // LBF6$2ACc?*4t;(t
      $_SESSION['csrfKey'] = \App\Libraries\RandomLib::lowerStringNumber(20);
      $_SESSION['csrfValue'] = \App\Libraries\RandomLib::lowerStringNumber(30);
      $_SESSION['status'] = 'active';
      $_SESSION['role'] = 'admin';
      $_SESSION['user'] = $user;
      $_SESSION['name'] = 'Antergo Design';
      $_SESSION['img'] = $f3->get('staticURL') . 'assets/img/default-user.png';
      $_SESSION['time'] = date('Y-m-d H:i:s');
      $f3->reroute('/');
    }else{
      $password = \Cripto::encrypt($password);
      $tmpUser = \Model::factory('App\\Models\\User', 'app')->where(array('user' => $user,'password' => $password))->find_one();
      if($tmpUser != false){
        // get worker
        $worker = \Model::factory('App\\Models\\Worker', 'app')->where('id', $tmpUser->worker_id)->find_one();
        // set session
        $_SESSION['csrfKey'] = \App\Libraries\RandomLib::lowerStringNumber(20);
        $_SESSION['csrfValue'] = \App\Libraries\RandomLib::lowerStringNumber(30);
        $_SESSION['status'] = 'active';
        $_SESSION['role'] = 'worker';
        $_SESSION['user'] = $user;
        $_SESSION['worker_id'] = $worker->id;
        $_SESSION['names'] = $worker->names;
        $_SESSION['last_names'] = $worker->last_names;
        $_SESSION['img'] = $f3->get('staticURL') . 'assets/img/default-user.png';
        $_SESSION['time'] = date('Y-m-d H:i:s');
        $f3->reroute('/');
      }else{ 
        $f3->reroute($f3->get('PATH') . '?error=user-pass-mismatch');
      }
    }
  }

  function signIn($f3, $args)
  {
    // helper
    parent::loadHelper('crypto');
    parent::loadHelper('orm');
    parent::loadHelper('login');
    // request
    $payload = $f3->get('POST');
    $user = $payload['user'];
    $password = $payload['password'];
    $password2 = $payload['password2'];
    $email = $payload['email'];
    if( // check all field al filled
      $user == '' || $password == '' || $password2 == '' || $email == ''
    ){
      http_response_code(500);
      $f3->reroute($f3->get('PATH') . 'login/sign_in?error=fill-all');
    }else{
      if(validateEmail($email) == false){ // valid email
        http_response_code(500);
        $f3->reroute('/login/sign_in?error=email-invalid');
      }else{
        if($password != $password2){ // equlas password
          http_response_code(500);
          $f3->reroute('/login/sign_in?error=passwords-mismatch');
        }else{
          // validate if user name not exist in users
          $existUser = \Model::factory('App\\Models\\User', 'app')
            ->where('user', $user)->find_one();
          if($existUser != false){
            http_response_code(500);
            $f3->reroute('/login/sign_in?error=user-named-used');
          }else{
            // validate email member    
            $member = \Model::factory('App\\Models\\Member', 'app')
              ->where('email', $email)->find_one();
            if($member == false){
              http_response_code(500);
              $f3->reroute('/login/sign_in?error=not-a-member-email');  
            }else{
              // validate if member id is asociated with a user
              $memberId = $member->{'id'};
              $userMember = \Model::factory('App\\Models\\UserMember', 'app')
                ->where('member_id', $memberId)->find_one();
              if($userMember != false){
                http_response_code(500);
                $f3->reroute('/login/sign_in?error=email-with-member');  
              }else{
                // create new user with the member and then members_users
                $nUser = \Model::factory('App\\Models\\User', 'app')->create();
                $nUser->user = $user;
                $nUser->password = \Cripto::encrypt($password);
                $nUser->reset_key = '';
                $nUser->activation_key = \App\Libraries\RandomLib::stringNumber(20);
                $nUser->save();
                $nUserMember = \Model::factory('App\\Models\\UserMember', 'app')->create();
                $nUserMember->member_id = $memberId;
                $nUserMember->user_id = $nUser->{'id'};
                $nUserMember->save();
                // send activation email
                parent::loadHelper('mail');
                activationMail($f3, $member, $nUser->activation_key);
                // ok message
                http_response_code(200);
                $f3->reroute('/login?success=activate-account');  
              }
            }
          }
        }
      }
    }
  }

  function session($f3)
  {
    var_dump($_SESSION);
  }

  function logout($f3)
  {
    $_SESSION = array();
    $f3->reroute('/login');
  }
}