<?php
include 'header.php';
include '../db_connect.php';

$action = $_GET['action'] ?? 'view';
$message = $_GET['message'] ?? '';

// === LOGIKA UNTUK CREATE / UPDATE ===
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_product'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $badge_text = $_POST['badge_text'];
    $badge_type = $_POST['badge_type'];
    $id = $_POST['id'];

    $image = $_POST['existing_image'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
             move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            $image = $_POST['existing_image'];
        }
    }

    if (empty($id)) {
        $stmt = $conn->prepare("INSERT INTO products (name, category_id, price, description, image, badge_text, badge_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siissss", $name, $category_id, $price, $description, $image, $badge_text, $badge_type);
        $stmt->execute();
        $message = "Produk berhasil ditambahkan!";
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, category_id=?, price=?, description=?, image=?, badge_text=?, badge_type=? WHERE id=?");
        $stmt->bind_param("siissssi", $name, $category_id, $price, $description, $image, $badge_text, $badge_type, $id);
        $stmt->execute();
        $message = "Produk berhasil diperbarui!";
    }
    $stmt->close();
    header("Location: products.php?message=" . urlencode($message));
    exit();
}

// === LOGIKA UNTUK DELETE ===
if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $img_stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $img_stmt->bind_param("i", $id);
    $img_stmt->execute();
    $img_file = $img_stmt->get_result()->fetch_assoc()['image'];
    if ($img_file && file_exists("../img/" . $img_file)) {
        unlink("../img/" . $img_file);
    }
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: products.php?message=" . urlencode("Produk berhasil dihapus!"));
    exit();
}

$categories_result = $conn->query("SELECT * FROM categories");
?>

<?php if ($action == 'view'): ?>
    <div class="content-header">
        <h1>🎂 Manajemen Menu</h1>
        <a href="products.php?action=add" class="btn btn-success">➕ Tambah Menu Baru</a>
    </div>

    <?php if ($message): ?>
        <div class="alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0;">Daftar Menu</h3>
            <span style="color: #64748b; font-size: 14px;">
                <?php 
                $count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
                echo $count . " menu tersedia";
                ?>
            </span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Badge</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><img src="<?php echo BASE_URL . 'img/' . htmlspecialchars($row['image']); ?>" alt="" class="product-thumb"></td>
                    <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><strong><?php echo "Rp " . number_format($row['price'], 0, ',', '.'); ?></strong></td>
                    <td>
                        <?php if($row['badge_text']): ?>
                            <span class="badge <?php echo htmlspecialchars($row['badge_type']); ?>">
                                <?php echo htmlspecialchars($row['badge_text']); ?>
                            </span>
                        <?php else: ?>
                            <span style="color: #cbd5e1;">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="action-links">
                        <a href="products.php?action=edit&id=<?php echo $row['id']; ?>" class="edit">✏️ Edit</a>
                        <a href="products.php?action=delete&id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus produk ini?');">🗑️ Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($action == 'add' || $action == 'edit'): ?>
    
    <?php
    $product = [
        'id' => '', 'name' => '', 'category_id' => '', 'price' => '', 
        'description' => '', 'image' => '', 'badge_text' => '', 'badge_type' => ''
    ];
    $formTitle = "Tambah Menu Baru";
    $formIcon = "➕";

    if ($action == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $formTitle = "Edit Menu";
        $formIcon = "✏️";
    }
    ?>
    <div class="content-header">
        <h1><?php echo $formIcon . " " . $formTitle; ?></h1>
        <a href="products.php" class="btn btn-warning">← Kembali</a>
    </div>

    <form action="products.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="existing_image" value="<?php echo $product['image']; ?>">
        
        <?php if ($action == 'edit'): ?>
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 16px 20px; border-radius: 10px; margin-bottom: 24px;">
                <p style="color: white; margin: 0; font-weight: 600;">Mengedit: <?php echo htmlspecialchars($product['name']); ?></p>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="name">Nama Produk *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required placeholder="Contoh: Red Velvet Cake">
            </div>
            <div class="form-group">
                <label for="category_id">Kategori *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php 
                    $categories_result->data_seek(0);
                    while($cat = $categories_result->fetch_assoc()): 
                    ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp) *</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required placeholder="78000">
            <small>Masukkan harga tanpa titik atau koma</small>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" placeholder="Deskripsikan menu ini..."><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Gambar Produk</label>
            <?php if ($action == 'edit' && $product['image']): ?>
                <div style="margin-bottom: 12px;">
                    <img src="<?php echo BASE_URL . 'img/' . htmlspecialchars($product['image']); ?>" alt="" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 3px solid #e2e8f0;">
                </div>
                <small style="display: block; margin-bottom: 8px;">Upload gambar baru untuk mengganti (biarkan kosong jika tidak ingin ganti)</small>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*" style="padding: 10px;">
        </div>

        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 2px dashed #cbd5e1; margin: 24px 0;">
            <h4 style="margin: 0 0 16px 0; color: #0f172a; font-size: 16px;">🏷️ Badge (Opsional)</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group" style="margin: 0;">
                    <label for="badge_text">Teks Badge</label>
                    <input type="text" id="badge_text" name="badge_text" value="<?php echo htmlspecialchars($product['badge_text']); ?>" placeholder="Contoh: Terlaris, Baru">
                </div>
                <div class="form-group" style="margin: 0;">
                    <label for="badge_type">Tipe Badge</label>
                    <select id="badge_type" name="badge_type">
                        <option value="" <?php echo ($product['badge_type'] == '') ? 'selected' : ''; ?>>Tidak Ada</option>
                        <option value="badge-popular" <?php echo ($product['badge_type'] == 'badge-popular') ? 'selected' : ''; ?>>🔥 Popular (Merah)</option>
                        <option value="badge-new" <?php echo ($product['badge_type'] == 'badge-new') ? 'selected' : ''; ?>>✨ New (Tosca)</option>
                        <option value="badge-featured" <?php echo ($product['badge_type'] == 'badge-featured') ? 'selected' : ''; ?>>⭐ Featured (Kuning)</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" name="save_product" class="btn btn-primary">💾 Simpan Produk</button>
            <a href="products.php" class="btn btn-warning">❌ Batal</a>
        </div>
    </form>
<?php endif; ?>

<?php
$conn->close();
include 'footer.php';
?>