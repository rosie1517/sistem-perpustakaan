<?php
include 'koneksi.php';

// Ambil data buku berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM buku WHERE id_buku = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $buku = mysqli_fetch_assoc($result);
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];

    $query = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ? WHERE id_buku = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $judul, $penulis, $penerbit, $tahun, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Gagal memperbarui buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Buku</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $buku['id_buku']; ?>">
        Judul: <input type="text" name="judul" value="<?= $buku['judul']; ?>" required><br>
        Penulis: <input type="text" name="penulis" value="<?= $buku['penulis']; ?>" required><br>
        Penerbit: <input type="text" name="penerbit" value="<?= $buku['penerbit']; ?>" required><br>
        Tahun Terbit: <input type="number" name="tahun" value="<?= $buku['tahun_terbit']; ?>" required><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
