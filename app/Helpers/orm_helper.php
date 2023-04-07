<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ORM::configure('mysql:host=localhost;port=3306;dbname=' . $_ENV['DB_NAME'] . ';charset=utf8;', null, 'app');
ORM::configure('username', $_ENV['DB_USER'], 'app');
ORM::configure('password', $_ENV['DB_PASS'], 'app');
ORM::configure('return_result_sets', true);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
ORM::configure('error_mode', PDO::ERRMODE_WARNING);
ORM::configure('logging', true);
