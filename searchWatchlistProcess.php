<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
   if (isset($_GET["s"])) {

      $search = $_GET["s"];
      $user = $_SESSION["user"]["email"];

      $p_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $search . "%'");
      $pid = $p_rs->fetch_assoc();

      $watch_rs = Database::search("SELECT * FROM `wishlist` WHERE `user_email`='" . $user . "' 
  AND `product_id` = '" . $pid["id"] . "'");

      $watch_num = $watch_rs->num_rows;
      if ($watch_num == 0) {
?>
         <!-- empty view -->
         <div class="col-12 ">
            <div class="row">
               <div class="col-12 emptyView"></div><br>
               <div class="col-12 text-center">
                  <label class="form-label f" style="font-size: 22px; font-weight: normal;">You have no items in your Watchlist
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
         <!-- <responsive-Large-screen> -->
         <div class="row " style="display: flex; justify-content: center;">
            <?php
            $query = "SELECT * FROM `product`";

            for ($x = 0; $x < $watch_num; $x++) {
               $watch_data = $watch_rs->fetch_assoc();

               $product_rs = Database::search("SELECT* FROM `product` WHERE `id`='" . $watch_data["product_id"] . "'");
               $product_data = $product_rs->fetch_assoc();

               $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $watch_data["product_id"] . "'");
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
               <div class="wishlist-box1 col-lg-6" style="height:325px; width:58%; margin-bottom: 20px;">
                  <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: center; display: flex; justify-content: center;">
                     <div class="product-image">

                        <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                     </div>
                     <div class="product-details" style="margin-left: 15px;">
                        <div class="product-body">
                           <h3 class="product-name" id="t"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                           <h4 class="product-price">Rs.<?php echo $price; ?>.00 <del class="product-old-price">Rs.<?php echo $new_price; ?>.00</del></h4><br>
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
                           <div class="product-label1">
                              <span class="new">NEW</span>
                           </div>
                           <div class="product-btns">

                              <a href="<?php echo "SingleProductView.php?id=" . $product_data["id"]; ?>"><i class="fa fa-eye" style="margin-top: 15px;"></i>&nbsp;Quick View</a>

                           </div>


                        </div>


                     </div>
                     <div class="product-details" style="margin-left: 15px;">

                        <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                           <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick="AddtoCart(<?php echo $product_data['id']; ?>);"><i class="fa fa-shopping-cart"></i> add to cart</button>
                           <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 275px;";><i class="fa fa-usd"></i>buy now</button> -->
                           <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick='removeFromWatchList(<?php echo $watch_data["id"]; ?>);'><i class="fa fa-trash"></i>remove</button>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- <responsive-Large-screen> -->

         <!-- <responsive-medium-screen> -->
         <div class="row " style="display: flex; justify-content: center;">
            <div class="wishlist-box2 d-lg-none" style="height:325px; width: 80%;">
               <div class="product-wishlist" style="display:flex; flex-direction:row; display: flex; align-items: center; display: flex; justify-content: center;">
                  <div class="product-image">

                     <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                  </div>
                  <div class="product-details" style="margin-left: 20px;">
                     <div class="product-body">
                        <h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                        <h4 class="product-price">Rs.<?php echo $price; ?>.00 <del class="product-old-price">Rs.<?php echo $new_price; ?>.00 </del></h4><br>
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
                        <div class="product-label1">
                           <span class="new">NEW</span>
                        </div>
                        <div class="product-btns">

                           <a href="<?php echo "SingleProductView.php?id=" . $product_data["id"]; ?>"><i class="fa fa-eye" style="margin-top: 15px;"></i>&nbsp;Quick View</a>

                        </div>


                     </div>


                  </div>
                  <div class="product-details" style="margin-right: 8px;">

                     <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                        <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick="AddtoCart(<?php echo $product_data['id']; ?>);"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 275px;";><i class="fa fa-usd"></i>buy now</button> -->
                        <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick='removeFromWatchList(<?php echo $watch_data["id"]; ?>);'><i class="fa fa-trash"></i>remove</button>
                     </div>


                  </div>
               </div>
            </div>
         </div>
         <!-- <responsive-medium-screen> -->

         <!-- <responsive-small-screen> -->
         <div class="row " style="display: flex; justify-content: center;">
            <div class="wishlist-box3" style="height:520px; width:60%; margin-bottom: 90px;">
               <div class="product-wishlist" style="display:flex; flex-direction:column; display: flex; align-items: center; display: flex; justify-content: center;">
                  <div class="product-image" style="width: 70%; height: 275px;">

                     <img src="<?php echo $image_data["code"]; ?>" alt="" class="img">

                  </div>
                  <div class="product-details" style="margin-left: 20px;">
                     <div class="product-body">
                        <h3 class="product-name"><a href="#"><?php echo $product_data["title"] ?></a></h3>
                        <h4 class="product-price">Rs.<?php echo $price; ?>.00 <del class="product-old-price">Rs.<?php echo $new_price; ?>.00 </del></h4><br>
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
                        <div class="product-label1">
                           <span class="new">NEW</span>
                        </div>
                        <div class="product-btns">

                           <a href="<?php echo "SingleProductView.php?id=" . $product_data["id"]; ?>"><i class="fa fa-eye" style="margin-top: 15px;"></i>&nbsp;Quick View</a>

                        </div>


                     </div>


                  </div>
                  <div class="product-details">

                     <div class="add-to-cart" style="display: flex; flex-direction: column; ">
                        <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick="AddtoCart(<?php echo $product_data['id']; ?>);"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        <!-- <button class="add-to-cart-btn" style="margin-top: 10px; width: 275px;";><i class="fa fa-usd"></i>buy now</button> -->
                        <button class="add-to-cart-btn" style="margin-top: 10px; width: 250px;" onclick='removeFromWatchList(<?php echo $watch_data["id"]; ?>);'><i class="fa fa-trash"></i>remove</button>
                     </div>
                  </div>

               </div>

            </div>
         <?php
            }
         }
         ?>
         </div>
         <!-- <responsive-small-screen> -->

         <?php require "footer.php"; ?>
<?php
   } else {
      header("location:wishlist.php");
   }
} else {
   header("location:home.php");
}

?>