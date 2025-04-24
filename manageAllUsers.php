<!DOCTYPE html>
<html>
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

    <title>Manage Users</title>

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
            Manage All Users
            <a href="#" style="font-size: 30px; margin-left: 10px; color: #d10024"><i class="fa fa-users" aria-hidden="true"></i>
            </a>
          </h2>
        </div>
        <div class="col-10 offset-1">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item "><a href="adminPanel.php" class="text-danger text-decoration-none">Back to Admin Panel</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">User Management page</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="row ">
        <div class="col-12 d-flex justify-content-center">
          <div class="mt-3">
            <input class="input-search rounded-3 manage-search" style="font-size: 16px; border: none; width: 400px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" placeholder="Search Users" id="mu">
            <button class="search-icon rounded-3" style="font-size: 16px; border: none;   background-color: #d10024; color: white; width: 100px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="searchMU();">Search</button>
          </div>

        </div>
        <div class="col-12 mt-3 d-lg-block d-none">
          <div class="row mx-2 rounded-3 " style="background-color: white; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
            <div class="col-lg-1 text-end">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">#</label>
            </div>
            <div class="col-lg-2 ">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Profile Image</label>

            </div>
            <div class="col-lg-2 ">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Username</label>

            </div>
            <div class="col-lg-2 ">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Email</label>

            </div>
            <div class="col-lg-2 ">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Mobile</label>

            </div>
            <div class="col-lg-2 ">
              <label class="form-label f4 fs-6 fw-bold my-1" style="color: #d10024;">Registered Date</label>

            </div>

          </div>

        </div>

        <div class="col-12" id="searchResults">
        <?php

        $query = "SELECT * FROM `user`";
        $pageno;

        if (isset($_GET["page"])) {
          $pageno = $_GET["page"];
        } else {
          $pageno = 1;
        }

        $user_rs = Database::search($query);
        $user_num = $user_rs->num_rows;

        $results_per_page = 10;
        $number_of_pages = ceil($user_num / $results_per_page);

        $page_results = ($pageno - 1) * $results_per_page;
        $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

        $selected_num = $selected_rs->num_rows;

        for ($x = 0; $x < $selected_num; $x++) {
          $selected_data = $selected_rs->fetch_assoc();

          $pro_img_rs = Database::search("SELECT * FROM `profile_image`
                WHERE `user_email` = '" . $selected_data["email"] . "';");
          $pro_img_num = $pro_img_rs -> num_rows;

          $pro_img_data = $pro_img_rs->fetch_assoc();

        ?>

            <div class="row mx-2 my-3 rounded-3 " style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
              <div class="col-lg-1 text-end">
                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $x + 1; ?></label>
              </div>
              <?php
              if(empty($pro_img_num)){
                ?>
                <div class="col-lg-1 d-flex justify-content-center my-1">
                <img src="resources/man.jpg" class="rounded-circle" style="height: 40px;">
              </div>                
                <?php
              }else{
                ?>
                <div class="col-lg-1 d-flex justify-content-center my-1">
                <img src="<?php echo $pro_img_data["path"]; ?>" class="rounded-circle" style="height: 40px;">
              </div>
                <?php
              }
              ?>
              
              <div class="col-lg-2">
                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></label>

              </div>
              <div class="col-lg-3">
                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data['email']; ?></label>

              </div>
              <div class="col-lg-2">
                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data['mobile']; ?></label>

              </div>
              <div class="col-lg-2">
                <label class="form-label f4 fs-6 my-2 text-white"><?php echo $selected_data['join_date']; ?></label>

              </div>
              <div class="col-lg-1">
                <?php

                if ($selected_data["status"] == 1) {
                ?>
                  <button id="UB<?php echo $selected_data['email']; ?>" class="rounded-3 text-white my-2" style="background-color: #d10024; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Block</button>
                <?php
                } else {
                ?>
                  <button id="UB<?php echo $selected_data['email']; ?>" class="rounded-3 text-white my-2" style="background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Unblock</button>
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
      </div>
    </div>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
  </body>

</html>
<?php
} else {
  header("location:html/index.php");
}
?>