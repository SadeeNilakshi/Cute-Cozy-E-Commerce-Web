<?php
include "connection.php";

$resultSet = Database::search("SELECT `product`.`id`,`product`.`title`, COUNT(`feedback`.`feed_id`)AS `total_review` FROM `feedback`
INNER JOIN `product` ON `feedback`.`product_id` = `product`.`id`
GROUP BY `product`.`id`,`product`.`title`
ORDER BY `total_review` DESC");

$num = $resultSet ->num_rows;

$labels = array();
$data = array();

for($i = 0; $i <$num; $i++){
    $d = $resultSet->fetch_assoc();

    $labels[] = $d["title"];
    $data [] = $d ["total_review"];
}

$json = array();
$json["labels"] = $labels;
$json["data"] = $data;

echo json_encode($json);