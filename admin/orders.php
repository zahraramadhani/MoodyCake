<?php
include 'header.php';
include '../db_connect.php';

// Ambil semua order
$sql = "SELECT o.*, u.name as user_name, u.email as user_email, u.phone as user_phone 
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC";
$orders = $conn->query($sql);
?>

<div class="content-header">
    <h1>📦 Pesanan Masuk</h1>
    <div style="display: flex; gap: 12px; align-items: center;">
        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
            <?php echo $orders->num_rows; ?> Total Pesanan
        </span>
    </div>
</div>

<div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
    <?php if ($orders->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 100px;">ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Kontak</th>
                    <th style="width: 140px;">Total Harga</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 100px;">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong style="color: #3b82f6; font-size: 15px;">#<?php echo $order['id']; ?></strong>
                    </td>
                    <td>
                        <div style="font-size: 14px;"><?php echo date('d M Y', strtotime($order['order_date'])); ?></div>
                        <div style="font-size: 12px; color: #64748b;"><?php echo date('H:i', strtotime($order['order_date'])); ?> WIB</div>
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($order['user_name']); ?></strong>
                    </td>
                    <td>
                        <div style="font-size: 13px; color: #64748b;">
                            📧 <?php echo htmlspecialchars($order['user_email']); ?>
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            📱 <?php echo htmlspecialchars($order['user_phone']); ?>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #10b981; font-size: 15px;">
                            <?php echo "Rp " . number_format($order['total_price'], 0, ',', '.'); ?>
                        </strong>
                    </td>
                    <td>
                        <?php
                        $statusColors = [
                            'pending' => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => '⏳'],
                            'processing' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'icon' => '⚙️'],
                            'completed' => ['bg' => '#d1fae5', 'text' => '#065f46', 'icon' => '✅'],
                            'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => '❌']
                        ];
                        $status = $order['status'];
                        $color = $statusColors[$status] ?? $statusColors['pending'];
                        ?>
                        <span style="background: <?php echo $color['bg']; ?>; 
                                     color: <?php echo $color['text']; ?>; 
                                     padding: 6px 12px; 
                                     border-radius: 20px; 
                                     font-size: 12px; 
                                     font-weight: 600;
                                     display: inline-block;">
                            <?php echo $color['icon'] . ' ' . ucfirst(htmlspecialchars($status)); ?>
                        </span>
                    </td>
                    <td>
                        <a href="orders.php?action=view&id=<?php echo $order['id']; ?>" 
                           class="btn btn-primary" 
                           style="padding: 8px 14px; font-size: 13px; width: 100%;">
                            👁️ Lihat
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 48px; margin-bottom: 16px;">📦</div>
            <h3 style="color: #64748b; margin-bottom: 8px;">Belum Ada Pesanan</h3>
            <p style="color: #94a3b8; font-size: 14px;">Pesanan dari pelanggan akan muncul di sini</p>
        </div>
    <?php endif; ?>
</div>

<?php
// Tampilkan Detail Item jika ada ID di URL
if (isset($_GET['action']) && $_GET['action'] == 'view' && isset($_GET['id'])):
    $order_id = $_GET['id'];
    
    // Ambil info order
    $order_info_sql = "SELECT o.*, u.name as user_name, u.email as user_email, u.phone as user_phone 
                       FROM orders o
                       JOIN users u ON o.user_id = u.id
                       WHERE o.id = ?";
    $stmt_info = $conn->prepare($order_info_sql);
    $stmt_info->bind_param("i", $order_id);
    $stmt_info->execute();
    $order_info = $stmt_info->get_result()->fetch_assoc();
    $stmt_info->close();
    
    // Ambil items
    $item_sql = "SELECT oi.*, p.name as product_name 
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = ?";
    $stmt = $conn->prepare($item_sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items = $stmt->get_result();
?>
    <div style="background: white; padding: 32px; margin-top: 32px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 8px;">Detail Pesanan #<?php echo $order_id; ?></h2>
                    <p style="color: #64748b; margin: 0;">
                        Tanggal: <?php echo date('d F Y, H:i', strtotime($order_info['order_date'])); ?> WIB
                    </p>
                </div>
                <?php
                $statusColors = [
                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'processing' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                    'completed' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b']
                ];
                $status = $order_info['status'];
                $color = $statusColors[$status] ?? $statusColors['pending'];
                ?>
                <span style="background: <?php echo $color['bg']; ?>; 
                             color: <?php echo $color['text']; ?>; 
                             padding: 10px 20px; 
                             border-radius: 20px; 
                             font-size: 14px; 
                             font-weight: 700;">
                    <?php echo strtoupper(htmlspecialchars($status)); ?>
                </span>
            </div>
        </div>

        <!-- Info Pelanggan -->
        <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 20px; border-radius: 10px; margin-bottom: 24px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">👤 Informasi Pelanggan</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <div>
                    <p style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Nama</p>
                    <p style="font-weight: 600; margin: 0;"><?php echo htmlspecialchars($order_info['user_name']); ?></p>
                </div>
                <div>
                    <p style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Email</p>
                    <p style="font-weight: 600; margin: 0;"><?php echo htmlspecialchars($order_info['user_email']); ?></p>
                </div>
                <div>
                    <p style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Telepon</p>
                    <p style="font-weight: 600; margin: 0;"><?php echo htmlspecialchars($order_info['user_phone']); ?></p>
                </div>
            </div>
        </div>

        <!-- Tabel Items -->
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">🛍️ Item Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="width: 80px;">Qty</th>
                    <th style="width: 130px;">Harga Satuan</th>
                    <th style="width: 130px;">Harga Tambahan</th>
                    <th>Catatan (Add-ons)</th>
                    <th style="width: 140px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                while($item = $items->fetch_assoc()): 
                    $subtotal = ($item['price_per_item'] + $item['additional_price']) * $item['quantity'];
                    $grandTotal += $subtotal;
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($item['product_name']); ?></strong></td>
                    <td><strong style="color: #3b82f6;"><?php echo $item['quantity']; ?>x</strong></td>
                    <td><?php echo "Rp " . number_format($item['price_per_item'], 0, ',', '.'); ?></td>
                    <td><?php echo "Rp " . number_format($item['additional_price'], 0, ',', '.'); ?></td>
                    <td>
                        <?php if($item['notes']): ?>
                            <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 13px;">
                                <?php echo htmlspecialchars($item['notes']); ?>
                            </span>
                        <?php else: ?>
                            <span style="color: #cbd5e1;">—</span>
                        <?php endif; ?>
                    </td>
                    <td><strong style="color: #10b981; font-size: 15px;"><?php echo "Rp " . number_format($subtotal, 0, ',', '.'); ?></strong></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <td colspan="5" style="text-align: right; color: white; font-weight: 700; font-size: 15px; padding: 16px 20px;">TOTAL PEMBAYARAN:</td>
                    <td style="color: white; font-weight: 700; font-size: 18px; padding: 16px 20px;">
                        <?php echo "Rp " . number_format($grandTotal, 0, ',', '.'); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        
        <div style="margin-top: 24px; display: flex; gap: 12px;">
            <a href="orders.php" class="btn btn-warning">← Kembali ke Daftar Pesanan</a>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Invoice</button>
        </div>
    </div>
<?php
    $stmt->close();
endif;
?>

<?php
$conn->close();
include 'footer.php';
?>