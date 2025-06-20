<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('partials/meta.php'); ?>

    <title>About - Aplikasi Kmeans Rifqi</title>
</head>

<body>
    <?php include('partials/navbar.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3">
                <img src="assets/img/foto.jpg" class="img-fluid mt-5">
                <h3 class="text-center mt-4 fw-semibold">
                    MUHAMMAD RIFQI KHOIRUL UMAM
                </h3>
                <h5 class="text-center fw-normal">
                    Teknik Informatika
                </h5>
                <h5 class="text-center fw-normal">
                    Universitas Islam Balitar
                </h5>
            </div>
            <div class="col-lg-9">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="mt-5" style="text-align: justify; text-indent: 50px; line-height: 30px;">
                            <p>
                                Aplikasi <b>Usulan Program Prioritas Anggaran di Desa Modangan</b> dikembangkan untuk menjawab tantangan pemerintah desa dalam menentukan skala prioritas dari berbagai usulan masyarakat yang masuk melalui musyawarah dusun dan musyawarah desa. Proses penyaluran dana desa yang cukup besar di Desa Modangan, yang mencakup lima bidang utama seperti pemerintahan, pembangunan, pembinaan, pemberdayaan, serta penanggulangan darurat, memerlukan sistem pendukung keputusan yang mampu memilah dan memilih program mana yang paling mendesak dan tepat sasaran. Mengingat luas wilayah, jumlah penduduk, serta keragaman usulan dari empat dusun yang ada (Dusun Bulu, Modangan, Karanganyar Barat, dan Karanganyar Timur), maka diperlukan sistem berbasis data untuk menjamin bahwa pengambilan keputusan benar-benar mempertimbangkan urgensi dan pemerataan.
                            </p>
                            <p>
                                Untuk itu, aplikasi ini mengimplementasikan algoritma K-Means Clustering guna mengelompokkan usulan berdasarkan indikator seperti kondisi penerima, jumlah manfaat, waktu pengerjaan, dan estimasi biaya. Penggunaan metode ini memungkinkan pemerintah desa untuk secara objektif mengidentifikasi klaster program dengan tingkat urgensi tertinggi. Dengan hasil klaster yang kemudian dievaluasi melalui Davies-Bouldin Index (DBI), aplikasi ini memberikan dasar yang kuat untuk penentuan program prioritas yang akan dianggarkan melalui APBDes. Harapannya, sistem ini dapat membantu meningkatkan efektivitas penggunaan dana desa secara transparan, adil, dan berbasis kebutuhan nyata masyarakat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('partials/script.php'); ?>
</body>

</html>