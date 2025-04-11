<?php
include "koneksi.php";

// Ambil ID barang dari parameter GET (tetap ada karena mungkin digunakan untuk hal lain)
$ProdukID = isset($_GET['PenjualanID']) ? $_GET['PenjualanID'] : null;

// Jika ID barang ada, ambil data barang dari database (tetap ada)
if ($ProdukID) {
    $sql_produk = "SELECT * FROM produk WHERE ProdukID = $ProdukID";
    $result_produk = $koneksi->query($sql_produk);
    $barang = $result_produk->fetch_assoc();
} else {
    $barang = null;
}

// Ambil semua data barang untuk dropdown Produk (tetap ada)
$sql_semua_barang = "SELECT * FROM produk";
$result_semua_barang = $koneksi->query($sql_semua_barang);

// Ambil semua data toko untuk dropdown Nama Toko
$sql_semua_toko = "SELECT TokoID, NamaToko FROM toko";
$result_semua_toko = $koneksi->query($sql_semua_toko);

// Fungsi untuk memformat harga ke Rupiah
function formatRupiah($angka) { 
    $rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $rupiah;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #1c1c1c; /* Latar belakang gelap */
        color: #eee; /* Teks terang */
        margin: 0;
        padding-top: 60px; /* Tambahkan padding-top agar konten tidak tertutup navbar */
    }
    .header {
        background-color: #2e2e2e; /* Header sedikit lebih terang */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed; /* Atur posisi menjadi fixed */
        top: 0;
        left: 0;
        width: 100%; /* Lebar header 100% */
        z-index: 1000; /* Pastikan header berada di atas konten lain */
    }
    .logo {
        font-size: 1.4rem; /* Ukuran logo lebih kecil */
        font-weight: bold;
        color: #ffc107; /* Kuning emas untuk logo */
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    .logo-icon {
        margin-right: 1.3rem;
        margin-left: 5rem;
        font-size: 1.6rem; /* Ukuran ikon logo lebih kecil */
    }
    .nav {
        display: flex;
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
    .container {
        max-width: 800px;
        margin: 80px auto 40px auto; /* Sesuaikan margin atas agar tidak tertutup navbar */
        padding: 2rem;
        border-radius: 8px;
        background-color: #333; /* Warna latar belakang kontainer gelap */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        color: #eee; /* Warna teks dalam kontainer */
    }
    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #eee; /* Warna teks judul */
        border-bottom: 2px solid #ffc107;
        padding-bottom: 0.7rem;
    }
    .form-group label {
        color: #eee; /* Warna teks label */
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
        height: 100%;
        box-sizing: border-box;
        background-color: #444;  /* latar belakang input */
        color: #eee;             /* warna teks input — PASTIKAN INI ADA */
    }

    .form-control:focus {
        outline: none;
        border-color: #ffc107;
        box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
    }
    .btn-primary, .btn-secondary {
        background-color: #ffc107; /* Warna tombol utama emas */
        border: none;
        color: #222; /* Warna teks tombol gelap */
        padding: 0.75rem 1.5rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        margin-top: 1rem;
        display: inline-block;
        text-decoration: none;
    }
    .btn-primary:hover, .btn-secondary:hover {
        background-color: #e0b000; /* Warna tombol saat hover lebih gelap */
        transform: scale(1.05);
    }
    .btn-secondary {
        background-color: #6c757d; /* Warna tombol kembali abu-abu gelap */
        color: #eee;
        margin-left: 0.5rem;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    select.form-control {
        appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="%23eee" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        background-repeat: no-repeat;
        background-position-x: 97%;
        background-position-y: center;
        padding-right: 2.5rem;
        background-color: #444; /* Warna latar belakang select */
        color: #eee; /* Warna teks select */
        border: 1px solid #555; /* Tambahkan border lagi jika hilang */
    }
    select.form-control:focus {
        background-image: url('data:image/svg+xml;utf8,<svg fill="%23ffc107" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        border-color: #ffc107; /* Warna border saat fokus */
    }
    input[readonly], input[disabled] {
        background-color: #444 !important;  /* samakan dengan field biasa */
        color: #eee !important;             /* teks tetap terang */
        opacity: 1 !important;              /* kadang default opacity jadi 0.5 */
    }
    select.form-control {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
</head>
<body>
<header class="header">
    <a href="index.php" class="logo">
        <i class="fas fa-camera logo-icon"></i> YURAS KAMERA
    </a>
    <nav class="nav">
        <a class="nav-link" href="tampil_produk.php">PRODUK</a>
        <a class="nav-link" href="data_penjualan.php">PENJUALAN</a>
        <a class="nav-link" href="detail_penjualan.php">DETAIL PENJUALAN</a>
        <a class="nav-link" href="logout.php">LOGOUT</a>
    </nav>
</header>
<div class="container mt-5">
    <h2>Tambah Data Penjualan</h2>
    <form action="update_penjualan.php" method="POST">
        <div class="form-group">
            <label for="ProdukID">Nama Produk :</label>
            <select name="ProdukID" id="ProdukID" class="form-control" required onchange="updateHarga()">
                <option value="">Pilih Produk</option>
                <?php while ($semua_barang = $result_semua_barang->fetch_assoc()): ?>
                    <option value="<?= $semua_barang['ProdukID'] ?>" title="<?= htmlspecialchars($semua_barang['NamaProduk']) ?>"
                        <?= ($barang && $barang['ProdukID'] == $semua_barang['ProdukID']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($semua_barang['NamaProduk']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
<div class="form-group">
    <label for="Harga">Harga Produk :</label>
        <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
</div>
     <input type="text" id="Harga" name="Harga" class="form-control" value="<?= $barang ? formatRupiah($barang['Harga']) : '' ?>" required readonly>
    </div>
    </div>    
        <div class="form-group">
            <label for="Stok">Jumlah Produk :</label>
            <input type="number" id="Stok" name="Stok" class="form-control" oninput="validasiStok()">
        </div>

        <div class="form-group">
            <label for="Subtotal">Subtotal :</label>
            <input type="text" id="Subtotal" name="Subtotal" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="TanggalPenjualan">Tanggal Penjualan :</label>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" class="form-control" value="<?= $penjualan ? $penjualan['TanggalPenjualan'] : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="TokoID">Nama Toko :</label>
            <select name="TokoID" id="TokoID" class="form-control" required>
                <option value="">Pilih Toko</option>
                <?php while ($semua_toko = $result_semua_toko->fetch_assoc()): ?>
                    <option value="<?= $semua_toko['TokoID'] ?>" title="<?= htmlspecialchars($semua_toko['NamaToko']) ?>">
                        <?= htmlspecialchars($semua_toko['NamaToko']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Data</button>
        <a href="data_penjualan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    function updateHarga() {
        var produkID = document.getElementById("ProdukID").value;
        <?php
        $produk_harga = array();
        $result_harga = $koneksi->query("SELECT ProdukID, Harga FROM produk");
        while ($row = $result_harga->fetch_assoc()) {
            $produk_harga[$row['ProdukID']] = $row['Harga'];
        }
        echo "var hargaProduk = " . json_encode($produk_harga) . ";";
        ?>
        document.getElementById("Harga").value = hargaProduk[produkID] || '';
        validasiStok();
    }

    function validasiStok() {
        var produkID = document.getElementById("ProdukID").value;
        var stokInput = document.getElementById("Stok");
        var stokPenjualan = parseInt(stokInput.value) || 0;
        <?php
        $produk_stok = array();
        $result_stok = $koneksi->query("SELECT ProdukID, Stok FROM produk");
        while ($row = $result_stok->fetch_assoc()) {
            $produk_stok[$row['ProdukID']] = $row['Stok'];
        }
        echo "var stokProduk = " . json_encode($produk_stok) . ";";
        ?>
        var stokTersedia = parseInt(stokProduk[produkID]) || 0;

        if (stokPenjualan > stokTersedia) {
            alert("Stok tidak mencukupi. Stok tersedia: " + stokTersedia);
            stokInput.value = stokTersedia;
        }
        hitungSubtotal();
    }

    function hitungSubtotal() {
        var harga = document.getElementById("Harga").value;
        var stok = document.getElementById("Stok").value;
        var subtotal = harga * stok;
        document.getElementById("Subtotal").value = subtotal || '';
    }
    
</script>
</body>
</html>
