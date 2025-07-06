CREATE TABLE usulan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis_usulan VARCHAR(100),
    kondisi INT,
    manfaat INT,
    waktu INT,
    biaya INT
);

INSERT INTO usulan (jenis_usulan, kondisi, manfaat, waktu, biaya) VALUES
('Aspal burda Jl. Masjid - Pondok', 3, 3, 40, 93234000),
('Aspal burda Jl. Pondok RW. 02', 3, 2, 60, 150639000),
('Aspal burda Jl. Sido rukun RW. 01', 3, 3, 40, 75504000),
('Penambalan Aspal burda Dsn. Bulu RW. 05', 2, 3, 20, 80128000),
('Aspal burda Dsn. Bulu RW. 08', 3, 2, 18, 17465000);