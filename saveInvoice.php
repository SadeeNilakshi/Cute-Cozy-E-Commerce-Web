<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $o_id =  $_POST["o"];
    $p_id =  $_POST["i"];
    $mail =  $_POST["m"];
    $amount =  $_POST["a"];
    $qty =  $_POST["q"];

    $product_Resultset = Database::search("SELECT * FROM `product` WHERE `id`= '" . $p_id . "' ");
    $product_data = $product_Resultset->fetch_assoc();

    $current_qty = $product_data["qty"];
    $new_qty = $current_qty - $qty;

    Database::insUpdelete("UPDATE `product` SET `qty` = '" . $new_qty . "' WHERE `id` = '" . $p_id . "'");

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::insUpdelete("INSERT INTO `invoice` (`order_id`, `date` , `total`,  `d_status`, `iqty`, `product_id`, `user_email`,`remove_status`) VALUES
('" . $o_id . "','" . $date . "','" . $amount . "','0','" . $qty . "', '" . $p_id . "','" . $mail . "','1')");

    echo ("success");
}
