<?php
include 'config.php';



if(!isset($_SESSION['id'])){
  header("location: login.php");
  exit();
}


$view = $conn->query ("SELECT * FROM transaksi_role");

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
        <title>Role Data - Alvian</title>
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
                    <h1> Role Setting </h1>
                    <a href="tambah_role.php" class = "btn btn-primary"> Tambah Data </a> 
                    <table class = "table table-bordered"> 
                        <tr> 
                            <th> ID Role </th>
                            <th> Nama  </th>
                         </tr>

                         <?php 

                         while ($row = $view->fetch_array()) { ?>

                         <tr> 
                            <td> <?php echo $row ['id_role'] ?></td>
                            <td> <?php echo $row ['name'] ?></td>
                            <td> 
                                <a href = "edit_role.php?id_role=<?=$row['id_role']?>"> Edit </a> 
                                <a href = "hapus_role.php?id_role=<?=$row['id_role']?>"  onclick= "return confirm ('Yakin untuk menghapus?')"> Hapus </a>
                         </td>
                         </tr> 
                         <?php } ?>
                         </table>
                         </div>
                         </body>
                         </html>