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
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Kriteria</h4>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Kriteria</button>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">
                    Tentukan prioritas perbandingan berpasangan untuk setiap kriteria.
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <caption>Tabel Kriteria</caption>
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Simbol</th>
                          <th>Kriteria</th>
                          <th>Bobot</th>
                          <th>Atribut</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="criteriaTable">
                        <!-- Data akan dimuat menggunakan JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Tambah Kriteria -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form id="addForm">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah Kriteria</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="criteria">Nama Kriteria</label>
                        <input type="text" id="criteria" name="criteria" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label for="attribute">Atribut</label>
                        <select id="attribute" name="attribute" class="form-control">
                          <option value="benefit">Benefit</option>
                          <option value="cost">Cost</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
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

  <script>
    // Fetch data from server
    function loadCriteria() {
      fetch('criteria-api.php')
        .then(response => response.json())
        .then(data => {
          let tableRows = '';
          data.forEach((criteria, index) => {
            tableRows += `
              <tr>
                <td>${index + 1}</td>
                <td>C${index + 1}</td>
                <td>${criteria.criteria}</td>
                <td>${criteria.weight.toFixed(4)}</td>
                <td>${criteria.attribute}</td>
                <td>
                  <button class="btn btn-warning btn-sm" onclick="editCriteria(${criteria.id})">Edit</button>
                  <button class="btn btn-danger btn-sm" onclick="deleteCriteria(${criteria.id})">Hapus</button>
                </td>
              </tr>
            `;
          });
          document.getElementById('criteriaTable').innerHTML = tableRows;
        });
    }

    // Handle form submission for adding criteria
    document.getElementById('addForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('criteria-add.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          alert('Kriteria berhasil ditambahkan');
          loadCriteria();
          document.getElementById('addForm').reset();
          const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
          modal.hide();
        });
    });

    // Load criteria data on page load
    document.addEventListener('DOMContentLoaded', loadCriteria);
  </script>
</body>

</html>
