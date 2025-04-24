<!DOCTYPE html>
<html>
<?php
session_start();
require "connection.php";

if (isset($_SESSION["aduser"])) {
    
    $email = $_SESSION["aduser"]["email"];
    $rs =  Database::search("SELECT * FROM `user` INNER JOIN `gender` ON `user`.`gender_id` = `gender`.`id`
    ORDER BY `user`.`join_date` ASC");

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
            <div class="row mt-3">
                <div class="col-12" id="printArea">
                    <h2 class="text-center fw-bold text-dark">User Report</h2>
                    <div class="table-responsive">
                        <table class="table table-hover mt-5">
                            <thead class="fw-bold">
                                <tr>
                                    
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th class="text-center">Profile Image</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold">
                                <?php
                                for ($i = 0; $i < $num; $i++) {
                                    $data = $rs->fetch_assoc();
                                    $img_resultSet = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $data["email"] . "';");
                                    $imgdata = $img_resultSet->fetch_assoc();
                                ?>
                                    <tr>
                                        
                                        <td><?php echo $data["fname"] ?></td>
                                        <td><?php echo $data["lname"] ?></td>
                                        <td><?php echo $data["email"] ?></td>
                                        <td><?php echo $data["mobile"] ?></td>
                                        <td><?php echo $data["gender_name"] ?></td>
                                        <td><?php echo ($data["status"] == 1) ? "Active" : "Inactive"; ?></td>
                                        <td class="text-center">
                                            <?php if (empty($imgdata["path"])) { ?>
                                                <img src="resources/user.png" height="30px">
                                            <?php } else { ?>
                                                <img src="<?php echo $imgdata["path"]; ?>" height="30px" class="rounded-circle">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-dark col-md-4 col-lg-2 col-sm-6 mb-2" onclick="printDiv();"><i class="bi bi-printer-fill me-2"></i>Print Report</button>
                </div>
            </div>
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