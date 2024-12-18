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
        <h3>Matrik</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Matriks Keputusan (X) &amp; Ternormalisasi (R)</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <caption>
                      Matrik Keputusan(X)
                    </caption>
                    <tr>
                      <th rowspan='2'>Alternatif</th>
                      <th colspan='6'>Kriteria</th>
                    </tr>
                    <tr>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                      <th colspan="2"></th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      echo "
                      <tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . round($row->C1, 2)  . "</td>
  <td>" . round($row->C2, 2) . "</td>
  <td>" . round($row->C3, 2) . "</td>
  <td>" . round($row->C4, 2) . "</td>
  <td>" . round($row->C5, 2) . "</td>
  <!--<td> 
  <a href='keputusan-hapus.php?id={$row->id_alternative}' class='btn btn-danger btn-sm'>Hapus</a>
  </td>-->
  </tr>\n";
                    }
                    $total_C1 = array_sum($X[1]);
                    $total_C2 = array_sum($X[2]);
                    $total_C3 = array_sum($X[3]);
                    $total_C4 = array_sum($X[4]);
                    $total_C5 = array_sum($X[5]);
                    echo "
  <tr class='center'>
  <th>Total</th>
  <td>" . array_sum($X[1]) . "</td>
  <td>" . array_sum($X[2]) . "</td>
  <td>" . array_sum($X[3]) . "</td>
  <td>" . array_sum($X[4]) . "</td>
  <td>" . array_sum($X[5]) . "</td>
  </tr>\n";
                    $result->free();

                    ?>
                  </table><br><br>

                  <table class="table table-striped mb-0">
                    <caption>
                      Normalisasi Matrik X
                    </caption>
                    <tr>
                      <th rowspan='2'>Alternatif</th>
                      <th colspan='6'>Kriteria</th>
                    </tr>
                    <tr>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                      <th colspan="2"></th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      echo "<tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . $normalisasi_C1  . "</td>
  <td>" . $normalisasi_C2  . "</td>
  <td>" . $normalisasi_C3  . "</td>
  <td>" . $normalisasi_C4  . "</td>
  <td>" . $normalisasi_C5  . "</td>
  
  </tr>\n";
                    }
                    $result->free();

                    ?>
                  </table><br><br>





                  <table class="table table-striped mb-0">
                    <caption>
                      Matriks Keputusan Berbobot Yang Ternormalisasi
                    </caption>
                    <tr>
                      <th rowspan='2'>Alternatif</th>
                      <th colspan='6'>Kriteria</th>
                    </tr>
                    <tr>
                      <th>C1</th>
                      <th>C2</th>
                      <th>C3</th>
                      <th>C4</th>
                      <th>C5</th>
                      <th colspan="2"></th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4,
          sum(if(id_criteria = 5, weight, 0)) as B5
        FROM
          saw_criterias";
                    $result2 = $db->query($sql2);
                    while ($weight = $result2->fetch_object()) {
                      $bobot_C1 = round($weight->B1, 2);
                      $bobot_C2 = round($weight->B2, 2);
                      $bobot_C3 = round($weight->B3, 2);
                      $bobot_C4 = round($weight->B4, 2);
                      $bobot_C5 = round($weight->B5, 2);
                    }
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                      $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                      $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                      $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                      $bobot_ternormalisasi_C5 = round(($normalisasi_C4 * $bobot_C5), 3);
                      echo "<tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . $bobot_ternormalisasi_C1 . "</td>
  <td>" . $bobot_ternormalisasi_C2 . "</td>
  <td>" . $bobot_ternormalisasi_C3 . "</td>
  <td>" . $bobot_ternormalisasi_C4 . "</td>
  <td>" . $bobot_ternormalisasi_C5 . "</td>
  
  
  </tr>\n";
                    }
                    $result->free();

                    ?>
                  </table><br><br>


                  <table class="table table-striped mb-0">
                    <tr>
                      <th colspan='2'>S+i = C1 + C2 + C3 + C4 + C5</th>
                      <th colspan='2'>S-i = -</th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4,
          sum(if(id_criteria = 5, weight, 0)) as B5
        FROM
          saw_criterias";
                    $result2 = $db->query($sql2);
                    while ($weight = $result2->fetch_object()) {
                      $bobot_C1 = round($weight->B1, 2);
                      $bobot_C2 = round($weight->B2, 2);
                      $bobot_C3 = round($weight->B3, 2);
                      $bobot_C4 = round($weight->B4, 2);
                      $bobot_C5 = round($weight->B5, 2);
                    }
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    $array_cost = array();
                    $array_benefit = array();
                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                      $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                      $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                      $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                      $bobot_ternormalisasi_C5 = round(($normalisasi_C5 * $bobot_C5), 3);
                      $benefit = $bobot_ternormalisasi_C1 + $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4 + $bobot_ternormalisasi_C5;
                      $cost = 0;
                      array_push($array_cost, $cost);
                      $total_cost = round(array_sum($array_cost), 2);
                      array_push($array_benefit, $benefit);
                      $total_benefit = round(array_sum($array_benefit), 2);
                      echo "<tr class='center'>
                      <th>S<sub>{$row->id_alternative}</sub></th>
                      <td>" . $benefit . "</td>
                      <th>S<sub>{$row->id_alternative}</sub></th>
                      <td>" . $cost . "</td>   
                      </tr>\n";
                    }
                    echo "
                      <tr class='center'>
                      <th>Total</th>
                      <td>" . $total_benefit . "</td>
                      <th>Total</th>
                      <td>" . $total_cost . "</td>
                      
                      </tr>\n";
                    $result->free();

                    ?>
                  </table><br><br>


                  <!-- <table class="table table-striped mb-0">
                    <caption>
                      Perhitungan bobot relatif tiap alternatif
                    </caption>
                    <tr>
                      <th colspan='2'>1/S-i</th>

                      <?php
                      $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                      $result = $db->query($sql);
                      $sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4,
          sum(if(id_criteria = 5, weight, 0)) as B5
        FROM
          saw_criterias";
                      $result2 = $db->query($sql2);
                      while ($weight = $result2->fetch_object()) {
                        $bobot_C1 = round($weight->B1, 2);
                        $bobot_C2 = round($weight->B2, 2);
                        $bobot_C3 = round($weight->B3, 2);
                        $bobot_C4 = round($weight->B4, 2);
                        $bobot_C5 = round($weight->B5, 2);
                      }
                      $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                      $array_cost = array();
                      $array_benefit = array();
                      $array_relatif = array();
                      $array_maxq = array();

                      while ($row = $result->fetch_object()) {
                        array_push($X[1], round($row->C1, 2));
                        array_push($X[2], round($row->C2, 2));
                        array_push($X[3], round($row->C3, 2));
                        array_push($X[4], round($row->C4, 2));
                        array_push($X[5], round($row->C5, 2));
                        $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                        $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                        $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                        $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                        $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                        $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                        $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                        $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                        $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                        $bobot_ternormalisasi_C5 = round(($normalisasi_C5 * $bobot_C5), 3);
                        $benefit = $bobot_ternormalisasi_C1 + $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4 + $bobot_ternormalisasi_C5;
                        $cost = 0;
                        array_push($array_cost, $cost);
                        $total_cost = round(array_sum($array_cost), 3);
                        array_push($array_benefit, $benefit);
                        $total_benefit = round(array_sum($array_benefit), 3);
                        $bobot_relatif = round((1 / $bobot_ternormalisasi_C1), 3);
                        array_push($array_relatif, $bobot_relatif);
                        $total_relatif = round(array_sum($array_relatif), 3);
                        // $relatif2 = round(($bobot_ternormalisasi_C1*212.436), 3);

                        // $relatif3 = round($benefit+(0.300/$relatif2), 3);
                        // array_push($array_maxq, $relatif3);
                        // $maxq = max($array_maxq);
                        echo "<tr class='center'>
  <th>S<sub>{$row->id_alternative}</sub></th>
  <td>" . $bobot_relatif . "</td>
  
  
  </tr>\n";
                      }
                      $getTotal_relatif = $total_relatif;
                      $getTotal_cost = $total_cost;


                      echo "
  <tr class='center'>
  <th>Total</th>
  <td>" . $total_relatif . "</td>
  
  
  </tr>\n";
                      $result->free();

                      ?>
                  </table><br><br> -->


                  <table class="table table-striped mb-0">
                    <caption>
                      Perhitungan bobot relatif tiap alternatif
                    </caption>
                    <tr>
                      <!-- <th colspan='2'>S-i * total 1/S-i</th> -->
                      <th colspan='2'>Bobot Relatif</th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4,
          sum(if(id_criteria = 5, weight, 0)) as B5
        FROM
          saw_criterias";
                    $result2 = $db->query($sql2);
                    while ($weight = $result2->fetch_object()) {
                      $bobot_C1 = round($weight->B1, 2);
                      $bobot_C2 = round($weight->B2, 2);
                      $bobot_C3 = round($weight->B3, 2);
                      $bobot_C4 = round($weight->B4, 2);
                      $bobot_C5 = round($weight->B5, 2);
                    }
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    $array_cost = array();
                    $array_benefit = array();
                    $array_relatif = array();
                    $array_maxq = array();

                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                      $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                      $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                      $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                      $bobot_ternormalisasi_C5 = round(($normalisasi_C5 * $bobot_C5), 3);
                      $benefit = $bobot_ternormalisasi_C1 +  $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4 + $bobot_ternormalisasi_C5;
                      $cost = 0;
                      // YG INI MASI BINGUNG
                      array_push($array_cost, $cost);
                      $total_cost = round(array_sum($array_cost), 3);
                      array_push($array_benefit, $benefit);
                      $total_benefit = round(array_sum($array_benefit), 3);
                      $bobot_relatif = round((1 / $bobot_ternormalisasi_C1), 3);
                      array_push($array_relatif, $bobot_relatif);
                      $total_relatif = round(array_sum($array_relatif), 3);
                      $relatif2 = round(($bobot_ternormalisasi_C1 * $getTotal_relatif), 3);

                      $relatif3 = round($benefit + ($getTotal_cost / $relatif2), 3);
                      array_push($array_maxq, $relatif3);
                      $maxq = max($array_maxq);
                      echo "<tr class='center'>";
  
  // <th>S<sub>{$row->id_alternative}</sub></th>
  // <td>" . $relatif2 . "</td>

  echo "<th>Q<sub>{$row->id_alternative}</sub></th>
  <td>" . $relatif3 . "</td>
  
  </tr>\n";
                    }


                    $getMaxq = $maxq;
                    echo "
  <tr class='center'>";
  // <th></th>
  // <td></td>
  echo "<th>Max Q<sub>i</sub></th>
  <td>" . $maxq .  "</td>
  
  </tr>\n";
                    $result->free();

                    ?>
                  </table><br><br>


                  <table class="table table-striped mb-0">
                    <caption>
                      Perhitungan utilitas kuantitatif
                    </caption>
                    <tr>
                      <th colspan='2'>Utilitas Kuantitatif</th>
                    </tr>
                    <?php
                    $sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4,
          sum(if(id_criteria = 5, weight, 0)) as B5
        FROM
          saw_criterias";
                    $result2 = $db->query($sql2);
                    while ($weight = $result2->fetch_object()) {
                      $bobot_C1 = round($weight->B1, 2);
                      $bobot_C2 = round($weight->B2, 2);
                      $bobot_C3 = round($weight->B3, 2);
                      $bobot_C4 = round($weight->B4, 2);
                      $bobot_C5 = round($weight->B5, 2);
                    }
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    $array_cost = array();
                    $array_benefit = array();
                    $array_relatif = array();
                    $array_maxq = array();

                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                      $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                      $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                      $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                      $bobot_ternormalisasi_C5 = round(($normalisasi_C5 * $bobot_C5), 3);
                      $benefit =$bobot_ternormalisasi_C1 + $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4 + $bobot_ternormalisasi_C5;
                      $cost = 0;
                      array_push($array_cost, $cost);
                      $total_cost = round(array_sum($array_cost), 3);
                      array_push($array_benefit, $benefit);
                      $total_benefit = round(array_sum($array_benefit), 3);
                      $bobot_relatif = round((1 / $bobot_ternormalisasi_C1), 3);
                      array_push($array_relatif, $bobot_relatif);
                      $total_relatif = round(array_sum($array_relatif), 3);
                      $relatif2 = round(($bobot_ternormalisasi_C1 * 212.436), 3);
                      $relatif3 = round($benefit + (0.300 / $relatif2), 3);
                      array_push($array_maxq, $relatif3);
                      $maxq = max($array_maxq);

                      $utilitas = round(($relatif3 / $getMaxq), 3);
                      echo "<tr class='center'>
  
  <th>U<sub>{$row->id_alternative}</sub></th>
  <td>" . $utilitas . "</td>
  
  </tr>\n";
                    }



                    $result->free();

                    ?>
                  </table><br><br>

                  <!--

