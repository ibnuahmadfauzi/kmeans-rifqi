<?php
$koneksi = mysqli_connect("localhost", "root", "", "modangan");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
