<?php

function stylesheetsHome($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development': // development
      $stylesheets = [
        $staticURL . 'build/bundle.app',
        $staticURL . 'build/vendor',
        $staticURL . 'assets/css/styles',
      ];
      break;
    case 'production': // production
      $stylesheets = [
        $staticURL . 'build/site.min',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}

function javascriptsHome($staticURL)
{
  $javascripts = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development': // development
      $javascripts = [
        $staticURL . 'build/bundle.app',
        $staticURL . 'build/vendor',
        $staticURL . 'assets/js/site',
      ];
      break;
    case 'production': // production
      $javascripts = [
        $staticURL . 'build/site.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}

function enterpriseData()
{
  return json_encode(array(
    'facebook' => $_ENV['FACEBOOK'],
    'instagram' => $_ENV['INSTAGRAM'],
    'whastapp' => $_ENV['WHASTAPP'],
    'email' => $_ENV['EMAIL_SITE'],
    'phone' => $_ENV['PHONE'],
  ));
}