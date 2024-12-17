<?php 
    // session_start(); // Mulai session
        if (!isset($_SESSION['username'])) {
            header("location:login.php"); // Redirect jika user belum login
            exit;
        }
        $username = $_SESSION['username']; // Ambil username dari session
    ?>
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="user.php">SPK PENILAIAN KINERJA KARYAWAN</a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item">
                    <a href="user.php" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="kriteria.php" class='sidebar-link'>
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span>Kriteria Penilaian</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="penilaian.php" class='sidebar-link'>
                        <i class="bi bi-pentagon-fill"></i>
                        <span>Penilaian</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="logout.php" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
