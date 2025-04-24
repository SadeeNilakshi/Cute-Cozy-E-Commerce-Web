<!DOCTYPE html>

<html>
<?php

session_start();
require "connection.php";

if (isset($_SESSION["aduser"])) {

  $email = $_SESSION["aduser"]["email"];
  $pageno;
?>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Selling History | Cute & Cozy</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.png" />

  </head>

  <body class="body" style="background-size: 115%; background-color: rgba(43, 45, 66, 0.91);">

    <div class="container-fluid">
      <div class="row">

        <div class="col-12 text-center" style="background-color:#2B2D42;">
          <label class="form-label text-light title1 fs-1 fw-bold f3">Selling History</label>&nbsp;
          <i class="bi bi-clipboard-minus" style="color: white; font-size: 30px;"></i>
        </div>

        <div class="col-12 border-0 border-end border-1 border-primary">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item f4"><a href="adminPanel.php" class="text-danger text-decoration-none">Back to Admin Panel</a></li>
              <li class="breadcrumb-item active text-light f4" aria-current="page">Selling History</li>
            </ol>
          </nav>
        </div>

        <div class="col-12 main-body mt-3 mb-3">
          <div class="row">
            <div class="col-12 col-lg-3 mt-2">
              <label class="form-label fs-6 text-white fw-bold text-uppercase">Search By invoice ID :</label>
              <input type="text" class="form-control border border-2 border-danger bg-dark text-light fs-6" placeholder="invoice ID Here ..." id="searchtxt" onkeyup="searchInvoiceID();" />
            </div>
            <div class="col-12 col-lg-3 offset-lg-2 mt-2">
              <label class="form-label text-white fw-bold text-uppercase fs-6">From Date :
              </label>
              <input type="date" class="form-control fs-6 text-light bg-dark border border-2" id="from" />
            </div>
            <div class="col-12 col-lg-3 mt-2">
              <label class="form-label text-white fw-bold text-uppercase fs-6">To Date :
              </label>
              <input type="date" class="form-control fs-6 text-light bg-dark border border-2" id="to" />
            </div>
            <div class="col-12 col-lg-1" style="margin-top: 40px;">
              <button class="btn bg-white border border-3 text-uppercase fw-bold rounded-5" style="color: #d10024; font-size: 14px; border-color: #d10024;" onclick="findSellings();">Find
              </button>
            </div>
          </div>
        </div>


        <div class="col-12">
          <div class="row align-items-center">

            <div class="col-2 col-md-1 col-lg-1 bg-dark text-md-end text-center rounded-start">
              <label class="form-label fs-5 fw-bold text-white">ID</label>
            </div>
            <div class="col-3 col-md-4 col-lg-4 text-md-end text-center" style="background-color: #2B2D42;">
              <label class="form-label fs-5 fw-bold" style="color:#d10024;">Product</label>
            </div>
            <div class="col-3 col-lg-2 d-none d-lg-block bg-dark text-end">
              <label class="form-label fs-5 fw-bold text-white">Buyer</label>
            </div>
            <div class="col-3 col-md-3 col-lg-2 text-md-end text-center" style="background-color: #2B2D42;">
              <label class="form-label fs-5 fw-bold" style="color:#d10024;">Amount</label>
            </div>
            <div class="col-2 col-md-2 col-lg-1 bg-dark text-md-end text-center rounded-end">
              <label class="form-label fs-5 fw-bold text-white">QTY</label>
            </div>
            <div class="col-lg-1 col-3 d-none d-md-block bg-transparent"></div>

          </div>
        </div>


        <?php

        ?>
        <div class="col-12 mt-2 " id="viewarea">
          <?php
          $query = "SELECT * FROM `invoice`";

          $pageno;

          if (isset($_GET["page"])) {
            $pageno = $_GET["page"];
          } else {
            $pageno = 1;
          }

          $results_per_page = 10;


          $page_results = ($pageno - 1) * $results_per_page;

          $product_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");
          $product_num = $product_rs->num_rows;

          $number_of_pages = ceil($product_num / $results_per_page);

          for ($x = 0; $x < $product_num; $x++) {
            $product_data = $product_rs->fetch_assoc();

            $title_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $product_data["product_id"] . "'");
            $title_data = $title_rs->fetch_assoc();

            $customer_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
            $customer_data = $customer_rs->fetch_assoc();
            $customer = $customer_data["fname"] . " " . $customer_data["lname"];


          ?>
            <div class="row mt-3 mb-3">

              <div class="col-2 col-md-1 col-lg-1 text-md-end text-center">
                <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $product_data["id"]; ?></label>
              </div>
              <div class="col-3 col-md-4 col-lg-4 text-md-end text-center rounded-start" style="background-color: #2B2D42;">
                <label class="form-label fs-6 fw-bold mt-1 mb-1" style="color:#d10024;"><?php echo $title_data["title"]; ?></label>
              </div>
              <div class="col-3 col-lg-2 d-none d-lg-block bg-dark text-end">
                <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $customer; ?></label>
              </div>
              <div class="col-3 col-md-3 col-lg-2 text-md-end text-center" style="background-color: #2B2D42;">
                <label class="form-label fs-6 fw-bold mt-1 mb-1" style="color:#d10024;">Rs.<?php echo $product_data["total"]; ?>.00</label>
              </div>
              <div class="col-2 col-md-2 col-lg-1 text-md-end text-center bg-dark">
                <label class="form-label fs-6 fw-bold text-white mt-1 mb-1"><?php echo $product_data["iqty"]; ?></label>
              </div>
              <div class="col-1 col-md-2 col-lg-2 text-center">
                <?php if ($product_data["d_status"] == 0) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: 	#8B8000; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Pending</button>

                  </button>
                <?php } else if ($product_data["d_status"] == 1) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #d10024; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Packaging</button>

                  </button>
                <?php } else if ($product_data["d_status"] == 2) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #ca00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Dispatching</button>

                  </button>
                <?php } else if ($product_data["d_status"] == 3) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #7d00d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Shipping</button>

                  </button>
                <?php } else if ($product_data["d_status"] == 4) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2" style="background-color: #1500d1; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Delivering</button>

                  </button>
                <?php } else if ($product_data["d_status"] == 5) { ?>
                  <button id="btn<?php echo $product_data["id"]; ?>" class="rounded-3 text-white my-2 disabled" style="background-color: #01944f; border: none; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeInvStatus('<?php echo $product_data['id']; ?>');">Completed</button>

                  </button>
                <?php } ?>
              </div>
            </div>

          <?php
          }
          ?>
        </div>

        <!--  -->
        <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-lg justify-content-center">
                            <li class="page-item">
                                <a class="page-link  fw-bold" style="color: #d10024;" href="<?php if ($pageno <= 1) {
                                                                                                echo ("#");
                                                                                            } else {
                                                                                                echo "?page=" . ($pageno - 1);
                                                                                            } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php

                            for ($x = 1; $x <= $number_of_pages; $x++) {
                                if ($x == $pageno) {
                            ?>
                                    <li class="page-item active">
                                        <a class="page-link  fw-bold" style="background-color: #d10024; border: none;" href="<?php echo "?page=" . ($x) ?>"><?php echo $x; ?></a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a class="page-link  fw-bold" style="border: none;" href="<?php echo "?page=" . ($x) ?>"><?php echo $x; ?></a>
                                    </li>
                            <?php
                                }
                            }

                            ?>

                            <li class="page-item">
                                <a class="page-link  fw-bold" style="color: #d10024;" href="<?php if ($pageno >= $number_of_pages) {
                                                                                                echo ("#");
                                                                                            } else {
                                                                                                echo "?page=" . ($pageno + 1);
                                                                                            } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
        <!--  -->


      </div>
    </div>


    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
  </body>

</html>
<?php

} else {
  header("location:adminPanel.php");
}
?>