<?php

if($_ENV['FF_ENVIRONMENT'] == 'production'){
  return array(
    'baseURL' => 'https://tickets.softweb.pe/',
    'staticURL' => 'https://tickets.softweb.pe/public/',
    'csrfKey' => 'demo_',
    'csrfValue' => '123_',
  );
}else if($_ENV['FF_ENVIRONMENT'] == 'development'){
  return array(
    'baseURL' => 'http://192.168.1.27:8000/',
    'staticURL' => 'http://192.168.1.27:8000/public/',
    'csrfKey' => '_demo',
    'csrfValue' => '_123',
  );
}
