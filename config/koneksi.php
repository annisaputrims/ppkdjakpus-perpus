<?php
$hostkoneksi ="localhost";
$username_koneksi = "root";
$pasword_koneksi = "";
$databse_koneksi = "perpus";

$koneksi = mysqli_connect ($hostkoneksi, $username_koneksi, $pasword_koneksi, $databse_koneksi);

if (!$koneksi) {
    die("Koneksi database gagal: ". mysqli_connect_error());
}
