<?php
// Mengimpor file koneksi.php yang berisi kode untuk koneksi ke database.
session_start();
include("koneksi.php");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Beranda</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c1c1c; /* Latar belakang gelap */
            color: #eee; /* Teks terang */
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333; /* Menghilangkan background header */
            box-shadow: none; /* Menghilangkan box shadow header */
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem; /* Ukuran logo lebih kecil */
            font-weight: bold;
            color: #ffc107; /* Kuning emas untuk logo */
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 0.5rem;
            font-size: 1.6rem; /* Ukuran ikon logo lebih kecil */
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center; /* Agar item vertikal sejajar */
        }

        .nav-link {
            text-decoration: none;
            color: #eee;
            transition: color 0.3s ease, transform 0.2s ease-in-out;
            padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
            margin-left: 0.4rem; /* Jarak antar item navigasi */
            margin-right: 0.4rem; /* Jarak antar item navigasi */
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #ffc107; /* Warna hover emas */
            border-bottom-color: #ffc107;
            transform: translateY(-2px);
        }

        .main-title {
            font-size: 2.2rem; /* Ukuran judul sedikit lebih kecil */
            font-weight: bold;
            color: #eee;
            margin-bottom: 1.2rem;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 0.5rem;
        }

        .welcome-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem; /* Tambahkan margin bawah untuk memisahkan dari konten berikutnya */
        }

        .welcome-text {
            flex: 1 1 50%;
        }

        .img-fluid {
            border-radius: 3px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 40%; /* Ubah agar gambar responsif di dalam kolom */
            height: auto;
        }

        .canon-latest {
            margin-top: 2rem;
            padding: 2rem;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            color: #eee;
        }

        .canon-latest h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #ffff;
            border-bottom: 1px solid #ffff;
            padding-bottom: 0.5rem;
        }

        .canon-latest-content {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
        }

        .canon-latest-image {
            flex: 1 1 40%;
            text-align: center;
        }

        .canon-latest-text {
            flex: 1 1 60%;
        }

        .canon-latest-image img {
            max-width: 50%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.9);
        }
    </style>
</head>
<body>
    <header class="header p-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="#" class="logo">
                <i class="fas fa-camera logo-icon"></i> YURAS KAMERA
            </a>
            <nav class="nav">
                <a class="nav-link" href="tampil_produk.php">PRODUK</a>
                <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
                <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
                <a class="nav-link" href="logout.php">LOGOUT</a>
            </nav>
        </div>
    </header>
    <main class="container my-5">
        <div class="row welcome-row">
        <div class="col-lg-6 welcome-text">
            <h1 class="main-title">Selamat Datang!</h1>
        <div class="divider"></div>
            <p class="lead">Mulai petualangan fotografimu bersama kami.
                            Abadikan setiap momen berharga dalam kualitas terbaik. Temukan kamera impianmu di sini!</p>
        </div>
        </div>

    <section class="canon-latest">
        <h2>Segera Hadir / EOS R1 (Bodi)</h2>
            <div class="canon-latest-content">
                <div class="canon-latest-image">
                    <img src="canon3.png" alt="Segera Hadir">
                </div>
                    <div class="canon-latest-text">
                    <p>Be One With Mastery</p>
                    <p>Memotret melesat hingga 40 fps bersama EOS R1, kamera andalan seri R mirrorless full-frame, dilengkapi dengan Dual Pixel Intelligent AF yang mampu menjaga fokus pada subjek Anda, bagaimana pun situasinya. 
                        Dengan fitur In-camera Upscaling dan Neural Network Noise Reduction, Anda bisa mendapatkan gambar yang jernih dengan resolusi kurang-lebih 96MP, bahkan sewaktu memotret pada ISO102,400.
                    <p><a href="https://id.canon/id/consumer/eos-r1-body/product" class="nav-link" style="margin-top: 1rem; display: inline-block;">Pelajari Lebih Lanjut</a></p>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
