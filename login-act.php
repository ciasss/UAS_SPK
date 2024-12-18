<?php
include 'include/conn.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

// Query untuk memeriksa username, password, dan role
$login = $db->query("SELECT * FROM saw_users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    session_start();
    $data = $login->fetch_assoc();

    // Simpan data ke session
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['status'] = "login";
    header("location:index.php");

    // Arahkan berdasarkan role
    if ($data['role'] == 'admin') {
        header("location:index.php");
    } elseif ($data['role'] == 'manager') {
        header("location:manager_dashboard.php");
    } elseif ($data['role'] == 'user') {
        header("location:user.php");
    } else {
        // Jika role tidak diketahui
        header("location:login.php?error=unknown_role");
    }
} else {
    header("location:login.php?error=invalid");
}
?>
