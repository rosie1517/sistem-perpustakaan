<?php
include 'koneksi.php';

// Ambil data dari tabel riwayat_hapus
$query = "SELECT * FROM riwayat_hapus";  // Pastikan ini mengakses tabel yang benar
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Buku Dihapus</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <h2>Riwayat Buku yang Dihapus</h2>

    <table>
        <tr>
            <th>ID Buku</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Tanggal Hapus</th> <!-- Menambahkan kolom tanggal_hapus -->
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['id_buku']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['penulis']; ?></td>
            <td><?php echo $row['penerbit']; ?></td>
            <td><?php echo $row['tahun_terbit']; ?></td>
            <td><?php echo $row['tanggal_hapus']; ?></td> <!-- Menampilkan tanggal_hapus -->
        </tr>
        <?php endwhile; ?>

    </table>

    <br>
    <a href="index.php">Kembali ke Halaman Utama</a>

</body>
</html>