<?php
session_start();
require "connection.php";

if (isset($_GET["mp"])) {

  $search = $_GET["mp"];

  $query = "SELECT * FROM `product`";
  $p_rs = Database::search($query . "WHERE `title` LIKE '%" . $search . "%'");

  $p_num = $p_rs->num_rows;
  if ($p_num == 0) {
    echo ("There is not that kind a product");
  } else {

    for ($x = 0; $x < $p_num; $x++) {
      $p_data = $p_rs->fetch_assoc();

      $product_img_rs = Database::search("SELECT * FROM `image` 
        WHERE `product_id` = '" . $p_data["id"] . "';");

      $product_img_data = $product_img_rs->fetch_assoc();

?>

      <div class="col-12">
        <div class="row mx-2 my-3 rounded-3 " style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
          <div class="col-lg-1 text-end">
            <label class="form-label text-white f4 fs-6 my-2"><?php echo $p_data["id"]; ?></label>
          </div>
          <div class="col-lg-2 d-flex justify-content-center my-1">
            <img src="<?php echo $product_img_data["code"]; ?>" style="height: 40px;">

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data["title"]; ?></label>

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white">Rs. <?php echo $p_data["price"]; ?>.00</label>

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data["qty"]; ?></label>

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data["datetime_added"]; ?></label>

          </div>
          <div class="col-lg-1">
            <?php

            if ($p_data["status_id"] == 1) {
            ?>
              <button id="pb<?php echo $p_data['id']; ?>" class="rounded-3 text-white my-2" style="background-color: #0073e6; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockProduct('<?php echo $p_data['id']; ?>');">Block</button>
            <?php
            } else {
            ?>
              <button id="pb<?php echo $p_data['id']; ?>" class="rounded-3 text-white my-2" style="background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockProduct('<?php echo $p_data['id']; ?>');">Unblock</button>
            <?php
            }
            ?>

          </div>

        </div>
      </div>

    <?php

    }

    ?>
<?php
  }
}

?>