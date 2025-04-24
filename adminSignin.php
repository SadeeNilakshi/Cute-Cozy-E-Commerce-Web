<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Sign In</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.png" />
</head>

<body class="body2" onchange="ADsignout();">
    <div class="container-fluid vh-100 d-flex justify-content-center" style="background-color: rgba(0, 0, 0, 0.20);">
        <div class="row align-content-center">

            <div class="col-12 ">
                <p class="text-center f2 text-black-50 fs-2"> Welcome to Cute & Cozy Admin Panel!</p>
            </div>

            <div class="col-12 p-3">
                <div class="row d-flex justify-content-center">

                    <div class="col-5 mx-4 d-none d-lg-block logo"></div>



                    <div class="col-10 col-lg-6" id="signInBox">
                        <div class="row g-2 d-flex justify-content-center  mx-2 rounded-4" style="background-color: rgba(43, 45, 66, 0.93);">

                            <div class="col-10 d-flex justify-content-center">
                                <p class="title02">Admin Sign In</p>
                            </div>

                            <div class="col-10 d-none" id="msgdiv">
                                <div class="alert alert-danger" role="alert" id="msg">

                                </div>
                            </div>

                            <div class="col-10">

                                <input type="email" class="form-control" id="e" placeholder="Enter Your Email Here" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                            </div>

                            <div class="col-10 d-grid mt-2">
                                <button class="btn f2" style="background-color: rgba(209, 0, 36, 0.74); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="adminVerification();">Get Verification Code</button>
                            </div>
                            <div class="col-10  d-grid mt-2 mb-3">
                                <button class="btn f2" style="background-color: rgba(43, 45, 66, 0.83); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="window.location='index.php'">Back To Customer Login</button>
                            </div>


                        </div>
                    </div>


                </div>
            </div>

            <!-- <modal> -->

            <div class="modal" tabindex="-1" id="veriFicationModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Admin Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body body">
                            <label class="form-label">Enter Your Verification Code</label>
                            <input type="text" class="form-control" id="vCode">
                        </div>
                        <div class="modal-footer">
                            <button type="btn" class="btn f2" style="background-color: rgba(209, 0, 36, 0.74); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" data-bs-dismiss="modal">Close</button>
                            <button type="btn" class="btn f2" style="background-color: rgba(43, 45, 66, 0.83); color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="verify();">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <modal> -->



            <div class="col-12 fixed-bottom text-center f4 text-black">
                <p>&copy; 2024 Cute & Cozy.lk | All Rights Reserved</p>
            </div>
        </div>


    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>

</body>

</html>