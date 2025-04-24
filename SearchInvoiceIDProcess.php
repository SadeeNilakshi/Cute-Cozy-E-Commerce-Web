<?php
require "connection.php";

if (isset($_GET["id"])) {
  $invoice_id = $_GET["id"];

  $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `id` = '" . $invoice_id . "'");
  $invoice_num = $invoice_rs->num_rows;

  if ($invoice_num == 1) {

    $invoice_data = $invoice_rs->fetch_assoc();

    $title_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_data["product_id"] . "'");
    $title_data = $title_rs->fetch_assoc();

    $customer_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $invoice_data["user_email"] . "'");
    $customer_data = $customer_rs->fetch_assoc();
    $customer = $customer_data["fname"] . " " . $customer_data["lname"];

?>
    <div class="row mt-3 mb-3">

      <div class="col-2 col-md-1 col-lg-1 text-md-end text-center">
        <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $invoice_data["id"]; ?></label>
      </div>
      <div class="col-3 col-md-4 col-lg-4 text-md-end text-center rounded-start" style="background-color: #2B2D42;">
        <label class="form-label fs-6 fw-bold mt-1 mb-1" style="color:#d10024;"><?php echo $title_data["title"]; ?></label>
      </div>
      <div class="col-3 col-lg-2 d-none d-lg-block bg-dark text-end">
        <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $customer; ?></label>
      </div>
      <div class="col-3 col-md-3 col-lg-2 text-md-end text-center" style="background-color: #2B2D42;">
        <label class="form-label fs-6 fw-bold mt-1 mb-1" style="color:#d10024;">Rs.<?php echo $invoice_data["total"]; ?>.00</label>
      </div>
      <div class="col-2 col-md-2 col-lg-1 text-md-end text-center bg-dark">
        <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $invoice_data["iqty"]; ?></label>
      </div>
      <div class="col-1 col-md-2 col-lg-2 text-center">
        <?php
        if ($invoice_data["d_status"] == 0) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #8B8000; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Pending</button>
        <?php

        } else if ($invoice_data["d_status"] == 1) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #d10024; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $invoice_data['id']; ?>');">Packaging</button>
        <?php
        } else if ($invoice_data["d_status"] == 2) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #ca00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $invoice_data['id']; ?>');">Dispatching</button>
        <?php
        } else if ($invoice_data["d_status"] == 3) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #7d00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $invoice_data['id']; ?>');">Shipping</button>
        <?php
        } else if ($invoice_data["d_status"] == 4) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #1500d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $invoice_data['id']; ?>');">Delivering</button>
        <?php
        } else if ($invoice_data["d_status"] == 5) {
        ?>
          <button id="btn<?php echo $invoice_data["id"]; ?>" class="rounded-3 text-white my-2 disabled" style="background-color: #01944f; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $invoice_data['id']; ?>');">Completed</button>
        <?php
        }

        ?>
      </div>
    </div>
<?php

  } else {
    echo ("invalid Invoice ID");
  }
}
?>