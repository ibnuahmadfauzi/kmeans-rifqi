<?php
include 'koneksi.php';

function euclidean($a, $b)
{
    return sqrt(pow($a[0] - $b[0], 2) + pow($a[1] - $b[1], 2) + pow($a[2] - $b[2], 2));
}

// Ambil data
$data = [];
$query = mysqli_query($koneksi, "SELECT * FROM usulan_program");
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'id' => $row['id'],
        'data' => [(int)$row['biaya'], (int)$row['manfaat'], (int)$row['urgensi']]
    ];
}

// Tentukan jumlah cluster (K = 3)
$k = 3;
$centroids = array_slice(array_column($data, 'data'), 0, $k);

for ($iter = 0; $iter < 10; $iter++) {
    $clusters = array_fill(0, $k, []);

    foreach ($data as $d) {
        $distances = [];
        foreach ($centroids as $c) {
            $distances[] = euclidean($d['data'], $c);
        }
        $minIndex = array_search(min($distances), $distances);
        $clusters[$minIndex][] = $d;
    }

    for ($i = 0; $i < $k; $i++) {
        if (count($clusters[$i]) == 0) continue;
        $newCentroid = [0, 0, 0];
        foreach ($clusters[$i] as $d) {
            $newCentroid[0] += $d['data'][0];
            $newCentroid[1] += $d['data'][1];
            $newCentroid[2] += $d['data'][2];
        }
        $centroids[$i] = [
            $newCentroid[0] / count($clusters[$i]),
            $newCentroid[1] / count($clusters[$i]),
            $newCentroid[2] / count($clusters[$i])
        ];
    }
}

// Update cluster ke DB
$labels = ['Prioritas Tinggi', 'Prioritas Menengah', 'Prioritas Rendah'];
foreach ($clusters as $index => $cluster) {
    foreach ($cluster as $d) {
        mysqli_query($koneksi, "UPDATE usulan_program SET cluster='$labels[$index]' WHERE id={$d['id']}");
    }
}

echo "Clustering selesai. <a href='hasil.php'>Lihat Hasil</a>";
