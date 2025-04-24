<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="resources/logo.png" />

	<title>Welcome | Start Shopping</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />
	<link rel="stylesheet" href="bootstrap-icons.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="style.css" />
</head>
<?php require "header2.php"  ?>

<body style="overflow-x: hidden;">

	<div class="section">
		<div class="container">
			<div class="row">
				<?php
				$category_resultSet = Database::search("SELECT * FROM `category` ORDER BY `c_id` DESC LIMIT 4");
				$category_num = $category_resultSet->num_rows;

				for ($x = 0; $x < $category_num; $x++) {
					$category_data = $category_resultSet->fetch_assoc();
				?>
					<div class="col-12 col-lg-3 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="<?php echo $category_data["path"]; ?>" alt="">
							</div>
							<div class="shop-body">
								<h4 class="text-white"><?php echo $category_data["name"]; ?><br>Collection</h4>
								<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>

	<div class="section" id="basicSearchResult">
		<div class="container">
			<div class="row">
				<div class="col-md-12" data-wow-delay="0.1s">
					<div class="section-title">
						<h3 class="title" style="color: #d10024;">New Products</h3>
					</div>
				</div>

				<div class="col-md-12">
					<div class="row">
						<div class="products-tabs">
							<div id="tab1" class="tab-pane active">
								<div class="products-slick" data-nav="#slick-nav-1">
									<?php
									$product_resultSet = Database::search("SELECT * FROM `product` WHERE `status_id` = '1' ORDER BY `datetime_added` DESC");

									$product_num = $product_resultSet->num_rows;

									for ($z = 0; $z < $product_num; $z++) {
										$product_data = $product_resultSet->fetch_assoc();

									?>
										<div class="product">
											<div class="product-img img-fluid">
												<?php
												$image_resultSet = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "';");
												$image_data = $image_resultSet->fetch_assoc();
												?>
												<img src="<?php echo $image_data["code"]; ?>" alt="">
												<div class="product-label">
													<span class="new">NEW</span>
												</div>
											</div>
											<div class="product-body">
												<h3 class="product-name"><a href="#"><?php echo $product_data["title"]; ?></a></h3>
												<h4 class="product-price">Rs.<?php echo $product_data["price"]; ?>.00</h4>
												<?php
												$Rf_rs = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
												$Rf_num = $Rf_rs->num_rows;
												$Rf_data = $Rf_rs->fetch_assoc();
												?>
												<div class="product-rating">
													<?php
													if ($Rf_num == 0) {
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

														if ($Rf_data["type"] == 5) {
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
														if ($Rf_data["type"] == 4) {
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
														if ($Rf_data["type"] == 3) {
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
														if ($Rf_data["type"] == 2) {
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
														if ($Rf_data["type"] == 1) {
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

												<div class="product-btns">
													<?php
													if (isset($_SESSION["user"])) {
														$email = $_SESSION["user"]["email"];

														$watchlist_Resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`= '" . $email . "'");
														$watchlist_num = $watchlist_Resultset->num_rows;

														if ($watchlist_num == 1) {
													?>
															<button class="add-to-wishlist" onclick='addWishlist(<?php echo $product_data["id"]; ?>);'>
																<i class="fa fa-heart text-danger" id='heart<?php echo $product_data["id"]; ?>'></i>
																<span class="tooltipp fs-6">Remove</span>
															</button>
														<?php
														} else {
														?>
															<button class="add-to-wishlist" onclick='addWishlist(<?php echo $product_data["id"]; ?>);'>
																<i class="fa fa-heart text-dark" id='heart<?php echo $product_data["id"]; ?>'></i>
																<span class="tooltipp">add to wishlist</span>
															</button>
													<?php
														}
													}
													
													?>
													<?php
													if (!isset($_SESSION["user"])) {
													?>
														<button class="d-none">
															<a href="#">
																<i class="fa fa-eye-slash"></i>
																<span class="tooltipp">Log in First</span>
															</a>
														</button>
													<?php
													} else {
													?>
														<button class="quick-view">
															<a href="<?php echo "SingleProductView.php?id=" . ($product_data["id"]); ?>">
																<i class="fa fa-eye"></i>
																<span class="tooltipp">quick view</span>
															</a>
														</button>
													<?php
													}
													?>
												</div>
											</div>
											<?php
											if (!isset($_SESSION["user"])) {
											?>
												<div class="add-to-cart">
													<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i>Can't add to Cart</button>
												</div>
											<?php
											} else {
											?>
												<div class="add-to-cart">
													<button class="add-to-cart-btn" onclick="AddtoCart(<?php echo $product_data['id']; ?>);"><i class="fa fa-shopping-cart"></i> add to cart</button>
												</div>
											<?php
											}
											?>
										</div>
									<?php
									}
									?>
									<!-- /product -->
								</div>
								<div id="slick-nav-1" class="products-slick-nav"></div>
							</div>
							<!-- /tab -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="hot-deal" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<div class="hot-deal">
						<?php
						$targetDate = strtotime("2024-07-02");

						$tdate = new DateTime();
						$tz = new DateTimeZone("Asia/Colombo");
						$tdate->setTimezone($tz);

						$currentDate = time();

						$difference = $targetDate - $currentDate;


						$days = floor($difference / (60 * 60 * 24));
						$hours = floor(($difference % (60 * 60 * 24)) / (60 * 60));
						$minutes = floor(($difference % (60 * 60)) / 60);
						$seconds = $difference % 60;
						?>
						<ul class="hot-deal-countdown">
							<li>
								<div>
									<h3><?php echo $days; ?></h3>
									<span>Days</span>
								</div>
							</li>
							<li>
								<div>
									<h3><?php echo $hours; ?></h3>
									<span>Hours</span>
								</div>
							</li>
							<li>
								<div>
									<h3><?php echo $minutes; ?></h3>
									<span>Mins</span>
								</div>
							</li>
						</ul>
						<h2 class="text-uppercase" style="color: black;">hot deal this week</h2>
						<p style="color: #d10024;">New Collection Up to 50% OFF</p>
						<a class="primary-btn cta-btn" href="#">Shop now</a>
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>


	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-xs-6">
					<div class="section-title">
						<h4 class="title" style="color: black;">Foot Wear</h4>
						<div class="section-nav">
							<div id="slick-nav-3" class="products-slick-nav"></div>
						</div>
					</div>

					<div class="products-widget-slick" data-nav="#slick-nav-3">
						<div>
							<?php

							$product_resultSet = Database::search("SELECT * FROM `product` WHERE `category_id`= '1' AND `status_id` = '1' ORDER BY `qty` ASC LIMIT 4 OFFSET 0");

							$product_num = $product_resultSet->num_rows;

							for ($z = 0; $z < $product_num; $z++) {
								$product_data = $product_resultSet->fetch_assoc();

							?>
								<div class="product-widget">
									<?php

									$image_resultSet = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "';");
									$image_data = $image_resultSet->fetch_assoc();

									?>
									<div class="product-img">
										<img src="<?php echo $image_data["code"]; ?>" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Footwear</p>
										<h3 class="product-name"><a href="#"><?php echo $product_data["title"]; ?></a></h3>
										<h4 class="product-price">Rs. <?php echo $product_data["price"]; ?>.00</h4>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-xs-6">
					<div class="section-title">
						<h4 class="title" style="color: black;">Hand bags</h4>
						<div class="section-nav">
							<div id="slick-nav-3" class="products-slick-nav"></div>
						</div>
					</div>

					<div class="products-widget-slick" data-nav="#slick-nav-3">
						<div>
							<?php

							$product_resultSet = Database::search("SELECT * FROM `product` WHERE `category_id`= '2' AND `status_id` = '1' ORDER BY `qty` ASC LIMIT 4 OFFSET 0");

							$product_num = $product_resultSet->num_rows;

							for ($z = 0; $z < $product_num; $z++) {
								$product_data = $product_resultSet->fetch_assoc();

							?>
								<div class="product-widget">
									<?php

									$image_resultSet = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "';");
									$image_data = $image_resultSet->fetch_assoc();

									?>
									<div class="product-img">
										<img src="<?php echo $image_data["code"]; ?>" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Hand bags</p>
										<h3 class="product-name"><a href="#"><?php echo $product_data["title"]; ?></a></h3>
										<h4 class="product-price">Rs. <?php echo $product_data["price"]; ?>.00</h4>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-xs-6">
					<div class="section-title">
						<h4 class="title" style="color: black;">Fancy Items</h4>
						<div class="section-nav">
							<div id="slick-nav-3" class="products-slick-nav"></div>
						</div>
					</div>

					<div class="products-widget-slick" data-nav="#slick-nav-3">
						<div>
							<?php

							$product_resultSet = Database::search("SELECT * FROM `product` WHERE `category_id`= '3' AND `status_id` = '1' ORDER BY `qty` ASC LIMIT 4 OFFSET 0");

							$product_num = $product_resultSet->num_rows;

							for ($z = 0; $z < $product_num; $z++) {
								$product_data = $product_resultSet->fetch_assoc();

							?>
								<div class="product-widget">
									<?php

									$image_resultSet = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "';");
									$image_data = $image_resultSet->fetch_assoc();

									?>
									<div class="product-img">
										<img src="<?php echo $image_data["code"]; ?>" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Hand bags</p>
										<h3 class="product-name"><a href="#"><?php echo $product_data["title"]; ?></a></h3>
										<h4 class="product-price">Rs. <?php echo $product_data["price"]; ?>.00</h4>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-xs-6">
					<div class="section-title">
						<h4 class="title" style="color: black;">Beauty Collection</h4>
						<div class="section-nav">
							<div id="slick-nav-3" class="products-slick-nav"></div>
						</div>
					</div>

					<div class="products-widget-slick" data-nav="#slick-nav-3">
						<div>
							<?php

							$product_resultSet = Database::search("SELECT * FROM `product` WHERE `category_id`= '4' AND `status_id` = '1' ORDER BY `qty` ASC LIMIT 4 OFFSET 0");

							$product_num = $product_resultSet->num_rows;

							for ($z = 0; $z < $product_num; $z++) {
								$product_data = $product_resultSet->fetch_assoc();

							?>
								<div class="product-widget">
									<?php

									$image_resultSet = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "';");
									$image_data = $image_resultSet->fetch_assoc();

									?>
									<div class="product-img">
										<img src="<?php echo $image_data["code"]; ?>" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">Hand bags</p>
										<h3 class="product-name"><a href="#"><?php echo $product_data["title"]; ?></a></h3>
										<h4 class="product-price">Rs. <?php echo $product_data["price"]; ?>.00</h4>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="newsletter" class="section"></div>

	<?php require "footer.php" ?>

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<script src="script.js"></script>

</body>

</html>