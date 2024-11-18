<?php
// Include file konfigurasi database
include 'config.php';

// Cek apakah pengguna telah login atau belum
if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 2) {
    header("Location: login.php");
    exit();
}

$barang = mysqli_query($conn, "SELECT * FROM data_barang ORDER BY nama_barang ASC");

$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += intval($value['harga']) * intval($value['jumlah']);
    }
}

// Perbarui jumlah barang jika ada permintaan
if (isset($_POST['update'])) {
    if (isset($_POST['jumlah'])) {
        foreach ($_POST['jumlah'] as $key => $value) {
            $_SESSION['cart'][$key]['jumlah'] = $value;

            // Kurangi jumlah stok barang di database
            $id_barang = $_SESSION['cart'][$key]['id_barang'];
            $query_update_stok = "UPDATE data_barang SET stok = stok - $value WHERE id_barang = $id_barang";
            mysqli_query($conn, $query_update_stok);
        }
    }
}

// Tambahkan barang ke dalam keranjang jika ada permintaan
if (isset($_POST['input_barang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah_barang = isset($_POST['jumlah_barang']) ? $_POST['jumlah_barang'] : 0;

    if ($jumlah_barang > 0) {
        // Ambil data barang dari database
        $query_barang = "SELECT * FROM data_barang WHERE id_barang = $id_barang";
        $result_barang = mysqli_query($conn, $query_barang);
        $data_barang = mysqli_fetch_assoc($result_barang);

        // Tambahkan barang ke dalam keranjang
        $_SESSION['cart'][] = array(
            'id_barang' => $data_barang['id_barang'],
            'nama' => $data_barang['nama_barang'],
            'harga' => $data_barang['harga_barang'],
            'jumlah' => $jumlah_barang
        );

        // Kurangi jumlah stok barang di database
        $query_update_stok = "UPDATE data_barang SET stok = stok - $jumlah_barang WHERE id_barang = $id_barang";
        mysqli_query($conn, $query_update_stok);
    }
}

// Checkout dan hitung kembalian
if (isset($_POST['checkout'])) {
    $bayar = $_POST['bayar'];
    $kembalian = $bayar - $sum;
    if ($kembalian >= 0) {
        // Simpan data transaksi ke tabel `transaksi`
        $id_transaksi = generateRandomId(); // Fungsi untuk menghasilkan ID transaksi acak
        $query_insert_transaksi = "INSERT INTO transaksi (id_transaksi, total_belanja) VALUES ('$id_transaksi', $sum)";
        mysqli_query($conn, $query_insert_transaksi);

        // Simpan data detail transaksi ke tabel `transaksi_detail`
        foreach ($_SESSION['cart'] as $key => $value) {
            $id_barang = $value['id'];
            $nama_barang = $value['nama'];
            $harga_barang = $value['harga'];
            $kuantitas = $value['jumlah'];
            $total = $harga_barang * $kuantitas;

            // Dapatkan ID detail transaksi
            $query_get_id_detail = "SELECT MAX(id_detail) AS max_id FROM transaksi_detail";
            $result_get_id_detail = mysqli_query($conn, $query_get_id_detail);
            $row_get_id_detail = mysqli_fetch_assoc($result_get_id_detail);
            $id_detail = $row_get_id_detail['max_id'] + 1;

            $query_insert_detail = "INSERT INTO transaksi_detail (id_detail, id_transaksi, id_barang, nama_barang, harga_barang, kuantitas, total) VALUES ($id_detail, '$id_transaksi', '$id_barang', '$nama_barang', $harga_barang, $kuantitas, $total)";
            mysqli_query($conn, $query_insert_detail);

            // Kurangi jumlah stok barang di database
            $query_update_stok = "UPDATE data_barang SET stok_barang = stok_barang - $kuantitas WHERE id_barang = $id_barang";
            mysqli_query($conn, $query_update_stok);
        }

        // Reset keranjang
        $_SESSION['cart'] = [];

        // Redirect ke halaman sukses atau struk pembayaran dengan mengirimkan ID transaksi
        header("Location: checkout_success.php?id_transaksi=$id_transaksi");
        exit();
    } else {
        $error_message = "Jumlah pembayaran kurang";
    }
}



// Fungsi untuk menghasilkan ID transaksi acak
function generateRandomId() {
    $characters = '0123456789';
    $id = '';
    for ($i = 0; $i < 5; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $id .= $characters[$index];
    }
    return $id;
}
// var_dump ($query_update_stok);
?>

