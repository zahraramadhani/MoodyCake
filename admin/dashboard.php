<?php
include 'header.php';
include '../db_connect.php';

// Ambil statistik
$totalProducts = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$totalOrders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$totalCategories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];

// Ambil pesanan terbaru
$recentOrders = $conn->query("SELECT o.*, u.name as user_name 
                               FROM orders o
                               JOIN users u ON o.user_id = u.id
                               ORDER BY o.order_date DESC LIMIT 5");

$conn->close();
?>

<div class="content-header">
    <h1>📊 Dashboard</h1>
</div>

<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 32px; border-radius: 16px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
    <h2 style="color: white; font-size: 24px; margin-bottom: 8px;">Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>! 👋</h2>
    <p style="color: rgba(255, 255, 255, 0.9); font-size: 15px; margin: 0;">Kelola seluruh konten MoodyCake dari panel admin ini</p>
</div>

<div class="dashboard-cards">
    <div class="dashboard-card">
        <h2><?php echo $totalProducts; ?></h2>
        <p>🎂 Total Menu</p>
    </div>
    <div class="dashboard-card green">
        <h2><?php echo $totalOrders; ?></h2>
        <p>📦 Total Pesanan</p>
    </div>
    <div class="dashboard-card orange">
        <h2><?php echo $totalUsers; ?></h2>
        <p>👥 Total Pelanggan</p>
    </div>
    <div class="dashboard-card red">
        <h2><?php echo $totalCategories; ?></h2>
        <p>📁 Total Kategori</p>
    </div>
</div>

<div style="background: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-top: 32px;">
    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #0f172a;">📋 Pesanan Terbaru</h3>
    
    <?php if ($recentOrders->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = $recentOrders->fetch_assoc()): ?>
                <tr>
                    <td><strong>#<?php echo $order['id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                    <td><strong><?php echo "Rp " . number_format($order['total_price'], 0, ',', '.'); ?></strong></td>
                    <td>
                        <span style="background: <?php echo ($order['status'] == 'pending' ? '#fef3c7' : '#d1fae5'); ?>; 
                                     color: <?php echo ($order['status'] == 'pending' ? '#92400e' : '#065f46'); ?>; 
                                     padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                    <td>
                        <a href="orders.php?action=view&id=<?php echo $order['id']; ?>" class="btn btn-primary" style="padding: 6px 12px; font-size: 13px;">Lihat</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            <a href="orders.php" class="btn btn-primary">Lihat Semua Pesanan</a>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: #64748b; padding: 40px 0;">Belum ada pesanan masuk</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>