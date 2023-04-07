<?php

namespace App\Filters;

class BeforeAllFilter
{
  public static function before($f3, $params = null)
  {
    // headers
    header('x-powered-by: PHP');
    header('Server: Ubuntu');
    // http -> https, www, etc
    if($_ENV['FF_ENVIRONMENT'] == 'production'){
      if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://'; // cambiar cuando haya SSL
        //$protocol = 'http://';
      }
      else {
        $protocol = 'http://';
      }
      if($protocol == 'http://'){
        $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
        $url = explode(".", $escaped_url);
        $www_removed = false;
        if($url[0] == 'www'){
            unset($url[0]);
            $escaped_url = implode(".", $url);
            $www_removed = true;
        }
        if($www_removed != false){
            header( "Location: https://" . $escaped_url );
        }else{
            header( "Location: https://" . implode('.',$url ));
        }
      }else{
        $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
        $url = explode(".", $escaped_url);
        $www_removed = false;
        if(strcasecmp($url[0], "www") == 0){
            unset($url[0]);
            $escaped_url = implode(".", $url);
            $www_removed = true;
        }
        if($www_removed){
            header( "Location: https://" . $escaped_url );
        }
      }
    }
  }

  public static function after($f3, $params = null)
  {
    // TODO
  }
}