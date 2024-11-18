<?php
include 'config.php';


if(!isset($_SESSION['id'])){
  header("location: login.php");
  exit();
}

if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 1) {
    $_SESSION['error'] = "Anda tidak memiliki akses ke halaman tersebut, silahkan login ulang";
  header("location: login.php");
  exit();
}
// jika user belum login, redirect ke halaman login
/*if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
} */
if (isset($_POST['simpan']))
{
    // echo var_dump($_POST);
    $nama= $_POST['nama'];
    // query menyimpan ke dalam database
    mysqli_query($conn, "INSERT INTO transaksi_role VALUES ('', '$nama')");
    $_SESSION['success'] = 'Data telah berhasil diinput ke dalam sistem';
    // setelah submit masuk ke barang.php
    header("Location: role.php");
}
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title> Add Role - Alvian </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
    <div class="container"> 
        <h1> Tambahkan Data Disini </h1>
        <form method="post">
            <div class="form-group">
                            <label for="nama">Nama Role</label>
                            <input type="text" name="nama"  class="form-control"  placeholder= "Tambahkan Nama" >
                        </div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <a href="role.php" class="btn btn-warning"> Batal </a>
                        </form>
</div>
</body>
</html>