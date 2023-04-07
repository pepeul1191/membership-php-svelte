<?php

namespace App\Filters;

class SessionAdminApiFilter
{
  public static function before($f3, $params = null)
  {
    if($_ENV['FF_SESSION'] == 'true'){
      $role = $_SESSION['role'];
      $pass = true;
      if($role != null){
        if($role != 'admin'){
          $pass = false;
        }
      }else{
        $pass = false;
      }
      if(!$pass){
        http_response_code(500);
        echo 'HTTP 500 Acceso Prohibido - Necesita ser administrador';
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}