<?php
require "connection.php";

if(isset($_GET["id"])){

$puid = $_GET["id"];

$purchasing_Resultset = Database::search("SELECT * FROM `invoice` WHERE `id` = '".$puid."'");
$purchasing_num = $purchasing_Resultset-> num_rows;
$purchasing_data = $purchasing_Resultset->fetch_assoc();

if($purchasing_num == 0){
  echo("Something went wrong Please try again later");
}else{
  Database::insUpdelete("UPDATE `invoice` SET `remove_status` = '2' WHERE `id` = '".$puid."'");

  echo("success");
}

}else{
  echo("Please select a Product");
}
?>