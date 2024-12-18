<?php
session_start();
include 'include/conn.php';

// Periksa role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Tambah user baru
// if (isset($_POST['add_user'])) {
//     $username = $_POST['username'];
//     $password = md5($_POST['password']);
//     $role = $_POST['role'];

//     $query = "INSERT INTO saw_users (username, password, role) VALUES ('$username', '$password', '$role')";
//     if ($db->query($query)) {
//         echo "<script>alert('Data berhasil ditambahkan');</script>";
//     } else {
//         echo "<script>alert('Data Gagal ditambahkan');</script>";
//     }
// }
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        //$role = $_POST['role'];
        $role = 'user'; // Set default role sebagai user

        // Pastikan nama user sudah ada di tabel saw_alternatives
        $query_check = "SELECT name FROM saw_alternatives WHERE name = '$username'";
        $result_check = $db->query($query_check);

        if ($result_check->num_rows > 0) {
            // Tambahkan user jika nama kandidat valid
            $query = "INSERT INTO saw_users (username, password, role) VALUES ('$username', '$password', '$role')";
            if ($db->query($query)) {
                echo "<script>alert('User berhasil ditambahkan'); window.location.href='kelola_user.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan user!');</script>";
            }
        } else {
            echo "<script>alert('Nama kandidat tidak valid!');</script>";
        }
    }


// Edit user
if (isset($_POST['edit_user'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $query = "UPDATE saw_users SET username='$username', role='$role' WHERE id_user=$id_user";
    if ($db->query($query)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='kelola_user.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Diupdate!');</script>";
    }
}

// Hapus user
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $query = "DELETE FROM saw_users WHERE id_user=$id_user";
    if ($db->query($query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='kelola_user.php';</script>";
    } else {
        echo "<script>alert('Data Tidak Berhasil dihapus!');</script>";
    }
}

// Ambil data user
$where_clause = "";
if (isset($_GET['filter_role']) && $_GET['filter_role'] != '') {
    $filter_role = $_GET['filter_role'];
    $where_clause = "WHERE role='$filter_role'";
}
$users = $db->query("SELECT * FROM saw_users $where_clause");

// Reset Password
if (isset($_POST['reset_password'])) {
    $id_user = $_POST['id_user'];
    $new_password = md5($_POST['new_password']);

    $query = "UPDATE saw_users SET password='$new_password' WHERE id_user=$id_user";
    if ($db->query($query)) {
        echo "<script>alert('Password berhasil diubah!'); window.location.href='kelola_user.php';</script>";
    } else {
        echo "<script>alert('Perubahan password tidak berhasil!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php require "layout/head.php"; ?>

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
                    <h3>Kelola Data User</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <!-- <div class="card">
                                <div class="card-header">
                                    <h4>Kelola Data User</h4>
                                </div> -->
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="GET">
                                            <label for="filter_role">Filter berdasarkan role:</label>
                                            <select name="filter_role" onchange="this.form.submit()">
                                                <option value="">Semua Role</option>
                                                <option value="admin" <?= isset($filter_role) && $filter_role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="manager" <?= isset($filter_role) && $filter_role == 'manager' ? 'selected' : '' ?>>Manager</option>
                                                <option value="user" <?= isset($filter_role) && $filter_role == 'user' ? 'selected' : '' ?>>User</option>
                                            </select>
                                        </form>
                                        <!-- <form method="POST" class="mt-3">
                                            <input type="text" name="username" placeholder="Username" required>
                                            <input type="password" name="password" placeholder="Password" required>
                                            <select name="role" required>
                                                <option value="">Pilih Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="manager">Manager</option>
                                                <option value="user">User</option>
                                            </select>
                                            <button type="submit" name="add_user" class="btn btn-primary">Tambah User</button>
                                        </form> -->

                                        <form method="POST" class="mt-3">
                                            <div class="form-group">
                                                <label for="username">Nama User (karyawan):</label>
                                                <select name="username" class="form-control" required>
                                                    <option value="">Pilih Nama User</option>
                                                    <?php
                                                    // Ambil data kandidat dari tabel saw_alternatives
                                                    $alternatives = $db->query("SELECT name FROM saw_alternatives");
                                                    while ($alt = $alternatives->fetch_assoc()) {
                                                        echo "<option value='{$alt['name']}'>{$alt['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role:</label>
                                                <input type="text" class="form-control" value="User" disabled>
                                                <input type="hidden" name="role" value="user"> <!-- Role secara otomatis menjadi user -->
                                            </div>
                                                <!-- <select name="role" class="form-control" required>
                                                    <option value="">Pilih Role</option> -->
                                                    <!-- <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="user">User</option> -->
                                                    <!-- <option value="user" selected>User</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option> -->
                                                </select>
                                            </div>
                                            <button type="submit" name="add_user" class="btn btn-primary">Tambah User</button>
                                        </form>


                                        <table class="table mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Username</th>
                                                    <th>Role</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $users->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= $row['id_user']; ?></td>
                                                    <td><?= $row['username']; ?></td>
                                                    <td><?= ucfirst($row['role']); ?></td>
                                                    <td>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                                                            <button type="button" class="btn btn-warning" onclick="showResetPasswordModal(<?= $row['id_user']; ?>)">Reset Password</button>
                                                        </form>
                                                        <a href="?delete=<?= $row['id_user']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                        <div id="resetPasswordModal" style="display:none;">
                                            <h3>Reset Password</h3>
                                            <form method="POST">
                                                <input type="hidden" name="id_user" id="modalUserId">
                                                <input type="password" name="new_password" placeholder="Masukkan Password Baru" required>
                                                <button type="submit" name="reset_password" class="btn btn-warning">Reset</button>
                                                <button type="button" class="btn btn-secondary" onclick="closeResetPasswordModal()">Batal</button>
                                            </form>
                                        </div>
                                        <script>
                                            function showResetPasswordModal(idUser) {
                                                document.getElementById('modalUserId').value = idUser;
                                                document.getElementById('resetPasswordModal').style.display = 'block';
                                            }
                                            function closeResetPasswordModal() {
                                                document.getElementById('resetPasswordModal').style.display = 'none';
                                            }
                                        </script>
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
