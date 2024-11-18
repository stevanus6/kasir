<?php
// Include file konfigurasi database
include 'config.php';

// Cek apakah pengguna telah login atau belum
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Ambil informasi pengguna dari database berdasarkan ID pengguna yang login
$id_pengguna = $_SESSION['id'];
$query_data_pengguna = "SELECT * FROM user WHERE id = $id_pengguna";
$result_data_pengguna = mysqli_query($conn, $query_data_pengguna);
$data_pengguna = mysqli_fetch_assoc($result_data_pengguna);

// Variabel untuk menyimpan pesan kesalahan
$error_message = '';

// Proses update data pengguna jika ada permintaan
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_baru = $_POST['password_baru'];

    // Validasi password baru
    if (!empty($password_baru) && strlen($password_baru) < 8) {
        $error_message = "Password baru harus memiliki panjang minimal 8 karakter!";
    } else {
        // Jika password baru diisi, lakukan update data pengguna
        $query_update = "UPDATE user SET nama = '$nama', username = '$username', email = '$email'";

        if (!empty($password_baru)) {
            $query_update .= ", password = '$password_baru'";
        }

        $query_update .= " WHERE id = $id_pengguna";
        mysqli_query($conn, $query_update);

        // Redirect ke halaman lain atau berikan pesan sukses
        // Contoh: header("Location: profil.php?status=success");
        // Atau berikan pesan sukses di halaman ini
        $error_message = "Berhasil mengubah data pengguna!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        h1 {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Data Pengguna</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post" action="edit_data.php">
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?=$data_pengguna['nama']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $data_pengguna['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $data_pengguna['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password Baru (kosongkan jika tidak ingin mengubah):</label>
                        <input type="password" class="form-control" name="password_baru" id="password_baru">
                    </div>
                    <button class="btn btn-primary" type="submit" name="update" onclick="return confirm('Yakin untuk melanjutkan?')">Update Data</button>
                    <a href="index.php" type="back" class="btn btn-danger btn-sm" onclick="return confirm('Data Anda tidak akan berubah sebelum disimpan...')">
                        Kembali
                    </a>
                    <?php if ($error_message !== '') { ?>
                        <p style="color: red;"><?= $error_message ?></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
