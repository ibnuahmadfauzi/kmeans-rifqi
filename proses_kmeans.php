<?php
include 'koneksi.php';

function euclidean($a, $b)
{
    $sum = 0;
    for ($i = 0; $i < count($a); $i++) {
        $sum += pow($a[$i] - $b[$i], 2);
    }
    return sqrt($sum);
}

// Ambil data dari DB
$query = mysqli_query($koneksi, "SELECT * FROM usulan_program");
if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'id' => $row['id'],
        'data' => [
            $row['kondisi'],
            $row['penerima_manfaat'],
            $row['waktu_pengerjaan'],
            $row['biaya_pengerjaan']
        ]
    ];
}

// Tentukan jumlah cluster
$k = 3;
$centroids = array_slice(array_column($data, 'data'), 0, $k);

// Iterasi K-Means
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

    // Update centroid
    for ($i = 0; $i < $k; $i++) {
        if (count($clusters[$i]) == 0) continue;

        $newCentroid = array_fill(0, 4, 0); // 4 dimensi
        foreach ($clusters[$i] as $d) {
            for ($j = 0; $j < 4; $j++) {
                $newCentroid[$j] += $d['data'][$j];
            }
        }
        for ($j = 0; $j < 4; $j++) {
            $newCentroid[$j] /= count($clusters[$i]);
        }
        $centroids[$i] = $newCentroid;
    }
}

// Simpan hasil cluster ke DB
$labels = ['Prioritas Tinggi', 'Prioritas Menengah', 'Prioritas Rendah'];
foreach ($clusters as $index => $cluster) {
    foreach ($cluster as $d) {
        mysqli_query($koneksi, "UPDATE usulan_program SET cluster='$labels[$index]' WHERE id={$d['id']}");
    }
}

echo "Clustering selesai. <a href='hasil.php'>Lihat Hasil</a>";
