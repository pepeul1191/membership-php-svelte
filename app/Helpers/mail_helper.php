<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendActivationMail()
{
  # TODO
  return null;
}

function mailToUs($data, $f3)
{
  $resp = array(
    'status' => 200,
    'message' => '',
  );
  // data
  $name = $data->{'name'};
  $email = $data->{'email'};
  $phone = $data->{'phone'};
  $comment = $data->{'comment'};
  // load .env
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
  // mail to us
  $layout = require VIEW_PATH . '/mails/mail_to_us.php';
  $logo_url = $f3->get('staticURL') . 'assets/img/mail-logo.png';
  $img_url = $f3->get('staticURL') . 'assets/img/mail-background.jpeg';
  $favicon = $f3->get('staticURL') . 'favicon.png';
  $data_layout = array(
    '%name' => $name, 
    '%email' => $email,
    '%phone' => $phone,  
    '%comment' => $comment, 
    '%logo_url' => $logo_url,
    '%img_url' => $img_url,
    '%base_url' => $f3->get('baseURL'),
    '%favicon' => $favicon,
    '%primary' => $_ENV['PRIMARY'],
    '%secondary' => $_ENV['SECONDARY'],
    '%enterprise_name' => $_ENV['NAME'],
    '%about' => $_ENV['ABOUT'],
    '%adress' => $_ENV['ADRESS'],
    '%phone' => $_ENV['PHONE'],
    '%year' => date('Y'),
  );
  $message = str_replace(
    array_keys($data_layout), 
    array_values($data_layout), 
    $layout
  );
  // send mail
  $mail = new PHPMailer(true);
  try {
    // server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Debugoutput = 'html';
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USER'];
    $mail->Password = $_ENV['MAIL_PASS'];
    $mail->SMTPSecure = 'tls'; // gmail tls, otro ssl
    $mail->SMTPAuth   = true; 
    $mail->Port = $_ENV['MAIL_PORT'];
    // recipients
    $mail->setFrom($_ENV['MAIL_SENDER'], $_ENV['NAME']);
    $mail->addAddress($_ENV['MAIL_US'], $name);     // Add a recipient
    // content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_ENV['NAME'] . ' - Mensaje desde el sitio web';
    $mail->Body = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    // send
    $mail->send();
  } catch (Exception $e) {
    $resp['status'] = 500;
    $resp['message'] = $e->getMessage();
  }
  return $resp;
}

function mailToVisitor($data, $f3)
{
  $resp = array(
    'status' => 200,
    'message' => '',
  );
  // data
  $name = $data->{'name'};
  $email = $data->{'email'};
  // load .env
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
  // mail to visitor
  $layout = require VIEW_PATH . '/mails/mail_to_visitor.php';
  $logo_url = $f3->get('staticURL') . 'assets/img/mail-logo.png';
  $img_url = $f3->get('staticURL') . 'assets/img/mail-background.jpeg';
  $favicon = $f3->get('staticURL') . 'favicon.png';
  $data_layout = array(
    '%name' => $name, 
    '%logo_url' => $logo_url,
    '%img_url' => $img_url,
    '%base_url' => $f3->get('baseURL'),
    '%favicon' => $favicon,
    '%primary' => $_ENV['PRIMARY'],
    '%secondary' => $_ENV['SECONDARY'],
    '%enterprise_name' => $_ENV['NAME'],
    '%about' => $_ENV['ABOUT'],
    '%adress' => $_ENV['ADRESS'],
    '%phone' => $_ENV['PHONE'],
    '%email' => $_ENV['EMAIL'],
    '%message' => $_ENV['MESSAGE'],
    '%year' => date('Y'),
  );
  $message = str_replace(
    array_keys($data_layout), 
    array_values($data_layout), 
    $layout
  );
  // send mail
  $mail = new PHPMailer(true);
  try {
    // server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Debugoutput = 'html';
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USER'];
    $mail->Password = $_ENV['MAIL_PASS'];
    $mail->SMTPSecure = 'tls'; // gmail tls, otro ssl
    $mail->SMTPAuth   = true; 
    $mail->Port = $_ENV['MAIL_PORT'];
    // recipients
    $mail->setFrom($_ENV['MAIL_SENDER'], $_ENV['NAME']);
    $mail->AddReplyTo($_ENV['MAIL_SENDER'], $name);
    $mail->addAddress($email);     // Add a recipient
    // content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_ENV['NAME'] . ' - Gracias por contactarnos';
    $mail->Body = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    // send
    $mail->send();
  } catch (Exception $e) {
    $resp['status'] = 500;
    $resp['message'] = $e->getMessage();
  }
  return $resp;
}