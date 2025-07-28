<?php
include 'koneksi.php';

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data buku sebelum dihapus
    $query = "SELECT * FROM buku WHERE id_buku = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $buku = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($buku) {
        // Simpan ke riwayat_hapus
        $insertQuery = "INSERT INTO riwayat_hapus (id_buku, judul, penulis, penerbit, tahun_terbit) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "issss", $buku['id_buku'], $buku['judul'], $buku['penulis'], $buku['penerbit'], $buku['tahun_terbit']);
        
        if (mysqli_stmt_execute($stmt)) {
            // Jika data berhasil dimasukkan ke riwayat_hapus, lanjutkan menghapus buku
            $deleteQuery = "DELETE FROM buku WHERE id_buku = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                // Buku berhasil dihapus
                header("Location: index.php?status=deleted");
                exit();
            } else {
                // Jika gagal menghapus buku
                header("Location: index.php?status=delete_failed");
                exit();
            }
        } else {
            // Jika gagal menyimpan ke riwayat_hapus
            header("Location: index.php?status=insert_failed");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Jika buku tidak ditemukan
        header("Location: index.php?status=notfound");
        exit();
    }
} else {
    // Jika ID tidak valid
    header("Location: index.php?status=invalid");
    exit();
}
?>