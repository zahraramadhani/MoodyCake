<?php
session_start();
session_unset(); // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi

// Ambil BASE_URL agar bisa redirect dengan benar
include '../db_connect.php';
header("Location: " . BASE_URL); // Arahkan kembali ke halaman utama
exit();
?>