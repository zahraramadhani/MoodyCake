<?php
// Pengaturan koneksi database
$host = 'localhost';
$username = 'root'; // Default username untuk XAMPP
$password = '';     // Default password untuk XAMPP
$database = 'moodycake_db'; // Nama database yang Anda buat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Set URL dasar untuk proyek Anda.
// Sesuaikan 'moodycake' jika nama folder Anda berbeda.
define('BASE_URL', 'http://localhost/moodycake/');
?>