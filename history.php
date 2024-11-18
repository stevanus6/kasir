<?php
// Include file konfigurasi database
include 'config.php';

// Cek apakah pengguna telah login atau belum
if (!isset($_SESSION['id']) || $_SESSION['id_role'] != 1) {
    header("Location: login.php");
    exit();
}

// Ambil semua ID transaksi dari tabel `transaksi`
$query_get_ids = "SELECT id_transaksi FROM transaksi";
$result_get_ids = mysqli_query($conn, $query_get_ids);
$ids = [];
while ($row = mysqli_fetch_assoc($result_get_ids)) {
    $ids[] = $row['id_transaksi'];
}

// Ambil ID transaksi yang dipilih dari dropdown (jika ada)
$selected_id = isset($_POST['selected_id']) ? $_POST['selected_id'] : '';

// Ambil detail transaksi berdasarkan ID transaksi yang dipilih
$detail_transaksi = [];
if ($selected_id != '') {
    $query_get_detail = "SELECT * FROM transaksi_detail WHERE id_transaksi = '$selected_id'";
    $result_get_detail = mysqli_query($conn, $query_get_detail);
    while ($row = mysqli_fetch_assoc($result_get_detail)) {
        $detail_transaksi[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>History Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        body {
            padding: 20px;
        }
        
        h1, h2 {
            text-align: center;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        
        /* .logout-link {
            float: left;
        } */
    </style>
</head>
<body>
    <h1>Selamat Datang, <?=$_SESSION['nama']?></h1>
    <a class="logout-link" href="logout.php">Logout</a>

    <!-- Dropdown untuk memilih ID transaksi -->
    <form method="POST">
        <label for="selected_id">Pilih ID Transaksi:</label>
        <select name="selected_id" id="selected_id">
            <option value="">-- Pilih ID Transaksi --</option>
            <?php foreach ($ids as $id) { ?>
                <option value="<?php echo $id; ?>" <?php if ($selected_id == $id) echo 'selected'; ?>>
                    <?php echo $id; ?>
                </option>
            <?php } ?>
        </select>

    <input type="submit" value="Tampilkan" class="btn btn-primary">
    <a href="index.php" type="back" class="btn btn-danger btn-sm")">
                        Kembali
                    </a>
                        </form>

    <?php if ($selected_id != '') { ?>
        <h2>Detail Transaksi (ID Transaksi: <?php echo $selected_id; ?>)</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID Detail</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail_transaksi as $detail) { ?>
                    <tr>
                        <td><?php echo $detail['id_detail']; ?></td>
                        <td><?php echo $detail['id_barang']; ?></td>
                        <td><?php echo $detail['nama_barang']; ?></td>
                        <td><?php echo $detail['harga_barang']; ?></td>
                        <td><?php echo $detail['kuantitas']; ?></td>
                        <td><?php echo $detail['total']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>

