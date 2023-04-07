<?php

  require 'vendor/autoload.php';
  require 'app/Helpers/crypto_helper.php';

  $tokenToDecrypt = 'c1N6MjdjUU9KczNINUk5b2pYOVRsQT09';
  $tokenToEncrypt = 'Li85q2HfCZ';
  $key = Cripto::generateKey();
  # var_dump($key);
  $tokenencrypt = Cripto::encrypt($tokenToEncrypt);
  # var_dump($tokenencrypt);
  $tokendecrypt = Cripto::decrypt($tokenToDecrypt);
  var_dump($tokendecrypt);
?>