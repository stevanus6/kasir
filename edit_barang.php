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


if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    $data = mysqli_query($conn, "SELECT * FROM data_barang WHERE id_barang = '$id_barang'");
    $data = mysqli_fetch_array($data);
}

if (isset($_POST['update'])) {
    $id_barang = $_GET['id_barang'];
    //jika $id_barang $_POST maka di html : <input type+"hidden" name="id_barang" value="<?=$data['id_barang']" .........  
    $nama_barang = $_POST['barang'];
    $harga_barang = $_POST['harga'];
    $stok_barang = $_POST['stok'];

    mysqli_query($conn, "UPDATE data_barang SET nama_barang='$nama_barang', harga_barang='$harga_barang', stok_barang='$stok_barang' 
    WHERE id_barang = '$id_barang'");

$_SESSION['success'] = 'Data barang telah berhasil diperbarui';

    header("Location: barang.php");
    /*exit;*/
}

?>

<!DOCTYPE html>
<head>
    <title>Edit Barang - Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
<div class="container"> 
        <h1> Update Data Barang </h1>
        <form method="post">
            <div class="form-group">
                            <label for="barang">Nama Barang</label>
                            <input type="text" name="barang"  class="form-control"  placeholder= "Edit Nama Barang" value="<?=$data['nama_barang']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" class="form-control"  placeholder="Edit Harga Barang" value="<?=$data['harga_barang']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" name="stok" class="form-control"  placeholder="Edit Stok Barang" value="<?=$data['stok_barang']?>" required >
                        </div>
                        <input type="submit" name="update" value="Perbarui" class="btn btn-primary">
                        <a href="barang.php" class="btn btn-warning"> Batal </a>
                        </form>
    </div>
</body>
</html>
