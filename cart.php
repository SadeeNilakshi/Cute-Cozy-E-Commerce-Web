<!DOCTYPE html>
<html>
<?php
require "connection.php";
session_start();
if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];

    $total = 0;
    $subtotal = 0;
    $shipping = 0;

?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title><?php echo $_SESSION["user"]["fname"]; ?>'s Cart page</title>

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

    <body>
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
                                        <li><a href="cart.php">cart</a></li>
                                    </ul>
                                </div>

                                <div class="col-md-6 col-sm-5 col-xs-5 wishlist" style="display: flex; justify-content: center; margin-top: 18px;">
                                    <h2 class="f3" style="font-weight:normal; color: white;">My Cart</h2>
                                    <a href="#" style="font-size: 24px; margin-left: 5px; color: #d10024;"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>


                                </div>
                                <div class="col-md-3 col-sm-5 col-xs-5 search-bar">
                                    <div class="header-search">
                                        <input class="input-search" placeholder="Search here" id="c">
                                        <button class="search-icon" style="font-size: 14px;"><i class="fa fa-search" aria-hidden="true" onclick="searchCart();"></i></button>
                                    </div>
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
            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "'");
            $cart_num = $cart_rs->num_rows;


            $addrerss_Rsesultset = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id
            INNER JOIN `district` ON city.district_id=district.id WHERE `user_email`='" . $email . "'");
            $address_num = $addrerss_Rsesultset->num_rows;
            $addrerss_data = $addrerss_Rsesultset->fetch_assoc();

            if ($address_num == 1) {

            ?>
                <?php
                if ($cart_num == 0) {
                ?>
                    <!-- empty view -->
                    <div class="col-12 ">
                        <div class="row">
                            <div class="col-12 empty-cart"></div><br>
                            <div class="col-12 text-center">
                                <label class="form-label f" style="font-size: 22px; font-weight: normal;">You have no items in your Cart
                                    yet.</label>
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
                    <div class="col-12 col-lg-9" id="searchresult">
                        <?php
                        $query = "SELECT * FROM `product`";

                        for ($x = 0; $x < $cart_num; $x++) {
                            $cart_data = $cart_rs->fetch_assoc();

                            $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
                            $product_data = $product_rs->fetch_assoc();

                            $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                            $image_data = $image_rs->fetch_assoc();

                            $total = $total + ($product_data["price"] * $cart_data["qty"]);

                            $ship = 0;

                            if ($addrerss_data["did"] == '3') {
                                $ship = $product_data["delivery_fee_colombo"];
                                $shipping = $shipping + $ship;
                            } else {
                                $ship = $product_data["delivery_fee_other"];
                                $shipping = $shipping + $ship;
                            }

                            $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
                            $seller_data = $seller_rs->fetch_assoc();
                            $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                        ?>
                            <div class="row " style="display: flex; justify-content: center;">
                                <div class="wishlist-box1 col-lg-8" style="height:325px; width:80%; margin-bottom: 20px;">
                                    <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: center; display: flex; justify-content: center;">
                                        <div class="product-image">

                                            <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                        </div>
                                        <div class="product-details" style="margin-left: 15px;">
                                            <div class="product-body">
                                                <p class="product-category">Seller: <?php echo $seller; ?></p>
                                                <h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                                                <div class="product-label1">
                                                    <span class="new">NEW</span>
                                                </div>
                                                <h4 class="product-price">Rs. <?php echo $product_data["price"] * $cart_data["qty"]; ?> .00</h4><br>
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
                                                </div>
                                                <div>
                                                    <span class="product-available"><?php echo $product_data["qty"]; ?> In Stock</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-details" style="margin-left: 10px; margin-right: 10px;">
                                            <div class="">
                                                <div class="qty-label" style="width: 200px; margin-top: 30px;">

                                                    <div class="input-number">
                                                        <input type="number" style="outline: none;" value="<?php echo $cart_data["qty"]; ?>" pattern="[0-9]" id="qty_input" onkeyup='checkValue(<?php echo $cart_data["qty"]; ?>);'>
                                                        <span class="qty-up" onkeyup='qty_inc(<?php echo $product_data["qty"]; ?>);' onclick='AddtoCart(<?php echo $product_data["id"]; ?>)'>+</span>
                                                        <span class="qty-down" onkeyup='qty_dec(<?php echo $product_data["qty"]; ?>);' onclick='MinCart(<?php echo $product_data["id"]; ?>)'>-</span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                                                <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;"><i class="fa fa-shopping-cart"></i> add to cart</button> -->
                                                <button class="add-to-cart-btn1" style="margin-top: 10px; width: 200px; font-weight: bold;" type="submit" id="payhere-payment" onclick="payNow(<?php echo $product_data['id']; ?>);"><i class="fa fa-usd"></i> &nbsp; BUY NOW</button>
                                                <button class="add-to-cart-btn" style="margin-top: 10px; width: 200px;" onclick="deleteFromCart(<?php echo $cart_data['id']; ?>)" ;><i class="fa fa-trash"></i>remove</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>

                    </div>

                    <!-- summary -->
                    <div class="col-12 col-lg-3">
                        <div class="row product-wishlist">

                            <div class="col-12" style="display:flex; justify-content: center; align-content: center;">
                                <label class="form-label f1" style="color:#d10024; font-size: 20px; margin-top: 10px;">CHECKOUT</label>
                            </div>

                            <div class="col-12">
                                <hr class="hr" style="width: 80%;" />
                            </div>
                            <div class="col-12" style="display: flex; flex-direction: row; justify-content: center;">
                                <div class="col-4 text-start mb-3">
                                    <span class="fs-6 f1" style="color: #d10024; margin-right: 90px; font-size: 16px;">Items Cost (<?php echo $cart_num; ?>)</span>

                                </div>

                                <div class="col-8 mb-3">
                                    <span class="fs-5 f1" style="color: black; font-size: 16px;">Rs. <?php echo $total; ?> .00</span>
                                </div>
                            </div>

                            <div class="col-12" style="display: flex; flex-direction: row; margin-top: 10px; justify-content: center;">
                                <div class="col-6 text-start mb-3">
                                    <span class="fs-6 f1" style="color: #d10024; margin-right: 90px; font-size: 16px;">Delivery Cost</span>

                                </div>

                                <div class="col-6 mb-3">
                                    <span class="fs-6 f1" style="color: black; font-size: 16px;">Rs. <?php echo $shipping; ?> .00</span>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <hr class="hr" style="width: 80%;" />
                            </div>
                            <div style="display: flex; flex-direction: row; margin-top: 10px; justify-content: center;">
                                <div class="col-6">
                                    <span class="fs-4 f1" style="color: #d10024; font-weight: bold; margin-right: 100px; font-size: 16px;">TOTAL</span>

                                </div>

                                <div class="col-6 text-end">
                                    <span class="fs-4 f1" style="color: black; font-size: 16px;">Rs. <?php echo ($shipping + $total); ?> .00</span>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <hr class="hr" style="width: 80%;" />
                            </div>

                            <div class="product-details" style="display: flex; justify-content: center; ">

                                <div class="add-to-cart1" style="display: flex; flex-direction: column; margin-bottom: 20px;">


                                    <a class="" style="margin-top: 5px; width: 225px; font-weight: bold;">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp; &nbsp;
                                        PROCEED</a>

                                </div>


                            </div>

                        </div>
                    </div>
                    <!-- summary -->
                <?php
                }
                ?>

                <!-- <responsive-medium-screen> -->
                <div class="col-12" id="searchresult">
                    <?php
                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "'");
                    $cart_num = $cart_rs->num_rows;
                    $query = "SELECT * FROM `product`";

                    for ($x = 0; $x < $cart_num; $x++) {
                        $cart_data = $cart_rs->fetch_assoc();

                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
                        $product_data = $product_rs->fetch_assoc();

                        $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                        $image_data = $image_rs->fetch_assoc();

                        $total = $total + ($product_data["price"] * $cart_data["qty"]);

                        $addrerss_Rsesultset = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id
                                    INNER JOIN `district` ON city.district_id=district.id WHERE `user_email`='" . $email . "'");
                        $addrerss_data = $addrerss_Rsesultset->fetch_assoc();

                        $ship = 0;

                        if ($addrerss_data["did"] == 2) {
                            $ship = $product_data["delivery_fee_colombo"];
                            $shipping = $shipping + $ship;
                        } else {
                            $ship = $product_data["delivery_fee_other"];
                            $shipping = $shipping + $ship;
                        }

                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
                        $seller_data = $seller_rs->fetch_assoc();
                        $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                    ?>
                        <div class="row " style="display: flex; justify-content: center;">
                            <div class="wishlist-box2 d-lg-none" style="height:325px; width: 80%;">
                                <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: center; display: flex; justify-content: center;">
                                    <div class="product-image">

                                        <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                    </div>
                                    <div class="product-details" style="margin-left: 15px;">
                                        <div class="product-body">
                                            <p class="product-category">Seller: <?php echo $seller; ?></p>
                                            <h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                                            <div class="product-label1">
                                                <span class="new">NEW</span>
                                            </div>
                                            <h4 class="product-price">Rs. <?php echo ($product_data["price"] * $cart_data["qty"]); ?> .00</h4><br>
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
                                            </div>

                                            <div>
                                                <span class="product-available"><?php echo $product_data["qty"]; ?> In Stock</span>
                                            </div>


                                        </div>


                                    </div>
                                    <div class="product-details" style="margin-right: 5px; margin-left: 5px;">
                                        <div class="">
                                            <div class="qty-label" style="width: 190px; margin-top: 30px;">

                                                <div class="input-number">
                                                    <input type="number" style="outline: none;" value="<?php echo $cart_data["qty"]; ?>" pattern="[0-9]" id="qty_input" onkeyup='checkValue(<?php echo $cart_data["qty"]; ?>);'>
                                                    <span class="qty-up" onkeyup='qty_inc(<?php echo $product_data["qty"]; ?>);' onclick='AddtoCart(<?php echo $product_data["id"]; ?>)'>+</span>
                                                    <span class="qty-down" onkeyup='qty_dec(<?php echo $product_data["qty"]; ?>);' onclick='MinCart(<?php echo $product_data["id"]; ?>)'>-</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                                            <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;"><i class="fa fa-shopping-cart"></i> add to cart</button> -->
                                            <button class="add-to-cart-btn1" style="margin-top: 10px; width: 200px; font-weight: bold;" type="submit" id="payhere-payment" onclick="payNow(<?php echo $product_data['id']; ?>);"><i class="fa fa-usd"></i> &nbsp; BUY NOW</button>
                                            <button class="add-to-cart-btn" style="margin-top: 10px; width: 200px;" onclick="deleteFromCart(<?php echo $cart_data['id']; ?>)" ;><i class="fa fa-trash"></i>remove</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- <responsive-medium-screen> -->

                <!-- <responsive-small-screen> -->
                <div class="col-12" id="searchresult">
                    <?php
                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "'");
                    $cart_num = $cart_rs->num_rows;
                    $query = "SELECT * FROM `product`";

                    for ($x = 0; $x < $cart_num; $x++) {
                        $cart_data = $cart_rs->fetch_assoc();

                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
                        $product_data = $product_rs->fetch_assoc();

                        $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                        $image_data = $image_rs->fetch_assoc();

                        $total = $total + ($product_data["price"] * $cart_data["qty"]);

                        $addrerss_Rsesultset = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id
                                    INNER JOIN `district` ON city.district_id=district.id WHERE `user_email`='" . $email . "'");
                        $addrerss_data = $addrerss_Rsesultset->fetch_assoc();

                        $ship = 0;

                        if ($addrerss_data["did"] == 2) {
                            $ship = $product_data["delivery_fee_colombo"];
                            $shipping = $shipping + $ship;
                        } else {
                            $ship = $product_data["delivery_fee_other"];
                            $shipping = $shipping + $ship;
                        }

                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
                        $seller_data = $seller_rs->fetch_assoc();
                        $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                    ?>
                        <div class="row " style="display: flex; justify-content: center;">

                            <div class="wishlist-box3" style="height:520px; width:60%; margin-top:190px;">
                                <div class="product-wishlist" style="display:flex; flex-direction:column; display: flex; align-items: center; display: flex; justify-content: center;">
                                    <div class="product-image" style="width: 70%; height: 275px;">

                                        <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                    </div>
                                    <div class="product-details" style="margin-left: 15px;">
                                        <div class="product-body">
                                            <p class="product-category">Seller: <?php echo $seller; ?></p>
                                            <h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                                            <div class="product-label1">
                                                <span class="new">NEW</span>
                                            </div>
                                            <h4 class="product-price">Rs. <?php echo ($product_data["price"] * $cart_data["qty"]); ?> .00</h4><br>
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
                                            </div>
                                            <div>
                                                <span class="product-available"><?php echo $product_data["qty"]; ?> In Stock</span>
                                            </div>


                                        </div>


                                    </div>
                                    <div class="product-details">
                                        <div class="">
                                            <div class="qty-label" style="width: 225px; margin-top: 30px;">

                                                <div class="input-number">
                                                    <input type="number" style="outline: none;" value="<?php echo $cart_data["qty"]; ?>" pattern="[0-9]" id="qty_input" onkeyup='checkValue(<?php echo $cart_data["qty"]; ?>);'>
                                                    <span class="qty-up" onkeyup='qty_inc(<?php echo $product_data["qty"]; ?>);' onclick='AddtoCart(<?php echo $product_data["id"]; ?>)'>+</span>
                                                    <span class="qty-down" onkeyup='qty_dec(<?php echo $product_data["qty"]; ?>);' onclick='MinCart(<?php echo $product_data["id"]; ?>)'>-</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                                            <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;"><i class="fa fa-shopping-cart"></i> add to cart</button> -->
                                            <button class="add-to-cart-btn1" style="margin-top: 10px; width: 200px; font-weight: bold;" type="submit" id="payhere-payment" onclick="payNow(<?php echo $product_data['id']; ?>);"><i class="fa fa-usd"></i> &nbsp; BUY NOW</button>
                                            <button class="add-to-cart-btn" style="margin-top: 10px; width: 200px;" onclick="deleteFromCart(<?php echo $cart_data['id']; ?>)" ;><i class="fa fa-trash"></i>remove</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php
                    }
                    ?>

                </div>
                <!-- <responsive-small-screen> -->
        </div>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    </body>
    <?php require "footer.php"; ?>

</html>

<?php
            } else {
?>
    <div class="col-12 ">
        <div class="row">
            <div class="col-12 empty-profile"></div><br>
            <div class="col-12 text-center">
                <label class="form-label f" style="font-size: 22px; font-weight: normal;">Hey <b class="text-primary"><?php echo $_SESSION["user"]["fname"]; ?></b>! Please Update Your Profile First </label>
            </div><br>
            <div class="offset-4 col-12 d-grid mb-3" style="display: flex; justify-content: center;">
                <a class="primary-shop-btn cta-btn" href="userprofile.php">Update now</a>
            </div><br>
        </div>
    </div>
<?php
            }
        } else {
            header("location:home.php");
        }

?>