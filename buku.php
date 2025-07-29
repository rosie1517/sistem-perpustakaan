<?php
include 'koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'] ?? '';
    $penulis = $_POST['penulis'] ?? '';
    $penerbit = $_POST['penerbit'] ?? '';
    $tahun = $_POST['tahun'] ?? '';

    // Validasi dasar
    if ($judul && $penulis && $penerbit && is_numeric($tahun)) {
        $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $judul, $penulis, $penerbit, $tahun);

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
    <style>
        /* Gaya konsisten dengan index.php */
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

        h1 {
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
            transition: border-color 0.3s;
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

        .message {
            margin: 10px 0;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
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
    </style>
</head>
<body>

    <h1>Tambah Buku</h1>

    <?php if ($error): ?>
        <p class="message error"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="message success"><?= htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <div class="container">
        <form action="" method="POST">
            <input type="text" name="judul" placeholder="Judul Buku" required>
            <input type="text" name="penulis" placeholder="Penulis" required>
            <input type="text" name="penerbit" placeholder="Penerbit" required>
            <input type="number" name="tahun" placeholder="Tahun Terbit" required min="1000" max="<?= date('Y'); ?>">
            <button type="submit">Simpan</button>
        </form>

        <a href="index.php" class="btn-kembali">← Kembali ke Daftar Buku</a>
    </div>

</body>
</html>