<table class="table table-striped mb-0">
    <caption>
        Matrik Ternormalisasi (R)
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='4'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
    </tr>
    <?php
    $sql = "SELECT
          a.id_alternative,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[1]) . ", " . min($X[1]) . "/a.value
              ) ,0
            ) 
          ) AS C1,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[2]) . ", " . min($X[2]) . "/a.value
              ) ,0
            ) 
          ) AS C2,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[3]) . ", " . min($X[3]) . "/a.value
              ) ,0
            ) 
          ) AS C3,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[3]) . ", " . min($X[3]) . "/a.value
              ) ,0
            ) 
          ) AS C4
          /*
          SUM(
            IF(
              a.id_criteria=2,
              IF(
                b.attribute='benefit',
                a.value/" . max($X[2]) . ",
                " . min($X[2]) . "/a.value)
               ,0)
             ) AS C2,
          SUM(
            IF(
              a.id_criteria=3,
              IF(
                b.attribute='benefit',
                a.value/" . max($X[3]) . ",
                " . min($X[3]) . "/a.value)
               ,0)
             ) AS C3,
          SUM(
            IF(
              a.id_criteria=4,
              IF(
                b.attribute='benefit',
                a.value/" . max($X[4]) . ",
                " . min($X[4]) . "/a.value)
               ,0)
             ) AS C4
             */
        FROM
          saw_evaluations a
          JOIN saw_criterias b USING(id_criteria)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative
       ";
    $result = $db->query($sql);
    $R = array();
    while ($row = $result->fetch_object()) {
      $R[$row->id_alternative] = array($row->C1, $row->C2, $row->C3, $row->C4);
      echo "<tr class='center'>
            <th>A{$row->id_alternative}</th>
            <td>" . round($row->C1, 2) . "</td>
            <td>" . round($row->C2, 2) . "</td>
            <td>" . round($row->C3, 2) . "</td>
            <td>" . round($row->C4, 2) . "</td>
          </tr>\n";
    }
    ?>
