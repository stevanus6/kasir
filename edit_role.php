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
if (isset($_GET['id_role'])) {
    $id_role = $_GET['id_role'];
    $data = mysqli_query($conn, "SELECT * FROM transaksi_role WHERE id_role = '$id_role'");
    $data = mysqli_fetch_array($data);
}

if (isset($_POST['update'])) {
    $id_role = $_GET['id_role'];
    //jika $id_barang $_POST maka di html : <input type+"hidden" name="id_barang" value="<?=$data['id_barang']" .........  
    $nama = $_POST['nama'];
    mysqli_query($conn, "UPDATE transaksi_role SET nama='$nama' WHERE id_role = '$id_role'");

$_SESSION['success'] = 'Data telah berhasil diperbarui, role telah berubah';

    header("Location: role.php");
    /*exit;*/
}

?>

<!DOCTYPE html>
<head>
    <title>Edit Role - Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
<div class="container"> 
        <h1> Update Data  </h1>
        <form method="post">
            <div class="form-group">
                            <label for="nama">Nama </label>
                            <input type="text" name="nama"  class="form-control"  placeholder= "Edit Nama" value="<?=$data['name']?>" required>
                        </div>
                        <input type="submit" name="update" value="Perbarui" class="btn btn-primary">
                        <a href="role.php" class="btn btn-warning"> Batal </a>
                        </form>
    </div>
    <footer>
</body>
</html>
