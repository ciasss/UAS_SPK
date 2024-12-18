<?php
require 'include/conn.php';

$sql = "SELECT * FROM saw_criterias";
$result = $db->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
