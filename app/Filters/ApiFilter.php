<?php

namespace App\Filters;

class ApiFilter
{
  public static function before($f3, $params = null)
  {
    if($_ENV['FF_API'] == 'true'){
      $status = $_SESSION['status'];
      $pass = true;
      if($status != null){
        if($status != 'active'){
          $pass = false;
        }
      }else{
        $pass = false;
      }
      if($pass){
        $f3->reroute('/admin');
        exit();
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}