<?php

# api
#### login
$f3->route('GET  /login', '\App\Controllers\LoginController->index');
$f3->route('GET  /login/sign_in', '\App\Controllers\LoginController->index');
$f3->route('GET  /login/reset_password', '\App\Controllers\LoginController->index');
$f3->route('GET  /login/change_password/@userId/@resetKey', '\App\Controllers\LoginController->index');
$f3->route('GET  /session', '\App\Controllers\LoginController->session');
$f3->route('GET  /log-out', '\App\Controllers\LoginController->logout');
$f3->route('POST /check_reset_key', '\App\Controllers\LoginController->checkResetKey');
$f3->route('POST /change_password', '\App\Controllers\LoginController->changePassword');
$f3->route('POST /login', '\App\Controllers\LoginController->access');
$f3->route('POST /sign_in', '\App\Controllers\LoginController->signIn');
$f3->route('POST /reset_password', '\App\Controllers\LoginController->resetPassword');
### access - user
$f3->route('GET  /access/user/worker/get', '\App\Controllers\Access\UserController->workerGet');
$f3->route('POST  /access/user/worker/update', '\App\Controllers\Access\UserController->workerUpdate');
$f3->route('GET  /access/user/menu', '\App\Controllers\Access\UserController->menu');
$f3->route('GET  /access/user/info', '\App\Controllers\Access\UserController->info');
#### admin
$f3->route('GET  /admin', '\App\Controllers\AdminController->index');
$f3->route('GET  /admin/member', '\App\Controllers\AdminController->index');
$f3->route('GET  /admin/discipline', '\App\Controllers\AdminController->index');
### admin - discipline
$f3->route('GET  /admin/discipline/list', '\App\Controllers\Admin\DisciplineController->list');
$f3->route('POST /admin/discipline/save', '\App\Controllers\Admin\DisciplineController->save');
### admin - member
$f3->route('GET  /admin/member/list', '\App\Controllers\Admin\MemberController->list');
$f3->route('POST /admin/member/save', '\App\Controllers\Admin\MemberController->save');
#### rest - file
$f3->route('POST /upload', '\App\Controllers\FileController->upload');
# error handler
$f3->route('GET  /error/access/@code', '\App\Controllers\ErrorController->access');
$f3->set('ONERROR', include_once 'on_error.php');
