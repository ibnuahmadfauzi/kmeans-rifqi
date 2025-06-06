<?php
include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM usulan_program ORDER BY cluster");
?>
<html>

<!DOCTYPE html>
<html>

<head>
    <title>Aplikasi K-Means Usulan Program Desa Modangan</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Memanggil file Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">

    <!-- Memanggi file FontAwesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
</head>

<body>

    <?php
    require('topbar.php');
    ?>

    <div class="container">
        <div class="card mt-5">
            <div class="card-body p-4">
                <a href="kmean-editor.php" class="btn btn-secondary">+ Alternatif Baru</a>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th class="text-center">Jenis Usulan</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Penerima Manfaat</th>
                            <th class="text-center">Waktu Pengerjaan</th>
                            <th class="text-center">Biaya Pengerjaan</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="text-center"><?= $count; ?></td>
                                <td><?= $row['nama_program'] ?></td>
                                <td style="width: 100px;"><?= $row['kondisi'] ?></td>
                                <td style="width: 100px;"><?= $row['penerima_manfaat'] ?></td>
                                <td style="width: 100px;"><?= $row['waktu_pengerjaan'] ?></td>
                                <td style="width: 100px;"><?= $row['biaya_pengerjaan'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning text-light">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger text-light">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr><?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <?php endwhile; ?>
                            <?php $count++; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <a href="#" class="btn btn-primary">Hitung K-Means</a>
                </div>
            </div>
        </div>
    </div>

    <!-- <h2 class="text-center">Aplikasi K-Means Clustering</h2>
    <h3 class="text-center">Pemilihan Usulan Program Prioritas Anggaran<br>Desa Modangan</h3>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <ul class="list-group">
                <li class="list-group-item text-center"><a class="text-decoration-none" href="input.php">Input Data Usulan Program</a></li>
                <li class="list-group-item text-center"><a class="text-decoration-none" href="proses_kmeans.php">Proses Clustering (K-Means)</a></li>
                <li class="list-group-item text-center"><a class="text-decoration-none" href="hasil.php">Lihat Hasil Clustering</a></li>
            </ul>
        </div>
    </div> -->

    <!-- Memanggil file Bootstrap -->
    <script src="assets/bootstrap/js/bootstrap.js"></script>

    <!-- Memanggil file FontAwesome -->
    <script src="assets/fontawesome/js/all.js"></script>
</body>

</html>