<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

// Ambil data (manfaat, waktu, biaya, dan cluster)
$result = $conn->query("SELECT manfaat, waktu_pengerjaan, biaya_pengerjaan, cluster FROM data_usulan");

$data = [];
foreach ($result as $row) {
    $cluster = $row['cluster'];
    $point = [$row['manfaat'], $row['waktu_pengerjaan'], $row['biaya_pengerjaan']];
    $data[$cluster][] = $point;
}

// Hitung centroid masing-masing cluster
$centroids = [];
foreach ($data as $cluster => $points) {
    $n = count($points);
    $sum = [0, 0, 0];
    foreach ($points as $p) {
        $sum[0] += $p[0];
        $sum[1] += $p[1];
        $sum[2] += $p[2];
    }
    $centroids[$cluster] = [$sum[0] / $n, $sum[1] / $n, $sum[2] / $n];
}

// Fungsi jarak Euclidean
function euclidean($a, $b)
{
    return sqrt(
        pow($a[0] - $b[0], 2) +
            pow($a[1] - $b[1], 2) +
            pow($a[2] - $b[2], 2)
    );
}

// Hitung S_i: rata-rata jarak tiap titik dalam klaster ke centroid-nya
$S = [];
foreach ($data as $cluster => $points) {
    $sum_dist = 0;
    foreach ($points as $p) {
        $sum_dist += euclidean($p, $centroids[$cluster]);
    }
    $S[$cluster] = $sum_dist / count($points);
}

// Hitung R_ij untuk setiap i ≠ j
$R = [];
foreach ($data as $i => $_) {
    $max_Rij = -INF;
    foreach ($data as $j => $_) {
        if ($i == $j) continue;

        $Mij = euclidean($centroids[$i], $centroids[$j]); // Jarak antar centroid
        if ($Mij == 0) continue; // hindari pembagian nol
        $Rij = ($S[$i] + $S[$j]) / $Mij;

        if ($Rij > $max_Rij) {
            $max_Rij = $Rij;
        }
    }
    $R[] = $max_Rij;
}

// Hitung nilai DBI
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

    <div class="container">
        <h3 class="text-center mt-5">Nilai Davies-Bouldin Index (DBI): <br> <span style='color:blue;'><?php echo $dbi; ?></span></h3>
    </div>

    <?php include('partials/script.php'); ?>
</body>

</html>