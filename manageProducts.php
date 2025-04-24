<!DOCTYPE html>
<html>
<?php

session_start();
require "connection.php";

if (isset($_SESSION["aduser"])) {

    $email = $_SESSION["aduser"]["email"];
?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Manage Products</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="style.css" />


        <link rel="icon" href="resources/logo.png" />


    </head>

    <body class="body" style="background-color: rgba(43, 45, 66, 0.91);">
        <div class="col-12">
            <div class="row h-25 d-flex justify-content-center" style="background-color: #2b2d42">


                <div class="col-lg-6 col-md-5 col-sm-12">
                    <h2 class="f3 text-white mt-2" style="display: flex; align-items: center; justify-content: center">
                        Manage Products
                        <a href="#" style="font-size: 30px; margin-left: 10px; color: #d10024"><i class="fa fa-shopping-bag" aria-hidden="true"></i>

                        </a>
                    </h2>
                </div>
                <div class="col-10 offset-1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="adminPanel.php" class="text-danger text-decoration-none">Back to Admin Panel</a></li>
                            <li class="breadcrumb-item active text-light" aria-current="page">Product Management page</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row ">
                <div class="col-12 d-flex justify-content-center">
                    <div class="mt-3">

                        <input class="input-search rounded-3 manage-search" style="font-size: 16px; border: none; width: 400px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" placeholder="Search here......." id="mp">
                        <button class="search-icon rounded-3 " style="font-size: 16px; border: none;   background-color:  #d10024; color: white; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="searchMP();">Search</button>
                    </div>

                </div>
                <div class="col-12 mt-3 d-lg-block d-none">
                    <div class="row mx-2 rounded-3 " style="background-color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                        <div class="col-lg-1 text-end">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">#</label>
                        </div>
                        <div class="col-lg-2 ">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Product Image</label>

                        </div>
                        <div class="col-lg-2 ">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Title</label>

                        </div>
                        <div class="col-lg-2 ">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Price</label>

                        </div>
                        <div class="col-lg-2 ">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Quantity</label>

                        </div>
                        <div class="col-lg-2 ">
                            <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Registered Date</label>

                        </div>

                    </div>

                </div>

                <div class="col-12" id="searchResults">
                    <?php
                    $query = "SELECT * FROM `product`";
                    $pageno;

                    if (isset($_GET["page"])) {
                        $pageno = $_GET["page"];
                    } else {
                        $pageno = 1;
                    }

                    $product_rs = Database::search($query);
                    $product_num = $product_rs->num_rows;

                    $results_per_page = 10;
                    $number_of_pages = ceil($product_num / $results_per_page);

                    $page_results = ($pageno - 1) * $results_per_page;
                    $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                    $selected_num = $selected_rs->num_rows;

                    for ($x = 0; $x < $selected_num; $x++) {

                        $selected_data = $selected_rs->fetch_assoc();

                        $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $selected_data["id"] . "';");

                        $product_img_data = $product_img_rs->fetch_assoc();

                    ?>
                        <div class="row mx-2 my-3 rounded-3 " style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                            <div class="col-lg-1 text-end">
                                <label class="form-label text-white f4 fs-6 my-2"><?php echo $selected_data["id"]; ?></label>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-center my-1">
                                <img src="<?php echo $product_img_data["code"]; ?>" style="height: 40px;">

                            </div>
                            <div class="col-lg-2 ">
                                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data["title"]; ?></label>

                            </div>
                            <div class="col-lg-2 ">
                                <label class="form-label f4 fs-6 my-2 text-white">Rs. <?php echo $selected_data["price"]; ?>.00</label>

                            </div>
                            <div class="col-lg-2 ">
                                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data["qty"]; ?></label>

                            </div>
                            <div class="col-lg-2 ">
                                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data["datetime_added"]; ?></label>

                            </div>
                            <div class="col-lg-1">
                                <?php

                                if ($selected_data["status_id"] == 1) {
                                ?>
                                    <button id="pb<?php echo $selected_data['id']; ?>" class="rounded-3 text-white my-2" style="background-color: #d10024; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Block</button>
                                <?php
                                } else {
                                ?>
                                    <button id="pb<?php echo $selected_data['id']; ?>" class="rounded-3 text-white my-2" style="background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Unblock</button>
                                <?php
                                }
                                ?>

                            </div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
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

                <hr style="color: white;" />

                <div class="col-12 text-center">
                    <h3 class=" fw-bold text-white f3">Manage Categories</h3>
                </div>

                <div class="col-12 mb-3">
                    <div class="row gap-1 justify-content-center mx-2">

                        <?php
                        $category_rs = Database::search("SELECT * FROM `category`");
                        $category_num = $category_rs->num_rows;

                        for ($x = 0; $x < $category_num; $x++) {
                            $category_data = $category_rs->fetch_assoc();

                        ?>
                            <div class="col-12 col-lg-3 rounded-3" style="height: 45px; border: 2px solid #d10024; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                                <div class="row">
                                    <div class="col-8 mt-2 mb-2">
                                        <label class="form-label fw-bold fs-6 text-white f4"><?php echo $category_data["name"]; ?></label>
                                    </div>
                                    <div class="col-4 border-start border-light text-center mt-2 mb-2">
                                        <label class="form-label fs-6 text-white"><i class="fa fa-trash"></i></label>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-12 col-lg-3 rounded-3" style="height: 45px; border: 2px solid #d10024; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="addNewCategory();">
                            <div class="row">
                                <div class="col-8 mt-2 mb-2">
                                    <label class="form-label fw-bold fs-6 text-white">Add new Category</label>
                                </div>
                                <div class="col-4 border-start border-light text-center mt-2 mb-2">
                                    <label class="form-label fs-6 text-white"><i class="fa fa-plus" aria-hidden="true"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 text-center">
                    <h3 class=" fw-bold text-white f3">Add Images For Categories</h3>
                </div>
                <div class="col-12 d-none" id="addmsgdiv">
                    <div class="alert alert-success" role="alert" id="addalertdiv">
                        <i class="bi bi-check2-circle fs-5" id="addmsg">

                        </i>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-3 d-flex justify-content-center">
                    <select class="form-select text-center text-white rounded-4" id="category1" style="height: 40px; background-color: #2b2d42; border: 2px solid white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; font-size: medium;">
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
                <div class="col-12 col-lg-3 d-flex justify-content-center">
                    <input type="file" class="d-none" id="imageuploder" />
                    <label for="imageuploder" class="col-12 btn btn-outline-dark fw-bold text-white" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeProductimg();">Upload Images</label>
                </div>
                <div class="col-lg-12 text-center">
                    <div class="col-lg-6 offset-lg-3 col-md-4 col-sm-10 offset-sm-1 d-flex justify-content-center border border-light rounded my-2">
                        <img src="resources/addproductimg.svg" class="img-fluid" style="width:200px; height:200px;" id="i0" />
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-3 col-md-4 col-sm-10 offset-sm-1 d-flex justify-content-center">
                    <button class="btn btn-outline-danger fw-bold text-white" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="addCatImg();">Add Category Image</button>
                </div>
                <div class="col-12">
                    <hr class="" style="border-width: 3px; color: white;" />
                </div>
                <!-- modal 2 -->
                <div class="modal" tabindex="-1" id="addCategoryModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="color: #ffffff; background-color: #2b2d42;">
                                <h5 class="modal-title text-uppercase fw-bold">Add New Category</h5>
                                <button type="button" class="btn-close bg-light text-light border border-2 border-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body body3">
                                <div class="col-12">
                                    <input type="text" class="form-control border border-2 border-danger text-danger" placeholder="Enter new category........" id="m" />
                                </div>
                                <br>
                                <div class="col-12">
                                    <input type="text" class="form-control border border-2 border-dark text-dark" placeholder="Enter Your Email........" id="e" />
                                </div>
                            </div>
                            <div class="modal-footer" style="color: #ffffff; background-color: #2b2d42;">
                                <button type="button" class="btn bg-dark text-light border border-2 border-light rounded text-uppercase fw-bold" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn bg-dark text-danger border border-2 border-danger rounded text-uppercase fw-bold" onclick="verifyCategory();">Save New Category</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal 2 -->

                <!-- modal 3 -->
                <div class="modal" tabindex="-1" id="addCategoryVerificationModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="color: #ffffff; background-color: #2b2d42;">
                                <h5 class="modal-title text-uppercase fw-bold" style="color: #ffffff;">Verification</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body body3">
                                <div class="col-12 mt-3 mb-3">
                                    <label class="form-label text-dark fw-bold">Enter Verification Code :</label>
                                    <input type="text" class="form-control bg-light text-dark fw-bold border border-2 border-dark " id="modaltxt" />
                                </div>
                            </div>
                            <div class="modal-footer" style="color: #ffffff; background-color: #2b2d42;">
                                <button type="button" class="btn bg-dark text-danger border border-2 border-danger rounded text-uppercase fw-bold" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn bg-dark text-info border border-2 border-info rounded text-uppercase fw-bold" onclick="saveCategory();">Verify & Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal 3 -->
            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

</html>
<?php
} else {
    header("location:adminPanel.php");
}
?>