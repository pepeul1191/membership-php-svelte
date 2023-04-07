<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Cripto
{
  private static $encryptMethod = "AES-256-CBC";

  public static function encrypt($data)
  {
    # keys from .env
    $secretKey = $_ENV['CRYPTO_KEY'];
    $secretIv = $_ENV['CRYPTO_DOM'];
    # encrypt
    $key = hash('sha256', $secretKey);
    $iv = substr(hash('sha256', $secretIv), 0, 16);
    $result = openssl_encrypt($data, self::$encryptMethod, $key, 0, $iv);
    return $result = base64_encode($result);
  }
  
  public static function decrypt($data)
  {
    # keys from .env
    $secretKey = $_ENV['CRYPTO_KEY'];
    $secretIv = $_ENV['CRYPTO_DOM'];
    # encrypt
    $key = hash('sha256', $secretKey);
    $iv = substr(hash('sha256', $secretIv), 0, 16);
    $result = openssl_decrypt(base64_decode($data), self::$encryptMethod, $key, 0, $iv);
    return $result;
  }

  public static function generateKey()
  {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($chars);
    $randomString = '';
    for ($i = 0; $i < 22; $i++) {
      $randomString .= $chars[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}

?>