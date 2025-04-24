<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
  if (isset($_GET["id"])) {

    $email = $_SESSION["user"]["email"];
    $pid = $_GET["id"];

    $watchlist_Resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`='" . $pid . "' AND
    `user_email`= '" . $email . "'");

    $watchlist_num = $watchlist_Resultset->num_rows;

    if ($watchlist_num == 1) {

      $watchlist_data = $watchlist_Resultset->fetch_assoc();
      $list_id = $watchlist_data["id"];

      Database::insUpdelete("DELETE FROM `wishlist` WHERE `id` = '" . $list_id . "'");
      echo ("Removed");
    
    } else {

      Database::insUpdelete("INSERT INTO `wishlist`(`product_id`, `user_email`) VALUES ('" . $pid . "' , '" . $email . "')");
      echo ("added");
    }
  } else {
    echo ("Something Went Wrong");
  }
} else {
  echo ("Please Login First");
}

?>
