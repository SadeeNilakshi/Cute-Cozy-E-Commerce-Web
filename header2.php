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
	<link type="text/css" rel="stylesheet" href="bootstrap-icons.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="./css/style.css" />
	<link rel="stylesheet" href="style.css">

	<link rel="icon" href="resources/logo.png" />



</head>

<body class="body">
	<div classs="vh-100 w-100 ">
		<div class="">
			<div class="col-12">
				<header>
					<!-- TOP HEADER -->
					<div id="top-header">
						<div class="container">
							<ul class="header-links pull-left">
								<li><a href="tel:+94552294330"><i class="fa fa-phone"></i> 055-2294330</a></li>
								<li><a href="mailto:cuteandcozy@email.com"><i class="fa fa-envelope-o"></i> cuteandcozy@email.com</a></li>
								<li><a href="#"><i class="fa fa-map-marker"></i>Visit Us</a></li>
							</ul>

							<ul class="header-links pull-right">
								
								
								
								<?php
								session_start();
								if (isset($_SESSION["user"])) {
									$data = $_SESSION["user"];

								?>
									<li><a href="userprofile.php"><i class="fa fa-user-o"></i> <?php echo $data["fname"]; ?>'s Profile</a></li>
									<li><a href="" onclick="signout();"><i class="fa fa-sign-out"></i> SignOut</a></li>
								<?php
								} else {
								?>
									<li><a href="index.php"><i class="fa fa-user-o"></i> Sign In</a></li>
								<?php
								}
								?>
						</div>
					</div>
					</ul>

					<!-- MAIN HEADER -->
					<div id="header">
						<!-- container -->
						<div class="container">
							<!-- row -->
							<div class="row">
								<!-- LOGO -->
								<div class="col-md-3 clearfix">
									<div class="header-ctn">
										<!-- Purchasing History -->
										<div class="dropdown" style="cursor: pointer;">
											<?php
											require "connection.php";
											if (!isset($_SESSION["user"]["email"])) {
											?>
												<a class="dropdown-toggle" data-toggle="" aria-expanded="false">
													<i class="fa fa-window-close"></i>
													<span>Purchased</span>
													<div class="qty">0</div>
												</a>
											<?php
											} else {
											?>
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" onclick="window.location='purchasingHistory.php'">
													<i class="fa fa-money"></i>
													<?php
													$p_rs = Database::search("SELECT * FROM `invoice`
									            INNER JOIN `user` ON invoice.user_email=user.email WHERE `user_email`= '" . $_SESSION["user"]["email"] . "' AND `remove_status` ='1'");
													$p_num = $p_rs->num_rows;
													?>
													<span>Purchased</span>
													<div class="qty"><?php echo $p_num; ?></div>
												</a>
											<?php
											}
											?>
											<div class="cart-dropdown">
												<div class="cart-list">
													<?php

													for ($x = 0; $x < $p_num; $x++) {
														$p_data = $p_rs->fetch_assoc();

														$product_rs = Database::search("SELECT* FROM `product` WHERE `id`='" . $p_data["product_id"] . "'");
														$product_data = $product_rs->fetch_assoc();

														$image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $p_data["product_id"] . "'");
														$image_data = $image_rs->fetch_assoc();

													?>
														<div class="product-widget">
															<div class="product-img">
																<img src="<?php echo $image_data['code']; ?>" />
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
																<h4 class="product-price"><span class="qty">1x</span>Rs. <?php echo $product_data["price"]; ?>.00</h4>
															</div>
														</div>
													<?php
													}
													?>
												</div>
												<div class="cart-btns" style="display: flex; justify-content: center;">
													<a href="home.php">Home</a>
													<a href="purchasingHistory.php">View Purchasing History <i class="fa fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<!-- /Purchasing History -->

										<!-- My Product -->
										<div class="dropdown" style="cursor: pointer;">
											<?php
											if (!isset($_SESSION["user"]["email"])) {
											?>
												<a class="dropdown-toggle" data-toggle="" aria-expanded="false">
												<i class="fa fa-shopping-basket"></i>
													<span>Products</span>
													<div class="qty">0</div>
												</a>
											<?php
											} else {
											?>
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" onclick="window.location='myProducts.php'">
												<i class="fa fa-dollar"></i>
													<?php
													$p_rs = Database::search("SELECT * FROM `product`
									            INNER JOIN `user` ON product.user_email=user.email WHERE `user_email`= '" . $_SESSION["user"]["email"] . "' AND `status_id` ='1'");
													$p_num = $p_rs->num_rows;
													?>
													<span>Sell</span>
													<div class="qty"><?php echo $p_num; ?></div>
												</a>
											<?php
											}
											?>
											<div class="cart-dropdown">
												<div class="cart-list">
													<?php

													for ($x = 0; $x < $p_num; $x++) {
														$p_data = $p_rs->fetch_assoc();

														$product_rs = Database::search("SELECT* FROM `product` WHERE `id`='" . $p_data["product_id"] . "'");
														$product_data = $product_rs->fetch_assoc();

														$image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $p_data["product_id"] . "'");
														$image_data = $image_rs->fetch_assoc();

													?>
														<div class="product-widget">
															<div class="product-img">
																<img src="<?php echo $image_data['code']; ?>" />
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
																<h4 class="product-price"><span class="qty">1x</span>Rs. <?php echo $product_data["price"]; ?>.00</h4>
															</div>
														</div>
													<?php
													}
													?>
												</div>
												<div class="cart-btns" style="display: flex; justify-content: center;">
													<a href="home.php">Home</a>
													<a href="myProducts.php">My Product <i class="fa fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<!-- /My Product -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="header-search">

										<select class="input-select" id="basic_search_select" style="max-width: 150px;">
											<option value="0">All Categories</option>
											<?php
											$category_resultSet = Database::search("SELECT * FROM `category`");
											$category_num = $category_resultSet->num_rows;

											for ($x = 0; $x < $category_num; $x++) {
												$category_data = $category_resultSet->fetch_assoc();

											?>
												<option value="<?php echo $category_data["c_id"]; ?>"><?php echo $category_data["name"]; ?></option>
											<?php
											}

											?>
										</select>
										<input class="input" type="text" aria-label="Text input with dropdown button" placeholder="Search here" id="basic_search_txt">
										<button class="search-btn" onclick="basicSearch();">Search</button>
									</div>
								</div>


								<!-- ACCOUNT -->
								<div class="col-md-3 clearfix">
									<div class="header-ctn">
										<!-- Wishlist -->
										<div class="dropdown" style="cursor: pointer;">
											<?php
											if (!isset($_SESSION["user"]["email"])) {
											?>
												<a class="dropdown-toggle" data-toggle="" aria-expanded="false">
													<i class="fa fa-heart-o"></i>
													<span>Your Wishlist</span>
													<div class="qty">0</div>
												</a>
											<?php
											} else {
											?>
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" onclick="window.location='wishlist.php'">
													<i class="fa fa-heart"></i>
													<?php
													$w_rs = Database::search("SELECT * FROM `wishlist`
									            INNER JOIN `user` ON wishlist.user_email=user.email WHERE `user_email`= '" . $_SESSION["user"]["email"] . "' ");
													$w_num = $w_rs->num_rows;
													?>
													<span>Your Wishlist</span>
													<div class="qty"><?php echo $w_num; ?></div>
												</a>
											<?php
											}
											?>
											<div class="cart-dropdown">
												<div class="cart-list">
													<?php
													for ($x = 0; $x < $w_num; $x++) {
														$w_data = $w_rs->fetch_assoc();

														$product_rs = Database::search("SELECT* FROM `product` WHERE `id`='" . $w_data["product_id"] . "'");
														$product_data = $product_rs->fetch_assoc();

														$image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $w_data["product_id"] . "'");
														$image_data = $image_rs->fetch_assoc();

													?>
														<div class="product-widget">
															<div class="product-img">
																<img src="<?php echo $image_data['code']; ?>" />
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
																<h4 class="product-price"><span class="qty">1x</span>Rs. <?php echo $product_data["price"]; ?>.00</h4>
															</div>
														</div>
													<?php
													}
													?>
												</div>
												<div class="cart-btns" style="display: flex; justify-content: center;">
													<a href="home.php">Home</a>
													<a href="wishlist.php">View Wishlist <i class="fa fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<!-- /Wishlist -->

										<!-- Cart -->
										<div class="dropdown" style="cursor: pointer;">
											<?php
											if (!isset($_SESSION["user"]["email"])) {
											?>
												<a class="dropdown-toggle" data-toggle="" aria-expanded="false">
													<i class="fa fa-shopping-bag"></i>
													<span>Your Cart</span>
													<div class="qty">0</div>
												</a>
											<?php
											} else {
											?>
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" onclick="window.location='cart.php'">
													<i class="fa fa-shopping-cart"></i>
													<?php

													$c_rs = Database::search("SELECT * FROM `cart`
									            INNER JOIN `user` ON cart.user_email=user.email WHERE `user_email`= '" . $data["email"] . "' ");
													$c_num = $c_rs->num_rows;
													?>
													<span>Your Cart</span>
													<div class="qty"><?php echo $c_num; ?></div>
												</a>
											<?php
											}
											?>
											<div class="cart-dropdown">
												<div class="cart-list">
													<?php
													for ($y = 0; $y < $c_num; $y++) {
														$c_data = $c_rs->fetch_assoc();

														$product_rs1 = Database::search("SELECT* FROM `product` WHERE `id`='" . $c_data["product_id"] . "'");
														$product_data1 = $product_rs1->fetch_assoc();

														$image_rs1 = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $c_data["product_id"] . "'");
														$image_data1 = $image_rs1->fetch_assoc();

													?>
														<div class="product-widget">
															<div class="product-img">
																<img src="<?php echo $image_data1['code']; ?>" alt="">
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="#"><?php echo $product_data1["title"] ?></a></h3>
																<h4 class="product-price"><span class="qty">1x</span>Rs. <?php echo $product_data1["price"]; ?>.00</h4>
															</div>
														</div>
													<?php
													}

													?>
												</div>
												<div class="cart-btns" style="display: flex; justify-content: center;">
													<a href="cart.php">View Cart</a>
													<a href="#">Checkout <i class="fa fa-arrow-circle-right"></i></a>
												</div>
											</div>
										</div>
										<!-- /Cart -->
									</div>
								</div>
								<!-- /ACCOUNT -->
							</div>
							<!-- row -->
						</div>
						<!-- container -->
					</div>
					<!-- /MAIN HEADER -->
				</header>

				<!-- NAVIGATION -->
			</div>
		</div>

	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<Script src="script.js"></Script>
	<Script src="bootstrap.bundle.js"></Script>


</body>

</html>