<?php

require "connection.php";

if (isset($_GET["id"])) {
    $cart_id = $_GET["id"];

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `id` ='" . $cart_id . "'");
    $cart_data = $cart_rs->fetch_assoc();

    $user = $cart_data["user_email"];
    $product = $cart_data["product_id"];

    $datetime = new DateTime();
    $timezone = new DateTimeZone("Asia/Colombo");
    $datetime->setTimezone($timezone);
    $date = $datetime->format("Y-m-d H:i:s");

    Database::insUpdelete("INSERT INTO `recent`(`product_id`,`user_email`,`recent_status`,`removed`) VALUES ('" . $cart_data["product_id"] . "' , '" . $cart_data["user_email"] . "','1','" . $date . "')");
    Database::insUpdelete("DELETE FROM `cart` WHERE `id` = '" . $cart_id . "'");

    echo ("successfuly Removed");
} else {
    echo ("something Went Wrong");
}
