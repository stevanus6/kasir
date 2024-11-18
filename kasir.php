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
            $id_barang = $value['id_barang'];
            $jumlah = $value['jumlah'];
            $total = $value['harga'] * $jumlah;
            $uang_terima = $bayar; // Ambil nilai uang_terima dari form Total Bayar
            $query_insert_detail = "INSERT INTO transaksi_detail (id_transaksi, id_barang, kuantitas, total, uang_terima) VALUES ('$id_transaksi', '$id_barang', $jumlah, $total, $uang_terima)";
            mysqli_query($conn, $query_insert_detail);
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
function generateRandomId()
{
    $characters = '0123456789';
    $id = '';
    for ($i = 0; $i < 5; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $id .= $characters[$index];
    }
    return $id;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir - Alvian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        /* CSS untuk fitur pencarian */
        .search-container {
            position: relative;
            display: inline-block;
        }

        #barangSearch {
            width: 100%;
            padding: 8px;
        }

        #searchResults {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        #searchResults a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: #000;
        }

        #searchResults a:hover {
            background-color: #e9e9e9;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Selamat Datang, <?= $_SESSION['nama'] ?></h1>
                <a href="edit_data.php">Settings</a> |
                <a href="reset.php">Reset Keranjang</a> |
                <a class="logout-link" href="logout.php">Logout</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <!-- Form dan tabel barang -->
                <form method="post" action="troli.php">
                    <div class="input-group">
                        <div class="search-container">
                            <input type="text" id="barangSearch" placeholder="Cari barang...">
                            <div id="searchResults"></div>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" name="input_barang">Input Barang</button>
                        </div>
                    </div>
                </form>
                <br>
                <form method="post" action="troli.php">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['cart'])) { ?>
                                <?php foreach (array_reverse($_SESSION['cart']) as $key => $value) { ?>
                                    <tr>
                                        <td><?= $value['id_barang'] ?></td>
                                        <td><?= $value['nama'] ?></td>
                                        <td style="text-align: right;"><?= number_format($value['harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <input type="number" class="form-control" name="jumlah[<?= $key ?>]" value="<?= $value['jumlah'] ?>">
                                        </td>
                                        <td style="text-align: right;"><?= number_format(intval($value['jumlah']) * intval($value['harga']), 0, ',', '.') ?></td>

                                        <td>
                                            <a href="hapus_barang_kasir.php?key=<?= $key ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                X
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button class="btn btn-success" type="submit" name="update">Update Troli</button>
                </form>
            </div>
            <div class="col-md-4">
                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                    <h3>Total Rp. <?= number_format($sum, 0, ',', '.') ?></h3>
                    <form method="post" action="checkout.php">
                        <div class="form-group">
                            <label for="bayar">Total Bayar:</label>
                            <input type="number" class="form-control" name="bayar" id="bayar" required>
                        </div>
                        <button class="btn btn-primary" type="submit" name="checkout">Checkout</button>
                        <?php if (isset($error_message)) { ?>
                            <p style="color: red;"><?= $error_message ?></p>
                        <?php } ?>
                    </form>
                <?php } else { ?>
                    <p>Tidak ada data yang dapat diproses.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#barangSearch").on("input", function () {
                var searchText = $(this).val();
                if (searchText.length > 0) {
                    $.ajax({
                        url: "search_barang.php",
                        method: "POST",
                        data: { searchText: searchText },
                        dataType: "json",
                        success: function (response) {
                            var searchResults = $("#searchResults");
                            searchResults.empty();
                            if (response.length > 0) {
                                $.each(response, function (index, value) {
                                    var resultItem = $("<a>")
                                        .attr("href", "#")
                                        .text(value.nama_barang)
                                        .appendTo(searchResults);
                                });
                                searchResults.show();
                            } else {
                                searchResults.hide();
                            }
                        }
                    });
                } else {
                    $("#searchResults").empty().hide();
                }
            });

            $(document).on("click", "#searchResults a", function (event) {
                event.preventDefault();
                var selectedBarang = $(this).text();
                $("#barangSearch").val(selectedBarang);
                $("#searchResults").empty().hide();
                $("form[name='input_barang']").submit();
            });

            $(document).click(function (event) {
                if (!$(event.target).closest("#searchResults").length) {
                    $("#searchResults").empty().hide();
                }
            });
        });
    </script>
</body>
</html>
