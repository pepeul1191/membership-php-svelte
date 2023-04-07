<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\CsrfFormFilter;
use App\Filters\SessionFalseFilter;

class MailController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    parent::beforeroute($f3);
    CsrfFormFilter::before($f3);
    parent::loadHelper('mail');
  }

  function mail($f3) 
  {
    // data
    $resp = [];
    $status = 200;
    $payload = json_decode(file_get_contents('php://input'));
    // response
    $resp1 = mailToUs($payload, $f3);
    if($resp1['status'] == 200){
      $resp2 = mailToVisitor($payload, $f3);
      if($resp2['status'] == 200){
        $resp = 'ok';
      }else{
        $resp = json_encode($resp2);
        $status = 500;
      }
    }else{
      $resp = json_encode($resp1);
      $status = 500;
    }
    // resp
    http_response_code(200);
    echo $resp;
  }
}
