<?php
session_start();

// Mendapatkan data identitas dari session
if (isset($_SESSION['nama']) && isset($_SESSION['no_telp'])) {
    $nama = $_SESSION['nama'];
    $no_telp = $_SESSION['no_telp'];
} else {
    // Redirect ke halaman identitas jika data identitas tidak ditemukan
    header("Location: identitas.php");
    exit();
}

// Inisialisasi harga produk
$harga_produk = array(
    'facewash daviena' => 65000,
    'toner daviena' => 65000,
    'serum gold daviena' => 70000,
    'daycream daviena' => 65000,
    'nightcream daviena' => 65000,
    // Tambahkan harga produk lain jika diperlukan
);

// Inisialisasi harga total
$total_harga = isset($_SESSION['total_harga']) ? $_SESSION['total_harga'] : 0;

// Memproses pembelian produk
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check apakah request untuk mereset total harga
    if (isset($_GET['reset_harga'])) {
        $total_harga = 0;
        $_SESSION['cart'] = array(); // Bersihkan keranjang belanja
        $_SESSION['total_harga'] = 0; // Reset total harga
        // Redirect agar tidak terjadi resubmission saat mereload halaman
        header("Location: pembelian_produk.php");
        exit();
    }

    // Check apakah ada produk yang dipilih
    if (isset($_GET['produk'])) {
        $selected_products = $_GET['produk'];

        // Menghitung total harga berdasarkan produk yang dipilih
        foreach ($selected_products as $produk) {
            if (array_key_exists($produk, $harga_produk)) {
                // Mengambil jumlah produk yang dipilih (default 1 jika tidak diisi)
                $jumlah_produk = isset($GET["jumlah$produk"]) ? intval($GET["jumlah$produk"]) : 1;

                // Menambahkan total harga berdasarkan jumlah produk
                $total_harga += $harga_produk[$produk] * $jumlah_produk;

                // Menambahkan produk ke keranjang belanja sesuai jumlah yang dipilih
                for ($i = 0; $i < $jumlah_produk; $i++) {
                    $_SESSION['cart'][] = $produk;
                }
            }
        }

        // Simpan total harga ke dalam session
        $_SESSION['total_harga'] = $total_harga;

        // Redirect agar tidak terjadi resubmission saat mereload halaman
        header("Location: pembelian_produk.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Produk</title>
    <style>
        body {
            background-color: blue;
        }
        .card {
            margin: auto;
            width: 500px;
            border-radius: 25px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            padding: 25px;
            background-color: white;
        }
        h2 {
            text-align: center;
        }
        .identitas {
            border-radius: 25px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            padding: 10px;
            margin: 10px;
        }
        p:nth-child(1) {
            font-weight: bold;
        }
        .checkout {
            padding: 10px;
            margin: 10px;
        }
        input:nth-child(7) {
            width: 200px;
            margin: 10px;
            padding: 5px;
            border-radius: 8px;
            background-color: red;
            color: white;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
        }
        button {
            width: 200px;
            margin: 10px;
            padding: 5px;
            border-radius: 8px;
            background-color: red;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="card">
    <h2>Pembelian Produk</h2>
    <div class="identitas">
    <p>Identitas Pembeli:</p>
    <p>Nama: <?php echo $nama; ?></p>
    <p>Nomor Telepon: <?php echo $no_telp; ?></p>
    </div>

    <h2>Checkout Barang</h2>   
    <div class="checkout">
    <form method="get" action="pembelian_produk.php">
    <label>
        <input type="checkbox" name="produk[]" value="facewash"> Facewash Daviena - Rp 65.000
        <input type="number" name="jumlah_sepatu" value="1" min="1">
    </label><br>
    <label>
        <input type="checkbox" name="produk[]" value="toner"> Toner Daviena - Rp 65.000
        <input type="number" name="jumlah_baju" value="1" min="1">
    </label><br>
    <label>
        <input type="checkbox" name="produk[]" value="topi"> Serum Gold Daviena - Rp 70.000
        <input type="number" name="jumlah_topi" value="1" min="1">
    </label><br>
    <label>
        <input type="checkbox" name="produk[]" value="daycream"> Daycream Daviena - Rp 65.000
        <input type="number" name="jumlah_topi" value="1" min="1">
    </label><br>
    <label>
        <input type="checkbox" name="produk[]" value="nightcream"> Nightcream Daviena - Rp 65.000
        <input type="number" name="jumlah_topi" value="1" min="1">
    </label><br>
    <!-- Tambahkan checkbox dan input jumlah untuk produk lain jika diperlukan -->

    <input type="submit" value="Tambahkan ke Keranjang">
</form>

    <!-- Tampilkan produk yang ditambahkan ke Keranjang -->
    <?php
    
    if (!empty($_SESSION['cart'])) {
        echo "<p>Produk ditambahkan ke Keranjang:</p>";
        echo "<ul>";
        foreach (array_count_values($_SESSION['cart']) as $item => $count) {
            $harga_tiap_produk = "Rp " . number_format($harga_produk[$item],0,',','.');
            echo "<li>$item - $harga_tiap_produk ( $count produk )</li>";
        }
        echo "</ul>";
    }
    ?>
    
    <!-- Tampilkan total harga -->
    <p>Total Harga: <?php echo "Rp " . number_format($total_harga,0,',','.'); ?></p>

    <!-- Tambahkan tombol reset total harga -->
    <form method="get" action="pembelian_produk.php">
        <input type="hidden" name="reset_harga" value="1">
        <button type="submit" name="reset_harga_btn">Checkout</button>
    </form>

    <!-- Tambahkan tombol kembali ke halaman identitas jika diperlukan -->
    <p><a href="identitas.php">Kembali ke Form Identitas</a></p>
    </div>
    </div>
</body>
</html>