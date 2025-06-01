CREATE DATABASE IF NOT EXISTS modangan;
USE modangan;

CREATE TABLE usulan_program (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_program VARCHAR(255),
  biaya INT,
  manfaat INT,
  urgensi INT,
  keterangan TEXT,
  cluster VARCHAR(50)
);
