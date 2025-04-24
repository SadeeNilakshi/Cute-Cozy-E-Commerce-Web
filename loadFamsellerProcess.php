<?php
include "connection.php";

$resultSet = Database::search("SELECT `user`.`email`,`user`.`fname`, SUM(`product`.`qty`)AS `total_reg` FROM `product`
INNER JOIN `user` ON `product`.`user_email` = `user`.`email`
GROUP BY `user`.`email`,`user`.`fname`
ORDER BY `total_reg` DESC");

$num = $resultSet ->num_rows;

$labels = array();
$data = array();

for($i = 0; $i <$num; $i++){
    $d = $resultSet->fetch_assoc();

    $labels[] = $d["fname"];
    $data [] = $d ["total_reg"];
}

$json = array();
$json["labels"] = $labels;
$json["data"] = $data;

echo json_encode($json);