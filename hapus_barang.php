<?php  
include 'config.php';


if(isset($_GET['id_barang'])) {
$id_barang = $_GET['id_barang'];

if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 1) {
    $_SESSION['error'] = "Anda tidak memiliki akses ke halaman tersebut, silahkan login ulang";
  header("location: login.php");
  exit();
}

mysqli_query($conn, "DELETE FROM data_barang WHERE id_barang='$id_barang'");

$_SESSION['success'] = 'Data barang telah berhasil dihapus dari sistem';

header("Location: barang.php");


}
?>