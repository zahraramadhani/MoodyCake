<?php
header('Content-Type: application/json');
include '../db_connect.php'; // Hubungkan ke database

// Ambil data JSON yang dikirim oleh JavaScript
$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$phone = $data['phone'] ?? '';

if (empty($name) || empty($email) || empty($password) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
    exit();
}

// Cek jika email sudah terdaftar
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar. Silakan login.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Hash password untuk keamanan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Masukkan user baru ke database
$stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed_password, $phone);

if ($stmt->execute()) {
    // Jika sukses, langsung loginkan user
    session_start();
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['user_name'] = $name;
    echo json_encode(['success' => true, 'message' => 'Registrasi berhasil!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
}

$stmt->close();
$conn->close();
?>