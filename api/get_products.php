<?php
header('Content-Type: application/json');
include '../db_connect.php'; // Hubungkan ke database

$result = $conn->query("SELECT p.id, p.category_id, c.slug as category_slug, p.name, p.description, p.price, p.image, p.badge_text, p.badge_type 
                       FROM products p
                       JOIN categories c ON p.category_id = c.id
                       ORDER BY p.id ASC");

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Konversi tipe data agar konsisten di JSON
        $row['id'] = (int)$row['id'];
        $row['category_id'] = (int)$row['category_id'];
        $row['price'] = (int)$row['price'];
        $products[] = $row;
    }
}

echo json_encode($products);

$conn->close();
?>