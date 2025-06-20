CREATE DATABASE kmeans_app;

USE kmeans_app;

CREATE TABLE data_usulan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jenis_usulan VARCHAR(100),
  kondisi_penerima VARCHAR(100),
  manfaat FLOAT,
  waktu_pengerjaan FLOAT,
  biaya_pengerjaan FLOAT,
  cluster INT DEFAULT NULL
);
