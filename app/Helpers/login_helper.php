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
        $staticURL . 'build/login',
      ];
      break;
    case 'production':
      $javascripts = [
        $staticURL . 'build/login.min',
      ];
      break;
    default:
      break;
  }
  return $javascripts;
}

function validateEmail($email) {
  // Define a regular expression pattern for valid email addresses
  $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

  // Use the preg_match function to test if the email matches the pattern
  if (preg_match($pattern, $email)) {
    return true; // The email is valid
  } else {
    return false; // The email is invalid
  }
}