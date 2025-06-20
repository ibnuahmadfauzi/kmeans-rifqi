<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('partials/meta.php'); ?>

    <title>Hitung Kmeans - Aplikasi Kmeans Rifqi</title>
</head>

<body>
    <?php include('partials/navbar.php'); ?>


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
    if (isset($data_cluster)) {
        foreach ($data_cluster as $id => $cluster) {
            $conn->query("UPDATE data_usulan SET cluster = $cluster WHERE id = $id");
        }
    }

    // Tampilkan hasil
    $result = $conn->query("SELECT * FROM data_usulan");
    ?>

    <div class="container">

        <div class="card mt-5">
            <div class="card-body">
                <a href="input.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Alternatif Baru</a>
                <?php if (isset($_GET['hapus']) && $_GET['hapus'] == 'berhasil'): ?>
                    <div class="alert alert-success text-center my-3">Data berhasil dihapus!</div>
                <?php endif; ?>

                <?php if (isset($_GET['update']) && $_GET['update'] == 'berhasil'): ?>
                    <div class="alert alert-success text-center my-3">Data berhasil diperbarui!</div>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success text-center my-3">Data berhasil ditambahkan!</div>
                <?php endif; ?>

                <div class="border my-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Jenis Usulan</td>
                                <td>Kondisi</td>
                                <td>Manfaat</td>
                                <td>Waktu</td>
                                <td>Biaya</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['jenis_usulan']; ?></td>
                                    <td><?php echo $row['kondisi_penerima']; ?></td>
                                    <td><?php echo $row['manfaat']; ?></td>
                                    <td><?php echo $row['waktu_pengerjaan']; ?></td>
                                    <td><?php echo $row['biaya_pengerjaan']; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning text-light">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal" data-id=<?php echo $row['id']; ?>>
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-secondary float-end" data-bs-toggle="modal" data-bs-target="#detailCluster"><i class="fa-solid fa-check"></i> Hitung K-Means</button>
            </div>

        </div>

    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailCluster" tabindex="-1" aria-labelledby="detailClusterLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $result = $conn->query("SELECT * FROM data_usulan");

                    // Tentukan label prioritas untuk setiap cluster
                    $prioritas_label = [
                        0 => 'Prioritas Rendah',
                        1 => 'Prioritas Sedang',
                        2 => 'Prioritas Tinggi'
                    ];
                    ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jenis Usulan</th>
                                <th>Cluster</th>
                                <th>Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                $cluster = $row['cluster'];
                                $prioritas = isset($prioritas_label[$cluster]) ? $prioritas_label[$cluster] : 'Tidak Diketahui';
                            ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= $row['jenis_usulan'] ?></td>
                                    <td><?= $cluster ?></td>
                                    <td><strong><?= $prioritas ?></strong></td>
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="hapus.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h3 class="mb-3">Yakin Hapus Data?</h3>
                        <input type="hidden" name="id" id="hapus-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php include('partials/script.php'); ?>
    <script>
        const hapusModal = document.getElementById('hapusModal');
        hapusModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang diklik
            const id = button.getAttribute('data-id'); // Ambil data-id
            const inputId = hapusModal.querySelector('#hapus-id'); // input hidden
            inputId.value = id; // Masukkan ke input
        });
    </script>
</body>

</html>