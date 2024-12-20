<?php
include "koneksi.php";
$connection = mysqli_connect($servername, $username, $password, $database);

// KECAMATAN
if ($_GET["menu"]=='kecamatan' && $_GET["act"]=='simpan') {
    mysqli_query($connection, "INSERT INTO kecamatan (nama, deskripsi, jumlah_desa, jumlah_destinasi) 
                        VALUES ('$_POST[nama]', '$_POST[deskripsi]', '$_POST[jumlah_desa]', '$_POST[jumlah_destinasi]')");
    header('location:index.php?menu=kecamatan');
}

if ($_GET["menu"]=="kecamatan" && $_GET["act"]=='update') {
    mysqli_query($connection, "UPDATE kecamatan SET nama='$_POST[nama]',
                    deskripsi='$_POST[deskripsi]',
                    jumlah_desa='$_POST[jumlah_desa]',
                    jumlah_destinasi='$_POST[jumlah_destinasi]' 
                    WHERE id='$_POST[id]'");
    header('location:index.php?menu=kecamatan');
}

if ($_GET["menu"]=='kecamatan' && $_GET["act"]=='hapus') {
    mysqli_query($connection, "DELETE FROM kecamatan WHERE id='$_GET[id]'");
    header('location:index.php?menu=kecamatan');
}

// DESA
if ($_GET["menu"]=='desa' && $_GET["act"]=='simpan') {
    mysqli_query($connection, "INSERT INTO desa (kecamatan_id, nama, deskripsi) 
                        VALUES ('$_POST[kecamatan_id]', '$_POST[nama]', '$_POST[deskripsi]')");
    header('location:index.php?menu=desa');
}

if ($_GET["menu"]=="desa" && $_GET["act"]=='update') {
    mysqli_query($connection, "UPDATE desa SET kecamatan_id='$_POST[kecamatan_id]',
                    nama='$_POST[nama]', deskripsi='$_POST[deskripsi]' 
                    WHERE id='$_POST[id]'");
    header('location:index.php?menu=desa');
}

if ($_GET["menu"]=='desa' && $_GET["act"]=='hapus') {
    mysqli_query($connection, "DELETE FROM desa WHERE id='$_GET[id]'");
    header('location:index.php?menu=desa');
}

// WISATA
if ($_GET["menu"]=='wisata' && $_GET["act"]=='simpan') {
    $foto = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);
    }
    
    mysqli_query($connection, "INSERT INTO wisata (desa_id, kecamatan_id, nama, deskripsi, alamat, 
                        latitude, longitude, foto, fasilitas, jam_operasional, harga_tiket, kontak) 
                        VALUES ('$_POST[desa_id]', '$_POST[kecamatan_id]', '$_POST[nama]', 
                        '$_POST[deskripsi]', '$_POST[alamat]', '$_POST[latitude]', '$_POST[longitude]',
                        '$foto', '$_POST[fasilitas]', '$_POST[jam_operasional]', 
                        '$_POST[harga_tiket]', '$_POST[kontak]')");
    header('location:index.php?menu=wisata');
}

if ($_GET["menu"]=="wisata" && $_GET["act"]=='ubah') {
    $foto_query = "";
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);
        $foto_query = ", foto='$foto'";
    }
    
    mysqli_query($connection, "UPDATE wisata SET desa_id='$_POST[desa_id]',
                    kecamatan_id='$_POST[kecamatan_id]', nama='$_POST[nama]', 
                    deskripsi='$_POST[deskripsi]', alamat='$_POST[alamat]',
                    latitude='$_POST[latitude]', longitude='$_POST[longitude]',
                    fasilitas='$_POST[fasilitas]', jam_operasional='$_POST[jam_operasional]',
                    harga_tiket='$_POST[harga_tiket]', kontak='$_POST[kontak]'
                    $foto_query WHERE id='$_POST[id]'");
    header('location:index.php?menu=wisata');
}

if ($_GET["menu"]=='wisata' && $_GET["act"]=='hapus') {
    mysqli_query($connection, "DELETE FROM wisata WHERE id='$_GET[id]'");
    header('location:index.php?menu=wisata');
}

// USER
if ($_GET["menu"]=='user' && $_GET["act"]=='simpan') {
    $password = md5($_POST['password']); // Gunakan hash untuk password
    mysqli_query($connection, "INSERT INTO user (user_login, password, nama, level) 
                        VALUES ('$_POST[user_login]', '$password', '$_POST[nama]', '$_POST[level]')");
    header('location:index.php?menu=user');
}

if ($_GET["menu"]=="user" && $_GET["act"]=='update') {
    $password_query = "";
    if(!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $password_query = ", password='$password'";
    }
    
    mysqli_query($connection, "UPDATE user SET user_login='$_POST[user_login]',
                    nama='$_POST[nama]', level='$_POST[level]' $password_query
                    WHERE id='$_POST[id]'");
    header('location:index.php?menu=user');
}

if ($_GET["menu"]=='user' && $_GET["act"]=='hapus') {
    mysqli_query($connection, "DELETE FROM user WHERE id='$_GET[id]'");
    header('location:index.php?menu=user');
}
?>