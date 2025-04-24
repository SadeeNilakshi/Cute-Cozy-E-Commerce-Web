<!DOCTYPE html>
<?php

include "connection.php";

?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome | Cute & Cozy </title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.png" />

</head>

<body class="body1">

    <div class="container-fluid vh-100 d-flex justify-content-center align-content-center" style="background-color: rgba(0, 0, 0, 0.20);">
        <div class="row d-flex align-content-center justify-content-center">
            <div class="col-10 col-lg-5" id="signUpBox">
                <div class="row g-2 d-flex justify-content-center  mx-2 rounded-4" style="background-color: rgba(43, 45, 66, 0.93);">

                    <div class="col-10 d-flex justify-content-center">
                        <p class="title02">Create New Account</p>
                    </div>

                    <div class="col-5">
                        <label class="form-label f1" style="color: white;">First Name</label>
                        <input type="text" class="form-control" placeholder="Enter Your First Name" id="fname" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                    </div>

                    <div class="col-5">
                        <label class="form-label f1" style="color: white;">Last Name</label>
                        <input type="text" class="form-control" placeholder="Enter Your Last Name" id="lname" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                    </div>

                    <div class="col-10">
                        <label class="form-label f1" style="color: white;">Email</label>
                        <input type="email" class="form-control" placeholder="Enter Valid Email Address" id="email" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                    </div>

                    <div class="col-10">
                        <label class="form-label f1" style="color: white;">Password</label>
                        <input type="password" class="form-control" placeholder="Enter Strong Password" id="pass" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                    </div>

                    <div class="col-5 ">
                        <label class="form-label f1" style="color: white;">Mobile</label>
                        <input type="text" class="form-control" placeholder="Enter your mobile" id="mobile" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                    </div>

                    <div class="col-5 ">
                        <label class="form-label f1" style="color: white;">Gender</label>
                        <select class="form-control" id="gender" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">

                            <?php
                            $rs = Database::search("SELECT * FROM `gender`");
                            $num = $rs->num_rows;

                            for ($x = 0; $x < $num; $x++) {
                                $data = $rs->fetch_assoc();
                            ?>

                                <option value="<?php echo $data["id"]; ?>">
                                    <?php echo $data["gender_name"]; ?>
                                </option>

                            <?php
                            }

                            ?>

                        </select>
                    </div>

                    <div class="col-10  d-grid mt-2">
                        <button class="btn f2" style="background-color: rgba(43, 45, 66, 0.68); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="signUp();">Sign Up</button>
                    </div>

                    <div class="col-10 d-grid mt-2 mb-4">
                        <button class="btn f2" style="background-color: rgba(209, 0, 36, 0.81); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; " onclick="changeView();">Already have an account? Sign In</button>
                    </div>
                    <div class="col-10 d-none f1" id="msgdiv">
                        <div class="alert alert-danger fs-6 f1 text-danger" role=" alert" id="alertdiv">
                            <i class="bi bi-x-octagon-fill fs-6" id="msg">
                            </i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-10 col-lg-5 d-none" id="signInBox">
                <div class="row g-2 d-flex justify-content-center  mx-2 rounded-4" style="background-color: rgba(43, 45, 66, 0.93);">

                    <div class="col-10 d-flex justify-content-center">
                        <p class="title02">Sign In</p>
                    </div>

                    <?php

                    $email = "";
                    $password = "";

                    if (isset($_COOKIE["email"])) {
                        $email = $_COOKIE["email"];
                    }

                    if (isset($_COOKIE["password"])) {
                        $password = $_COOKIE["password"];
                    }

                    ?>

                    <div class="col-10">
                        <label class="form-label rounded-4 f1" style="color: white; ">Email</label>
                        <input type="email" class="form-control" id="email2" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" value="<?php echo $email; ?>"  />
                    </div>
                    <div class="col-10">
                        <label class="form-label f1" style="color: white;">Password</label>
                        <input type="password" class="form-control" id="password2" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" value="<?php echo $password; ?>"/>
                    </div>
                    <div class="col-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberme" />
                            <label class="form-check-label f1" style="color: white;">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-5 text-end">
                        <a href="#" class="link-primary f1" onclick="forgotPassword();">Forgot Password?</a>
                    </div>


                    <div class="col-10 d-grid mt-2">
                        <button class="btn f2" style="background-color: rgba(209, 0, 36, 0.74); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="signIn();">Sign In</button>
                    </div>
                    <div class="col-10  d-grid mt-2 mb-4">
                        <button class="btn f2" style="background-color: rgba(43, 45, 66, 0.83); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="changeView();">New Member? Sign Up</button>
                    </div>
                    <div class="col-10 d-none" id="msgdiv2">
                        <div class="alert alert-danger" role="alert" id="alertdiv2">
                            <i class="bi bi-x-octagon-fill fs-5" id="msg2">
                            </i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mx-3 d-lg-block logo"></div>

            
        <!-- modal -->
        <div class="modal" tabindex="-1" id="forgotPasswordModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2b2d42">
                        <h5 class="modal-title text-white">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="body">
                        <div class="row g-3">

                            <div class="col-6">
                                <label class="form-label">New Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="newpassinput" />
                                    <button class="btn btn-outline-secondary" type="button" id="newpassbtn" onclick="ShowPass();">
                                        <i id="eye1" class="bi bi-eye-slash-fill text-dark">
                                        </i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label">Re type Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="retypepassinput" />
                                    <button class="btn btn-outline-secondary" type="button" id="retypepassbtn" onclick="ShowRetypePass();">
                                        <i id="eye2" class="bi bi-eye-slash-fill text-dark"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="verifycode" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2" style="background-color: #2b2d42">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: rgba(209, 0, 36, 0.81); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; ">Close</button>
                        <button type="button" class="btn btn-primary" style="background-color: rgba(43, 45, 66, 0.83); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="resetpass();">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- footer -->

        <div class="col-12 fixed-bottom d-none d-lg-block">
            <p class="text-center">&copy; 2024 Cute&Cozy.com || All Right Reserved</p>
        </div>

        <!-- footer -->
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>


</html>