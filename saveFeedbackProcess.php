<?php

session_start();
include "connection.php";

if (isset($_SESSION["user"])) {

    $mail = $_SESSION["user"]["email"];
    $pid = $_POST["pid"];
    $type = $_POST["t"];
    $feed = $_POST["f"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if (empty($feed)) {
        echo ("Please Review your product");
    } else if ($type == 0) {
        echo ("Please Rate this product");
    } else {
        Database::insUpdelete("INSERT INTO `feedback`(`type`,`feedback`,`date`,`product_id`,`user_email`) VALUES
    ('" . $type . "','" . $feed . "','" . $date . "','" . $pid . "','" . $mail . "')");

        echo ("Review Added Successfully");
    }
}
