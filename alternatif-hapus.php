<?php
require "include/conn.php";

$id = $_GET['id'];

// Validasi input
if (empty($id)) {
    die("ID tidak valid!");
}

// Query untuk menghapus dari tabel saw_evaluations
$sql_delete_evaluations = "DELETE FROM saw_evaluations WHERE id_alternative = '$id'";
if (!mysqli_query($db, $sql_delete_evaluations)) {
    die("Gagal menghapus data dari saw_evaluations: " . mysqli_error($db));
}

// Query untuk menghapus dari tabel saw_alternatives
$sql_delete_alternatives = "DELETE FROM saw_alternatives WHERE id_alternative = '$id'";
if (!mysqli_query($db, $sql_delete_alternatives)) {
    die("Gagal menghapus data dari saw_alternatives: " . mysqli_error($db));
}

// Redirect setelah berhasil
header("location:./alternatif.php");
?>