</table>



<br><br>


<table class="table table-striped mb-0">
    <caption>
        Matrik Ternormalisasi (R) Coba
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='4'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
    </tr>
    <?php
    $sql = "SELECT
          a.id_alternative,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[1]) . ", " . min($X[1]) . "/a.value
              ) ,0
            ) 
          ) AS C1,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[2]) . ", " . min($X[2]) . "/a.value
              ) ,0
            ) 
          ) AS C2,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[3]) . ", " . min($X[3]) . "/a.value
              ) ,0
            ) 
          ) AS C3,
          SUM(
            IF(
              a.id_criteria=1,
              IF(
                  b.attribute='benefit', a.value/" . max($X[3]) . ", " . min($X[3]) . "/a.value
              ) ,0
            ) 
          ) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_criterias b 
          USING(id_criteria)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative
       ";
    $result = $db->query($sql);
    $R = array();
    while ($row = $result->fetch_object()) {
      $R[$row->id_alternative] = array($row->C1, $row->C2, $row->C3, $row->C4);
      echo "<tr class='center'>
            <th>A{$row->id_alternative}</th>
            <td>" . $total_C1 . "</td>
            <td>" . round($row->C2, 2) . "</td>
            <td>" . round($row->C3, 2) . "</td>
            <td>" . round($row->C4, 2) . "</td>
          </tr>\n";
    }
    // BINGUNG BELUM
    ?>

    
