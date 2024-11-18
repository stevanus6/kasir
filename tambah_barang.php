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
     $id_barang = $id_barang = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
      //uniqid();// Menghasilkan ID unik berdasarkan waktu
    $nama_barang= $_POST['barang'];
    $harga_barang= $_POST['harga'];
    $stok_barang= $_POST['stok'];

    // query menyimpan ke dalam database
    mysqli_query($conn, "INSERT INTO data_barang VALUES ('$id_barang','$nama_barang', '$harga_barang', '$stok_barang')");
    $_SESSION['success'] = 'Data berhasil ditambah';
    $_SESSION['success'] = 'Data telah berhasil diinput ke dalam sistem';
    // setelah submit masuk ke barang.php
    header("Location: barang.php");
}
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title> Add Barang - Alvian </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
    <div class="container"> 
        <h1> Tambahkan Data Barang </h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                            <label for="barang">Nama Barang</label>
                            <input type="text" name="barang"  class="form-control"  placeholder= "Tambahkan Nama Barang" >
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" class="form-control"  placeholder="Tambahkan Harga Barang" >
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" name="stok" class="form-control"  placeholder="Tambahkan Stok Barang" >
                        </div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <a href="barang.php" class="btn btn-danger"> Batal </a>
                        </form>
</div>
</body>
</html>