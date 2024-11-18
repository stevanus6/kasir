<?php
include 'config.php';

// Mengecek apakah ID transaksi dan jumlah bayar dikirimkan melalui metode POST
if (isset($_POST['id_transaksi']) && isset($_POST['jumlah_bayar'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    // Mendapatkan informasi transaksi dari database berdasarkan ID transaksi
    $query_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $transaksi = mysqli_fetch_assoc($result_transaksi);

    // Menghitung jumlah kembalian
    $total_belanja = $transaksi['total_belanja'];
    $kembalian = $jumlah_bayar - $total_belanja;
}
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
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Proses Pembayaran</h2>
                <h4>ID Transaksi: <?=$transaksi['id_transaksi']?></h4>
                <h4>Total Pembayaran: Rp. <?=number_format($total_belanja, 0, ',', '.')?></h4>
                <h4>Jumlah Bayar: Rp. <?=number_format($jumlah_bayar, 0, ',', '.')?></h4>
                <h4>Kembalian: Rp. <?=number_format($kembalian, 0, ',', '.')?></h4>
                <a href="kasir.php" class="btn btn-danger btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
