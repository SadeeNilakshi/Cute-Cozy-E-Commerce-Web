<!DOCTYPE html>
<html>
<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

  $email = $_SESSION["user"]["email"];
  $pageno;
?>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Add Product | Cute & Cozy</title>

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
            <h2 class="f3 text-white mt-2">Add Your Product Here</h2>
          </div>
        </div>
        <div class="col-10 offset-1">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item fw-bold"><a href="myProducts.php" class="text-danger">Back</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Product Registration</li>
            </ol>
          </nav>
        </div>
        <div class="col-12 d-none" id="addmsgdiv">
          <div class="alert alert-success" role="alert" id="addalertdiv">
            <i class="bi bi-check2-circle fs-5" id="addmsg">

            </i>
          </div>
        </div>
        <div class="col-12">
          <div class="row d-flex justify-content-center mt-3 add-product-details">
            <div class="col-lg-5 col-md-5 col-sm-10 mx-2 my-2">
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Select Category</label>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <select class="form-select text-center text-white rounded-4" id="category" style="height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; font-size: medium;">
                  <?php
                  $category_rs = Database::search("SELECT * FROM `category`");
                  $category_num = $category_rs->num_rows;

                  for ($x = 0; $x < $category_num; $x++) {
                    $category_data = $category_rs->fetch_assoc();
                  ?>
                    <option value="<?php echo $category_data["c_id"]; ?>">
                      <?php echo $category_data["name"]; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Add a Title</label>
              </div>
              <div class="col-12">
                <input type="text" id="title" class="form-control f1 text-white rounded-4" style="height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
              </div>
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Quantity</label>
              </div>
              <div class="input-number col-12 d-flex justify-content-center">
                <input type="number" class="rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" value="1" pattern="[0-9]" id="qty_input">
              </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-10 mx-2 my-2 add-product-detail-box-2" style="border-left:2px solid #0073e6;">
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Cost Per Item</label>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                <input type="number" id="cost" class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">.00</span>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Delivery Cost - Colombo</label>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                <input type="number" id="dwc" class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">.00</span>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <label class="text-white my-2">Delivery Cost - Other</label>
              </div>
              <div class="col-12 d-flex justify-content-center">
                <span class="input-group-text rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Rs.</span>
                <input type="number" id="doc" class="form-control rounded-4 text-white" style="outline: none; height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
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
                <div class="col-12 add-description-box d-flex justify-content-center">
                  <textarea class="form-control f5 rounded-4" id="desc" placeholder="Add product description..." cols="30" rows="20" style="font-size: 15px; border: none; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; width: 90%; min-height: 200px;"></textarea>
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
              <label class="form-label fw-bold text-white" style="font-size:20px;">Add Product Image</label>
            </div>

            <div class="col-lg-10 offset-lg-1 col-10 offset-1">
              <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i0" />
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i1" />
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i2" />
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i3" />
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i4" />
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center border border-light rounded my-2">
                  <img src="resources/addproductimg.svg" class="img-fluid img-thumbnail" style="width:200px; height:300px;" id="i5" />
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
          <button class="btn btn-outline-danger fw-bold text-white" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="addProduct();">ADD & SAVE Product</button>
        </div>

      </div>

    </div>



    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
  </body>

</html>
<?php

} else {
  header("location:home.php");
}
?>