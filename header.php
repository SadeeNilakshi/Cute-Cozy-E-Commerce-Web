<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />


    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <link rel="stylesheet" href="css/font-awesome.min.css">

    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.png" />



</head>

<body class="body">
    <div classs=" vh-100 ">
        <div class="">
            <div class="col-12 ">
                <header>
                    <!-- TOP HEADER -->
                    <div id="top-header">
                        <div class="container">
                            <ul class="header-links pull-left">
                                <li><a href="tel:+94552294330"><i class="fa fa-phone"></i> 055-2294330</a></li>
                                <li><a href="mailto:cuteandcozy@email.com"><i class="fa fa-envelope-o"></i> cuteandcozy@email.com</a></li>
                                <li><a href=""><i class="fa fa-map-marker"></i>Visit Us</a></li>
                            </ul>
                            <ul class="header-links pull-right">
                                
                                <?php
                                if (isset($_SESSION["user"])) {
                                    $data = $_SESSION["user"];

                                ?>
                                    <li><a href="userprofile.php"><i class="fa fa-user-o"></i> <?php echo $data["fname"]; ?>'s Profile</a></li>
                                    <li><a href="" onclick="signout();"><i class="fa fa-sign-out"></i> SignOut</a></li>
                                    <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                            </ul>
                        <?php

                                } else {

                        ?>
                            <li><a href="index.php"><i class="fa fa-user-o"></i> Log In</a></li>
                        <?php

                                }

                        ?>

                        </ul>

                        </div>
                    </div>
                    <!-- /TOP HEADER -->
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>
    <script src="script.js"></script>

</body>

</html>