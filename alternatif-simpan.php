<?php
require "include/conn.php";

// Ambil data dari form
$name = $_POST['name'];
$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];
$c4 = $_POST['c4'];
$c5 = $_POST['c5'];

// Insert nama ke tabel saw_alternatives
$sql = "INSERT INTO saw_alternatives (name) VALUES ('$name')";

if ($db->query($sql) === true) {
    // Dapatkan ID dari alternatif yang baru saja ditambahkan
    $id_alternative = $db->insert_id;

    // Array nilai untuk dimasukkan ke saw_evaluations
    $values = [$c1, $c2, $c3, $c4, $c5];

    // Loop untuk menambahkan ke tabel saw_evaluations
    $success = true;
    foreach ($values as $index => $value) {
        $id_criteria = $index + 1; // ID Criteria (1-5)
        $sql_eval = "INSERT INTO saw_evaluations (id_alternative, id_criteria, value) 
                     VALUES ('$id_alternative', '$id_criteria', '$value')";

        // Jika gagal pada salah satu query, hentikan eksekusi
        if (!$db->query($sql_eval)) {
            $success = false;
            echo "Error: " . $sql_eval . "<br>" . $db->error;
            break;
        }
    }

    // Jika semua berhasil, redirect ke alternatif.php
    if ($success) {
        header("location:./alternatif.php");
    }
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}
?>
