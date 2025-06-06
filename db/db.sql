CREATE DATABASE IF NOT EXISTS modangan;
USE modangan;

CREATE TABLE usulan_program (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_program VARCHAR(255),
  kondisi INT,
  penerima_manfaat INT,
  waktu_pengerjaan INT,
  biaya_pengerjaan INT,
  keterangan TEXT,
  cluster VARCHAR(50)
);
