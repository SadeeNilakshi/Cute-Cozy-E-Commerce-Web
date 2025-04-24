<?php
include "connection.php";

$resultSet = Database::search("SELECT `product`.`id`,`product`.`title`, SUM(`invoice`.`iqty`)AS `total_sold` FROM `invoice`
INNER JOIN `product` ON `invoice`.`product_id` = `product`.`id`
GROUP BY `product`.`id`,`product`.`title`
ORDER BY `total_sold` DESC");

$num = $resultSet ->num_rows;

$labels = array();
$data = array();

for($i = 0; $i <$num; $i++){
    $d = $resultSet->fetch_assoc();

    $labels[] = $d["title"];
    $data [] = $d ["total_sold"];
}

$json = array();
$json["labels"] = $labels;
$json["data"] = $data;

echo json_encode($json);

