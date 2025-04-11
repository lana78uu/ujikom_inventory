<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$PenjualanID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Query SQL dengan kondisi pencarian dan pengurutan tanggal
$sql = "SELECT penjualan.*, produk.NamaProduk, toko.NamaToko
            FROM penjualan
            INNER JOIN produk ON penjualan.ProdukID = produk.ProdukID
            INNER JOIN toko ON penjualan.TokoID = toko.TokoID";

if (!empty($search)) {
    $sql .= " WHERE produk.NamaProduk LIKE '%$search%'";
}

if ($PenjualanID) {
    $sql .= " WHERE PenjualanID = $PenjualanID";
}

$sql .= " ORDER BY TanggalPenjualan DESC"; // DESC untuk terbaru ke terlama

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);

// Fungsi untuk memformat harga ke Rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 2, ',', '.');
}

// Hitung total jumlah dan subtotal
$totalJumlah = 0;
$totalSubtotal = 0;
foreach ($result as $row) {
    $totalJumlah += $row['Stok'];
    $totalSubtotal += $row['Subtotal'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c1c1c; /* Latar belakang gelap */
            color: #eee; /* Teks terang */
            margin: 0;
            padding-top: 60px; /* Padding untuk navbar fixed */
        }

        .header {
            background-color: #2e2e2e; /* Header sedikit lebih terang */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; /* Navbar fixed di atas */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: bold;
            color: #ffc107; /* Kuning emas untuk logo */
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 0.5rem;
            font-size: 1.6rem;
        }

        .nav {
            display: flex;
        }

        .nav-link {
            color: #eee;
            text-decoration: none;
            margin-left: 1.5rem;
            transition: color 0.3s ease, transform 0.2s ease-in-out;
            padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #ffc107;
            border-bottom-color: #ffc107;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 80px auto 40px auto; /* Margin atas disesuaikan agar tidak tertutup navbar */
            padding: 2rem;
            border-radius: 8px;
            background-color: #333; /* Latar belakang kontainer gelap */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            color: #eee; /* Warna teks dalam kontainer */
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #eee;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 0.7rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 1px solid #555;
            border-radius: 5px;
            padding: 1rem;
            color: #eee;
            background-color: #eee;
        }

        .form-control:focus {
            outline: none;
            border-color: #ffc107;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }

        .btn-primary,
        .btn-secondary {
            background-color: #ffc107;
            border: none;
            color: #222;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background-color: #e0b000;
            transform: scale(1.05);
        }

        .table {
            width: 100%;
            margin-top: 1.5rem;
            color: #eee;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #555;
        }

        .table th {
            background-color: #2e2e2e;
            color: #ffc107;
        }

        .table tbody tr:nth-child(even) {
            background-color: #333;
        }

        .table tbody tr:hover {
            background-color: #444;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tfoot strong {
            color: #ffc107;
        }
    </style>
</head>
<body>
<header class="header">
    <a href="index.php" class="logo">
        <i class="fas fa-camera logo-icon"></i> KAMERA
    </a>
    <nav class="nav">
        <a class="nav-link" href="tampil_produk.php">PRODUK</a>
        <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
        <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        <a class="nav-link" href="logout.php">LOGOUT</a>
    </nav>
</header>

<div class="container mt-5">
    <h2>Detail Penjualan</h2>
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="detail_penjualan.php" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Subtotal</th>
                <th>Tanggal Penjualan</th>
                <th>Nama Toko</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($found): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= $row['NamaProduk'] ?></td>
                        <td><?= formatRupiah($row['Harga']) ?></td>
                        <td><?= $row['Stok'] ?></td>
                        <td><?= formatRupiah($row['Subtotal']) ?></td>
                        <td><?= $row['TanggalPenjualan'] ?></td>
                        <td><?= $row['NamaToko'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Barang yang Anda cari tidak ada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td><?= formatRupiah($totalSubtotal) ?></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>