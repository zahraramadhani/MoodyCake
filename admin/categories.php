<?php
include 'header.php';
include '../db_connect.php';

$message = '';
$category = ['id' => '', 'name' => '', 'slug' => ''];

// === LOGIKA CREATE / UPDATE ===
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_category'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $id = $_POST['id'];

    if (empty($id)) {
        $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $slug);
        $message = "Kategori berhasil ditambahkan!";
    } else {
        $stmt = $conn->prepare("UPDATE categories SET name=?, slug=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $slug, $id);
        $message = "Kategori berhasil diperbarui!";
    }
    $stmt->execute();
    $stmt->close();
}

// === LOGIKA DELETE ===
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $message = "Kategori berhasil dihapus!";
}

// === LOGIKA UNTUK EDIT (ISI FORM) ===
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $category = $stmt->get_result()->fetch_assoc();
}
?>

<div class="content-header">
    <h1>📁 Manajemen Kategori</h1>
</div>

<?php if ($message): ?>
    <div class="alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-top: 24px;">
    <!-- Form Tambah/Edit -->
    <div>
        <form action="categories.php" method="POST">
            <h3><?php echo empty($category['id']) ? '➕ Tambah Kategori' : '✏️ Edit Kategori'; ?></h3>
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            
            <?php if (!empty($category['id'])): ?>
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="color: white; margin: 0; font-size: 14px; font-weight: 600;">Mengedit: <?php echo htmlspecialchars($category['name']); ?></p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Nama Kategori *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required placeholder="Contoh: Cake Character">
                <small>Nama kategori yang akan ditampilkan</small>
            </div>
            
            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($category['slug']); ?>" required placeholder="Contoh: cakeChar">
                <small>URL-friendly identifier (tanpa spasi)</small>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <button type="submit" name="save_category" class="btn btn-primary">
                    <?php echo empty($category['id']) ? '💾 Simpan' : '✅ Update'; ?>
                </button>
                <?php if (!empty($category['id'])): ?>
                    <a href="categories.php" class="btn btn-warning">❌ Batal</a>
                <?php endif; ?>
            </div>
        </form>

        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 16px; border-radius: 10px; margin-top: 20px; border-left: 4px solid #f59e0b;">
            <p style="margin: 0; font-size: 13px; color: #92400e; font-weight: 500;">💡 <strong>Tips:</strong> Slug digunakan untuk URL. Gunakan format camelCase atau lowercase tanpa spasi.</p>
        </div>
    </div>

    <!-- Tabel Kategori -->
    <div>
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0;">Daftar Kategori</h3>
                <span style="color: #64748b; font-size: 14px;">
                    <?php 
                    $count = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
                    echo $count . " kategori";
                    ?>
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM categories ORDER BY id ASC");
                    if ($result->num_rows > 0):
                        while($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                        <td>
                            <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 13px; color: #3b82f6;">
                                <?php echo htmlspecialchars($row['slug']); ?>
                            </code>
                        </td>
                        <td class="action-links">
                            <a href="categories.php?action=edit&id=<?php echo $row['id']; ?>" class="edit">✏️ Edit</a>
                            <a href="categories.php?action=delete&id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Menghapus kategori akan error jika masih ada produk di dalamnya. Yakin?');">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #64748b; padding: 40px 0;">
                            Belum ada kategori. Tambahkan kategori pertama Anda!
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>