<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="./">SPK PENILAIAN KINERJA KARYAWAN</a>
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
                    <a href="./" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span>Data</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="alternatif.php">Alternatif</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="bobot.php">Bobot &amp; Kriteria</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="matrik.php" class='sidebar-link'>
                        <i class="bi bi-pentagon-fill"></i>
                        <span>Matrik</span>
                    </a>
                </li>

                <!-- Hanya tampil jika role adalah admin -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li class="sidebar-item">
                        <a href="kelola_user.php" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Kelola Data User</span>
                        </a>
                    </li>
                <?php endif; ?>

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
