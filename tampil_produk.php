<?php
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : ''; // Ambil pesan dari URL

// Query SQL dengan kondisi pencarian dan pengurutan
$sql = "SELECT * FROM produk";

if (!empty($search)) {
    $sql .= " WHERE NamaProduk LIKE '%$search%'";
}

// Tambahkan klausa ORDER BY untuk mengurutkan berdasarkan TanggalMasuk secara descending (terbaru di atas)
$sql .= " ORDER BY TanggalMasuk DESC";

$query = mysqli_query($koneksi, $sql);
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Periksa apakah hasil query kosong
$found = !empty($result);

// Fungsi untuk memformat harga ke Rupiah
function formatRupiah($angka) {
    $rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $rupiah;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c1c1c; /* Latar belakang gelap */
            color: #eee; /* Teks terang */
            margin: 0;
            padding-top: 80px; /* Padding untuk navbar */
        }

        .header {
            background-color: #2e2e2e; /* Header sedikit lebih terang */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: bold;
            color: #ffc107; /* Kuning emas untuk logo */
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 0.6rem;
            font-size: 1.8rem;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .nav-item {
            margin-left: 1.5rem;
        }

        .nav-link {
            text-decoration: none;
            color: #eee;
            transition: color 0.3s ease, transform 0.2s ease-in-out;
            padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #ffc107; /* Warna hover emas */
            border-bottom-color: #ffc107;
            transform: translateY(-2px);
        }

        .data-container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #333; /* Kontainer lebih terang */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            color: #eee;
        }

        h1 {
            font-size: 2.4rem;
            font-weight: bold;
            color: #eee;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 0.7rem;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #eee; /* Warna teks default tabel menjadi putih */
        }

        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #555;
            color: #eee; /* Warna teks di dalam sel menjadi putih */
        }

        th {
            background-color: #fff;
            color: #555; /* Warna teks header tetap putih */
        }

        tr:hover {
            background-color: #555; /* Warna latar belakang saat dihover */
            color: #eee; /* Pastikan teks saat dihover juga putih */
            text-align: left;
        }

        .btn-group a {
            text-decoration: none;
            color: #eee; /* Warna teks pada tombol menjadi putih */
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-right: 0.5rem;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn-warning {
            background-color: #f0ad4e;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-warning:hover {
            background-color: #eea236;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .btn-success {
            background-color: #5cb85c;
            color: #eee;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #4cae4c;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #eee;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-left: 1rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .form-inline {
            display: flex;
            margin-bottom: 1rem;
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

        .input-group-append .btn {
            background-color: #ffc107; /* Warna kuning untuk tombol */
            color: #222; 
            border: none;
            border-radius: 3px; 
            height: auto; 
            padding: 0.5rem 1rem; 
            margin-right: 0; 
            cursor: pointer;
            transition: background-color 0.3s ease; 
            display: flex; 
            align-items: center; 
            transition: background-color 0.3s ease;
        }
        .input-group-append .btn:hover {
            background-color: #555; /* Warna yang lebih gelap saat hover */
        }

        .text-center {
            text-align: center;
        }

        .alert {
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
        }

        .close {
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
            text-decoration: none;
        }

        .close:hover {
            opacity: .75;
            text-decoration: none;
        }

        /* Style untuk popup pesan gagal hapus karena foreign key */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1001;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #333;
            color: #eee;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            z-index: 1002;
            text-align: center;
        }

        .popup-content {
            margin-bottom: 15px;
        }

        .popup-buttons .ok-btn {
            background-color: #ffc107;
            color: #222;
            border: none;
            border-radius: 5px;
            padding: 0.7rem 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .popup-buttons .ok-btn:hover {
            background-color: #e0b000;
        }
    </style>
</head>
<body>
<?php if ($pesan == 'gagal_fk'): ?>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <div class="popup-content">
                <p>Data tidak bisa dihapus karena masih terdapat di Detail Penjualan.</p>
            </div>
            <div class="popup-buttons">
                <button onclick="closePopup()" class="ok-btn">OK</button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('popup').style.display = 'block';
            });

            function closePopup() {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('popup').style.display = 'none';
                window.location.href = 'tampil_produk.php'; // Redirect untuk menghilangkan parameter pesan
            }
        </script>
    <?php elseif ($pesan == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($pesan == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data gagal dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="logo">
                <i class="fas fa-camera logo-icon"></i> YURAS KAMERA
            </a>
            <nav class="nav-links">
                <li class="nav-item"><a class="nav-link" href="tampil_produk.php">PRODUK</a></li>
                <li class="nav-item"><a class="nav-link" href="data_penjualan.php">PENJUALAN</a></li>
                <li class="nav-item"><a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
            </nav>
        </div>
    </header>

    <div class="data-container">
        <h1>Daftar Produk</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="tampil_produk.php" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Produk..." value="<?= htmlspecialchars($search) ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <a href="data_produk.php" class="btn btn-success">Tambah Data</a>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Stok</th>
                    <th>Tanggal Masuk</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($found): ?>
                    <?php $i = 1; foreach ($result as $produk): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($produk['NamaProduk']) ?></td>
                            <td><?= formatRupiah($produk['Harga']); ?></td>
                            <td><?= htmlspecialchars($produk['Stok']) ?></td>
                            <td><?= htmlspecialchars($produk['TanggalMasuk']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="edit.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-warning btn-sm mr-2">Edit</a>
                                    <a href="delete.php?id=<?= $produk["ProdukID"] ?>" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Produk yang Anda cari tidak ada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
