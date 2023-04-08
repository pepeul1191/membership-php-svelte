<?php

function stylesheetsAdmin($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development': // development
      $stylesheets = [
        $staticURL . 'build/admin',
      ];
      break;
    case 'production': // production
      $stylesheets = [
        $staticURL . 'build/admin',
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
        $staticURL . 'build/admin',
      ];
      break;
    case 'production': // production
      $javascripts = [
        $staticURL . 'build/admin.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}