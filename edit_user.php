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

$role = mysqli_query($conn, "SELECT * FROM transaksi_role");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM user WHERE id= '$id'");
    $data = mysqli_fetch_array($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    //jika $id_barang $_POST maka di html : <input type+"hidden" name="id_barang" value="<?=$data['id_barang']" .........  
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $id_role= $_POST['id_role'];

    mysqli_query($conn, "UPDATE user SET nama='$nama', username='$username', password='$password', email='$email', id_role='$id_role' 
    WHERE id = '$id'");

$_SESSION['success'] = 'Data telah berhasil dirubah. Gunakan data terbaru Anda untuk mengakses halaman';

    header("Location: user.php");
    /*exit;*/
}

?>

<!DOCTYPE html>
<head>
    <title>Edit Data - Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
<div class="container"> 
        <h1> Update Data User </h1>
        <form method="post">
            <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama"  class="form-control"  placeholder= "Edit Nama User" value="<?=$data['nama']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"  placeholder="Edit Username Anda" value="<?=$data['username']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control"  placeholder="Edit Password Anda" value="<?=$data['password']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"  placeholder="Edit Email Anda" value="<?=$data['email']?>" required >
                        </div>
                        <div class="form-group">
                            <label> Pilih Role </label> 
                            <select class="form-control" name="id_role">
                          <option value = ""> Pilih Aksi Role </option>
                          <?php  while ($row = mysqli_fetch_array($role)) {?> 
                            <option value ="<?=$row['id_role']?>" <?=$row['id_role']==$data['id_role']?'selected':''?>><?= $row['name'] ?></option>
                        <?php } ?>
                          </select>
                          </div>
                        <input type="submit" name="update" value="Perbarui" class="btn btn-primary">
                        <a href="user.php" class="btn btn-warning"> Batal </a>
                        </form>
    </div>
    <footer>
</body>
</html>
