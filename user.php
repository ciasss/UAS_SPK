

<!DOCTYPE html>
<html lang="en">
    <?php 
    require "layout/head.php";
    
    // session_start(); // Mulai session
        if (!isset($_SESSION['username'])) {
            header("location:login.php"); // Redirect jika user belum login
            exit;
        }
        $username = $_SESSION['username']; // Ambil username dari session
    ?>

    <body>
        <div id="app">
            <?php require "layout/sidebar_user.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <!-- Menampilkan Halo, 'username' -->
                    <h3>Halo, <?= htmlspecialchars($username); ?></h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Sistem Pendukung Keputusan Penilaian Kerja Karyawan</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="card-text">
                                        Metode AHP (Analytic Hierarchy Process) adalah teknik pengambilan keputusan untuk menentukan bobot kriteria melalui perbandingan berpasangan, menghasilkan prioritas yang konsisten dan terukur.
                                        <br><br>
                                        Metode COPRAS digunakan untuk menganalisis alternatif yang berbeda, dan memperkirakan alternatif sesuai dengan tingkat utilitasnya dimana nilai-nilai dari atribut dinyatakan dalam interval untuk meningkatkan efisiensi dan meningkatkan akurasi dalam proses pengambilan keputusan.
                                        </p>
                                        <hr>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php require "layout/footer.php";?>
            </div>
        </div>
        <?php require "layout/js.php";?>
    </body>

</html>