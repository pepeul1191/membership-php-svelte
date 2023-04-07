<?php

function stylesheetsAdmin($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development': // development
      $stylesheets = [
        $staticURL . 'build/bundle.admin',
      ];
      break;
    case 'production': // production
      $stylesheets = [
        $staticURL . 'build/bundle.admin',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}

function javascriptsAdmin($staticURL)
{
  $javascripts = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development': // development
      $javascripts = [
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/bundle.admin',
      ];
      break;
    case 'production': // production
      $javascripts = [
        $staticURL . 'vendor/bootstrap/bootstrap.bundle.min',
        $staticURL . 'build/bundle.admin.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}