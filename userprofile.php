<!DOCTYPE html>
<?php
session_start();
require "connection.php";
if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?php echo $_SESSION["user"]["fname"]; ?>'s Profile</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.png" />
</head>


<body class="body3">
    <?php require "header.php";?>
    <div class="container-fluid vh-100">
        <div class="row">
            <?php

                $details_resultSet = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON gender.id=user.gender_id WHERE `email`= '" . $email . "';");
                $img_resultSet = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "';");

                $addr_resultSet = Database::search("SELECT * FROM `user_has_address`
INNER JOIN `city` ON user_has_address.city_id=city.id
INNER JOIN `district` ON city.district_id=district.id
INNER JOIN `province` ON district.province_id=province.id WHERE `user_email`='" . $email . "';");

                $data = $details_resultSet->fetch_assoc();
                $imgdata = $img_resultSet->fetch_assoc();
                $addrdata = $addr_resultSet->fetch_assoc();
            ?>
                <div class="col-12 d-flex justify-content-center vh-100 mt-5">
                    <div class="row d-flex align-content-center justify-content-center border-bottom-danger border-5">
                        <div class="col-9 d-flex justify-content-center align-content-center rounded-5 resp" style="background-color: rgba(43, 45, 66, 0.93); ">
                            <div class="d-flex flex-column align-items-center text-center justify-content-center mt-3">

                                <?php

                                if (empty($imgdata["path"])) {
                                ?>
                                    <img src="resources/user.png" id="viewimg" class="rounded-circle mt-5" style="width:150px ;" />
                                <?php

                                } else {
                                ?>
                                    <img src="<?php echo $imgdata["path"]; ?>" id="viewimg" class="rounded-circle mt-5" style="width:150px ;" />
                                <?php

                                }
                                ?>
                                <span class="fw-bold text-white f1"><?php echo $email; ?></span>
                                <span class=" text-white f1" style="font-size: 14px;"><?php echo $data["fname"] . " " . $data["lname"]; ?></span>

                                <input type="file" class="d-none" id="profileimg" accept="image/*" />
                                <label for="profileimg" class="btn mt-5 text-white f2" style="background-color: rgba(209, 0, 36, 0.81); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset; " onclick="changeimg();">Update Profile Image</label>
                            </div>
                            <div class="col-9 d-flex justify-content-center resp-box" id="updateProfile">
                                <div class="row d-flex justify-content-center  ">

                                    <div class="col-10 d-flex justify-content-center mt-3">
                                        <p class="title02">My Profile</p>
                                    </div>


                                    <div class="col-5">
                                        <label class="form-label f1 text-white">First Name</label>
                                        <input type="text" class="form-control f1 text-black" value="<?php echo $data["fname"]; ?>" id="fname" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label f1 text-white">Last Name</label>
                                        <input type="text" class="form-control f1 text-black" value="<?php echo $data["lname"]; ?>" id="lname" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                    </div>

                                    <div class="col-10 ">
                                        <label class="form-label f1 text-white">Mobile</label>
                                        <input type="text" class="form-control f1 text-black" value="<?php echo $data["mobile"]; ?>" id="mob" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                    </div>

                                    <div class="col-10">
                                        <label class="form-label f1 text-white">Email</label>
                                        <input type="email" class="form-control f1 text-black" readonly value="<?php echo $data["email"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                    </div>

                                    <div class="col-10">
                                        <label class="form-label f1 text-white">Password</label>

                                        <input type="password" class="form-control f1 text-black" readonly value="<?php echo $data["password"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />

                                    </div>

                                    <div class="col-10">
                                        <label class="form-label f1 text-white">Registered Date</label>
                                        <input type="email" class="form-control f1 text-black" readonly value="<?php echo $data["join_date"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                    </div>
                                    <?php
                                    if (!empty($addrdata["line1"])) {
                                    ?>
                                        <div class="col-10">
                                            <label class="form-label f1 text-white">Address Line 01</label>
                                            <input id="add01" type="text" class="form-control f1 text-black" value="<?php echo $addrdata["line1"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>
                                    <?php
                                    } else {
                                    ?> <div class="col-10">
                                            <label class="form-label f1 text-white">Address Line 01</label>
                                            <input id="add01" type="text" class="form-control f1 text-black" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>

                                    <?php
                                    }
                                    if (!empty($addrdata["line2"])) {
                                    ?>
                                        <div class="col-10">
                                            <label class="form-label f1 text-white">Address Line 02</label>
                                            <input id="add02" type="text" value="<?php echo $addrdata["line2"]; ?>" class="form-control f1 text-black" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="col-10">
                                            <label class="form-label f1 text-white">Address Line 02</label>
                                            <input id="add02" type="text" class="form-control f1 text-black" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>

                                    <?php
                                    }

                                    $province_resultSet = Database::search("SELECT * FROM `province`");
                                    $district_resultSet = Database::search("SELECT * FROM `district`");
                                    ?>

                                    <div class="col-5">
                                        <label class="form-label f1 text-white">Province</label>
                                        <select class="form-select f1 text-black" id="province" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                                            <option value="0">Select Province</option>
                                            <?php
                                            $province_num = $province_resultSet->num_rows;
                                            for ($x = 0; $x < $province_num; $x++) {
                                                $province_data = $province_resultSet->fetch_assoc();
                                            ?>

                                                <option value="<?php echo $province_data["id"]; ?>" <?php
                                                                                                    if (!empty($addrdata["province_id"])) {

                                                                                                        if ($province_data["id"] == $addrdata["province_id"]) {

                                                                                                    ?>selected<?php
                                                                                                            }
                                                                                                        } ?>>

                                                    <?php echo $province_data["province_name"]; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label f1 ">District</label>
                                        <select class="form-select f1 text-black" id="district" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                                            <option value="0">Select District</option>
                                            <?php

                                            $district_num = $district_resultSet->num_rows;
                                            for ($x = 0; $x < $district_num; $x++) {
                                                $district_data = $district_resultSet->fetch_assoc();
                                            ?>

                                                <option value="<?php echo $district_data["id"]; ?>" <?php
                                                                                                    if (!empty($addrdata["district_id"])) {

                                                                                                        if ($district_data["id"] == $addrdata["district_id"]) {

                                                                                                    ?>selected<?php
                                                                                                            }
                                                                                                        } ?>>

                                                    <?php echo $district_data["district_name"]; ?></option>

                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label f1 text-white">City</label>
                                        <select class="form-select f1 text-black" id="city" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
                                            <option value="0">Select City</option>
                                            <?php
                                            $city_resultSet = Database::search("SELECT * FROM `city`");
                                            $city_num = $city_resultSet->num_rows;
                                            for ($x = 0; $x < $city_num; $x++) {
                                                $city_data = $city_resultSet->fetch_assoc();
                                            ?>

                                                <option value="<?php echo $city_data["id"]; ?>" <?php
                                                                                                if (!empty($addrdata["city_id"])) {

                                                                                                    if ($city_data["id"] == $addrdata["city_id"]) {

                                                                                                ?>selected<?php
                                                                                                        }
                                                                                                    } ?>>

                                                    <?php echo $city_data["city_name"]; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    if (!empty($addrdata["postal_code"])) {
                                    ?>
                                        <div class="col-5">
                                            <label class="form-label f1 text-white">Postal Code</label>
                                            <input id="postal" type="text" class="form-control f1 text-black" value="<?php echo $addrdata["postal_code"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>

                                    <?php
                                    } else {
                                    ?>
                                        <div class="col-5">
                                            <label class="form-label f1 text-white">Postal Code</label>
                                            <input id="postal" type="text" class="form-control f1 text-black" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div> <?php
                                            }
                                            if (!empty($data["gender_name"])) {
                                                ?>
                                        <div class="col-10 ">
                                            <label class="form-label f1 text-white">Gender</label>
                                            <input class="form-control f1" readonly value="<?php echo $data["gender_name"]; ?>" style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>
                                    <?php
                                            } else {
                                    ?>
                                        <div class="col-10 ">
                                            <label class="form-label f1 text-white">Gender</label>
                                            <input class="form-control f1" readonly style="box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" />
                                        </div>
                                    <?php
                                            }

                                    ?>
                                    <div class="col-10 d-grid mt-2 mb-4">
                                        <button class="btn f2" onclick="updatePro();" style="background-color: rgba(209, 0, 36, 0.81); box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">Update My Profile</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

        </div>

    </div>
<?php

            } else {
                header("location:home.php");
            }
            
?>
<script src="bootstrap.bundle.js"></script>
<script src="script.js"></script>
</body>

</html>