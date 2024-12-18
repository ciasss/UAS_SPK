<?php
require 'include/conn.php';

$criteria = $_POST['criteria'];
$attribute = $_POST['attribute'];

$sql = "INSERT INTO saw_criterias (criteria, attribute) VALUES ('$criteria', '$attribute')";
$db->query($sql);
echo "Kriteria berhasil ditambahkan!";