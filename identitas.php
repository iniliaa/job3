<?php
// Validasi form identitas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $no_telp = filter_input(INPUT_POST, 'no_telp', FILTER_SANITIZE_NUMBER_INT);

    // Validasi Nama
    if (empty($nama)) {
        $errors[] = "Nama harus diisi.";
    }

    // Validasi No. Telp
    if (empty($no_telp)) {
        $errors[] = "Nomor Telepon harus diisi.";
    } elseif (!is_numeric($no_telp)) {
        $errors[] = "Nomor Telepon harus berupa angka.";
    }

    if (empty($errors)) {
        // Simpan data identitas ke dalam session
        session_start();
        $_SESSION['nama'] = $nama;
        $_SESSION['no_telp'] = $no_telp;

        // Redirect ke halaman pembelian_produk.php
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
    <title>Selamat Datang</title>
    <style>
        body {
            background-color: blue;
        }
        .card {
            background-color: white;
            margin: auto;
            width: 300px;
            border-radius: 25px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            padding: 25px;
        }
        h2 {
            text-align: center;
        }
        .tombol {
            width: 200px;
            margin-top: 20px;
            padding: 5px;
            border-radius: 8px;
            background-color: red;
            color: white;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
        }
        input{
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
    <h2>Form Identitas</h2>
    
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <form method="post" action="identitas.php">
        <label for="nama">Nama:</label><br>
        <input type="text" name="nama" required><br>

        <label for="no_telp">Nomor Telepon:</label><br>
        <input type="tel" name="no_telp" required><br>

        <input class="tombol" type="submit" value="Lanjutkan ke Pembelian Produk">
    </form>
    </div>
    
</body>
</html>