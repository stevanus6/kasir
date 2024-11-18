<?php

include 'config.php';

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
} else {
  $id = $_SESSION['id'];
  $user_query = $conn->query("SELECT * FROM user WHERE id = $id");
  $user = $user_query->fetch_assoc();

  if ($user['id_role'] == 2) {
    header("Location: kasir.php");
    exit();
  }
}

// Ambil data barang dari database
$barang_query = $conn->query("SELECT * FROM data_barang");
?>

<!DOCTYPE html>
<html>
<head> 
    <title> Dashboard </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
    /* CSS untuk tabel */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
      color: #333;
      font-weight: bold;
      text-transform: uppercase;
    }

    tr:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body> 
<div class="container">
    <h1> Selamat Datang, <?php echo $user["nama"]; ?> </h1>
    <a href="barang.php"> Atur Barang </a>  | <a href="user.php"> User </a> | <a href="history.php">History</a> | <a  href="edit_admin.php"> Settings </a> | <a class="logout-link" href="logout.php">Logout</a> 
    <h2>Table Barang Tersedia</h2>
    <table>
        <tr>
            <th>Id Barang</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Stok Barang</th>
        </tr>
        <?php while($row = $barang_query->fetch_assoc()) { ?>
        <tr>
            <td>VCR<?php echo $row['id_barang'] ?></td>
            <td><?php echo $row['nama_barang'] ?></td>
            <td><?php echo 'Rp. ' . number_format($row['harga_barang'], 0, ',', '.');?></td>
            <td><?php echo $row['stok_barang'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
