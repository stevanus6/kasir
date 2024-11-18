<?php
// Include file konfigurasi database
include 'config.php';

// Inisialisasi pesan error
if (!isset($_SESSION['error'])) {
    $_SESSION['error'] = '';
}

// Cek apakah pengguna mengirimkan formulir lupa password
if (isset($_POST['kirim'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Query untuk mencari pengguna berdasarkan username dan email
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND email='$email'");

    // Memeriksa jumlah baris yang dikembalikan
    $check = mysqli_num_rows($query);

    if (!$check) {
        $_SESSION['error'] = 'Username atau email yang Anda masukkan tidak valid. Silahkan ulangi.';
    } else {
        // Redirect pengguna ke halaman ubah password
        header("Location: ubah_password.php?username=$username");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lupa Password - POS Alvian</title>
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

        <h1>Form Lupa Password</h1>
        <form method='post'>
            <div class='form-group'>
                <label for="username">Username</label>
                <input type='text' class='form-control' id='username' name='username' placeholder="masukkan username Anda">
            </div>
            <div class='form-group'>
                <label for="email">Email</label>
                <input type='email' class='form-control' id='email' name='email' placeholder="masukkan email Anda">
            </div>
            <input type="submit" name="kirim" value="Kirim" class="btn btn-primary">
            <a href="login.php" class="btn btn-danger">Kembali</a>
        </form>
        <footer>
    </div>
</body>

</html>
