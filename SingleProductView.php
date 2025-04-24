<!DOCTYPE html>
<?php
session_start();
require "connection.php";
require "header.php";
if (isset($_GET["id"])) {
	$pid = $_GET["id"];

	$product_Resultset =
		Database::search("SELECT product.id,product.price,product.qty,product.description,product.title,product.datetime_added,product.delivery_fee_colombo,
product.delivery_fee_other,product.category_id,product.status_id,product.user_email FROM `product` WHERE product.id='" . $pid . "'");
	$product_num = $product_Resultset->num_rows;
	if ($product_num == 1) {
		$product_data = $product_Resultset->fetch_assoc();


		if (isset($_SESSION["user"])) {
			$email = $_SESSION["user"]["email"];

?>
			<html lang="en">

			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="icon" href="resources/logo.png" />
				<title><?php echo $product_data["title"]; ?></title>


				<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
				<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
				<link type="text/css" rel="stylesheet" href="css/slick.css" />
				<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
				<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />
				<link rel="stylesheet" href="css/font-awesome.min.css">
				<link type="text/css" rel="stylesheet" href="css/style.css" />
				<link rel="stylesheet" href="style.css">
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
				<link rel="stylesheet" href="bootstrap.css" />

			</head>

			<body style="overflow-x: hidden;">
				<!-- SECTION -->
				<div class="section">
					<!-- container -->
					<div class="container">
						<!-- row -->
						<div class="row">
							<!-- Product main img -->
							<!-- Product main img -->
							<div class="col-md-5 col-md-push-2">
								<div id="product-main-img">
									<?php
									$image_Rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "'");
									$image_num = $image_Rs->num_rows;

									$img = array();

									if ($image_num != 0) {

										for ($y = 0; $y < $image_num; $y++) {
											$image_data = $image_Rs->fetch_assoc();
											$img[$y] = $image_data["code"];

									?>
											<div class="product-preview">
												<img src="<?php echo $img["$y"]; ?>" />
											</div>
										<?php

										}
										?>
								</div>
							</div>
							<!-- /Product main img -->
							<!-- /Product main img -->

							<!-- Product thumb imgs -->
							<div class="col-md-2  col-md-pull-5">
								<div id="product-imgs">
									<?php

										$image_Rs1 = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "'");
										$image_num1 = $image_Rs1->num_rows;

										$img1 = array();

										if ($image_num1 != 0) {

											for ($x = 0; $x < $image_num1; $x++) {
												$image_data1 = $image_Rs1->fetch_assoc();
												$img1[$x] = $image_data1["code"];

									?>
											<div class="product-preview">
												<img src="<?php echo $img1["$x"]; ?>" />
											</div>
									<?php
											}
										}

									?>
								</div>
							</div>
							<!-- /Product thumb imgs -->
						<?php

									}
						?>
						<!-- Product details -->
						<div class="col-md-5">
							<div class="product-details">
								<?php

								?>
								<h2 class="product-name" style="color: black;"><?php echo $product_data["title"]; ?></h2>
								<div>
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

								</div>
								<div>
									<?php

									$price = $product_data["price"];
									$adding_price = ($price / 100) * 5;
									$new_price = $price + $adding_price;
									$difference = $new_price - $price;
									$percentage = ($difference / $price) * 100;

									?>
									<h3 class="product-price">Rs.<?php echo $price; ?>.00 <del class="product-old-price">Rs.<?php echo $new_price; ?>.00</del></h3>
									<div><span class="product-available"> <?php echo $product_data["qty"]; ?> In Stock</span>
									</div>
								</div>
								<div class="">
									<div class="qty-label" style="width: 275px; margin-top: 10px;">
										<div class="input-number">
											<input type="number" style="outline: none;" value="1" pattern="[0-9]" id="qty_input" onkeyup='checkValue(<?php echo $product_data["qty"]; ?>);'>
											<span class="qty-up" onclick='qty_inc(<?php echo $product_data["qty"]; ?>);'>+</span>
											<span class="qty-down" onclick='qty_dec(<?php echo $product_data["qty"]; ?>);'>-</span>
										</div>
									</div>

								</div>
								<div class="add-to-cart" style="display: flex; flex-direction: column;">
									<button class="add-to-cart-btn" style="margin-top: 10px; width: 275px;" ; type="submit" id="payhere-payment" onclick="payNow(<?php echo $pid; ?>);"><i class="fa fa-usd"></i>buy
										now</button>

								</div>

								<ul class="product-btns">
									<?php

									$watchlist_Resultset = Database::search("SELECT * FROM `wishlist` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`= '" . $email . "'");
									$watchlist_num = $watchlist_Resultset->num_rows;

									if ($watchlist_num == 1) {
									?>
										<li><a href="#" onclick='addWishlist(<?php echo $product_data["id"]; ?>);'>
												<i class="fa fa-heart-o text-danger" id='heart<?php echo $product_data["id"]; ?>'></i> Remove from wishlist</a></li>
									<?php

									} else {

									?>
										<li><a href="#" onclick='addWishlist(<?php echo $product_data["id"]; ?>);'>
												<i class="fa fa-heart-o text-dark" id='heart<?php echo $product_data["id"]; ?>'></i>
												add to wishlist</a></li>
								<?php
									}
								}
								?>
								</ul>
								<ul class="product-links">
									<li>Share:</li>
									<li><a href="#"><i class="fa fa-facebook-official"></i></a></li>
									<li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
									<li><a href="#"><i class="fa fa-youtube"></i></a></li>

								</ul>
							</div>

						</div>
						<!-- /Product details -->

						<!-- Product tab -->
						<div class="col-md-12">

							<div id="product-tab">
								<!-- product tab nav -->
								<ul class="tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
									<?php
									$Rf_rs = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $product_data["id"] . "' ORDER BY `date` DESC");
									$Rf_num = $Rf_rs->num_rows;
									$Rf_data = $Rf_rs->fetch_assoc();
									?>
									<li><a data-toggle="tab" href="#tab3">Reviews (<?php echo $Rf_num; ?>)</a></li>
								</ul>
								<!-- /product tab nav -->

								<!-- product tab content -->
								<div class="tab-content">
									<!-- tab1  -->
									<div id="tab1" class="tab-pane fade in active">
										<div class="row">
											<div class="col-md-12">
												<p><?php echo $product_data["description"]; ?></p>
											</div>
										</div>
									</div>
									<!-- /tab1  -->

									<!-- tab3  -->
									<div id="tab3" class="tab-pane fade in">
										<div class="row">
											<!-- Rating -->
											<?php
											if ($Rf_num == 0) {
											?>
												<div class="col-md-3 d-none">
												<?php
											} else {
												?>
													<div class="col-md-3 d-sm-block d-lg-none">
													<?php
												}
													?>
													<div id="rating">
														<?php
														if ($Rf_data["type"] == 5) {
														?>
															<div class="rating-avg">
																<span>5.0</span>
																<div class="rating-stars">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																</div>
															</div>
														<?php
														}
														?>

														<?php
														if ($Rf_data["type"] == 4) {
														?>
															<div class="rating-avg">
																<span>4.5</span>
																<div class="rating-stars">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star-o"></i>
																</div>
															</div>
														<?php
														}
														?>

														<?php
														if ($Rf_data["type"] == 3) {
														?>
															<div class="rating-avg">
																<span>3.5</span>
																<div class="rating-stars">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																</div>
															</div>
														<?php
														}
														?>


														<?php
														if ($Rf_data["type"] == 2) {
														?>
															<div class="rating-avg">
																<span>2.5</span>
																<div class="rating-stars">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																</div>
															</div>
														<?php
														}
														?>

														<?php
														if ($Rf_data["type"] == 1) {
														?>
															<div class="rating-avg">
																<span>1.0</span>
																<div class="rating-stars">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																</div>
															</div>
														<?php
														}
														?>
													</div>
													</div>
													<!-- /Rating -->

													<!-- Reviews -->
													<div class="col-md-7">
														<div id="reviews">
															<ul class="reviews" id="view_area">
																<?php
																$feedback_rs = Database::search("SELECT * FROM `feedback` INNER JOIN `user` ON feedback.user_email=user.email WHERE `product_id`='" . $product_data["id"] . "'");
																$feedback_num = $feedback_rs->num_rows;

																for ($y = 0; $y < $feedback_num; $y++) {
																	$feedback_data = $feedback_rs->fetch_assoc();

																?>
																	<li>
																		<div class="review-heading">
																			<h5 class="name text-dark">
																				<?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?>
																			</h5>

																			<p class="date"><?php echo $feedback_data["date"]; ?></p>
																			<div class="review-rating">
																				<?php
																				if ($feedback_data["type"] == 5) {
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
																				if ($feedback_data["type"] == 4) {
																				?>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star-o empty"></i>
																				<?php
																				}
																				?>

																				<?php
																				if ($feedback_data["type"] == 3) {
																				?>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																				<?php
																				}
																				?>

																				<?php
																				if ($feedback_data["type"] == 2) {
																				?>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																				<?php
																				}
																				?>
																				<?php
																				if ($feedback_data["type"] == 1) {
																				?>
																					<i class="fa fa-star"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																					<i class="fa fa-star-o empty"></i>
																				<?php
																				}
																				?>
																			</div>
																		</div>
																		<div class="review-body">
																			<p><?php echo $feedback_data["feedback"]; ?></p>
																		</div>
																	</li>
																<?php

																}

																?>
															</ul>
														</div>
													</div>
													<!-- /Reviews -->

													<!-- Review Form -->
													<div class="col-md-5">
														<div id="review-form">
															<div class="review-form">
																<textarea class="input" placeholder="Your Review" id="feed"></textarea>
																<div class="input-rating">
																	<span>Your Rating: </span>
																	<div class="stars">
																		<input id="type5" name="rating" value="5" type="radio" /><label for="type5" checked></label>
																		<input id="type4" name="rating" value="4" type="radio"><label for="type4" checked></label>
																		<input id="type3" name="rating" value="3" type="radio" /><label for="type3" checked></label>
																		<input id="type2" name="rating" value="2" type="radio" /><label for="type2" checked></label>
																		<input id="type1" name="rating" value="1" type="radio" /><label for="type1" checked></label>
																	</div>
																</div>
																<button class="primary-btn" onclick="saveFeedback(<?php echo $pid; ?>);">Submit</button>
															</div>
														</div>
														<br>
														<div class="col-12 d-none" id="addmsgdiv">
															<div class="alert alert-success" role="alert" id="addalertdiv">
																<i class="bi bi-check2-circle fs-5" id="addmsg">
																</i>
															</div>
														</div>
													</div>
													<!-- Review Form -->

												</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						</div>
					</div>

					<!-- jQuery Plugins -->
					<!-- <script src="js/jquery.min.js"></script> -->
					<script src="js/bootstrap.min.js"></script>
					<script src="js/slick.min.js"></script>
					<script src="js/nouislider.min.js"></script>
					<script src="js/jquery.zoom.min.js"></script>
					<script src="js/main.js"></script>
					<script src="bootstrap.bundle.js"></script>
					<script src="script.js"></script>
					<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>



			</body>

			</html>
	<?php

	} else {
		echo ("Sorry for the inconvenience");
	}
}

	?>
	<?php require "footer.php" ?>