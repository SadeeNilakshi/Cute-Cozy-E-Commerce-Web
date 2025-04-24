<!DOCTYPE html>
<html>
<?php
require "connection.php";
session_start();
if (isset($_SESSION["user"])) {
    $umail = $_SESSION["user"]["email"];

    $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `user_email`='" . $umail . "' AND `remove_status` ='1'");
    $invoice_num = $invoice_rs->num_rows;
?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Purchasing History | Cute & Cozy</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />


        <!-- Slick -->
        <link type="text/css" rel="stylesheet" href="css/slick.css" />
        <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="css/font-awesome.min.css">

        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="css/style.css" />

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap-icons.css" />


        <link rel="icon" href="resources/logo.png" />
    </head>

    <body style="background-size: cover;">
        <?php require "header.php"; ?>

        <div class="container-fluid vh-100">
            <div class="row">
                <div class="col-12  d-flex justify-content-center vh-100">
                    <!-- BREADCRUMB -->
                    <div id="breadcrumb" class="section" style="height:80px; background-color: rgba(43, 45, 66, 0.91);">
                        <!-- container -->
                        <div class="container">
                            <!-- row -->
                            <div class="row  bread">
                                <div class="col-md-3 breadcrumb-resp" style="margin-top: 20px;">
                                    <ul class="breadcrumb-tree">
                                        <li><a href="home.php">Home</a></li>
                                        <li><a href="purchasingHistory.php">Purchasing History</a></li>
                                    </ul>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6 wishlist" style="display: flex; justify-content: center; margin-top: 18px;">
                                    <h2 class="f3 " style="font-weight:normal; color: white; text-wrap: nowrap;">Purchasing History</h2>
                                    <a href="#" style="font-size: 24px; margin-left: 5px; color: #D10024;"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- /row -->
                        </div>
                        <!-- /container -->
                    </div>
                    <!-- /BREADCRUMB -->

                </div>

            </div>
            <?php
            if ($invoice_num == 0) {
            ?>
                <!-- empty view -->
                <div class="col-12 ">
                    <div class="row">
                        <div class="col-12 empty-purchasing-history"></div><br>
                        <div class="col-12 text-center">
                            <label class="form-label f" style="font-size: 22px; font-weight:normal;">You have not purchased any item yet.
                        </div>
                        <div class="col-12 text-center">
                            <label class="form-label f" style="font-size: 18px; font-weight: lighter;">Check back after your next shopping trip!
                        </div><br>
                        <div class="offset-4 col-12 d-grid mb-3" style="display: flex; justify-content: center;">
                            <a class="primary-shop-btn cta-btn" href="home.php">Shop now</a>
                        </div><br>
                    </div>
                </div>
                <!-- empty view -->
            <?php
            } else {
            ?>
                <!-- product view -->
                <div class="col-12 col-mb-12  product">
                    <div class="row">
                        <div class="col-12 purchasing-top-bar" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div class="row" style="display: flex; flex-direction: row; width: 95%; height: 15%; background-color: #D10024; margin-bottom: 20px; border-radius: 10px;">
                                <div class="col-1" style="width: 5%; display: flex; justify-content: center; align-items: center; color: white;">
                                    <label class="form-label f4">#</label>
                                </div>
                                <div class="col-3" style="width: 50%; display: flex; justify-content: center; align-items: center; color: white; ">
                                    <label class="form-label f4"> Order Details</label>
                                </div>
                                <div class="col-3" style="width: 30%; display: flex; justify-content: center; align-items: center; color: white;">
                                    <label class="form-label f4">Shipping Details</label>
                                </div>
                                <div class="col-3" style="width: 15%; display: flex; justify-content: center; align-items: center;">
                                    <label class="form-label f4"></label>
                                </div>
                            </div>
                        </div>

                        <?php
                        for ($x = 0; $x < $invoice_num; $x++) {
                            $invoice_data = $invoice_rs->fetch_assoc();
                        ?>
                            <div class="col-12 purchase-large" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div class="row purchasing-table" style="display: flex; flex-direction: row; width: 95%; height: 275px; background-color: #2B2D42; margin-bottom: 20px; border-radius: 10px;">
                                    <div class="col-12" style="width: 5%; display: flex; justify-content: center; align-items: center; background-color: #D10024; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                        <label class="form-label f4" style="color: #ffffff;"></label>
                                    </div>
                                    <div class="col-3" style="width: 55%; ">
                                        <div class="" style=" display: flex; justify-content: start; align-items: start; ">
                                            <div class="product-purchase" style="display:flex; flex-direction:row; align-items: start; ">
                                                <div class="product-image" style="width: 270px; height: 275px;">
                                                    <?php
                                                    $pid = $invoice_data["product_id"];
                                                    $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "' ");
                                                    $image_data = $image_rs->fetch_assoc();
                                                    ?>
                                                    <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                                </div>
                                                <div class="product-details" style="background-color: #ffffff; height: 275px; width: 320px;">
                                                    <div class="product-body">
                                                        <?php
                                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `product`.`id`='" . $pid . "' ");
                                                        $product_data = $product_rs->fetch_assoc();

                                                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                                                        $seller_data = $seller_rs->fetch_assoc();

                                                        $buyer_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "' ");
                                                        $buyer_data = $buyer_rs->fetch_assoc();

                                                        $addr_resultSet = Database::search("SELECT * FROM `user_has_address`
                                                        INNER JOIN `city` ON user_has_address.city_id=city.id
                                                        INNER JOIN `district` ON city.district_id=district.id
                                                        INNER JOIN `province` ON district.province_id=province.id WHERE `user_email`='" . $invoice_data["user_email"] . "';");
                                                        $addrdata = $addr_resultSet->fetch_assoc();
                                                        ?>
                                                        <p class="product-category f5" style="color: #D10024;"><b>Seller : </b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></p>
                                                        <h4 class="product-name-purchase f5"><a href="#" style="color: #2B2D42;"><?php echo $product_data["title"]; ?></a></h4>
                                                        <div class="product-label1">
                                                            <?php
                                                            if ($invoice_data["d_status"] == 0) {
                                                            ?>
                                                                <span class="sale f5">Pending</span>
                                                            <?php

                                                            } else if ($invoice_data["d_status"] == 1) {
                                                            ?>
                                                                <span class="sale f5">Packaging</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 2) {
                                                            ?>
                                                                <span class="sale f5">Dispatching</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 3) {
                                                            ?>
                                                                <span class="sale f5">Shipping</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 4) {
                                                            ?>
                                                                <span class="sale f5">Delivering</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 5) {
                                                            ?>
                                                                <span class="sale f5">Completed</span>
                                                            <?php
                                                            }
                                                            ?>
                                                            <span class="new f5">Paid</span>
                                                        </div>
                                                        <span>Purchased Price: <span class="product-price"><b>Rs. <?php echo $invoice_data["total"]; ?> .00</b></span></span><br>
                                                        <?php
                                                        $Rf_rs1 = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
                                                        $Rf_num1 = $Rf_rs1->num_rows;
                                                        $Rf_data1 = $Rf_rs1->fetch_assoc();
                                                        ?>
                                                        <div class="product-rating">
                                                            <?php
                                                            if ($Rf_num1 == 0) {
                                                            ?>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <?php
                                                                if ($Rf_data1["type"] == 5) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 4) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 3) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 2) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 1) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div><br>
                                                        <time class="product-name-purchase f5"><a href="#" style="color: #2B2D42;"><?php echo $invoice_data["date"]; ?></a></time>
                                                        <p class="product-category f5" style="color: #D10024;">0<?php echo $invoice_data["iqty"]; ?> Items</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3" style="width: 30%; display: flex; justify-content: center; align-items: center;">
                                        <li>
                                            <h3 class="product-category f5" style="color: white;"><?php echo $buyer_data["fname"] . " " . $buyer_data["lname"]; ?></h3>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["line1"]; ?> <?php echo $addrdata["line2"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["city_name"]; ?> | <?php echo $addrdata["postal_code"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["district_name"]; ?> | <?php echo $addrdata["province_name"]; ?></p>
                                        </li>
                                    </div>

                                    <?php
                                    if ($invoice_data["d_status"] == 5) {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" onclick="removeFromPurchasingHistory('<?php echo $invoice_data['id']; ?>');"><i class="fa fa-trash"></i><span class="tooltipp">Remove Item</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" disabled><i class="fa fa-trash"></i><span class="tooltipp">Incomplete Order</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <div class="col-12 purchase-medium" style="margin-left: 35px; display: flex; justify-content:center; align-items: center; flex-direction: column;">
                                <div class="row purchasing-table" style="display: flex; flex-direction: row; width: 95%; height: 275px; background-color: #2B2D42; margin-bottom: 20px; border-radius: 10px;">
                                    <div class="col-12" style="width: 5%; display: flex; justify-content: center; align-items: center; background-color: #D10024; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                        <label class="form-label f4" style="color: #ffffff;"><?php echo $invoice_data["id"]; ?></label>
                                    </div>
                                    <div class="col-3" style="width: 55%; ">
                                        <div class="" style=" display: flex; justify-content: start; align-items: start; ">
                                            <div class="product-purchase" style="display:flex; flex-direction:row; align-items: start; ">
                                                <div class="product-image" style="width: 270px; height: 275px;">
                                                    <?php
                                                    $pid = $invoice_data["product_id"];
                                                    $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "' ");
                                                    $image_data = $image_rs->fetch_assoc();
                                                    ?>
                                                    <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                                </div>
                                                <div class="product-details" style="background-color: #ffffff; height: 275px; width: 320px;">
                                                    <div class="product-body">
                                                        <?php
                                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "' ");
                                                        $product_data = $product_rs->fetch_assoc();

                                                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                                                        $seller_data = $seller_rs->fetch_assoc();

                                                        $buyer_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "' ");
                                                        $buyer_data = $buyer_rs->fetch_assoc();

                                                        $addr_resultSet = Database::search("SELECT * FROM `user_has_address`
                                                        INNER JOIN `city` ON user_has_address.city_id=city.id
                                                        INNER JOIN `district` ON city.district_id=district.id
                                                        INNER JOIN `province` ON district.province_id=province.id WHERE `user_email`='" . $invoice_data["user_email"] . "';");
                                                        $addrdata = $addr_resultSet->fetch_assoc();
                                                        ?>
                                                        <p class="product-category f5" style="color: #D10024;"><b>Seller : </b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></p>
                                                        <h4 class="product-name-purchase f5"><a href="#"style="color: #2B2D42;"><?php echo $product_data["title"]; ?></a></h4>
                                                        <div class="product-label1">
                                                            <?php
                                                            if ($invoice_data["d_status"] == 0) {
                                                            ?>
                                                                <span class="sale f5">Pending</span>
                                                            <?php

                                                            } else if ($invoice_data["d_status"] == 1) {
                                                            ?>
                                                                <span class="sale f5">Packaging</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 2) {
                                                            ?>
                                                                <span class="sale f5">Dispatching</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 3) {
                                                            ?>
                                                                <span class="sale f5">Shipping</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 4) {
                                                            ?>
                                                                <span class="sale f5">Delivering</span>
                                                            <?php
                                                            } else if ($invoice_data["d_status"] == 5) {
                                                            ?>
                                                                <span class="sale f5">Completed</span>
                                                            <?php
                                                            }
                                                            ?>
                                                            <span class="new f5">Paid</span>
                                                        </div>
                                                        <span>Purchased Price: <span class="product-price"><b>Rs. <?php echo $invoice_data["total"]; ?> .00</b></span></span><br>
                                                        <?php
                                                        $Rf_rs1 = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
                                                        $Rf_num1 = $Rf_rs1->num_rows;
                                                        $Rf_data1 = $Rf_rs1->fetch_assoc();
                                                        ?>
                                                        <div class="product-rating">
                                                            <?php
                                                            if ($Rf_num1 == 0) {
                                                            ?>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <?php
                                                                if ($Rf_data1["type"] == 5) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 4) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 3) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 2) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>

                                                                <?php
                                                                if ($Rf_data1["type"] == 1) {
                                                                ?>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php
                                                                }
                                                                ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div><br>
                                                        <time class="product-name-purchase f5"><a href="#" style="color: #2B2D42;"><?php echo $invoice_data["date"]; ?></a></time>
                                                        <p class="product-category f5" style="color: #D10024;">0<?php echo $invoice_data["iqty"]; ?> Items</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3" style="width: 30%; display: flex; justify-content: center; align-items: center;">
                                        <li>
                                            <h3 class="product-category f5" style="color: white;"><?php echo $buyer_data["fname"] . " " . $buyer_data["lname"]; ?></h3>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["line1"]; ?> <?php echo $addrdata["line2"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["city_name"]; ?> | <?php echo $addrdata["postal_code"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["district_name"]; ?> | <?php echo $addrdata["province_name"]; ?></p>

                                        </li>
                                    </div>

                                    <?php
                                    if ($invoice_data["d_status"] == 5) {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" onclick="removeFromPurchasingHistory('<?php echo $invoice_data['id']; ?>');"><i class="fa fa-trash"></i><span class="tooltipp">Remove Item</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" disabled><i class="fa fa-trash"></i><span class="tooltipp">Incomplete Order</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <div class="col-12 purchase-small" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div class="row" style="display: flex; flex-direction: column; width: 90%; height: 900px; background-color: #2B2D42; margin-bottom: 20px; border-radius: 10px;">
                                    <div class="col-12 " style=" display: flex; justify-content: center; align-items: center; background-color: #0073e6; border-top-left-radius: 10px; border-bottom-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                                        <label class="form-label f4" style="color: #ffffff;"><?php echo $invoice_data["id"]; ?></label>
                                    </div>

                                    <div class="col-12 product-purchase" style="display:flex; flex-direction:column; align-items: center; margin-top: 15px;">
                                        <div class="product-image" style=" width:75%;">
                                            <?php
                                            $pid = $invoice_data["product_id"];
                                            $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "' ");
                                            $image_data = $image_rs->fetch_assoc();
                                            ?>
                                            <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                        </div>
                                        <div class="product-details" style=" width:75%; margin-top: 15px; margin-left: 3px;">
                                            <div class="product-body">
                                                <?php
                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "' ");
                                                $product_data = $product_rs->fetch_assoc();

                                                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                                                $seller_data = $seller_rs->fetch_assoc();

                                                $buyer_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "' ");
                                                $buyer_data = $buyer_rs->fetch_assoc();

                                                $addr_resultSet = Database::search("SELECT * FROM `user_has_address`
                                                        INNER JOIN `city` ON user_has_address.city_id=city.id
                                                        INNER JOIN `district` ON city.district_id=district.id
                                                        INNER JOIN `province` ON district.province_id=province.id WHERE `user_email`='" . $invoice_data["user_email"] . "';");
                                                $addrdata = $addr_resultSet->fetch_assoc();
                                                ?>
                                                <p class="product-category f5" style="color: #D10024;"><b>Seller : </b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></p>
                                                <h3 class="product-name-purchase f5"><a href="#" style="color: #2B2D42;"><?php echo $product_data["title"]; ?></a></h3>
                                                <div class="product-label1">
                                                    <?php
                                                    if ($invoice_data["d_status"] == 0) {
                                                    ?>
                                                        <span class="sale f5">Pending</span>
                                                    <?php

                                                    } else if ($invoice_data["d_status"] == 1) {
                                                    ?>
                                                        <span class="sale f5">Packaging</span>
                                                    <?php
                                                    } else if ($invoice_data["d_status"] == 2) {
                                                    ?>
                                                        <span class="sale f5">Dispatching</span>
                                                    <?php
                                                    } else if ($invoice_data["d_status"] == 3) {
                                                    ?>
                                                        <span class="sale f5">Shipping</span>
                                                    <?php
                                                    } else if ($invoice_data["d_status"] == 4) {
                                                    ?>
                                                        <span class="sale f5">Delivering</span>
                                                    <?php
                                                    } else if ($invoice_data["d_status"] == 5) {
                                                    ?>
                                                        <span class="sale f5">Completed</span>
                                                    <?php
                                                    }
                                                    ?>
                                                    <span class="new f5">Paid</span>
                                                </div>
                                                <span>Purchased Price: <span class="product-price"><b>Rs. <?php echo $invoice_data["total"]; ?> .00</b></span></span><br>
                                                <?php
                                                $Rf_rs1 = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
                                                $Rf_num1 = $Rf_rs1->num_rows;
                                                $Rf_data1 = $Rf_rs1->fetch_assoc();
                                                ?>
                                                <div class="product-rating">
                                                    <?php
                                                    if ($Rf_num1 == 0) {
                                                    ?>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <?php
                                                        if ($Rf_data1["type"] == 5) {
                                                        ?>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>

                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($Rf_data1["type"] == 4) {
                                                        ?>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>

                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($Rf_data1["type"] == 3) {
                                                        ?>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>

                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($Rf_data1["type"] == 2) {
                                                        ?>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>

                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($Rf_data1["type"] == 1) {
                                                        ?>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>

                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </div><br>

                                                <time class="product-name-purchase f5"><a href="#" style="color: #2B2D42;"><?php echo $invoice_data["date"]; ?></a></time>
                                                <p class="product-category f5" style="color: #D10024;">0<?php echo $invoice_data["iqty"]; ?> Items</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12" style=" margin-left: 50px;">
                                        <li>
                                            <h3 class="product-category f5" style="color: white;"><?php echo $buyer_data["fname"] . " " . $buyer_data["lname"]; ?></h3>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["line1"]; ?> <?php echo $addrdata["line2"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["city_name"]; ?> | <?php echo $addrdata["postal_code"]; ?></p>
                                            <p class="product-category f5" style="color: white;"><?php echo $addrdata["district_name"]; ?> | <?php echo $addrdata["province_name"]; ?></p>
                                        </li>


                                    </div>

                                    <?php
                                    if ($invoice_data["d_status"] == 5) {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" onclick="removeFromPurchasingHistory('<?php echo $invoice_data['id']; ?>');"><i class="fa fa-trash"></i><span class="tooltipp">Remove Item</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="product-body" style="background-color:transparent; border-radius: 400px; justify-content: center; align-items: center; display: flex;">
                                            <div class="product-btns" style="background-color:white; border-radius: 20px;">
                                                <button class="quick-view" disabled><i class="fa fa-trash"></i><span class="tooltipp">Incomplete Order</span></button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>


                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="col-12">
                <hr />
            </div>
            <?php require "footer.php"; ?>
        </div>
        <!-- produc view -->
    <?php
}
    ?>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    </body>