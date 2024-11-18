<?php
// Include file konfigurasi database
include 'config.php';

// Inisialisasi pesan error
if (!isset($_SESSION['error'])) {
    $_SESSION['error'] = '';
}

// Memeriksa apakah parameter username ada dalam URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    // Jika parameter username tidak ada, redirect pengguna ke halaman lupa_password.php
    header("Location: lupa_password.php");
    exit();
}

// Cek apakah pengguna mengirimkan formulir ubah password
if (isset($_POST['ubah'])) {
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password != $konfirmasi_password) {
        $_SESSION['error'] = 'Konfirmasi password tidak sesuai! Silakan coba lagi.';
    } else {
        // Update password pengguna dalam database
        $query_update = mysqli_query($conn, "UPDATE user SET password='$password' WHERE username='$username'");

        if ($query_update) {
            // Redirect pengguna ke halaman login.php dengan pesan sukses
            $_SESSION['success_message'] = 'Password telah berhasil diubah. Silahkan login dengan password baru Anda.';
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan saat mengubah password! Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ubah Password - POS Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <?php if ($_SESSION['error'] != '') { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php
            $_SESSION['error'] = '';
        }
        ?>

        <h1>Ubah Password</h1>
        <form method='post'>
            <div class='form-group'>
                <label for="password">Password Baru</label>
                <input type='password' class='form-control' id='password' name='password' placeholder="Masukkan password baru">
            </div>
            <div class='form-group'>
                <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                <input type='password' class='form-control' id='konfirmasi_password' name='konfirmasi_password' placeholder="Konfirmasi password baru">
            </div>
            <input type="submit" name="ubah" value="Ubah Password" class="btn btn-primary">
            <a href="lupa_password.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>
</body>

</html>
