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
$view= $conn->query("SELECT u.*,t.name as name FROM user as u INNER JOIN transaksi_role as t ON u.id_role=t.id_role");

    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Data User - Alvian</title>
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
                    <h1> List User </h1>
                    <a href="tambah_user.php" class = "btn btn-primary"> Tambah </a> 
                    <a href="index.php" class = "btn btn-danger"> Kembali </a> 
                    <table class = "table table-bordered"> 
                        <tr> 
                            <th> ID User </th>
                            <th> Nama User </th>
                            <th> Username </th>
                            <th> Password </th>
                            <th> Email </th>
                            <th> Hak Akses </th>
                            <th> Opsion </th>
                         </tr>

                         <?php 

                         while ($row = $view->fetch_array()) { ?>

                         <tr> 
                            <td> UVCR<?php echo $row ['id'] ?></td>
                            <td> <?php echo $row ['nama'] ?></td>
                            <td> <?php echo $row ['username'] ?></td>
                            <td> <?php echo $row ['password'] ?></td>
                            <td> <?php echo $row ['email'] ?></td>
                            <td> <?php echo $row ['name'] ?></td>

                            <td> 
                                <a href = "edit_user.php?id=<?=$row['id']?>"> Edit </a> 
                                <a href = "hapus_user.php?id=<?=$row['id']?>"  onclick= "return confirm ('Yakin untuk menghapus?')"> Hapus </a>
                         </td>
                         </tr> 
                         <?php } ?>
                         </table>
                         </div>
                         </body>
                         </html>