<!DOCTYPE html>
<html lang="en">

<?php 
    require "layout/head.php";
    require "include/conn.php";
    // session_start(); // Mulai session
        if (!isset($_SESSION['username'])) {
            header("location:login.php"); // Redirect jika user belum login
            exit;
        }
        $username = $_SESSION['username']; // Ambil username dari session
    ?>

<body>
  <div id="app">
    <?php require "layout/sidebar_user.php"; ?>
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <div class="page-heading">
        <h3>Bobot Kriteria</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Tabel Bobot Kriteria</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">Pengambil keputusan untuk penilaian kinerja karyawan berdasarkan kriteria dan bobot di bawah:</p>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <caption>
                      Tabel Kriteria C<sub>i</sub>
                    </caption>
                    <tr>
                      <th>No</th>
                      <th>Simbol</th>
                      <th>Kriteria</th>
                      <th>Bobot</th>
                    </tr>
                    <?php
                    $sql = 'SELECT id_criteria,criteria,weight,attribute FROM saw_criterias';
                    $result = $db->query($sql);
                    $i = 0;
                    while ($row = $result->fetch_object()) {
                      echo "<tr>
        <td class='right'>" . (++$i) . "</td>
        <td class='center'>C{$i}</td>
        <td>{$row->criteria}</td>
        <td>{$row->weight}</td>
      </tr>\n";
                    }
                    $result->free();
                    ?>
                  </table><br><br>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php require "layout/footer.php"; ?>
    </div>
  </div>
  <?php require "layout/js.php"; ?>
</body>

</html>