<?php

namespace App\Controllers\Access;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Filters\SessionAdminApiFilter;
use App\Libraries\RandomLib;

class UserController extends BaseController
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

  function workerGet($f3)
  {
    SessionAdminApiFilter::before($f3);
    // data
    $resp = [];
    $status = 200;
    $worker_id = $f3->get('GET.worker_id');
    // logic
    try {
      $r = \Model::factory('App\\Models\\User', 'app')->where('worker_id', $worker_id)->find_one();
      if($r == false){
        $status = 404;
        $resp = '';
      }else{
        $resp = json_encode(array(
          'id' => $r->{'id'},
          'last_login' => $r->{'last_login'},
          'user' => $r->{'user'},
        ));
      }
    }catch (\Exception $e) {
      $status = 500;
      $resp = json_encode(['ups', $e->getMessage()]);
    }
    // resp
    http_response_code($status);
    echo $resp;
  }

  function workerUpdate($f3)
  {
    SessionAdminApiFilter::before($f3);
    // helper
    parent::loadHelper('crypto');
    // data
    $resp = '';
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'));
    $id = $payload->{'id'};
    $worker_id = $payload->{'worker_id'};
    $password = $payload->{'password'};
    $user = $payload->{'user'};
    // logic
    \ORM::get_db('app')->beginTransaction();
    try {
      if($id == 'E'){
        // validate user and email must be unique in db
        $tmpUser = \Model::factory('App\\Models\\User', 'app')->where('user', $user)->find_one();
        $tmpWorker = \Model::factory('App\\Models\\Worker', 'app')->where('email', $email)->find_one();
        if($tmpUser == false && $tmpWorker == false){
          $n = \Model::factory('App\\Models\\User', 'app')->create();
          $n->worker_id = $worker_id;
          $n->password = \Cripto::encrypt($password);
          $n->user = $user;
          $n->activation_key = \App\Libraries\RandomLib::stringNumber(20);
          $n->reset_key = \App\Libraries\RandomLib::stringNumber(20);
          $n->save();
          // response data
          $resp = $n->id;
        }else{
          $status = 501;
          $resp = 'No se puede crear usuario porque el nombre de usuario y/o correo están en uso';
        }
      }else{
        $proceed = true;
        // check new user name is unique except himself
        $tmpUser = \Model::factory('App\\Models\\User', 'app')->where('user', $user)->find_one();
        if($tmpUser != false){
          if($tmpUser->id != $id){
            $proceed = false;
          }
        }
        // check new user email is unique except himself
        if($proceed == true){
          $tmpWorker = \Model::factory('App\\Models\\Worker', 'app')->where('email', $email)->find_one();
          if($tmpWorker != false){
            if($tmpWorker->id != $worker_id){
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
          $resp = 'No se puede editar usuario porque el nombre de usuario y/o correo están en uso';
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

  function menu($f3)
  {
    $resp = '';
    $status = 200;
    $role = $_SESSION['role'];
    /*
    {name: 'Home', url: '/admin', active: true, items: []}, 
		{name: 'Recursos', url: '#', active: true, items: [
			{name: 'Trabajadores', url: '/worker', active: true}, 
			{name: 'Puestos de Trabajo', url: '/position', active: true}, 
			{name: 'Tipos de Servicios', url: '/service_type', active: true}, 
			{name: 'Sedes - Lima', url: '/branch/lima', active: false}, 
			{name: 'Sedes - Provincias', url: '/branch/province', active: false}, 
		]}, 
		{name: 'Servicios', url: '/service', active: true, items: []}, 
		{name: 'Incidencias', url: '/admin/service', active: true, items: []}, 
		{name: 'S. Técnicos', url: '/admin/project', active: true, items: []}, 
    */
    if($role == 'admin'){
      $resp = array(
        array('name' => 'Home', 'url' => '/', 'items' => array()),
        array('name' => 'Recursos', 'url' => '#', 'items' => array(
          array('name' => 'Trabajadores', 'url' => '/worker', 'items' => array()), 
          array('name' => 'Puestos de Trabajo', 'url' => '/position', 'items' => array()), 
          array('name' => 'Tipos de Servicios', 'url' => '/service_type', 'items' => array()), 
          array('name' => 'Sedes - Lima', 'url' => '/branch/lima', 'items' => array()), 
          array('name' => 'Sedes - Provincias', 'url' => '/branch/province', 'items' => array()), 
        )),
      );
    }else{
      $resp = array(
        array('name' => 'Home', 'url' => '/', 'items' => array()),
        array('name' => 'Servicios', 'url' => '/service', 'items' => array()), 
        array('name' => 'Incidencias', 'url' => '/admin/service', 'items' => array()), 
        array('name' => 'S. Técnicos', 'url' => '/admin/project', 'items' => array()), 
      );
    }
    // resp
    http_response_code($status);
    echo json_encode($resp);
  }

  function info($f3) 
  {
    // data
    $resp = json_encode([
      'user' => $_SESSION['user'],
      'worker_id' => $_SESSION['worker_id'],
      'names' => $_SESSION['names'],
      'last_names' => $_SESSION['last_names'],
      'role' => $_SESSION['role'],
      'img' => $_SESSION['img'],
    ]);
    $status = 200;
    // resp
    http_response_code($status);
    echo $resp;
  }
}