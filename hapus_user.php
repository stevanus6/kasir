<?php  
include 'config.php';


if(isset($_GET['id'])) {
$id = $_GET['id'];

if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 1) {
    $_SESSION['error'] = "Anda tidak memiliki akses ke halaman tersebut, silahkan login ulang";
  header("location: login.php");
  exit();
}

mysqli_query($conn, "DELETE FROM user WHERE id='$id'");

$_SESSION['success'] = 'Data telah berhasil dihapus dari sistem';

header("Location: user.php");


}
?>