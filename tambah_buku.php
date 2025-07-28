<?php
include 'koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'] ?? '';
    $penulis = $_POST['penulis'] ?? '';
    $penerbit = $_POST['penerbit'] ?? '';
    $tahun = $_POST['tahun'] ?? '';
    $jumlah = $_POST['jumlah'] ?? '';

    // Validasi dasar
    if ($judul && $penulis && $penerbit && is_numeric($tahun) && is_numeric($jumlah)) {
        $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, jumlah) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssii", $judul, $penulis, $penerbit, $tahun, $jumlah);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Buku berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan buku: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Query gagal dipersiapkan: " . mysqli_error($conn);
        }
    } else {
        $error = "Semua kolom wajib diisi dan harus valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <h1>Tambah Buku</h1>

    <?php if ($error): ?>
        <p class="error" style="color:red"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success" style="color:green"><?= htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <div class="container">
        <form action="" method="POST">
            <input type="text" name="judul" placeholder="Judul Buku" required>
            <input type="text" name="penulis" placeholder="Penulis" required>
            <input type="text" name="penerbit" placeholder="Penerbit" required>
            <input type="number" name="tahun" placeholder="Tahun Terbit" required min="1000" max="<?= date('Y'); ?>">
            <input type="number" name="jumlah" placeholder="Jumlah Buku" required min="1">
            <button type="submit">Simpan</button>
        </form>
    </div>

</body>
</html>
