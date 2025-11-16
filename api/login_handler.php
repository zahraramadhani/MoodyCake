<?php
header('Content-Type: application/json');
session_start(); // Mulai sesi
include '../db_connect.php'; // Hubungkan ke database

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email dan password wajib diisi.']);
    exit();
}

// Cari user berdasarkan email
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Password benar, simpan info user di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        echo json_encode(['success' => true, 'message' => 'Login berhasil!']);
    } else {
        // Password salah
        echo json_encode(['success' => false, 'message' => 'Email atau password salah.']);
    }
} else {
    // User tidak ditemukan
    echo json_encode(['success' => false, 'message' => 'Email atau password salah.']);
}

$stmt->close();
$conn->close();
?>