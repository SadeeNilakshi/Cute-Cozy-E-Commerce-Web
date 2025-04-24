<?php
session_start();
require "connection.php";

if (isset($_GET["mu"])) {

  $search = $_GET["mu"];

  $query = "SELECT * FROM `user`";
  $p_rs = Database::search($query . "WHERE `fname` LIKE '%" . $search . "%' LIMIT 1");

  $p_num = $p_rs->num_rows;
  if ($p_num == 0) {
    echo ("No users you are sarching for");
  } else {

    for ($x = 0; $x < $p_num; $x++) {
      $p_data = $p_rs->fetch_assoc();

      $pro_img_rs = Database::search("SELECT * FROM `profile_image` 
        WHERE `user_email` = '" . $p_data["email"] . "';");

      $pro_img_data = $pro_img_rs->fetch_assoc();

?>
      <div class="col-12">
        <div class="row mx-2 my-3 rounded-3" style="background-color: #2b2d42; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;">
          <div class="col-lg-1 text-end">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $x + 1; ?></label>
          </div>
          <div class="col-lg-1 d-flex justify-content-center my-1">
            <img src="<?php echo $pro_img_data["path"]; ?>" class="rounded-circle" style="height: 40px;">

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data["fname"] . " " . $p_data["lname"]; ?></label>

          </div>
          <div class="col-lg-3 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data['email']; ?></label>

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data['mobile']; ?></label>

          </div>
          <div class="col-lg-2 ">
            <label class="form-label f4 fs-6 my-2 text-white"><?php echo $p_data['join_date']; ?></label>

          </div>
          <div class="col-lg-1">
            <?php

            if ($p_data["status"] == 1) {
            ?>
              <button id="UB<?php echo $p_data['email']; ?>" class="rounded-3 text-white my-2" style="background-color: #d10024; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockUser('<?php echo $p_data['email']; ?>');">Block</button>
            <?php
            } else {
            ?>
              <button id="UB<?php echo $p_data['email']; ?>" class="rounded-3 text-white my-2" style="background-color: #2b2d42; border: none; width: 75px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;" onclick="blockUser('<?php echo $p_data['email']; ?>');">Unblock</button>
            <?php

            }

            ?>

          </div>
        </div>
      </div>


    <?php
    }

    ?>
<?php
  }
}

?>