<?php

function stylesheetsAccess($staticURL)
{
  $stylesheets = [];
  switch ($_ENV['FF_ENVIRONMENT']) {
    case 'development':
      $stylesheets = [
        $staticURL . 'build/error',
      ];
      break;
    case 'production':
      $stylesheets = [
        $staticURL . 'build/erro.min',
      ];
      break;
    default:
      break;
  }
  return $stylesheets;
}
