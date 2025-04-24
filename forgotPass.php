<?php
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";


use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["email2"])) {

  $email = $_GET["email2"];

  $resultSet = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "';");
  $num = $resultSet->num_rows;

  if ($num == 1) {
    $code = uniqid();

    Database::insUpdelete("UPDATE `user` SET `verification_code` = '" . $code . "' WHERE `email` = '" . $email . "';");

    // email code
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sadeeshanilakshi25@gmail.com';
    $mail->Password = 'jpzvibdzhgoqdegt';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('sadeeshanilakshi25@gmail.com', 'Reset Password');
    $mail->addReplyTo('sadeeshanilakshi25@gmail.com', 'Reset Password');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Do you Reset your Password in Cute & Cozy online platform';
    $bodyContent = '<h1 style="color:#D10024">Here is your Verification Code ' . $code . '</h1>';
    $mail->Body    = $bodyContent;


    if($mail -> send()){
      echo "success";
    }else{
      echo 'Verification code sending failed';
    }

  } else {
    echo ("Invalid Email Address");
  }
}
