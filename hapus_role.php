<?php  
include 'config.php';

if(isset($_GET['id_role'])) {
$id_role = $_GET['id_role'];

if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 1) {
    $_SESSION['error'] = "Anda tidak memiliki akses ke halaman tersebut, silahkan login ulang";
  header("location: login.php");
  exit();
}

mysqli_query($conn, "DELETE FROM transaksi_role WHERE id_role='$id_role'");

$_SESSION['success'] = 'Data telah berhasil dihapus dari sistem';

header("Location: role.php");


}
?>