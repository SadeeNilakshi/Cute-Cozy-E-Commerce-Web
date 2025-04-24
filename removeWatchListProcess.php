<?php
require "connection.php";

if(isset($_GET["id"])){

$wid = $_GET["id"];

$watch_Resultset = Database::search("SELECT * FROM `wishlist` WHERE `id` = '".$wid."'");
$watch_num = $watch_Resultset-> num_rows;
$watch_data = $watch_Resultset->fetch_assoc();

$datetime = new DateTime();
$timezone = new DateTimeZone("Asia/Colombo");
$datetime->setTimezone($timezone);
$date = $datetime->format("Y-m-d H:i:s");

if($watch_num == 0){
  echo("Something went wrong Please try again later");
}else{
  Database::insUpdelete("INSERT INTO `recent`(`product_id`,`user_email`,`recent_status`,`removed`) VALUES ('".$watch_data["product_id"]."' , '".$watch_data["user_email"]."','1','".$date."')");

  Database::insUpdelete("DELETE FROM `wishlist` WHERE `id`= '".$wid."'");

  echo("success");
}

}else{
  echo("Please select a Product");
}
?>