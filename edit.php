<?php
include("koneksi.php");

$ProdukID = $_GET["id"];

$sql = "SELECT * FROM produk WHERE ProdukID=$ProdukID";
$result = mysqli_query($koneksi, $sql);
$barang = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
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
            max-width: 800px;
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
        .form-group label {
            color: #eee;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control {
            border: 1px solid #555;
            border-radius: 5px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            width: 100%;
            box-sizing: border-box;
            background-color: #444;
            color: #eee;
        }
        .form-control:focus {
            outline: none;
            border-color: #ffc107;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }
        .btn-primary, .btn-secondary {
            background-color: #ffc107;
            border: none;
            color: #222;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none;
        }
        .btn-primary:hover, .btn-secondary:hover {
            background-color: #e0b000;
            transform: scale(1.05);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #eee;
            margin-left: 0.5rem;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
        <h2>Edit Barang</h2>

        <form action="update.php" method="POST">
            <input type="hidden" name="action" value="<?php echo $barang['ProdukID']; ?>">

            <div class="form-group">
                <label for="ProdukID"></label>
                <input type="text" name="ProdukID" class="form-control" value="<?php echo $barang['ProdukID']; ?>" required hidden>
            </div>

            <div class="form-group">
                <label for="NamaProduk">Nama Produk:</label>
                <input type="text" name="NamaProduk" class="form-control" value="<?php echo $barang['NamaProduk']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Harga">Harga Produk:</label>
                <input type="number" name="Harga" class="form-control" value="<?php echo $barang['Harga']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Stok">Stok:</label>
                <input type="number" name="Stok" class="form-control" value="<?php echo $barang['Stok']; ?>" required>
            </div>

            <div class="form-group">
                <label for="TanggalMasuk">TanggalMasuk:</label>
                <input type="date" name="TanggalMasuk" class="form-control" value="<?php echo $barang['TanggalMasuk']; ?>" required>
            </div>


            <button type="submit" class="btn btn-primary">Update Barang</button>
            <a href="tampil_produk.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>