<!DOCTYPE html>
<html>
<?php session_start(); ?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Completed & removed Invoices</title>

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

    <!-- <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="bootstrap-icons.css" /> -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap-icons.css" />


    <link rel="icon" href="resources/logo.png" />
</head>

<body>

    <?php

    if (isset($_SESSION["aduser"])) {
    ?>

        <div class="container-fluid vh-100">
            <div class="row">
                <div class="col-12  d-flex justify-content-center vh-100">
                    <!-- BREADCRUMB -->
                    <div id="breadcrumb" class="section" style="height:80px; background-color: rgba(43, 45, 66, 0.91);">
                        <!-- container -->
                        <div class="container">
                            <!-- row -->
                            <div class="row bread">
                                <div class="col-md-3 breadcrumb-resp" style="margin-top: 20px;">
                                    <ul class="breadcrumb-tree">
                                        <li><a href="adminPanel.php">Dashboard</a></li>
                                        <li><a href="removedInv.php">Removed Invoices</a></li>
                                    </ul>

                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 wishlist" style="display: flex; justify-content: center; margin-top: 18px;">
                                    <h2 class="f3" style="font-weight:normal; color: white; text-wrap: nowrap; justify-content: center;">Completed & Removed Invoices </h2>
                                    <a href="#" style="font-size: 24px; margin-left: 5px; color: #d10024;"> <i class="fa fa-money" aria-hidden="true"></i></a>
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
            require "connection.php";

            $inv_rs = Database::search("SELECT * FROM `invoice`
            INNER JOIN `product` ON `invoice`.`product_id` = `product`.`id`
            INNER JOIN `user` ON `invoice`.`user_email` = `user`.`email`
            WHERE `remove_status` = '2'");
            $inv_num = $inv_rs->num_rows;

            if ($inv_num == 0) {
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
                        </div><br>
                    </div>
                </div>
                <!-- empty view -->

            <?php
            } else {

            ?>
                <!-- <responsive-Large-screen> -->
                <div class="col-12">
                    <div class="row " style="display: flex; justify-content: center;">
                        <?php
                        $query = "SELECT * FROM `product`";

                        for ($x = 0; $x < $inv_num; $x++) {
                            $inv_data = $inv_rs->fetch_assoc();

                            $product_rs = Database::search("SELECT* FROM `product` WHERE `id`='" . $inv_data["product_id"] . "'");
                            $product_data = $product_rs->fetch_assoc();

                            $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $inv_data["product_id"] . "'");
                            $image_data = $image_rs->fetch_assoc();

                            $Rf_rs1 = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
                            $Rf_num1 = $Rf_rs1->num_rows;
                            $Rf_data1 = $Rf_rs1->fetch_assoc();

                            $price = $product_data["price"];
                            $adding_price = ($price / 100) * 5;
                            $new_price = $price + $adding_price;
                            $difference = $new_price - $price;
                            $percentage = ($difference / $price) * 100;

                        ?>
                            <div class="wishlist-box1 col-lg-12" style="height:200px; width:70%; margin-bottom: 45px;">
                                <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: start; display: flex; justify-content: start;">
                                    <div class="product-image" style="height: 200px; width: 200px;">
                                        <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">
                                    </div>
                                    <div class="product-details" style="margin-left: 15px;">
                                        <span class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></span><br />
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
                                        <br> <br>
                                        <span>Order ID: <b><?php echo $inv_data["order_id"] ?></b></span><br>
                                        <span>Purchased On: <b><?php echo $inv_data["date"] ?></b></span><br>
                                        <span>Purchased By: <b><?php echo $inv_data["user_email"] ?></b></span><br>
                                        <span>Total Paid: <b>Rs. <?php echo $inv_data["total"] ?>.00</b></span><br>
                                        <span>Purchased QTY: <b><?php echo $inv_data["iqty"] ?></b></span><br>
                                        <div class="product-label1" style="margin-bottom: 6px;">
                                            <span class="new">Removed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- <responsive-Large-screen> -->

                <!-- <responsive-medium-screen> -->
                <div class="col-12" id="searchresult">
                    <div class="row " style="display: flex; justify-content: center;">
                        <div class="wishlist-box2 d-lg-none" style="height:200px; width: 70%; margin-bottom: 120px;">
                            <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: start; display: flex; justify-content: start;">
                                <div class="product-image">

                                    <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                                </div>
                                <div class="product-details" style="margin-left: 15px;">
                                    <span class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></span><br />
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
                                    <br> <br>
                                    <span>Order ID: <b><?php echo $inv_data["order_id"] ?></b></span><br>
                                    <span>Purchased On: <b><?php echo $inv_data["date"] ?></b></span><br>
                                    <span>Purchased By: <b><?php echo $inv_data["user_email"] ?></b></span><br>
                                    <span>Total Paid: <b>Rs. <?php echo $inv_data["total"] ?>.00</b></span><br>
                                    <span>Purchased QTY: <b><?php echo $inv_data["iqty"] ?></b></span><br>
                                    <div class="product-label1" style="margin-bottom: 6px;">
                                        <span class="new">Removed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <responsive-medium-screen> -->

                <!-- <responsive-small-screen> -->
                <div class="col-12">
                    <div class="row " style="display: flex; justify-content: center;">
                        <div class="wishlist-box3" style="height:520px; width:70%; margin-bottom: 15px;">
                            <div class="product-wishlist" style="display:flex; flex-direction:column; display: flex; align-items: center; display: flex; justify-content: center;">
                                <div class="product-image" style="width: 80%; height: 275px;">
                                    <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">
                                </div>
                                <div class="product-details" style="margin-left: 12px;">
                                    <span class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></span><br />
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
                                    <br> <br>
                                    <span>Order ID: <b><?php echo $inv_data["order_id"] ?></b></span><br>
                                    <span>Purchased On: <b><?php echo $inv_data["date"] ?></b></span><br>
                                    <span>Purchased By: <b><?php echo $inv_data["user_email"] ?></b></span><br>
                                    <span>Total Paid: <b>Rs. <?php echo $inv_data["total"] ?>.00</b></span><br>
                                    <span>Purchased QTY: <b><?php echo $inv_data["iqty"] ?></b></span><br>
                                    <div class="product-label1" style="margin-bottom: 6px;">
                                        <span class="new">Removed</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php

                        }
                    ?>
                    </div>
                </div>
                <!-- <responsive-small-screen> -->

                <?php require "footer.php"; ?>

        <?php
            }
        } else {
            header("location:home.php");
        }
        ?>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>

</body>

</html>