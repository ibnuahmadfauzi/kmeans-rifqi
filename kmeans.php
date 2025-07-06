<?php
$mysqli = new mysqli("localhost", "root", "", "kmeans_app");

// Ambil data usulan
$usulan = [];
$result = $mysqli->query("SELECT * FROM usulan");
while ($row = $result->fetch_assoc()) {
    $usulan[] = $row;
}

// Centroid awal (4 cluster × 4 fitur: kondisi, manfaat, waktu, biaya)
$centroids = [
    [3, 3, 30, 70000000],
    [3, 2, 50, 100000000],
    [2, 3, 20, 50000000],
    [3, 1, 18, 20000000],
];

// Fungsi Euclidean Distance
function euclidean_distance($data, $centroid)
{
    $sum = 0;
    for ($i = 0; $i < count($data); $i++) {
        $sum += pow($data[$i] - $centroid[$i], 2);
    }
    return sqrt($sum);
}

// Proses clustering
$hasilCluster = [];
foreach ($usulan as $row) {
    $data = [$row['kondisi'], $row['manfaat'], $row['waktu'], $row['biaya']];
    $distances = [];
    foreach ($centroids as $centroid) {
        $distances[] = euclidean_distance($data, $centroid);
    }
    $minIndex = array_search(min($distances), $distances);
    $row['distances'] = $distances;
    $row['cluster'] = $minIndex + 1;
    $hasilCluster[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('partials/meta.php'); ?>

    <title>Hitung Kmeans - Aplikasi Kmeans Rifqi</title>
</head>

<body>
    <?php include('partials/navbar.php'); ?>

    <div class="container">
        <h3 class="mt-5">Centroid Awal</h3>
        <a href="input.php" class="btn btn-sm btn-primary text-light mb-3">Tambah Cluster</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Cluster</th>
                    <th>Kondisi</th>
                    <th>Manfaat</th>
                    <th>Waktu</th>
                    <th>Biaya</th>
                </tr>
                <?php foreach ($centroids as $index => $c): ?>
                    <tr>
                        <td>Cluster<?= $index + 1 ?></td>
                        <td><?= implode("</td><td>", $c) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <h3 class="mt-5">Hasil Cluster</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Jenis Usulan</th>
                    <th>Kondisi</th>
                    <th>Manfaat</th>
                    <th>Waktu</th>
                    <th>Biaya</th>
                    <?php for ($i = 1; $i <= count($centroids); $i++): ?>
                        <th>Cluster <?= $i ?></th>
                    <?php endfor; ?>
                    <th>Cluster</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($hasilCluster as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['jenis_usulan'] ?></td>
                        <td><?= $row['kondisi'] ?></td>
                        <td><?= $row['manfaat'] ?></td>
                        <td><?= $row['waktu'] ?></td>
                        <td><?= number_format($row['biaya']) ?></td>
                        <?php foreach ($row['distances'] as $d): ?>
                            <td><?= number_format($d, 6) ?></td>
                        <?php endforeach; ?>
                        <td>Cluster-<?= $row['cluster'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning text-light">Edit</a>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger text-light">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>


    <?php include('partials/script.php'); ?>
</body>

</html>