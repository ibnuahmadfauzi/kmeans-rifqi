<a href="dbi.php">Lihat Evaluasi DBI</a>

<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

// Ambil data
$result = $conn->query("SELECT id, manfaat, waktu_pengerjaan, biaya_pengerjaan FROM data_usulan");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['id']] = [$row['manfaat'], $row['waktu_pengerjaan'], $row['biaya_pengerjaan']];
}

$k = 3; // jumlah cluster
$max_iter = 100;

// Inisialisasi centroid secara acak
$centroids = array_values(array_slice($data, 0, $k));

for ($iter = 0; $iter < $max_iter; $iter++) {
    $clusters = [];

    // Pengelompokan
    foreach ($data as $id => $features) {
        $min_dist = INF;
        $cluster_id = 0;
        foreach ($centroids as $i => $centroid) {
            $dist = sqrt(
                pow($features[0] - $centroid[0], 2) +
                    pow($features[1] - $centroid[1], 2) +
                    pow($features[2] - $centroid[2], 2)
            );
            if ($dist < $min_dist) {
                $min_dist = $dist;
                $cluster_id = $i;
            }
        }
        $clusters[$cluster_id][] = $features;
        $data_cluster[$id] = $cluster_id;
    }

    // Update centroid
    $new_centroids = [];
    foreach ($clusters as $cluster) {
        $mean = [0, 0, 0];
        foreach ($cluster as $point) {
            $mean[0] += $point[0];
            $mean[1] += $point[1];
            $mean[2] += $point[2];
        }
        $count = count($cluster);
        $new_centroids[] = [$mean[0] / $count, $mean[1] / $count, $mean[2] / $count];
    }

    if ($new_centroids == $centroids) break;
    $centroids = $new_centroids;
}

// Simpan cluster ke database
foreach ($data_cluster as $id => $cluster) {
    $conn->query("UPDATE data_usulan SET cluster = $cluster WHERE id = $id");
}

// Tampilkan hasil
$result = $conn->query("SELECT * FROM data_usulan");
echo "<table border=1>
<tr><th>ID</th><th>Jenis Usulan</th><th>Kondisi</th><th>Manfaat</th><th>Waktu</th><th>Biaya</th><th>Cluster</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['jenis_usulan']}</td>
    <td>{$row['kondisi_penerima']}</td>
    <td>{$row['manfaat']}</td>
    <td>{$row['waktu_pengerjaan']}</td>
    <td>{$row['biaya_pengerjaan']}</td>
    <td>{$row['cluster']}</td>
    </tr>";
}
echo "</table>";
