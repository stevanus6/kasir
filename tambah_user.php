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

// jika user belum login, redirect ke halaman login
/*if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
} */
if (isset($_POST['simpan']))
{
    // echo var_dump($_POST);
    $id = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $nama= $_POST['nama'];
    $username= $_POST['username'];
    $password= $_POST['password'];
    $email= $_POST['email'];
    $id_role= $_POST['id_role'];

    // query menyimpan ke dalam database
    mysqli_query($conn, "INSERT INTO user VALUES ('$id', '$nama','$username','$password','$email','$id_role')");
    $_SESSION['success'] = 'Data telah berhasil diinput ke dalam sistem';
    // setelah submit masuk ke barang.php
    header("Location: user.php");
}
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title> Add User - Alvian </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body> 
    <div class="container"> 
        <h1> Tambahkan Data User </h1>
        <form method="post">
            <div class="form-group">
            <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama"  class="form-control"  placeholder= "Edit Nama User"  required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"  placeholder="Edit Username Anda"  required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control"  placeholder="Edit Password Anda"  required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"  placeholder="Edit Email Anda" required >
                        </div>
                        <div class="form-group">
                            <label> Pilih Role </label> 
                            <select class="form-control" name="id_role">
                          <option value = ""> Pilih Aksi Role </option>
                          <?php  while ($row = mysqli_fetch_array($role)) {?> 
                        <option value ="<?=$row['id_role']?>"><?=$row['name']?></option>
                    <?php } ?> 
                          </select> 
                          </div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary"> 
                        <a href="user.php" class="btn btn-warning"> Batal </a>
                        </form>
</div>
</body>
</html>