<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

if (
    isset($_POST['id']) &&
    isset($_POST['jenis_usulan']) &&
    isset($_POST['kondisi_penerima']) &&
    isset($_POST['manfaat']) &&
    isset($_POST['waktu']) &&
    isset($_POST['biaya'])
) {
    $id = intval($_POST['id']);
    $jenis = $conn->real_escape_string($_POST['jenis_usulan']);
    $kondisi = intval($_POST['kondisi_penerima']);
    $manfaat = intval($_POST['manfaat']);
    $waktu = intval($_POST['waktu']);
    $biaya = intval($_POST['biaya']);

    $query = "UPDATE data_usulan 
              SET jenis_usulan='$jenis', kondisi_penerima=$kondisi, manfaat=$manfaat, 
                  waktu_pengerjaan=$waktu, biaya_pengerjaan=$biaya 
              WHERE id=$id";

    if ($conn->query($query)) {
        header("Location: kmeans.php?update=berhasil");
        exit();
    } else {
        echo "Update gagal: " . $conn->error;
    }
} else {
    echo "Form tidak lengkap.";
}
