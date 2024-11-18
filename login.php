<?php
// Include file konfigurasi database
include 'config.php';

// Inisialisasi pesan error
if (!isset($_SESSION['error'])) {
    $_SESSION['error'] = '';
}

// Inisialisasi pesan sukses
if (!isset($_SESSION['success_message'])) {
    $_SESSION['success_message'] = '';
}

// Cek apakah terdapat pesan sukses
if ($_SESSION['success_message'] != '') {
    // Tampilkan alert sukses
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';

    // Hapus pesan sukses dari session
    $_SESSION['success_message'] = '';
}

// Cek apakah terdapat pesan error
if ($_SESSION['error'] != '') {
    // Tampilkan alert error
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';

    // Hapus pesan error dari session
    $_SESSION['error'] = '';
}

// Cek apakah pengguna mengirimkan formulir login
if (isset($_POST['masuk'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencocokkan username atau email dengan password
    $query = mysqli_query($conn, "SELECT * FROM user WHERE (username='$username' OR email='$username') AND password='$password'");

    // Mengambil data pengguna
    $data = mysqli_fetch_array($query);

    // Memeriksa jumlah baris yang dikembalikan
    $check = mysqli_num_rows($query);

    if (!$check) {
        $_SESSION['error'] = 'Username atau password salah! Silahkan ulangi.';
    } else {
        // Menyimpan data pengguna dalam session
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['id_role'] = $data['id_role'];

        // Mengalihkan pengguna ke halaman setelah login
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Page POS - Alvian</title>
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

        <h1>Login</h1>
        <form method='post'>
            <div class='form-group'>
                <label for="username">Username</label>
                <input type='text' class='form-control' id='username' name='username' placeholder="masukkan username Anda">
            </div>
            <div class='form-group'>
                <label for="password">Password</label>
                <input type='password' class='form-control' id='password' name='password' placeholder="masukkan password Anda">
            </div>
            <input type="submit" name="masuk" value="Masuk" class="btn btn-primary">
            <a href="lupa_password.php" class="btn btn-link">Lupa Password?</a>
        </form>
        <footer>
    </div>
</body>

</html>
