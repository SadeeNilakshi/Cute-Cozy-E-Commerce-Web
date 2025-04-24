<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
  if (isset($_GET["c"])) {

    $search = $_GET["c"];
    $email = $_SESSION["user"]["email"];

    $total = 0;
    $subtotal = 0;
    $shipping = 0;

    $p_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $search . "%'");
    $p_data = $p_rs->fetch_assoc();

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' 
    AND `product_id` = '" . $p_data['id'] . "'");
    $cart_num = $cart_rs->num_rows;

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

          $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $cart_data["user_email"] . "'");
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
                              <p class="product-category">Seller: <?php echo $product_data["user_email"]; ?></p>
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
<?php
}
?>

<!-- <responsive-medium-screen> -->
<div class="col-12">
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

      $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $cart_data["user_email"] . "'");
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
                          <p class="product-category">Seller: <?php echo $product_data["admin_email"]; ?></p>
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
<div class="col-12">
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

      $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $cart_data["user_email"] . "'");
      $seller_data = $seller_rs->fetch_assoc();
      $seller = $seller_data["fname"] . " " . $seller_data["lname"];

  ?>
      <div class="row " style="display: flex; justify-content: center;">

          <div class="wishlist-box3" style="height:520px; width:60%; margin-top: 150px;">
              <div class="product-wishlist" style="display:flex; flex-direction:column; display: flex; align-items: center; display: flex; justify-content: center;">
                  <div class="product-image" style="width: 70%; height: 275px;">

                      <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                  </div>
                  <div class="product-details" style="margin-left: 15px;">
                      <div class="product-body">
                          <p class="product-category">Seller: <?php echo $product_data["admin_email"]; ?></p>
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

<?php
    }
  } else {
    echo ("something went wrong");
  }

?>