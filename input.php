<?php include 'koneksi.php'; ?>
<html>

<head>
    <title>Aplikasi K-Means Usulan Program Desa Modangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="row justify-content-center mt-5 container-fluid">
        <div class="col-lg-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <input type="text" class="form-control" name="nama_program" placeholder="Nama Program" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="biaya" placeholder="Biaya" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="manfaat" placeholder="Manfaat (1-10)" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="urgensi" placeholder="Urgensi (1-10)" required>
                </div>
                <div class="mb-3">
                    <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['simpan'])) {
        mysqli_query($koneksi, "INSERT INTO usulan_program (nama_program, biaya, manfaat, urgensi, keterangan)
    VALUES (
        '$_POST[nama_program]',
        '$_POST[biaya]',
        '$_POST[manfaat]',
        '$_POST[urgensi]',
        '$_POST[keterangan]'
    )");
        echo "Data disimpan.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>