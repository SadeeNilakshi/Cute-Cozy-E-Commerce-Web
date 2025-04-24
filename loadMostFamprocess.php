<?php
include "connection.php";

$resultSet = Database::search("SELECT `user`.`email`,`user`.`fname`, SUM(`invoice`.`iqty`)AS `total_sold` FROM `invoice`
INNER JOIN `user` ON `invoice`.`user_email` = `user`.`email`
GROUP BY `user`.`email`,`user`.`fname`
ORDER BY `total_sold` DESC");

$num = $resultSet ->num_rows;

$labels = array();
$data = array();

for($i = 0; $i <$num; $i++){
    $d = $resultSet->fetch_assoc();

    $labels[] = $d["fname"];
    $data [] = $d ["total_sold"];
}

$json = array();
$json["labels"] = $labels;
$json["data"] = $data;

echo json_encode($json);
