<?php
header('Content-Type: application/json');
session_start();
include '../db_connect.php'; // Hubungkan ke database

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login untuk checkout. Silakan refresh halaman dan login.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'] ?? [];
$total_price = $data['total_price'] ?? 0;
$user_id = $_SESSION['user_id'];

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Keranjang Anda kosong.']);
    exit();
}

// Mulai transaksi database untuk memastikan semua data masuk
$conn->begin_transaction();

try {
    // 1. Simpan data order utama ke tabel `orders`
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("ii", $user_id, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Ambil ID order yang baru saja dibuat
    $stmt->close();

    if ($order_id == 0) {
        throw new Exception("Gagal membuat order.");
    }

    // 2. Siapkan statement untuk memasukkan item-item order
    $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_per_item, additional_price, notes) VALUES (?, ?, ?, ?, ?, ?)");

    // 3. Looping setiap item di keranjang dan masukkan ke tabel `order_items`
    foreach ($cart as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price_per_item = $item['price'];
        $additional_price = $item['additionalPrice'] ?? 0;
        $notes = $item['notes'] ?? '';
        
        $stmt_items->bind_param("iiiiis", $order_id, $product_id, $quantity, $price_per_item, $additional_price, $notes);
        if (!$stmt_items->execute()) {
            // Jika satu item gagal, batalkan semua
            throw new Exception("Gagal menyimpan item: " . $item['name']);
        }
    }
    $stmt_items->close();

    // Jika semua berhasil, commit transaksi
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Pesanan berhasil dibuat!', 'order_id' => $order_id]);

} catch (Exception $e) {
    // Jika ada error, batalkan semua perubahan (rollback)
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Gagal memproses pesanan: ' . $e->getMessage()]);
}

$conn->close();
?>