<!DOCTYPE html>
<html>
<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
  if (isset($_SESSION["product"])) {

    $email = $_SESSION["user"]["email"];
    $pageno;
?>

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />

      <title>Update <?php echo $_SESSION["product"]["title"]; ?></title>

      <link rel="stylesheet" href="bootstrap.css" />
      <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
      <link type="text/css" rel="stylesheet" href="css/slick.css" />
      <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
      <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <link type="text/css" rel="stylesheet" href="css/style.css" />

      <link rel="icon" href="resources/logo.png" />
    </head>

    <body class="body" style="background-color: rgba(43, 45, 66, 0.91);">

      <div class="col-12">
        <div class="row">
          <div class="col-12 d-flex justify-content-center align-items-center">
            <div class="row ">
              <h2 class="f3 text-white mt-2">Update <?php echo $_SESSION["product"]["title"]; ?></h2>
            </div>
          </div>
          <div class="col-12 d-none" id="addmsgdiv">
            <div class="alert alert-danger" role="alert" id="addalertdiv">
              <i class="bi bi-x-octagon-fill fs-5" id="addmsg"></i>
            </div>
          </div>
          <div class="col-12">
            <div class="row d-flex justify-content-center mt-3 add-product-details">
              <div class="col-lg-5 col-md-5 col-sm-10 mx-2 my-2">
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Selected Category</label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <select class="form-select text-center text-white rounded-4" disabled style="height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; font-size: medium;">
                    <?php
                    $product = $_SESSION["product"];

                    $category_Resultset =
                      Database::search("SELECT * FROM `category`
                          WHERE `c_id` = '" . $product["category_id"] . "';");

                    $category_data = $category_Resultset->fetch_assoc();

                    ?>
                    <option><?php echo $category_data["name"]; ?></option>
                  </select>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Selected Title</label>
                </div>
                <div class="col-12">
                  <input type="text" disabled class="form-control f1 text-white rounded-4" value="<?php echo $product["title"]; ?>" style="height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Update Quantity</label>
                </div>
                <div class="input-number col-12 d-flex justify-content-center">
                  <input type="number" class="rounded-4 f1 text-white" value="<?php echo $product["qty"]; ?>" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" min="0" pattern="[0-9]" id="upqty">
                </div>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-10 mx-2 my-2 add-product-detail-box-2" style="border-left:2px solid #d10024;">
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Cost Per Item</label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                  <input type="number" value="<?php echo $product["price"]; ?>" disabled class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">.00</span>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Update Delivery Cost - Colombo</label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                  <input type="number" id="updwc" value="<?php echo $product["delivery_fee_colombo"]; ?>" class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">.00</span>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <label class="text-white my-2">Delivery Cost - Other</label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                  <input type="number" id="updoc" value="<?php echo $product["delivery_fee_other"]; ?>" class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                  <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">.00</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <hr class="" style="border-width: 3px; color: white;" />
          </div>

          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-12">
                <div class="row">
                  <div class="col-12 text-center">
                    <label class="form-label fw-bold text-white f5" style="font-size: 20px;">Product Description</label>
                  </div>
                  <div class="col-12 add-description-box">
                    <textarea class="form-control f5 rounded-4" id="updesc" placeholder="Add product description..." cols="30" rows="20" style="font-size: 15px; border: none; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; width: 100%; min-height: 200px;"><?php echo $product["description"]; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <hr class="" style="border-width: 3px; color: white;" />
          </div>
          <div class="col-12">
            <div class="row">
              <div class="col-12 text-center">
                <label class="form-label fw-bold text-white" style="font-size:20px;">Update Product Image</label>
              </div>

              <div class="col-lg-10 offset-lg-1 col-10 offset-1">
                <?php
                $img = array();
                $img[0] = "resources\addproductimg.svg";
                $img[1] = "resources\addproductimg.svg";
                $img[2] = "resources\addproductimg.svg";
                $img[3] = "resources\addproductimg.svg";
                $img[4] = "resources\addproductimg.svg";
                $img[5] = "resources\addproductimg.svg";

                $image_Resultset =
                  Database::search("SELECT * FROM `image`
                                    WHERE `product_id` = '" . $product["id"] . "'");

                $image_num = $image_Resultset->num_rows;

                for ($x = 0; $x < $image_num; $x++) {
                  $image_data = $image_Resultset->fetch_assoc();
                  $img[$x] = $image_data["code"];
                }
                ?>
                <div class="row">
                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[0]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i0" />
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[1]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i1" />
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[2]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i2" />
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[3]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i3" />
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[4]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i4" />
                  </div>

                  <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                    <img src="<?php echo $img[5]; ?>" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i5" />
                  </div>
                </div>
              </div>


              <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-3">
                <input type="file" class="d-none" id="imageuploder" multiple />
                <label for="imageuploder" class="col-12 btn btn-outline-danger fw-bold text-white" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeProductimg();">Upload Images</label>
              </div>
            </div>
          </div>

          <div class="col-12">
            <hr class="" style="border-width: 3px; color: white;" />
          </div>

          <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-3 mb-3">
            <button class="btn btn-outline-danger fw-bold text-white" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="Updateproduct();">Update Product</button>
          </div>

        </div>

      </div>

      <?php require "footer.php"; ?>

      <script src="bootstrap.bundle.js"></script>
      <script src="script.js"></script>
    </body>

</html>
<?php
  } else {
    header("location : myProducts.php");
  }
} else {
  header("location:home.php");
}
?>