<?php

function stylesheetsIndex($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $stylesheets = [
        $staticURL . 'build/login',
      ];
      break;
    case 'production':
      $stylesheets = [
        $staticURL . 'build/login',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}

function javascriptsIndex($staticURL)
{
  $javascripts = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $javascripts = [
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/login',
      ];
      break;
    case 'production':
      $javascripts = [
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/login.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}