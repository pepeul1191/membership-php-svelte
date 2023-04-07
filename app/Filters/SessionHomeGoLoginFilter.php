<?php

namespace App\Filters;

class SessionHomeGoLoginFilter
{
  public static function before($f3, $params = null)
  {
    if($_ENV['FF_SESSION'] == 'true'){
      $status = $_SESSION['status'];
      $pass = true;
      if($status != null){
        if($status != 'active'){
          $pass = false;
        }
      }else{
        $pass = false;
      }
      $path = $f3->get('PATH');
      if(!$pass && $path == '/'){
        $f3->reroute('/login');
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}