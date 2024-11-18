<?php
include 'config.php';

// Mengecek apakah ID transaksi dikirimkan melalui parameter
if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
} else {
    // Jika tidak ada ID transaksi, redirect ke halaman troli
    header("Location: troli.php");
    exit();
}

// Koneksi ke database
// $conn = mysqli_connect("localhost", "username", "password", "nama_database");

// Mendapatkan informasi transaksi dari database berdasarkan ID transaksi
$query_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
$result_transaksi = mysqli_query($conn, $query_transaksi);
$transaksi = mysqli_fetch_assoc($result_transaksi);

// Mendapatkan informasi detail transaksi dari database berdasarkan ID transaksi
$query_detail = "SELECT transaksi_detail.*, data_barang.nama_barang, transaksi.total_belanja FROM transaksi_detail JOIN data_barang ON transaksi_detail.id_barang = data_barang.id_barang JOIN transaksi ON transaksi_detail.id_transaksi = transaksi.id_transaksi WHERE transaksi_detail.id_transaksi = '$id_transaksi'";
$result_detail = mysqli_query($conn, $query_detail);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir - Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Selamat Datang, <?=$_SESSION['nama']?></h1>
                <!-- <a class="logout-link" href="logout.php">Logout</a> ||
                <a href="reset.php">Reset Keranjang</a> || -->
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Checkout Sukses</h2>
                <h4>Informasi Transaksi</h4>
                <p>ID Transaksi: <?=$transaksi['id_transaksi']?></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_detail)) {
                            $sub_total = $row['harga_barang'] * $row['kuantitas'];
                            ?>
                            <tr>
                                <td><?=$row['nama_barang']?></td>
                                <td style="text-align: right;"><?=number_format($row['harga_barang'], 0, ',', '.')?></td>
                                <td><?=$row['kuantitas']?></td>
                                <td style="text-align: right;"><?=number_format($sub_total, 0, ',', '.')?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <h4>Total Pembayaran: Rp. <?=number_format($transaksi['total_belanja'], 0, ',', '.')?></h4>
<form method="POST" action="proses_pembayaran.php">
    <input type="hidden" name="id_transaksi" value="<?=$transaksi['id_transaksi']?>">
    <label for="jumlah_bayar">Jumlah Bayar:</label>
    <input type="number" name="jumlah_bayar" id="jumlah_bayar" required>   
    <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
</form>

            <a href="kasir.php" class="btn btn-danger btn-sm" onclick="return confirm('Pastikan seluruh transaksi telah selesai!')"> Kembali </a>   
        </div>
        </div>
    </div>
</body>
</html>
