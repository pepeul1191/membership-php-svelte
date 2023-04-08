<?php

# api
#### login
$f3->route('GET  /login', '\App\Controllers\LoginController->index');
$f3->route('GET  /login/sign_in', '\App\Controllers\LoginController->index');
$f3->route('GET  /login/reset-password', '\App\Controllers\LoginController->index');
$f3->route('GET  /session', '\App\Controllers\LoginController->session');
$f3->route('POST /login', '\App\Controllers\LoginController->access');
$f3->route('POST /sign_in', '\App\Controllers\LoginController->signIn');
$f3->route('POST /reset_password', '\App\Controllers\LoginController->resetPassword');
$f3->route('GET  /log-out', '\App\Controllers\LoginController->logout');
#### rest - file
$f3->route('POST /upload', '\App\Controllers\FileController->upload');
# error handler
$f3->route('GET  /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
