<?php
session_start();
include 'koneksi.php'; // Sekarang koneksi tetap terbuka

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['user_login']);
    $password = md5($_POST['password']); 

    // Query untuk memeriksa data pengguna
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        // Jika login berhasil, simpan data ke sesi
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Tutup koneksi setelah selesai menggunakan
        mysqli_close($connection);
        
        header('Location: index.php');
        exit();
    } else {
        // Jika login gagal
        $_SESSION['error'] = "Username atau password salah!";
        
        // Tutup koneksi setelah selesai menggunakan
        mysqli_close($connection);
        
        header('Location: login.php');
        exit();
    }
} else {
    // Tutup koneksi
    mysqli_close($connection);
    
    header('Location: login.php');
    exit();
}
?>