<?php
// Include file konfigurasi database
include 'config.php';

if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];

    // Cari barang berdasarkan nama_barang di database
    $query = "SELECT nama_barang FROM data_barang WHERE nama_barang LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);

    $barang = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $barang[] = $row;
    }

    echo json_encode($barang);
}
?>
