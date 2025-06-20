<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "kmeans_app");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada ID yang dikirim dari form
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // pastikan ID adalah angka bulat

    // Eksekusi query hapus
    $query = "DELETE FROM data_usulan WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        // Berhasil dihapus, arahkan kembali ke halaman sebelumnya
        header("Location: kmeans.php?hapus=berhasil");
        exit();
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}

$conn->close();
