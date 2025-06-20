<?php
$conn = new mysqli("localhost", "root", "", "kmeans_app");
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM data_usulan WHERE id = $id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('partials/meta.php'); ?>

    <title>Tambah Data - Aplikasi Kmeans Rifqi</title>
</head>

<body>
    <?php include('partials/navbar.php'); ?>
    <div class="mt-5 container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <form method="post" action="update.php">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label" for="jenis_usulan">Jenis Usulan:</label>
                        <input type="text" name="jenis_usulan" class="form-control" id="jenis_usulan" value="<?= $data['jenis_usulan'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kondisi_penerima">Kondisi Penerima:</label>
                        <select name="kondisi_penerima" class="form-select" id="kondisi_penerima" required>
                            <option value="1" <?= $data['kondisi_penerima'] == 1 ? 'selected' : '' ?>>Rusak ringan</option>
                            <option value="2" <?= $data['kondisi_penerima'] == 2 ? 'selected' : '' ?>>Rusak sedang</option>
                            <option value="3" <?= $data['kondisi_penerima'] == 3 ? 'selected' : '' ?>>Rusak parah</option>
                            <option value="4" <?= $data['kondisi_penerima'] == 4 ? 'selected' : '' ?>>Belum ada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="manfaat">Manfaat (kategori 1-4):</label>
                        <input type="number" name="manfaat" id="manfaat" class="form-control" value="<?= $data['manfaat'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="waktu">Waktu Pengerjaan (kategori 1-3):</label>
                        <input type="number" name="waktu" class="form-control" id="waktu" value="<?= $data['waktu_pengerjaan'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="biaya">Biaya Pengerjaan (kategori 1-4):</label>
                        <input type="number" name="biaya" id="biaya" class="form-control" value="<?= $data['biaya_pengerjaan'] ?>" required><br>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('partials/script.php'); ?>
</body>

</html>