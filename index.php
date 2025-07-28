<?php
include 'koneksi.php';

// Ambil data dari tabel buku
$query = "SELECT * FROM riwayat_hapus";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <style>
/* Reset dasar */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background-color: #e8f5e9; /* Warna latar belakang hijau muda */
  text-align: center;
}

.container {
  width: 90%;
  max-width: 1100px;
  background: white;
  margin: 30px auto; /* Margin atas dan bawah untuk jarak */
  padding: 30px; /* Padding lebih besar untuk ruang yang lebih baik */
  border-radius: 15px; /* Sudut lebih bulat */
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Bayangan lebih halus */
  transition: transform 0.3s; /* Efek transformasi saat hover */
}

.container:hover {
  transform: translateY(-5px); /* Efek angkat saat hover */
}

h1 {
  background: #4caf50; /* Warna latar belakang hijau */
  padding: 20px;
  font-size: 2.5em; /* Ukuran font lebih besar */
  color: rgb(255, 255, 255);
  border-radius: 10px; /* Sudut lebih bulat */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Bayangan untuk judul */
  margin-bottom: 20px; /* Jarak bawah untuk pemisahan */
}

/* Tombol */
.btn-tambah, .btn-riwayat {
  display: inline-block;
  padding: 12px 24px;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background 0.3s, transform 0.2s; /* Tambahkan efek transform */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan untuk tombol */
  margin: 10px; /* Jarak antar tombol */
}

.btn-tambah {
  background: #4caf50; /* Warna hijau */
}
.btn-tambah:hover {
  background: #388e3c; /* Warna hijau lebih gelap saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

.btn-riwayat {
  background: #66bb6a; /* Warna hijau muda */
}
.btn-riwayat:hover {
  background: #388e3c; /* Warna hijau lebih gelap saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

/* Tabel */
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
  background: #4caf50; /* Warna hijau untuk header tabel */
  color: white;
  font-weight: bold; /* Tebalkan teks header */
}

tr:nth-child(even) {
  background: #f1f8e9; /* Warna latar belakang baris genap */
}

tr:hover {
  background: #c8e6c9; /* Warna latar belakang saat hover */
}

/* Tombol aksi */
.btn-edit, .btn-hapus {
  display: inline-block;
  padding: 8px 12px;
  margin: 5px; /* Jarak antar tombol aksi */
  color: white;
  text-decoration: none;
  border-radius: 4px;
  font-size: 14px;
  transition: background 0.3s, transform 0.2s; /* Tambahkan efek transform */
}

.btn-edit {
  background: #66bb6a; /* Warna hijau muda */
}
.btn-edit:hover {
  background: #388e3c; /* Warna hijau lebih gelap saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

.btn-hapus {
  background: #e57373; /* Warna merah muda */
}
.btn-hapus:hover {
  background: #c62828; /* Warna merah lebih gelap saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

/* Form Penc arian */
input[type="text"] {
  width: 60%;
  padding: 10px;
  margin: 10px auto; /* Jarak atas dan bawah untuk pemisahan */
  border: 1px solid #ccc;
  border-radius: 5px;
  transition: border-color 0.3s, box-shadow 0.3s; /* Efek transisi border dan bayangan */
}

input[type="text"]:focus {
  border-color: #4caf50; /* Warna border saat fokus */
  outline: none; /* Menghilangkan outline default */
  box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Bayangan saat fokus */
}

button {
  background: #4caf50; /* Warna hijau */
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s, transform 0.2s; /* Tambahkan efek transform */
  margin: 10px; /* Jarak antar tombol */
}

button:hover {
  background: #388e3c; /* Warna hijau lebih gelap saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

@media (max-width: 768px) {
  .container {
    width: 100%;
    padding: 10px;
  }
  input[type="text"] {
    width: 100%;
  }
}
    </style>

</head>
<body>

    <h1>Daftar Buku Perpustakaan</h1>

    <!-- Menampilkan pesan status setelah operasi -->
    <?php if (isset($_GET['status'])): ?>
        <p style="color: <?= ($_GET['status'] == 'success' || $_GET['status'] == 'deleted') ? 'green' : 'red'; ?>;">
            <?= ($_GET['status'] == 'success') ? 'Buku berhasil ditambahkan!' : ($_GET['status'] == 'deleted' ? 'Buku berhasil dihapus!' : 'Gagal menambah buku!'); ?>
        </p>
    <?php endif; ?>

    <div class="container">
        <!-- Form Pencarian Buku -->
        <form method="GET" action="index.php" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Cari Buku..." value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Cari</button>
        </form>

        <a href="buku.php" class="btn-tambah">+ Tambah Buku</a>
        <a href="riwayat_hapus.php" class="btn-riwayat">Lihat Riwayat Hapus</a>
        
        <table>
            <tr>
                <th>ID Buku</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>

            <?php 
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ?";
            $stmt = mysqli_prepare($conn, $query);
            $searchTerm = "%$search%";
            mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0): 
                while ($buku = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?= htmlspecialchars($buku['id']); ?></td>
                <td><?= htmlspecialchars($buku['judul']); ?></td>
                <td><?= htmlspecialchars($buku['penulis']); ?></td>
                <td><?= htmlspecialchars($buku['penerbit']); ?></td>
                <td><?= htmlspecialchars($buku['tahun_terbit']); ?></td>
                <td>
                    <!-- Tombol Edit Buku -->
                    <a href="edit_buku.php?id=<?= $buku['id']; ?>" class="btn-edit">✏️ Edit</a>

                    <!-- Tombol Hapus Buku -->
                    <form action="hapus_buku.php" method="GET" onsubmit="return confirm('Yakin ingin menghapus buku ini?')" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $buku['id']; ?>">
                        <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada data buku.</td>
                </tr>
            <?php endif; ?>

        </table>
    </div>

</body>
</html>
