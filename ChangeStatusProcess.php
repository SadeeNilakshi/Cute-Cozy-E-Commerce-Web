<?php

require "connection.php";

$product = $_GET["p"];

$product_Resultset = Database::search
("SELECT * FROM `product`
WHERE `id` = '".$product."';");

$product_num = $product_Resultset -> num_rows;

if($product_num == 1){
  $product_data = $product_Resultset -> fetch_assoc();
  $status = $product_data["status_id"];

  if($status == 1){

    Database::insUpdelete("UPDATE `product` 
    SET `status_id` = '2'
    WHERE  `id` = '".$product."';");

    echo("Product Activated");

  }else if($status == 2){

    Database::insUpdelete("UPDATE `product` 
    SET `status_id` = '1'
    WHERE  `id` = '".$product."';");

    echo("Product Deactivated");

  }

}else{
  echo("Something went wrong please try again later!!!");
}

?>