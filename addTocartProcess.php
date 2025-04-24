<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
  if (isset($_GET["id"])) {

    $email = $_SESSION["user"]["email"];
    $pid = $_GET["id"];

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $pid . "' AND `user_email`='" . $email . "'");
    $cart_num = $cart_rs->num_rows;

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
    $product_data = $product_rs->fetch_assoc();
    $product_qty = $product_data["qty"];

    if ($cart_num == 1) {
      
      $cart_data = $cart_rs->fetch_assoc();
      $current_qty = $cart_data["qty"];
      $new_qty = (int)$current_qty + 1;

      if ($product_qty >= $new_qty) {

        Database::insUpdelete("UPDATE `cart` SET `qty`='" . $new_qty . "' WHERE `product_id` = '" . $pid . "' AND `user_email`='" . $email . "'");
        echo ("product Updated");
      } else {
        echo ("Invalid Quantity");
      }
    } else {
      Database::insUpdelete("INSERT INTO `cart`(`product_id`,`user_email`,`qty`) VALUES ('" . $pid . "' , '" . $email . "', '1')");
      echo ("Product Saved Successfully");
    }
  } else {
    echo ("something went wrong");
  }
} else {
  echo ("Please Sign In or Register");
}
