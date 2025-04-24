<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Checkout | Chanaka Electroinics</title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="bootstrap-icons.css" />
</head>

<body>
	<?php
	require "connection.php";
	session_start();
	include "header.php";
	if (isset($_SESSION["user"])) {
		$umail = $_SESSION["user"]["email"];
		$total = 0;
		$subtotal = 0;
		$shipping = 0;
	?>

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header text-danger">Checkout</h3>
						<ul class="breadcrumb-tree">
							<li><a href="cart.php">Cart</a></li>
							<li class="active">Checkout</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class=" col-12 col-lg-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title text-danger">Shipping address</h3>
							</div>

							<div class="form-group">
								<input class="input" type="text" name="first-name" value="<?php echo $_SESSION["user"]["fname"]; ?>" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="last-name" value="<?php echo $_SESSION["user"]["lname"]; ?>" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" value="<?php echo $_SESSION["user"]["email"]; ?>" readonly>
							</div>
							<div class="form-group">
								<?php
								$address_rs = Database::search("SELECT * FROM `user_has_address`
								INNER JOIN `city` ON `user_has_address`.`city_id` = `city`.`id`
								WHERE `user_email` = '" . $umail . "' ");
								$address_data = $address_rs->fetch_assoc();
								?>
								<input class="input" type="text" name="address" value="<?php echo $address_data["line1"] . ", " . $address_data["line2"]; ?>" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="city" value="<?php echo $address_data["city_name"]; ?>" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="zip-code" value="<?php echo $address_data["postal_code"]; ?>" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel" value="<?php echo $_SESSION["user"]["mobile"]; ?>" readonly>
							</div>

						</div>


						<!-- Shiping Details -->
						<div class="shiping-details">
							<div class="section-title">
								<h3 class="title text-danger">Billing address</h3>
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" value="Chanaka Electronics" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" value="chanakaelectro@gmail.com" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="address" value="No. 50, Independent Trade Center," readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="city" value="Bandarawela" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="country" value="Sri Lanka" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="zip-code" value="90100" readonly>
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel" value="+94 77 8200 344" readonly>
							</div>

						</div>
					</div>

					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<?php
							$cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $umail . "'");
							$cart_num = $cart_rs->num_rows;
							?>
							<h2 class="title text-danger">Checkout</h2>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<?php
								$query = "SELECT * FROM `product`";
								for ($x = 0; $x < $cart_num; $x++) {
									$cart_data = $cart_rs->fetch_assoc();

									$product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
									$product_data = $product_rs->fetch_assoc();

									$total = $total + ($product_data["price"] * $cart_data["qty"]);

									$seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $cart_data["user_email"] . "'");
									$seller_data = $seller_rs->fetch_assoc();
									$seller = $seller_data["fname"] . " " . $seller_data["lname"];

									$addrerss_Rsesultset1 = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id
									INNER JOIN `district` ON city.district_id=district.id WHERE `user_email`='" . $umail . "'");
									$addrerss_data1 = $addrerss_Rsesultset1->fetch_assoc();

									$ship = 0;

									if ($addrerss_data1["did"] == '3') {
										$ship = $product_data["delivery_fee_colombo"];
										$shipping = $shipping + $ship;
									} else {
										$ship = $product_data["delivery_fee_other"];
										$shipping = $shipping + $ship;
									}
		
									$countRs = Database::search("SELECT SUM(`cart`.`qty`)AS `CartQTY` FROM `cart` WHERE `user_email`='" . $umail . "'");
									$count_data = $countRs->fetch_assoc();

									$checkoutCountResultSet = Database::search("SELECT `product`.`delivery_fee_colombo`,`product`.`delivery_fee_other`,
									SUM(`product`.`price`*`cart`.`qty`)AS `price` FROM `cart` 
									INNER JOIN `product` ON `cart`.`product_id` = `product`.`id`
									WHERE `cart`.`user_email`='" . $umail . "'
									GROUP BY `product`.`delivery_fee_colombo`,`product`.`delivery_fee_other`");
									$checkoutCountData = $checkoutCountResultSet->fetch_assoc();
								?>
							</div>
							<div class="order-products">
								<div class="order-col">
									<div><?php echo $product_data["title"] ?></div>
									<div><?php echo $cart_data["qty"]; ?> items</div>
									<div>Rs. <?php echo $product_data["price"] * $cart_data["qty"]; ?> .00</div>
								</div>
							<?php
								}
							?>
							</div>

							<div class="order-col">
								<div><strong class="text-danger"><?php echo $count_data["CartQTY"]; ?></strong> Products Selected</div>
								<div><strong>Rs. <?php echo $total; ?> .00</strong></div>
							</div>
							<div class="order-col">
								<div id="qty_input">Shipping</div>
								<div><strong>Rs. <?php echo $shipping; ?> .00</strong></div>
							</div>
							<div class="order-col">
								<div><strong>Sub Total</strong></div>
								<div><strong class="text-danger">Rs. <?php echo ($shipping + $total); ?> .00</strong></div>
							</div>
						</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1">
								<label for="payment-1">
									<span></span>
									Direct Bank Transfer
								</label>
								<div class="caption">
									<p>Account Number :- 102068680627</p>
									<p>Account Type :- Savings Account</p>
									<p>Bank Name :- DFCC Bank</p>
									<p>Branch Name :- Bandarawela</p>
									<p>Account Holder Name :- H.P.K Tharindu Chanaka</p>
									<p>Country:- Sri Lanka</p><br>
								</div>
							</div>

							<div class="input-radio">
								<input type="radio" name="payment" id="payment-3">
								<label for="payment-3">
									<span></span>
									Paypal System
								</label>
								<div class="caption">
									<p>Paypal systems are accepted</p>
								</div>
							</div>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="terms">
							<label for="terms">
								<span></span>
								I've read and accept the <a href="#">terms & conditions</a>
							</label>
						</div>
						<button type="submit" id="payhere-payment" onclick="payNow(<?php echo $cart_data['product_id']; ?>);" class="primary-btn order-submit">Place order</button>
					</div>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->


		<!-- jQuery Plugins -->
		<script src="bootstrap.bundle.js"></script>
		<script src="script.js"></script>
		<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>

</body>
<?php
	}
?>

</html>