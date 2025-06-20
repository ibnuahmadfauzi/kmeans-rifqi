<form method="post" action="simpan.php">
    <label>Jenis Usulan:</label>
    <input type="text" name="jenis_usulan" required><br>

    <label>Kondisi Penerima:</label>
    <select name="kondisi_penerima" required>
        <option value="Rusak ringan">Rusak ringan</option>
        <option value="Rusak sedang">Rusak sedang</option>
        <option value="Rusak parah">Rusak parah</option>
        <option value="Belum ada">Belum ada</option>
    </select><br>

    <label>Jumlah Penerima Manfaat (orang):</label>
    <input type="number" name="manfaat" required><br>

    <label>Waktu Pengerjaan (hari):</label>
    <input type="number" name="waktu" required><br>

    <label>Biaya Pengerjaan (Rp):</label>
    <input type="number" name="biaya" required><br>

    <button type="submit">Simpan</button>
</form>