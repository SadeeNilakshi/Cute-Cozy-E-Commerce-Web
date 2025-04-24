<!DOCTYPE html>
<html>
<?php
session_start();
require "connection.php";

if (isset($_SESSION["aduser"])) {

?>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Admin Panel Dashboard</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.png" />


  </head>

  <body class="body">
    <div class="col-12">
      <div class="row h-25" style="background-color: #2b2d42">
        <div class="col-lg-3 col-md-5 col-sm-12 mt-2">
          <p class="f3 text-white mt-2" style="
              display: flex;
              align-content: center;
              justify-content: center;
            ">
            Hi <?php echo $_SESSION["aduser"]["fname"] . " " . $_SESSION["aduser"]["lname"]; ?>
          </p>
        </div>

        <div class="col-lg-5 col-md-5 col-sm-12">
          <h2 class="f3 text-white mt-2" style="display: flex; align-items: center; justify-content: center">
            Admin Dashboard
            <a href="#" style="font-size: 30px; margin-left: 10px; color: #d10024"><i class="fa fa-tachometer" aria-hidden="true"></i></a>
          </h2>

        </div>
        <div class="col-lg-3 col-md-5 col-sm-12 mt-2">
          <p class="f3 text-white mt-2" style="
              display: flex;
              align-content: center;
              justify-content: center;
            " onclick="ADsignout();">
            Sign out
          </p>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="row" style="
          background-color: rgba(43, 45, 66, 0.91);
          display: flex;
          flex-direction: row;
        ">
        <div class="col-lg-12 offset-lg-1 offset-1 col-md-12 col-sm-12 mt-2 mb-2 ml-2">
          <ol class="breadcrumb-tree bread" style="
              display: inline-flex;
              flex-direction: row;
              justify-content: center;
              align-items: center;
            ">
            <li><a href="adminPanel.php" class="text-light text-decoration-none">Dashboard</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="manageAllUsers.php" class="text-light text-decoration-none">Manage Users</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="manageProducts.php" class="text-light text-decoration-none">Manage Products</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="sellingHistory.php" class="text-light text-decoration-none">Selling History</a></li>
            &nbsp; &#47; &nbsp;
            
            
          </ol>
          <ol class="breadcrumb-tree bread" style="
              display: inline-flex;
              flex-direction: row;
              justify-content: center;
              align-items: center;
            ">
          <li><a href="charts.php" class="text-light text-decoration-none">View Charts</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="UserReport.php" class="text-light text-decoration-none">View Reports</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="recent.php" class="text-light text-decoration-none">Recent Products</a></li>
            &nbsp; &#47; &nbsp;
            <li><a href="removedInv.php" class="text-light text-decoration-none">Removed Invoice</a></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-2 col-md-11 col-sm-12 mt-3 d-flex flex-column align-items-center rounded-4 mx-2 mb-2" style="background-color:rgba(43, 45, 66, 0.91); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold mt-2" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Daily Earnings</p>
            <?php

            $today = date("Y-m-d");
            $thismonth = date("m");
            $thisyear = date("Y");

            $a = "0";
            $b = "0";
            $c = "0";
            $e = "0";
            $f = "0";

            $invoice_rs = Database::search("SELECT * FROM `invoice`");
            $invoice_num = $invoice_rs->num_rows;

            for ($x = 0; $x < $invoice_num; $x++) {
              $invoice_data = $invoice_rs->fetch_assoc();

              $f = $f + $invoice_data["iqty"]; //total qty

              $d = $invoice_data["date"];
              $splitDate = explode(" ", $d); //separate date time
              $pdate = $splitDate[0]; //sold date

              if ($pdate == $today) {
                $a = $a + $invoice_data["total"];
                $c = $c + $invoice_data["iqty"];
              }

              $splitMonth = explode("-", $pdate); //separate year,month & date
              $pyear = $splitMonth[0]; // year
              $pmonth = $splitMonth[1]; // month

              if ($pyear == $thisyear) {
                if ($pmonth == $thismonth) {
                  $b = $b  + $invoice_data["total"];
                  $e = $e  + $invoice_data["iqty"];
                }
              }
            }

            ?>
            <p>Rs.<?php echo $a; ?> .00</p>
          </div>
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Monthly Earnings</p>
            <p>Rs.<?php echo $b; ?> .00</p>
          </div>
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Today Sellings</p>
            <p><?php echo $c; ?> items</p>
          </div>
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Monthly Sellings</p>
            <p><?php echo $e; ?> items</p>
          </div>
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Total Sellings</p>
            <p><?php echo $f; ?> items</p>
          </div>
          <div class="f4 col-lg-12 col-md-12 col-sm-10 dasboard-sm-box mt-3 mb-3 d-flex align-items-center justify-content-center flex-column rounded-3 fw-bold" style="background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mt-1">Total Engagements</p>
            <?php
            $user_Rs = Database::search("SELECT * FROM `user`");
            $user_num = $user_Rs->num_rows;
            ?>
            <p><?php echo $user_num; ?> Members</p>
          </div>
        </div>


        <div class="col-lg-9 col-md-11 col-sm-12 mt-3 rounded-4 mx-2 mb-2" style="background-color:rgba(43, 45, 66, 0.91); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
          <div class="f3 col-12 bg-white mt-3 rounded-3 fs-4 d-flex flex-row align-content-center justify-content-center active-time" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <p class="mx-2 my-2">Total Active Time</p>
            <?php

            $start_date = new DateTime("2024-04-01 00:00:00");

            $tdate = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $tdate->setTimezone($tz);

            $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

            $difference = $end_date->diff($start_date);

            ?>
            <p class="mx-5 my-2" style="color: #d10024; text-wrap: nowrap;">
              <?php
              echo $difference->format('%Y') . " Years " .
                $difference->format('%m') . " Months " .
                $difference->format('%d') . " Days " .
                $difference->format('%H') . " Hours " .
                $difference->format('%i') . " Minutes " .
                $difference->format('%s') . " Seconds ";
              ?></p>

          </div>
          <div class="col-12  d-flex flex-row justify-content-center mt-5 top-seller">
            <?php
            $freq_rs = Database::search("SELECT `product_id`,COUNT(`product_id`) AS `value_occurance`
                FROM `invoice` WHERE `date` LIKE '%" . $today . "%' GROUP BY `product_id` ORDER BY
                `value_occurance` DESC LIMIT 1");

            $freq_num = $freq_rs->num_rows;
            if ($freq_num > 0) {
              $freq_data = $freq_rs->fetch_assoc();

              $product_Rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $freq_data["product_id"] . "'");
              $product_data = $product_Rs->fetch_assoc();

              $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $freq_data["product_id"] . "'");
              $image_data = $image_rs->fetch_assoc();

              $qty_rs = Database::search("SELECT SUM(`iqty`) AS `qty_total` FROM `invoice` WHERE `product_id` = '" . $freq_data["product_id"] . "' AND `date` LIKE '%" . $today . "%'");
              $qty_data = $qty_rs->fetch_assoc();

            ?>
              <div class="col-lg-5 col-md-5 col-sm-10 dashboard-box my-2 mx-2 d-flex justify-content-center align-items-center flex-column rounded-3" style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <h6 class="f4 mt-2 fs-6 fw-bold">Mostly Sold Item</h6>

                <div class="dashboard-img" style="height: 300px; width: 300px;">
                  <img src="<?php echo $image_data["code"]; ?>" style="height: 100%; width: 100%; ">
                </div>
                <p class="f4 mt-2 fs-6"><?php echo $product_data["title"]; ?></p>
              </div>
            <?php
            } else {
            ?>
              <div class="col-lg-5 col-md-5 col-sm-10 dashboard-box my-2 mx-2 d-flex justify-content-center align-items-center flex-column rounded-3" style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <h6 class="f4 mt-2 fs-6 fw-bold">Mostly Sold Item</h6>
                <div class="dashboard-img" style="height: 300px; width: 300px;">
                  <img src="Category/fluffy3.jpg" style="height: 100%; width: 100%; ">
                </div>
                <p class="f4 mt-2 fs-6">No Most sold Item</p>
              </div>
            <?php
            }
            ?>

            <?php
            if ($freq_num > 0) {
              $proimg_rs = Database::search("SELECT * FROM `profile_image` WHERE
                 `user_email` = '" . $product_data["user_email"] . "'");
              $pro_data = $proimg_rs->fetch_assoc();

              $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
              $user_Data = $user_rs->fetch_assoc();

            ?>
              <div class="col-lg-5 col-md-5 col-sm-10 dashboard-box my-2 mx-2 d-flex justify-content-center align-items-center flex-column rounded-3" style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <h6 class="f4 mt-2 fs-6 fw-bold">Most Famous Seller</h6>
                <div class="dashboard-img" style="height: 300px; width: 300px;">
                  <img src="<?php echo $pro_data["path"]; ?>" style="height: 100%; width: 100%; ">
                </div>
                <p class="f4 mt-2 fs-6"><?php echo $user_Data["fname"] . " " . $user_Data["lname"]; ?></p>
              </div>
            <?php
            } else {
            ?>
              <div class="col-lg-5 col-md-5 col-sm-10 dashboard-box my-2 mx-2 d-flex justify-content-center align-items-center flex-column rounded-3" style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <h6 class="f4 mt-2 fs-6 fw-bold">Most Famous Seller</h6>
                <div class="dashboard-img" style="height: 300px; width: 300px;">
                  <img src="resources/user.png" style="height: 100%; width: 100%; ">
                </div>
                <p class="f4 mt-2 fs-6">No Famous Seller yet</p>
              </div>
            <?php
            }
            ?>
          </div>

        </div>
      </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
  </body>
<?php
} else {
  header("location:adminSignin.php");
}
?>

</html>