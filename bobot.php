<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";
?>

<body>
  <div id="app">
    <?php require "layout/sidebar.php"; ?>
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
                  <p class="card-text">Pengambil keputusan memberi bobot preferensi dari setiap kriteria dengan
                    masing-masing jenisnya (keuntungan/benefit atau biaya/cost):</p>
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
                      <th colspan="2">Atribut</th>
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
        <td>{$row->attribute}</td>
        <td>
            <a href='bobot-edit.php?id={$row->id_criteria}' class='btn btn-info btn-sm'>Edit</a>
            </td>
      </tr>\n";
                    }
                    $result->free();
                    ?>
                  </table><br><br>


                  <?php
                  $matrix = [
                    [1, 2, 3, 4, 5],
                    [1 / 2, 1, 2, 3, 4],
                    [1 / 3, 1 / 2, 1, 2, 3],
                    [1 / 4, 1 / 3, 1 / 2, 1, 2],
                    [1 / 5, 1 / 4, 1 / 3, 1 / 2, 1]
                  ];
                  ?>
                  <table class="table table-striped mb-0">
                    <caption>
                      Matriks Perbandingan Kriteria
                    </caption>
                    <tr>
                      <th>Bobot</th>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                    </tr>

                    <?php
                    $columnTotals = array_fill(0, count($matrix[0]), 0);

                    for ($i = 0; $i < count($matrix); $i++) {
                      echo "<tr>";
                      echo "<th>C" . ($i + 1) . "</th>"; // Header baris

                      for ($j = 0; $j < count($matrix[$i]); $j++) {
                        $value = $matrix[$i][$j];
                        $columnTotals[$j] += $value;
                        echo "<td>" . number_format($value, 4) . "</td>"; // Format angka desimal
                        // hapus
                      }

                      echo "</tr>";
                    }
                    ?>
                    <tr>
                      <th>Total</th>
                      <?php
                      foreach ($columnTotals as $total) {
                        echo "<td>" . number_format($total, 4) . "</td>"; // Tampilkan total kolom
                      }
                      ?>
                    </tr>
                  </table><br><br>

                  <!-- aman -->
                  <table class="table table-striped mb-0">
                    <caption>
                      Normalisasi Matriks Kriteria
                    </caption>
                    <tr>
                      <th>Bobot</th>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                    </tr>

                    <?php

                    for ($i = 0; $i < count($matrix); $i++) {
                      echo "<tr>";
                      echo "<th>C" . ($i + 1) . "</th>"; // Header baris
                      for ($j = 0; $j < count($matrix[$i]); $j++) {
                        $matrix[$i][$j] = $matrix[$i][$j] / $columnTotals[$j];
                        echo "<td>" . number_format($matrix[$i][$j], 4)  . "</td>"; // Format angka desimal
                      }
                      echo "</tr>";
                    }

                    $columnTotals = array_fill(0, count($columnTotals), 0);
                    for ($i = 0; $i < count($matrix); $i++) {
                      for ($j = 0; $j < count($matrix[$i]); $j++) {
                        $value = $matrix[$i][$j];
                        $columnTotals[$j] += $value;
                      }
                    } ?>

                    <tr>
                      <th>Total</th>
                      <?php
                      foreach ($columnTotals as $total) {
                        echo "<td>" . number_format($total, 4) . "</td>"; // Tampilkan total kolom
                      }
                      ?>
                    </tr>
                  </table><br><br>

                  <!-- NILAI RATA RATA -->
                  <table class="table table-striped mb-0">
                    <caption>
                      Nilai Rata-Rata Tiap Baris
                    </caption>
                    <tr>
                      <th>Bobot</th>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                      <th>Nilai Rata-Rata</th>
                    </tr>

                    <?php
                    $rowTotals = array_fill(0, 5, 0);
                    for ($i = 0; $i < count($matrix); $i++) {
                      echo "<tr>";
                      echo "<th>C" . ($i + 1) . "</th>"; // Header baris

                      // $rowTotal=0;
                      for ($j = 0; $j < count($matrix[$i]); $j++) {
                        // $rowTotal+=$matrix[$i][$j];
                        $value = $matrix[$i][$j];
                        $rowTotals[$i] += $value;
                        echo "<td>" . number_format($value, 4) . "</td>"; // Format angka desimal
                      }
                      // $rowAverage = $rowTotal / count($matrix[$i]);
                      echo "<td>" . number_format($rowTotals[$i] / 5, 4) . "</td>";
                      echo "</tr>";
                      $totalAvarageRow = array_sum($rowTotals) / 5;
                    } ?>

                    <tr>
                      <th colspan='6'>Total</th>
                      <th><?php echo $totalAvarageRow ?></th>
                    </tr>

                  </table><br><br>


                  <table class="table table-striped mb-0">
                    <caption>
                      Nilai Bobot
                    </caption>
                    <tr>
                      <th>Kriteria</th>
                      <th>Bobot</th>
                    </tr>

                    <?php
                    $bobot;
                    for ($i = 0; $i < count($rowTotals); $i++) {
                    echo "<tr>";
                    $id=$i+1;
                    echo "<th>C" . ($i + 1) . "</th>";
                    $bobot=$rowTotals[$i]/5;
                    $sql = "UPDATE saw_criterias SET weight='$bobot' WHERE id_criteria='$id'";
                    $result = $db->query($sql);
                    echo "<td>" . number_format($bobot, 4) . "</td>";
                    echo "</tr>";
                    }
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