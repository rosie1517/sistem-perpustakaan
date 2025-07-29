<?php
include 'koneksi.php';

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data buku sebelum dihapus (pakai kolom 'id' bukan 'id_buku')
    $query = "SELECT * FROM buku WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $buku = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($buku) {
        // Simpan ke riwayat_hapus (gunakan $buku['id'] sebagai id_buku)
        $insertQuery = "INSERT INTO riwayat_hapus (id_buku, judul, penulis, penerbit, tahun_terbit) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "issss", $buku['id'], $buku['judul'], $buku['penulis'], $buku['penerbit'], $buku['tahun_terbit']);
        
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil disimpan ke riwayat, lanjut hapus
            $deleteQuery = "DELETE FROM buku WHERE id = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?status=deleted");
                exit();
            } else {
                header("Location: index.php?status=delete_failed");
                exit();
            }
        } else {
            header("Location: index.php?status=insert_failed");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: index.php?status=notfound");
        exit();
    }
} else {
    header("Location: index.php?status=invalid");
    exit();
}
?>
