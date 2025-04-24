<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <link rel="icon" href="resources/logo.png" />



</head>

<body class="body">
    <div class="">
        <div class="row">
            <div class="col-12 mt-5 foooter">
                <!-- FOOTER -->
                <footer id="footer">
                    <!-- top footer -->
                    <div class="section">
                        <!-- container -->
                        <div class="container">
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <div class="footer">
                                        <h3 class="footer-title">About Us</h3>
                                        <p class="about">Step into our world of elegance and style, where every piece tells a story of empowerment and beauty. Founded with a vision to celebrate the essence of womanhood, we curate a stunning collection of fashion items that inspire confidence and allure.</p>
                                        <ul class="footer-links">
                                            <li><a href="#"><i class="fa fa-map-marker"></i>Badulla Road</a></li>
                                            <li><a href="#"><i class="fa fa-phone"></i>055-2294330</a></li>
                                            <li><a href="#"><i class="fa fa-envelope-o"></i>cuteandcozy@email.com</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-6">
                                    <div class="footer">
                                        <h3 class="footer-title">Categories</h3>
                                        <ul class="footer-links">
                                            <?php

                                            $category_resultSet1 = Database::search("SELECT * FROM `category`");
                                            $category_num1 = $category_resultSet1->num_rows;

                                            for ($x = 0; $x < $category_num1; $x++) {
                                                $category_data1 = $category_resultSet1->fetch_assoc();

                                            ?>
                                                <li><a href="#"><?php echo $category_data1["name"]; ?> Collection</a></li>
                                            <?php
                                            }

                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="clearfix visible-xs"></div>

                                <div class="col-md-3 col-xs-6">
                                    <div class="footer">
                                        <h3 class="footer-title ">Information</h3>
                                        <ul class="footer-links">
                                            <li><a href="#">About Us</a></li>
                                            <li><a href="#">Contact Us</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Orders and Returns</a></li>
                                            <li><a href="#">Terms & Conditions</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-6">
                                    <div class="footer">
                                        <h3 class="footer-title">Service</h3>
                                        <ul class="footer-links">
                                            <li><a href="#">My Account</a></li>
                                            <li><a href="#">View Cart</a></li>
                                            <li><a href="#">Wishlist</a></li>
                                            <li><a href="#">Track My Order</a></li>
                                            <li><a href="#">Help</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /row -->
                        </div>
                        <!-- /container -->
                    </div>
                    <!-- /top footer -->

                    <!-- bottom footer -->
                    <div id="bottom-footer" class="section">
                        <div class="container">
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <ul class="footer-payments">
                                        <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                                        <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                                        <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                                        <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                                        <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                                        <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                                    </ul>
                                    <span class="copyright">

                                        Copyright &copy;<script>
                                            document.write(new Date().getFullYear());
                                        </script> All rights reserved | Cute & Cozy Women Accessories </a>

                                    </span>


                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /bottom footer -->
                </footer>
                <!-- /FOOTER -->
            </div>

        </div>

    </div>
    <!-- jQuery Plugins -->

</body>