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
            <form method="post">
                <label>Nama Program:</label><br>
                <input type="text" name="nama_program"><br><br>

                <label>Kondisi (1–10):</label><br>
                <input type="number" name="kondisi"><br><br>

                <label>Penerima Manfaat (jumlah orang):</label><br>
                <input type="number" name="penerima_manfaat"><br><br>

                <label>Waktu Pengerjaan (dalam hari):</label><br>
                <input type="number" name="waktu_pengerjaan"><br><br>

                <label>Biaya Pengerjaan (Rp):</label><br>
                <input type="number" name="biaya_pengerjaan"><br><br>

                <label>Keterangan:</label><br>
                <textarea name="keterangan"></textarea><br><br>

                <input type="submit" name="simpan" value="Simpan">
            </form>

        </div>
    </div>

    <?php
    if (isset($_POST['simpan'])) {
        $nama_program = $_POST['nama_program'];
        $kondisi = $_POST['kondisi'];
        $penerima = $_POST['penerima_manfaat'];
        $waktu = $_POST['waktu_pengerjaan'];
        $biaya = $_POST['biaya_pengerjaan'];
        $keterangan = $_POST['keterangan'];

        mysqli_query($koneksi, "INSERT INTO usulan_program 
        (nama_program, kondisi, penerima_manfaat, waktu_pengerjaan, biaya_pengerjaan, keterangan)
        VALUES ('$nama_program', '$kondisi', '$penerima', '$waktu', '$biaya', '$keterangan')");

        echo "Data berhasil disimpan.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>