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
                <form method="post" action="simpan.php">
                    <div class="mb-3">
                        <label class="form-label" for="jenis_usulan">Jenis Usulan:</label>
                        <input type="text" name="jenis_usulan" class="form-control" id="jenis_usulan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kondisi_penerima">Kondisi Penerima:</label>
                        <select name="kondisi_penerima" class="form-select" id="kondisi_penerima" required>
                            <option value="Rusak ringan">Rusak ringan</option>
                            <option value="Rusak sedang">Rusak sedang</option>
                            <option value="Rusak parah">Rusak parah</option>
                            <option value="Belum ada">Belum ada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="manfaat">Jumlah Penerima Manfaat (orang):</label>
                        <input type="number" name="manfaat" class="form-control" id="manfaat" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="waktu">Waktu Pengerjaan (hari):</label>
                        <input type="number" name="waktu" class="form-control" id="waktu" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="biaya">Biaya Pengerjaan (Rp):</label>
                        <input type="number" name="biaya" class="form-control" id="biaya" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include('partials/script.php'); ?>
</body>

</html>