</table>

-->

                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Hasil Perhitungan</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">
                    Setelah didapatkan nilai 𝑈𝑖 kemudian
                    hasil penilaian kinerja karyawan akan
                    diurutkan dari
                    nilai 𝑈𝑖 terbesar sampai dengan
                    nilai 𝑈𝑖 terkecil. Pengguna dapat
                    melihat urutan kinerja karyawan yang telah dihitung menggunakan metode
                    COPRAS.
                  </p>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <caption>
                      Nilai 𝑈𝑖 yang lebih besar
                      mengindikasikan bahwa alternatif memiliki kinerja yang lebih
                      tinggi dibandingkan alternatif lain.
                    </caption>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php
                      $sql = 'SELECT criteria FROM saw_criterias';
                      $result = $db->query($sql);
                      $i = 0;
                      while ($row = $result->fetch_object()) {
                        echo "<th>{$row->criteria}</th>";
                      }
                      $result->free();
                      ?>
                      <!-- <th>Harga</th>
                      <th>BBM</th>
                      <th>CC</th>
                      <th>Tahun</th> -->
                      <th>Nilai</th>

                    </tr>
                    <?php
                    $sql = "SELECT
                              a.id_alternative,
                              b.name,
                              SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
                              SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
                              SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
                              SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
                              SUM(IF(a.id_criteria=5,a.value,0)) AS C5
                              FROM
                              saw_evaluations a
                              JOIN 
                              saw_alternatives b 
                              USING(id_alternative)
                              GROUP BY a.id_alternative
                              ORDER BY a.id_alternative";
                    $result = $db->query($sql);
                    $sql2 = "SELECT
                              weight as bobot,
                              sum(if(id_criteria = 1, weight, 0)) as B1,
                              sum(if(id_criteria = 2, weight, 0)) as B2,
                              sum(if(id_criteria = 3, weight, 0)) as B3,
                              sum(if(id_criteria = 4, weight, 0)) as B4,
                              sum(if(id_criteria = 5, weight, 0)) as B5
                              FROM
                              saw_criterias";
                    $result2 = $db->query($sql2);
                    while ($weight = $result2->fetch_object()) {
                      $bobot_C1 = round($weight->B1, 2);
                      $bobot_C2 = round($weight->B2, 2);
                      $bobot_C3 = round($weight->B3, 2);
                      $bobot_C4 = round($weight->B4, 2);
                      $bobot_C5 = round($weight->B5, 2);
                    }
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    $array_cost = array();
                    $array_benefit = array();
                    $array_relatif = array();
                    $array_maxq = array();

                    while ($row = $result->fetch_object()) {
                      array_push($X[1], round($row->C1, 2));
                      array_push($X[2], round($row->C2, 2));
                      array_push($X[3], round($row->C3, 2));
                      array_push($X[4], round($row->C4, 2));
                      array_push($X[5], round($row->C5, 2));
                      $normalisasi_C1 = round(($row->C1 / $total_C1), 3);
                      $normalisasi_C2 = round(($row->C2 / $total_C2), 3);
                      $normalisasi_C3 = round(($row->C3 / $total_C3), 3);
                      $normalisasi_C4 = round(($row->C4 / $total_C4), 3);
                      $normalisasi_C5 = round(($row->C5 / $total_C5), 3);
                      $bobot_ternormalisasi_C1 = round(($normalisasi_C1 * $bobot_C1), 3);
                      $bobot_ternormalisasi_C2 = round(($normalisasi_C2 * $bobot_C2), 3);
                      $bobot_ternormalisasi_C3 = round(($normalisasi_C3 * $bobot_C3), 3);
                      $bobot_ternormalisasi_C4 = round(($normalisasi_C4 * $bobot_C4), 3);
                      $bobot_ternormalisasi_C5 = round(($normalisasi_C5 * $bobot_C5), 3);
                      $benefit = $bobot_ternormalisasi_C1 + $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4 + $bobot_ternormalisasi_C5;
                      $cost = 0;
                      // BELUM / BINGUNG
                      array_push($array_cost, $cost);
                      $total_cost = round(array_sum($array_cost), 3);
                      array_push($array_benefit, $benefit);
                      $total_benefit = round(array_sum($array_benefit), 3);
                      $bobot_relatif = round((1 / $bobot_ternormalisasi_C1), 3);
                      array_push($array_relatif, $bobot_relatif);
                      $total_relatif = round(array_sum($array_relatif), 3);
                      $relatif2 = round(($bobot_ternormalisasi_C1 * 212.436), 3);
                      $relatif3 = round($benefit + (0.300 / $relatif2), 3);
                      array_push($array_maxq, $relatif3);
                      $maxq = max($array_maxq);

                      $utilitas = round(($relatif3 / $getMaxq), 3);
                      echo "<tr class='center'>
                            
                            <th>{$row->id_alternative}</th>
                            <td>{$row->name}</td>
                            <td>{$row->C1}</td>
                            <td>{$row->C2}</td>
                            <td>{$row->C3}</td>
                            <td>{$row->C4}</td>
                            <td>{$row->C5}</td>

                            <td>" . $utilitas . "</td>
                            
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
      </div>
    </div>
  </div>

  <?php require "layout/js.php"; ?>
</body>

</html>