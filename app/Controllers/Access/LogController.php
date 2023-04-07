<?php

namespace App\Controllers\Access;

use App\Controllers\BaseController;
use App\Filters\SessionTrueApiFilter;
use App\Libraries\RandomLib;

class LogController extends BaseController
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
}