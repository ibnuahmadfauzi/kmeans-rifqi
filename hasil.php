<?php
include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM usulan_program ORDER BY cluster");
?>
<html>

<head>
    <title>Aplikasi K-Means Usulan Program Desa Modangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <table border="1" class="table table-bordered">
                    <tr>
                        <th>Program</th>
                        <th>Kondisi</th>
                        <th>Penerima Manfaat</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Biayan Pengerjaan</th>
                        <th>Keterangan</th>
                        <th>Cluster</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $row['nama_program'] ?></td>
                            <td><?= $row['kondisi'] ?></td>
                            <td><?= $row['penerima_manfaat'] ?></td>
                            <td><?= $row['waktu_pengerjaan'] ?></td>
                            <td><?= $row['biaya_pengerjaan'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                            <td><?= $row['cluster'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>