<?php
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["e"])){
  $email = $_POST["e"];

  $admin_Resultset = Database::search("SELECT * FROM `admin` WHERE `email` = '".$email."'");

  $admin_num = $admin_Resultset -> num_rows;
  if($admin_num >0){

    $code = uniqid();

    Database::insUpdelete("UPDATE `admin` SET `verification_code` = '".$code."' WHERE `email` = '".$email."'");

        // email code
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sadeeshanilakshi25@gmail.com';
        $mail->Password = 'jpzvibdzhgoqdegt';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('sadeeshanilakshi25@gmail.com', 'Admin Verification');
        $mail->addReplyTo('sadeeshanilakshi25@gmail.com', 'Admin Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Cute & Cozy Admin Login verification_code';
        $bodyContent = '<h1 style="color:#0073e6">Your Verification Code is ' . $code . '</h1>';
        $mail->Body    = $bodyContent;

        if($mail -> send()){
          echo "success";
        }else{
          echo 'Verification code sending failed';
        }

  }else{
    echo("you are not a valid User");
  }

}else{
  echo("Email Field should not be empty");
}
