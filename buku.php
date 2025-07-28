<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan sanitasi data input
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun = intval($_POST['tahun']);

    // Validasi sederhana
    if (!empty($judul) && !empty($penulis) && !empty($penerbit) && $tahun > 0) {
        // Gunakan prepared statement
        $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Binding parameter
        mysqli_stmt_bind_param($stmt, "sssi", $judul, $penulis, $penerbit, $tahun);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=success");
            exit();
        } else {
            $error = "Gagal menambahkan buku!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Semua kolom harus diisi dengan benar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tambah Buku Baru</h1>
    <div class="container">
        <form action="" method="POST">
            <input type="text" name="judul" placeholder="Judul Buku" required>
            <input type="text" name="penulis" placeholder="Penulis" required>
            <input type="text" name="penerbit" placeholder="Penerbit" required>
            <input type="number" name="tahun" placeholder="Tahun Terbit" required min="1000" max="<?= date('Y'); ?>">
            <button type="submit">Simpan</button>
        </form>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <a href="index.php">Kembali</a>
    </div>
</body>
</html>
