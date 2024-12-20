<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED); 
ini_set('display_errors', 0); 
include "koneksi.php";
$conn = mysqli_connect($servername, $username, $password, $database);
$login = $_SESSION['login'];

if ($login <> 1) {
    include "login.php";
    exit;
}
echo "<body style='background-color:#E0E6E6'>";

echo "<table border=1>
      <tr>
          <td><a href=index.php?menu=>Home</a></td>
          <td><a href=index.php?menu=kecamatan>Kecamatan</a></td>
          <td><a href=index.php?menu=desa>Desa</a></td>
          <td><a href=index.php?menu=wisata>Wisata</a></td>
          <td><a href=index.php?menu=user>User</a></td>
          <td><a href=logout.php>Logout</a></td>
      </tr>
      </table>";

if (empty($_GET['menu'])) {
    echo "ini halaman Home/Beranda";
}

if ($_GET['menu'] == 'kecamatan') {
    include "data/kecamatan.php"; // Halaman untuk mengelola Kecamatan
}

if ($_GET['menu'] == 'desa') {
    include "data/desa.php"; // Halaman untuk mengelola Desa
}

if ($_GET['menu'] == 'wisata') {
    include "data/wisata.php"; // Halaman untuk mengelola Wisata
}

if ($_GET['menu'] == 'user') {
    include "data/user.php"; // Halaman untuk mengelola User
}

?>
