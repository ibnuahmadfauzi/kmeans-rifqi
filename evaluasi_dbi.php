<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");

// Ambil data mentah (tanpa klaster)
$data = [];
$result = $conn->query("SELECT manfaat, waktu_pengerjaan, biaya_pengerjaan FROM data_usulan");
while ($row = $result->fetch_assoc()) {
    $data[] = [(float)$row['manfaat'], (float)$row['waktu_pengerjaan'], (float)$row['biaya_pengerjaan']];
}

// Fungsi Euclidean
function euclidean($a, $b)
{
    return sqrt(pow($a[0] - $b[0], 2) + pow($a[1] - $b[1], 2) + pow($a[2] - $b[2], 2));
}

// Fungsi KMeans sederhana
function kmeans($data, $k, $max_iter = 100)
{
    $n = count($data);
    $dim = count($data[0]);
    $centroids = array_slice($data, 0, $k); // inisialisasi centroid awal
    $clusters = [];

    for ($iter = 0; $iter < $max_iter; $iter++) {
        $clusters = array_fill(0, $k, []);

        // Assignment step
        foreach ($data as $point) {
            $min_dist = INF;
            $min_k = 0;
            foreach ($centroids as $i => $centroid) {
                $dist = euclidean($point, $centroid);
                if ($dist < $min_dist) {
                    $min_dist = $dist;
                    $min_k = $i;
                }
            }
            $clusters[$min_k][] = $point;
        }

        // Update step
        $new_centroids = [];
        foreach ($clusters as $cluster) {
            $new = [0, 0, 0];
            $count = count($cluster);
            if ($count > 0) {
                foreach ($cluster as $p) {
                    for ($d = 0; $d < $dim; $d++) {
                        $new[$d] += $p[$d];
                    }
                }
                for ($d = 0; $d < $dim; $d++) {
                    $new[$d] /= $count;
                }
            }
            $new_centroids[] = $new;
        }

        if ($new_centroids === $centroids) break; // jika tidak berubah, selesai
        $centroids = $new_centroids;
    }

    return [$clusters, $centroids];
}

// Hitung DBI untuk hasil klaster
function calculate_dbi($clusters, $centroids)
{
    $S = [];
    foreach ($clusters as $i => $cluster) {
        $sum = 0;
        foreach ($cluster as $point) {
            $sum += euclidean($point, $centroids[$i]);
        }
        $S[$i] = count($cluster) > 0 ? $sum / count($cluster) : 0;
    }

    $R = [];
    foreach ($clusters as $i => $_) {
        $maxRij = -INF;
        foreach ($clusters as $j => $_) {
            if ($i == $j) continue;
            $Mij = max(euclidean($centroids[$i], $centroids[$j]), 0.0001);
            $Rij = ($S[$i] + $S[$j]) / $Mij;
            if ($Rij > $maxRij) $maxRij = $Rij;
        }
        $R[] = $maxRij;
    }

    return count($R) > 0 ? array_sum($R) / count($R) : 0;
}

// Hitung DBI untuk k = 2 sampai 6
$dbi_values = [];
for ($k = 2; $k <= 6; $k++) {
    [$clusters, $centroids] = kmeans($data, $k);
    $dbi = calculate_dbi($clusters, $centroids);
    $dbi_values[$k] = round($dbi, 4);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Grafik DBI vs K</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Evaluasi Davies-Bouldin Index (DBI)</h2>
    <canvas id="dbiChart" width="600" height="300"></canvas>

    <script>
        const ctx = document.getElementById('dbiChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($dbi_values)) ?>,
                datasets: [{
                    label: 'DBI per nilai k',
                    data: <?= json_encode(array_values($dbi_values)) ?>,
                    borderColor: 'blue',
                    fill: false,
                    tension: 0.3,
                    pointBackgroundColor: 'red'
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Jumlah Klaster (k)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'DBI'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>