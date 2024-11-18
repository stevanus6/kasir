<?php
// Include file konfigurasi database
include 'config.php';

// Cek apakah pengguna telah login atau belum
if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 2) {
    header("Location: login.php");
    exit();
}

// Tambahkan barang ke keranjang jika ada permintaan
if(isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $data = mysqli_query($conn, "SELECT * FROM data_barang WHERE id_barang='$id_barang'");
    $dbarang = mysqli_fetch_assoc($data);

    $barang = [
        'id' => $dbarang['id_barang'],
        'nama' => $dbarang['nama_barang'],
        'harga' => $dbarang['harga_barang'],
        'jumlah' => 1
    ];

    $_SESSION['cart'][] = $barang;
    header('Location: kasir.php');
    exit();
}

// Perbarui jumlah barang jika ada permintaan
if(isset($_POST['update'])){
    foreach ($_POST['jumlah'] as $key => $value){
        $_SESSION['cart'][$key]['jumlah'] = $value;
    }
    header("Location: kasir.php");
    exit();
}
?>
