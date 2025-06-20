<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

if (
    isset($_POST['jenis_usulan']) &&
    isset($_POST['kondisi_penerima']) &&
    isset($_POST['manfaat']) &&
    isset($_POST['waktu']) &&
    isset($_POST['biaya'])
) {
    // Ambil input asli
    $jenis = $conn->real_escape_string($_POST['jenis_usulan']);
    $kondisi = $_POST['kondisi_penerima'];
    $manfaat_orang = intval($_POST['manfaat']);
    $waktu_hari = intval($_POST['waktu']);
    $biaya_rupiah = intval($_POST['biaya']);

    // KONVERSI KONDISI
    $nilai_kondisi = match ($kondisi) {
        'Rusak ringan' => 1,
        'Rusak sedang' => 2,
        'Rusak parah' => 3,
        'Belum ada' => 4,
        default => 0
    };

    // KONVERSI MANFAAT
    if ($manfaat_orang <= 300) $nilai_manfaat = 1;
    elseif ($manfaat_orang <= 500) $nilai_manfaat = 2;
    elseif ($manfaat_orang <= 700) $nilai_manfaat = 3;
    else $nilai_manfaat = 4;

    // KONVERSI WAKTU
    if ($waktu_hari <= 30) $nilai_waktu = 3;
    elseif ($waktu_hari <= 60) $nilai_waktu = 2;
    else $nilai_waktu = 1;

    // KONVERSI BIAYA
    $biaya_juta = $biaya_rupiah / 1000000;
    if ($biaya_juta > 80) $nilai_biaya = 1;
    elseif ($biaya_juta <= 20) $nilai_biaya = 2;
    elseif ($biaya_juta <= 40) $nilai_biaya = 3;
    else $nilai_biaya = 4;

    // Simpan ke database
    $query = "INSERT INTO data_usulan (jenis_usulan, kondisi_penerima, manfaat, waktu_pengerjaan, biaya_pengerjaan)
              VALUES ('$jenis', '$nilai_kondisi', $nilai_manfaat, $nilai_waktu, $nilai_biaya)";

    if ($conn->query($query)) {
        header("Location: input.php?success=1");
        exit();
    } else {
        echo "Error saat menyimpan: " . $conn->error;
    }
} else {
    echo "Form tidak lengkap.";
}
