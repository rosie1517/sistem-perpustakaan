<?php
include 'koneksi.php';

// Ambil data dari tabel riwayat_hapus
$query = "SELECT * FROM riwayat_hapus ORDER BY tanggal_hapus DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Buku Dihapus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #e8f5e9;
            text-align: center;
            padding: 40px;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            background: #4caf50;
            color: white;
            padding: 20px;
            font-size: 2em;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f1f8e9;
        }

        tr:hover {
            background-color: #c8e6c9;
        }

        a.btn-kembali {
            display: inline-block;
            margin-top: 20px;
            background: #66bb6a;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
        }

        a.btn-kembali:hover {
            background: #388e3c;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Riwayat Buku yang Dihapus</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>ID Buku</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Tanggal Hapus</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['id_buku']); ?></td>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td><?= htmlspecialchars($row['penulis']); ?></td>
                <td><?= htmlspecialchars($row['penerbit']); ?></td>
                <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                <td><?= htmlspecialchars($row['tanggal_hapus']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>Tidak ada data riwayat penghapusan.</p>
        <?php endif; ?>

        <a href="index.php" class="btn-kembali">← Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
