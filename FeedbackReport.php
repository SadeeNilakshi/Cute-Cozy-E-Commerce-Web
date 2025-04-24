<!DOCTYPE html>
<html>
<?php
session_start();
require "connection.php";

if (isset($_SESSION["aduser"])) {

    $rs = Database::search("SELECT * FROM `feedback`
    INNER JOIN `user` ON  `feedback`.`user_email` = `user`.`email`
    INNER JOIN `product` ON  `feedback`.`product_id` = `product`.`id` 
    ORDER BY `feedback`.`date` ASC");

    $num = $rs->num_rows;

?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Business Reports</title>

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

                <div class="col-lg-6 col-md-5 col-sm-12">
                    <h2 class="f3 text-white mt-2" style="display: flex; align-items: center; justify-content: center">
                        Business Reports
                        <a href="#" style="font-size: 30px; margin-left: 10px; color: #d10024"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row" style="
          background-color: rgba(43, 45, 66, 0.91);
          display: flex;
          flex-direction: row;
        ">
                <div class="col-lg-8 offset-lg-1 col-md-12 col-sm-12 mt-2 mb-2">
                    <ol class="breadcrumb-tree bread" style="
              display: inline-flex;
              flex-direction: row;
              justify-content: center;
              align-items: center;
            ">
                        <li><a href="adminPanel.php" class="text-light text-decoration-none">Dashboard</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="UserReport.php" class="text-light text-decoration-none">User Report</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="productReports.php" class="text-light text-decoration-none">Product Report</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="invoiceReport.php" class="text-light text-decoration-none">Invoice Report</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="FeedbackReport.php" class="text-light text-decoration-none">Feedback Reports</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="container mt-3 table-responsive" id="printArea">
            <h2 class="text-center fw-bold text-black">Feedback Report</h2>

            <table class="table table-hover mt-5 ">
                <thead class="fw-bold">
                    <tr>
                        <th>Product Name</th>
                        <th>Reviewed By</th>
                        <th class="text-center">Profile Picture</th>
                        <th>Star Ratings</th>
                        <th>feedback</th>
                        <th>Reviewed Date</th>

                    </tr>
                </thead>
                <tbody class="fw-bold">

                    <?php

                    for ($i = 0; $i < $num; $i++) {
                        $data = $rs->fetch_assoc();

                        $img_resultSet = Database::search("SELECT*FROM `image` WHERE `product_id`='" . $data["id"] . "';");
                        $imgdata = $img_resultSet->fetch_assoc();

                        $proimg_resultSet = Database::search("SELECT*FROM `profile_image` WHERE `user_email`='" . $data["email"] . "';");
                        $proimgdata = $proimg_resultSet->fetch_assoc();

                        $Rf_rs1 = Database::search("SELECT * FROM `feedback`WHERE `product_id`='" . $data["id"] . "' ORDER BY `date` DESC");
                        $Rf_num1 = $Rf_rs1->num_rows;
                        $Rf_data1 = $Rf_rs1->fetch_assoc();

                    ?>
                        <tr>
                            <td><?php echo $data["title"] ?></td>

                            <td><?php echo $data["fname"]; ?></td>
                            <td class="text-center">
                                <?php

                                if (empty($proimgdata["path"])) {
                                ?>
                                    <img src="resources/user.png" height="30px">
                            </td>
                        <?php

                                } else {
                        ?>
                            <img src="<?php echo $proimgdata["path"]; ?>" height="30px" class="rounded-circle"></td>
                        <?php

                                }
                        ?>
                        <td>
                            <?php
                            if ($Rf_data1["type"] == 1) {
                                echo ("1 Stars");
                            } else if ($Rf_data1["type"] == 2) {
                                echo ("2 Stars");
                            } else if ($Rf_data1["type"] == 3) {
                                echo ("3 Stars");
                            } else if ($Rf_data1["type"] == 4) {
                                echo ("4 Stars");
                            } else if ($Rf_data1["type"] == 5) {
                                echo ("5 Stars");
                            } else {
                                echo ("None");
                            }
                            ?>
                        </td>
                        <td><?php echo $data["feedback"] ?></td>
                        <td><?php echo $data["date"] ?></td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-end container my-2 col-12">
            <button class="btn btn-dark  col-md-2 col-lg-2 col-sm-6" onclick="printDiv();"><i class="bi bi-printer-fill me-2"></i>Print Report</button>
        </div>
        <script>
            function printDiv() {
                var orginalContent = document.body.innerHTML;
                var printArea = document.getElementById("printArea").innerHTML;
                document.body.innerHTML = printArea;
                window.print();
                document.body.innerHTML = orginalContent;
            }
            request.open("POST", path, true);
            request.send(fd);
        </script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>
<?php
} else {
    header("location:adminPanel.php");
}
?>

</html>