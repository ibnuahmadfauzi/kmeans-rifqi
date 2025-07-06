<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

if (
    isset($_POST['id']) &&
    isset($_POST['jenis_usulan']) &&
    isset($_POST['kondisi']) &&
    isset($_POST['manfaat']) &&
    isset($_POST['waktu']) &&
    isset($_POST['biaya'])
) {
    $id = intval($_POST['id']);
    $jenis = $conn->real_escape_string($_POST['jenis_usulan']);
    $kondisi = intval($_POST['kondisi']);
    $manfaat = intval($_POST['manfaat']);
    if ($manfaat <= 300) $nilai_manfaat = 1;
    elseif ($manfaat <= 500) $nilai_manfaat = 2;
    elseif ($manfaat <= 700) $nilai_manfaat = 3;
    else $nilai_manfaat = 4;
    $waktu = intval($_POST['waktu']);
    $biaya = intval($_POST['biaya']);

    $query = "UPDATE usulan 
              SET jenis_usulan='$jenis', kondisi=$kondisi, manfaat=$nilai_manfaat, 
                  waktu=$waktu, biaya=$biaya 
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
