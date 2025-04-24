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

        <title>Business Charts</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="style.css" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />

        <link rel="icon" href="resources/logo.png" />


    </head>

    <body class="body" onload="loadBChart();">
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
                        Business Charts
                        <a href="#" style="font-size: 30px; margin-left: 10px; color: #d10024"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
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
                        <li><a href="charts.php" class="text-light text-decoration-none">Most Sold Product</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="mostFamousSeller.php" class="text-light text-decoration-none">Most Famous Seller</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="mostFamousBuyer.php" class="text-light text-decoration-none">Most Famous Buyer</a></li>
                        &nbsp; &#47; &nbsp;
                        <li><a href="mostReviewedProduct.php" class="text-light text-decoration-none">Most Reviewed Product</a></li>
                    </ol>
                </div>
            </div>
        </div>

            <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 20px;">
                <div class="row table-responsive">
                    <div class="col-12" style="width: 1000px;">
                        <h2 class="text-center text-dark fw-bold">Most Sold Product (Bar Chart)</h2>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>


        <!-- empty view -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            function loadBChart() {
                var ctx = document.getElementById("myChart");
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if ((request.readyState == 4) & (request.status == 200)) {
                        var response = request.responseText;

                        var data = JSON.parse(response);
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    labels: data,
                                    data: data.data,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                };
                request.open("POST", "loadMostSellProcess.php", true);
                request.send();
            }
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