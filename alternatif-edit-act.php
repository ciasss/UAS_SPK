<?php
require "include/conn.php";

$id_alternative = $_POST['id_alternative'];
$name = $_POST['name'];
$values = array($_POST['c1'], $_POST['c2'], $_POST['c3'], $_POST['c4'], $_POST['c5']);

// Validasi input
if (empty($id_alternative) || empty($name) || count($values) == 0) {
    die("Input tidak valid!");
}

// Update tabel `saw_alternatives`
$sql = $db->prepare("UPDATE saw_alternatives SET name = ? WHERE id_alternative = ?");
$sql->bind_param("si", $name, $id_alternative);
$result = $sql->execute();

if (!$result) {
    die("Gagal mengupdate saw_alternatives: " . $db->error);
}

// Update tabel `saw_evaluations`
foreach ($values as $index => $value) {
    $id_criteria = $index + 1; // Indeks kriteria dimulai dari 1
    $sql_evaluasi = $db->prepare("UPDATE saw_evaluations SET value = ? WHERE id_alternative = ? AND id_criteria = ?");
    $sql_evaluasi->bind_param("dii", $value, $id_alternative, $id_criteria); // "dii" -> double, int, int
    $result = $sql_evaluasi->execute();
    
    if (!$result) {
        die("Gagal mengupdate saw_evaluations (id_criteria = $id_criteria): " . $db->error);
    }
}

// Redirect kembali ke halaman alternatif
header("Location: ./alternatif.php");
?>
