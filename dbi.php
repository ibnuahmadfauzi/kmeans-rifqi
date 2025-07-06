<?php
$mysqli = new mysqli("localhost", "root", "", "kmeans_app");

// Ambil data usulan yang sudah diklaster
$data = [];
$result = $mysqli->query("SELECT * FROM usulan");
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Centroid akhir (dari hasil manual atau hasil iterasi sebelumnya)
$centroids = [
    [3, 3, 30, 70000000],
    [3, 2, 50, 100000000],
    [2, 3, 20, 50000000],
    [3, 1, 18, 20000000],
];

// Kelompokkan data berdasarkan cluster
$clusters = [[], [], [], []];
foreach ($data as $row) {
    $fitur = [$row['kondisi'], $row['manfaat'], $row['waktu'], $row['biaya']];
    $jarak_min = PHP_FLOAT_MAX;
    $index = -1;

    // cari centroid terdekat
    foreach ($centroids as $i => $centroid) {
        $d = 0;
        for ($j = 0; $j < count($fitur); $j++) {
            $d += pow($fitur[$j] - $centroid[$j], 2);
        }
        $d = sqrt($d);
        if ($d < $jarak_min) {
            $jarak_min = $d;
            $index = $i;
        }
    }

    $clusters[$index][] = $fitur;
}

// Hitung S_i (rata-rata jarak anggota ke centroid)
function avg_distance_to_centroid($cluster, $centroid)
{
    $total = 0;
    foreach ($cluster as $point) {
        $d = 0;
        for ($i = 0; $i < count($point); $i++) {
            $d += pow($point[$i] - $centroid[$i], 2);
        }
        $total += sqrt($d);
    }
    return count($cluster) > 0 ? $total / count($cluster) : 0;
}

$S = [];
for ($i = 0; $i < count($clusters); $i++) {
    $S[$i] = avg_distance_to_centroid($clusters[$i], $centroids[$i]);
}

// Hitung M_ij (jarak antar centroid)
function centroid_distance($c1, $c2)
{
    $d = 0;
    for ($i = 0; $i < count($c1); $i++) {
        $d += pow($c1[$i] - $c2[$i], 2);
    }
    return sqrt($d);
}

// Hitung DBI
$R = [];
for ($i = 0; $i < count($centroids); $i++) {
    $maxRij = -INF;
    for ($j = 0; $j < count($centroids); $j++) {
        if ($i != $j) {
            $Mij = centroid_distance($centroids[$i], $centroids[$j]);
            if ($Mij != 0) {
                $Rij = ($S[$i] + $S[$j]) / $Mij;
                if ($Rij > $maxRij) {
                    $maxRij = $Rij;
                }
            }
        }
    }
    $R[$i] = $maxRij;
}

$dbi = array_sum($R) / count($R);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('partials/meta.php'); ?>

    <title>Hitung DBI - Aplikasi Kmeans Rifqi</title>
</head>

<body>
    <?php include('partials/navbar.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Perhitungan Davies-Bouldin Index (DBI)</h2>

                        <table>
                            <tr>
                                <th>Cluster</th>
                                <th>S<sub>i</sub> (Rata-rata jarak ke centroid)</th>
                            </tr>
                            <?php foreach ($S as $i => $val): ?>
                                <tr>
                                    <td>Cluster <?= $i + 1 ?></td>
                                    <td><?= number_format($val, 6) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <h3>Hasil DBI: <span style="color:green"><?= number_format($dbi, 6) ?></span></h3>
                        <p>Semakin kecil nilai DBI, semakin baik hasil clustering.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('partials/script.php'); ?>
</body>

</html>