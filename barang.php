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

$view = $conn->query ("SELECT * FROM data_barang");

// jika user belum login, redirect ke halaman login
/*if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}*/
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Data Barang - Alvian</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <style>
           .table th {
                text-align: center;
            } </style> 
            </head>

            <body>
                <div class="container"> 
                <?php if(isset($_SESSION['success']) && $_SESSION['success'] != '') {?>
    <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?>
    </div>

    <?php 
    } $_SESSION['success'] = '';
    ?>
                    <h1> List Barang </h1>
                    <table class = "table table-bordered"> 
                        <tr> 
                            <th> ID Barang </th>
                            <th> Nama Barang </th>
                            <th> Harga Barang </th>
                            <th> Stok Sisa </th>
                            <th> Opsion </th>
                         </tr>

                         <?php 

                         while ($row = $view->fetch_array()) { ?>

                         <tr> 
                         <td> VCR<?php echo $row ['id_barang'] ?></td>
                            <td> <?php echo $row ['nama_barang'] ?></td>
                            <td><?php echo 'Rp. ' . number_format($row['harga_barang'], 0, ',', '.');?></td>
                            <td> <?php echo $row ['stok_barang'] ?></td>
                            <td> 
                                <a href = "edit_barang.php?id_barang=<?=$row['id_barang']?>"> Edit </a> |
                                <a href = "hapus_barang.php?id_barang=<?=$row['id_barang']?>"  onclick= "return confirm ('Yakin untuk menghapus?')"> Hapus </a>
                         </td>
                         </tr> 
                         <?php } ?>
                         </table>
                         <a href="tambah_barang.php" class = "btn btn-primary"> Tambah </a> 
                         <a href="index.php" class = "btn btn-danger"> Kembali </a> 
                         </div>
                         <footer>
                         </body>
                         </html>