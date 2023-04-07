<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Filters\SessionTrueFilter;
use App\Filters\SessionHomeGoLoginFilter;

class HomeController extends BaseController
{
  function __construct()
  {
    parent::__construct();
  }

  function beforeroute($f3) 
  {
    SessionHomeGoLoginFilter::before($f3);
    parent::beforeroute($f3);
    $path = $f3->get('PATH');
    $method = $f3->get('VERB');
    if(
      $path == '/'
      || $path == '/admin/project-type'
      || $path == '/admin/service'
      || $path == '/admin/project'
      || $path == '/admin/project/add'
      || strpos($path, '/admin/project/edit') == 0
    ){
      SessionTrueFilter::before($f3);
    }
  }

  function index($f3) 
  {
    $this->beforeroute($f3);
    parent::loadHelper('admin');
    $f3->mset(array(
      'title' => 'Administrador de Contenido',
      'href' => '/',
      'stylesheets' => stylesheetsAdmin($f3->get('staticURL')),
      'javascripts' => javascriptsAdmin($f3->get('staticURL')),
    ));
    http_response_code(200);
    echo $this->render('admin/index', $locals);
  }
}