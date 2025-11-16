<?php
// Panggil auth_check untuk melindungi halaman ini
include 'auth_check.php';
// Ambil nama halaman saat ini
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MoodyCake</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>MoodyCake</h2>
            <nav>
                <ul>
                    <li>
                        <a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                            📊 Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="products.php" class="<?php echo ($currentPage == 'products.php') ? 'active' : ''; ?>">
                            🎂 Manajemen Menu
                        </a>
                    </li>
                    <li>
                        <a href="categories.php" class="<?php echo ($currentPage == 'categories.php') ? 'active' : ''; ?>">
                            📁 Manajemen Kategori
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" class="<?php echo ($currentPage == 'orders.php') ? 'active' : ''; ?>">
                            📦 Lihat Pesanan
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php">🚪 Logout</a>
            </div>
        </aside>
        <main class="main-content">