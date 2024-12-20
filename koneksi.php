<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "wisata_pku";
$connection = mysqli_connect($servername, $username, $password, $database);
// mengecek koneksi
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}