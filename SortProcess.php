<?php

session_start();

require "connection.php";

$user = $_SESSION["user"];

// $search = $_POST["search"];
$time = $_POST["time"];
$qty = $_POST["qty"];
$category = $_POST["cat"];
$price = $_POST["price"];

$query = "SELECT * FROM `product` WHERE `user_email` = '" . $user["email"] . "'"; //This query is common for all filters
$status = 0;

// if (!empty($search)) {

//     $query .= " AND `title` LIKE '%" . $search . "%'"; // Now we don't need above common query
//     // All we need to add this 'Wild Card' query for this.
// }

if ($category != "0") {

    if ($category == "1") {
        $query .= "AND `category_id`= '1' ";
    } else if ($category == "2") {
        $query .= "AND `category_id`= '2' ";
    } else if ($category == "3") {
        $query .= "AND `category_id`= '3' ";
    } else if ($category == "4") {
        $query .= "AND `category_id`= '4' ";
    }
}

// Active time sorting

if ($time != "0") {

    if ($time == "1") {
        $query .= " ORDER BY `datetime_added` DESC"; 

    } else if ($time == "2") {
        $query .= " ORDER BY `datetime_added` ASC"; 
    }
}


if ($time != "0" && $qty != "0") {

    if ($qty == "1") {
        $query .= " , `qty` DESC "; 

    } else if ($qty == "2") {
        $query .= " , `qty` ASC "; 
    }
} else if ($time == "0" && $qty != "0") {

    if ($qty == "1") {
        $query .= " ORDER BY `qty` DESC "; 

    } else if ($qty == "2") {
        $query .= " ORDER BY `qty` ASC "; 
    }
}

if ($time != "0" && $price != "0") {

    if ($price == "1") {
        $query .= " , `price` DESC "; 

    } else if ($price == "2") {
        $query .= " , `price` ASC "; 
    }
} else if ($time == "0" && $price != "0") {

    if ($price == "1") {
        $query .= " ORDER BY `price` DESC "; 

    } else if ($price == "2") {
        $query .= " ORDER BY `price` ASC "; 
    }
}


?>
<div class="col-12">
    <!-- store products -->
    <div class="row">
        <?php
        if (isset($_GET["page"])) {
            $pageno = $_GET["page"];
        } else {
            $pageno = 1;
        }

        $product_Rs = Database::search($query);
        $product_num = $product_Rs->num_rows;

        $result_per_page = 4;
        $number_of_pages = ceil($product_num / $result_per_page);

        $page_results = ($pageno - 1) * $result_per_page;
        $selected_rs = Database::search($query . " LIMIT " . $result_per_page . " OFFSET " . $page_results . "");

        $selected_num = $selected_rs->num_rows;

        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();

        ?>
            <!-- product -->
            <div class="col-12 col-md-4">
                <div class="product">
                    <div class="product-img">
                        <?php
                        $product_img_rs = Database::search("SELECT * FROM `image`
                                        WHERE `product_id` = '" . $selected_data["id"] . "';");

                        $product_img_data = $product_img_rs->fetch_assoc();

                        ?>
                        <img src="<?php echo $product_img_data["code"]; ?>" alt="">
                        <div class="product-label">
                            <span class="new"><?php echo $selected_data["qty"]; ?></span>
                        </div>
                    </div>
                    <div class="product-body">
                        <h3 class="product-name"><a href="#"><?php echo $selected_data["title"]; ?></a></h3>
                        <?php

                        $price = $selected_data["price"];
                        $adding_price = ($price / 100) * 5;
                        $new_price = $price + $adding_price;
                        $difference = $new_price - $price;
                        $percentage = ($difference / $price) * 100;

                        ?>
                        <h4 class="product-price">Rs.<?php echo $price; ?>.00 <del class="product-old-price">Rs.<?php echo $new_price; ?>.00</del></h4>
                        <?php
                        $Rf_rs = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $selected_data["id"] . "' ORDER BY `date` DESC");
                        $Rf_num = $Rf_rs->num_rows;
                        $Rf_data = $Rf_rs->fetch_assoc();
                        ?>
                        <div class="product-rating">
                            <?php
                            if ($Rf_num == 0) {
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

                                if ($Rf_data["type"] == 5) {
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
                                if ($Rf_data["type"] == 4) {
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
                                if ($Rf_data["type"] == 3) {
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
                                if ($Rf_data["type"] == 2) {
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
                                if ($Rf_data["type"] == 1) {
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
                        <div class="product-btns">
                            <?php if ($selected_data["status_id"] == 2) { ?>
                                <button class="add-to-wishlist" id="fd<?php echo $selected_data["id"]; ?>" <?php if ($selected_data["status_id"] == 2) { ?>checked<?php } ?> onclick="changeStatus(<?php echo $selected_data['id']; ?>);">
                                    <i class="fa fa-circle-o text-danger"></i>
                                    <span class="tooltipp">Activate</span>
                                </button>
                            <?php } else { ?>
                                <button class="add-to-wishlist" id="fd<?php echo $selected_data["id"]; ?>" <?php if ($selected_data["status_id"] == 1) { ?>checked<?php } ?> onclick="changeStatus(<?php echo $selected_data['id']; ?>);">
                                    <i class="fa fa-circle text-danger"></i><span class="tooltipp">Deactivate</span></button>
                            <?php
                            }
                            ?>
                            <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">Update Product</span></button>
                        </div>

                    </div>
                </div>
                <div class="col-12" style="display: none;" id="activemsgdiv">
                    <div class="alert alert-danger" role="alert" id="activealertdiv">
                        <i class="bi bi-x-octagon-fill fs-5" id="activemsg">

                        </i>
                    </div>
                </div>
            </div>
            <!-- /product -->

            <div class="clearfix visible-sm visible-xs"></div>
        <?php

        }

        ?>
    </div>
    <!-- /store products -->
    <!-- Copy to SortProduct.php -->
</div>