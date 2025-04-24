<?php

session_start();
require "connection.php";

if (isset($_SESSION["product"])) {

  $product_id = $_SESSION["product"]["id"];

  $qty = $_POST["upqty"];
  $dwc = $_POST["updwc"];
  $doc = $_POST["updoc"];
  $desc = $_POST["updesc"];

  Database::insUpdelete("UPDATE `product` SET `qty` = '" . $qty . "' , `delivery_fee_colombo` = '" . $dwc . "' ,
`delivery_fee_other` = '" . $doc . "' ,`description` = '" . $desc . "' WHERE `id` = '" . $product_id . "'");

  $length = sizeof($_FILES);
  $allowed_img_ex = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
  Database::insUpdelete("DELETE FROM `image` WHERE `product_id` ='" . $product_id . "'");
  if ($length <= 6 && $length > 0) {

    for ($x = 0; $x < $length; $x++) {

      if (isset($_FILES["i" . $x])) {

        $img_file = $_FILES["i" . $x];
        $file_type = $img_file["type"];

        if (in_array($file_type, $allowed_img_ex)) {

          $new_img_ex;

          if ($file_type == "image/jpg") {
            $new_img_ex = ".jpg";
          } else if ($file_type == "image/jpeg") {
            $new_img_ex = ".jpeg";
          } else if ($file_type == "image/png") {
            $new_img_ex = ".png";
          } else if ($file_type == "image/svg+xml") {
            $new_img_ex = ".svg";
          }
          $titleRS = Database::search("SELECT `title` FROM `product` WHERE `id`= '" . $product_id . "' ");
          $title = $titleRS->fetch_assoc();

          $file_name = "category//Product//" . $title["title"] . "_" . $x . "_" . uniqid() . $new_img_ex;
          move_uploaded_file($img_file["tmp_name"], $file_name);

          Database::insUpdelete("INSERT INTO `image` (`code` , `product_id`)
         VALUES ('" . $file_name . "','" . $product_id . "')");
        } else {
          echo ("File Type not allowed ! ");
        }
      }
    }
    echo ("Product has been updated Successfully !!");
  } else {
    echo ("Invalid Image Count");
  }
}
