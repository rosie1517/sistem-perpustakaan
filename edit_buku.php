<?php
include 'koneksi.php';

$buku = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM buku WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $buku = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$buku) {
        echo "Data buku tidak ditemukan.";
        exit;
    }
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];

    $query = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ? WHERE id = ?";
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
    <meta charset="UTF-8">
    <title>Edit Buku</title>
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
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            background: #4caf50;
            padding: 20px;
            font-size: 2em;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #4caf50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        button[type="submit"] {
            background: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background: #388e3c;
            transform: scale(1.05);
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

        .notfound {
            font-size: 1.2em;
            color: red;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <?php if ($buku): ?>
    <h2>Edit Buku</h2>
    <div class="container">
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($buku['id']); ?>">
            <input type="text" name="judul" value="<?= htmlspecialchars($buku['judul']); ?>" placeholder="Judul Buku" required>
            <input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']); ?>" placeholder="Penulis" required>
            <input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']); ?>" placeholder="Penerbit" required>
            <input type="number" name="tahun" value="<?= htmlspecialchars($buku['tahun_terbit']); ?>" placeholder="Tahun Terbit" required>
            <button type="submit">Simpan</button>
        </form>
        <a href="index.php" class="btn-kembali">← Kembali ke Daftar Buku</a>
    </div>
    <?php else: ?>
        <p class="notfound">Data tidak ditemukan atau ID tidak valid.</p>
    <?php endif; ?>

</body>
</html>
