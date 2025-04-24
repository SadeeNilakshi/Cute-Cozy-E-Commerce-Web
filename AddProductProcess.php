 <?php
  session_start();
  require "connection.php";

  $email = $_SESSION["user"]["email"];

  $category = $_POST["category"];
  $title = $_POST["title"];
  $qty = $_POST["qty"];
  $cost = $_POST["cost"];
  $dwc = $_POST["dwc"];
  $doc = $_POST["doc"];
  $description = $_POST["desc"];

  if ($category == "0") {
    echo ("Please select a category");
  } else if (empty($title)) {
    echo ("Please Enter Product title that you want to sell");
  } else if (strlen($title <= 100)) {
    echo ("Title should have less than 100 chars");
  } else if (empty($qty)) {
    echo ("Please enter the quantity");
  } else if ($qty == "0" | $qty == "e" | $qty < 0) {
    echo ("Invalid input for Quantity");
  } else if (empty($cost)) {
    echo ("Please Enter Product Price");
  } else if (!is_numeric($cost)) {
    echo ("Please input for Price/ Cost");
  } else if (empty($dwc)) {
    echo ("Please Enter delivery cost for Colombo area");
  } else if (!is_numeric($dwc)) {
    echo ("Please input valid price for Delivery Cost inside Colombo");
  } else if (empty($doc)) {
    echo ("Please Enter delivery cost for out of Colombo");
  } else if (!is_numeric($doc)) {
    echo ("Please input valid Price for Delivery Cost out of Colombo");
  } else if (empty($description)) {
    echo ("Please enter the Description");
  } else {

    $datetime = new DateTime();
    $timezone = new DateTimeZone("Asia/Colombo");
    $datetime->setTimezone($timezone);
    $date = $datetime->format("Y-m-d H:i:s");

    $status = 1;

    Database::insUpdelete("INSERT INTO `product`

    (`price`,`qty`,`description`,`title`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,
    `category_id`,`status_id`,`user_email`)

    VALUES ('" . $cost . "' , '" . $qty . "', '" . $description . "', '" . $title . "', '" . $date . "','" . $dwc . "' ,'" . $doc . "'
    ,'" . $category . "' ,'" . $status . "' , '" . $email . "')");

    $product_id = Database::$connection->insert_id;

    $length = sizeof($_FILES);    //We can get a length of array using sizeof
    if ($length <= 6 && $length > 0) {

      $allowed_img_extension = array("image/jpeg", "image/jpg", "image/png", "image/svg+xml");
      for ($x = 0; $x < $length; $x++) {
        if (isset($_FILES["img" . $x])) {

          $image_file = $_FILES["img" . $x];
          $file_ex = $image_file["type"];

          if (in_array($file_ex, $allowed_img_extension)) {

            $new_img_ex;
            if ($file_ex == "image/jpg") {
              $new_img_ex = ".jpg";
            } else if ($file_ex == "image/jpeg") {
              $new_img_ex = ".jpeg";
            } else if ($file_ex == "image/png") {
              $new_img_ex = ".png";
            } else if ($file_ex == "image/svg+xml") {
              $new_img_ex = ".svg";
            }

            $file_name = "category//Product//" . $title . "_" . $x . "_" . uniqid() . $new_img_ex;
            move_uploaded_file($image_file["tmp_name"], $file_name);

            Database::insUpdelete("INSERT INTO `image`(`code`,`product_id`)
      VALUES ('" . $file_name . "','" . $product_id . "')");
         } else {
          echo ("invalid Image type");
        }
      }
    }

    echo ("Product Saved Successfully");

  } else {
    echo ("Invalid Image count");
  }

}
