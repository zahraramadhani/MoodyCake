<?php
session_start(); // Wajib ada di baris paling atas
include 'db_connect.php'; // Masukkan file koneksi

// Cek jika ada user yang login dari session
$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT id, name, email, phone FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $currentUser = $result->fetch_assoc();
    }
    $stmt->close();
}
$conn->close(); // Tutup koneksi setelah selesai
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MoodyCake — Cake Shop</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
    <?php include 'style.php'; ?>
    <?php include 'responsive.php'; ?>
    <script>
      // Kirim data user dan BASE_URL dari PHP ke JavaScript
      // Ini akan menjadi variabel global yang bisa diakses file JS lain
      const currentUser = <?php echo json_encode($currentUser); ?>;
      const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
  </head>
  <body>
    <div class="cake-character" onclick="showRandomMessage()" title="Klik aku!">
      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="50" cy="85" rx="35" ry="8" fill="#ffb6d5" />
        <rect x="15" y="60" width="70" height="25" rx="5" fill="#ff6fa8" />
        <rect x="15" y="60" width="70" height="8" rx="3" fill="#ffd1e5" />
        <rect x="20" y="40" width="60" height="20" rx="5" fill="#ffb6d5" />
        <rect x="20" y="40" width="60" height="6" rx="3" fill="#ffe0f0" />
        <rect x="25" y="25" width="50" height="15" rx="5" fill="#ff6fa8" />
        <rect x="25" y="25" width="50" height="5" rx="3" fill="#ffd1e5" />
        <circle cx="50" cy="20" r="6" fill="#ff4757" />
        <circle cx="50" cy="20" r="4" fill="#ff6b7a" />
        <ellipse cx="48" cy="18" rx="2" ry="1.5" fill="#ff9aa2" opacity="0.7" />
        <circle cx="30" cy="50" r="2" fill="#fff" />
        <circle cx="45" cy="52" r="2" fill="#fff" />
        <circle cx="60" cy="48" r="2" fill="#fff" />
        <circle cx="35" cy="70" r="2" fill="#fff" />
        <circle cx="50" cy="72" r="2" fill="#fff" />
        <circle cx="65" cy="68" r="2" fill="#fff" />
        <rect x="47" y="10" width="6" height="12" rx="1" fill="#ffd93d" />
        <ellipse cx="50" cy="8" rx="4" ry="3" fill="#ff6348" />
        <ellipse cx="50" cy="6" rx="3" ry="2" fill="#ff8c7a" opacity="0.8" />
      </svg>
    </div>

    <header>
      <div class="brand">
        <div class="logo">
          <img src="<?php echo BASE_URL; ?>logo.jpg" alt="MoodyCake Logo" />
        </div>
        <div>
          <div class="brand-name">MoodyCake</div>
          <div class="brand-tagline">✨ Made with Love ✨</div>
        </div>
      </div>
      <nav>
        <a onclick="showHome()">Home</a>
        <a onclick="scrollToSection('menu')">Menu</a>
        <a onclick="scrollToSection('about')">About</a>
        <a onclick="scrollToSection('testimonials')">Testimoni</a>
        <div id="userControlContainer" style="margin-left: auto; margin-right: 12px;"></div>
        <button class="cart-btn" onclick="showCart()">
          🛒 Keranjang
          <span class="cart-badge" id="cartBadge">0</span>
        </button>
      </nav>
      <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
    </header>

    <div
      class="mobile-overlay"
      id="mobileOverlay"
      onclick="toggleMobileMenu()"
    ></div>
    <div class="mobile-nav" id="mobileNav">
      <div id="mobileUserControlContainer"></div>
      <a onclick="showHome(); toggleMobileMenu()">🏠 Home</a>
      <a onclick="scrollToSection('menu'); toggleMobileMenu()">🍰 Menu</a>
      <a onclick="scrollToSection('about'); toggleMobileMenu()">ℹ️ About</a>
      <a onclick="scrollToSection('testimonials'); toggleMobileMenu()"
        >💬 Testimoni</a
      >
      <button class="cart-btn" onclick="showCart(); toggleMobileMenu()">
        🛒 Keranjang
        <span class="cart-badge" id="cartBadgeMobile">0</span>
      </button>
    </div>

    <main id="mainContent">
      </main>

    <div class="cart-page" id="cartPage">
      <h2
        style="
          font-family: 'Playfair Display';
          font-size: 32px;
          margin-bottom: 20px;
        "
      >
        🛒 Keranjang Belanja
      </h2>
      <div id="cartItems"></div>
      <div class="cart-summary" id="cartSummary" style="display: none">
        <h3 style="margin-top: 0">Ringkasan Pesanan</h3>
        <div
          style="display: flex; justify-content: space-between; margin: 12px 0"
        >
          <span>Total Item:</span>
          <strong id="totalItems">0</strong>
        </div>
        <div
          style="
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            font-size: 20px;
          "
        >
          <strong>Total Harga:</strong>
          <strong style="color: var(--pink-3)" id="totalPrice">Rp 0</strong>
        </div>
        <button
          class="btn btn-pink"
          style="width: 100%; margin-top: 16px"
          id="btnProceedCheckout"
        >
          Checkout
        </button>
        <button
          class="btn btn-outline"
          style="width: 100%; margin-top: 8px"
          onclick="showHome()"
        >
          Lanjut Belanja
        </button>
      </div>
    </div>

    <div class="modal" id="productModal" onclick="closeModalOnBackdrop(event)">
      <div class="modal-content">
        <div class="modal-header">
          <h2
            id="modalTitle"
            style="margin: 0; font-family: 'Playfair Display'"
          ></h2>
          <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
          <img
            id="modalImage"
            src=""
            alt=""
            style="width: 100%; border-radius: 12px; margin-bottom: 12px"
          />
          <div id="modalBadge"></div>
          <p
            id="modalDescription"
            style="color: var(--muted); margin-bottom: 12px"
          ></p>
          <div class="price" id="modalPrice" style="font-size: 24px"></div>

          <div class="quantity-control">
            <button class="qty-btn" onclick="decreaseQty()">−</button>
            <span class="qty-display" id="qtyDisplay">1</span>
            <button class="qty-btn" onclick="increaseQty()">+</button>
          </div>

          <div class="additional-options">
            </div>

          <button
            class="btn btn-pink"
            style="width: 100%"
            id="modalAddToCartBtn"
          >
            🛒 Tambah ke Keranjang
          </button>
        </div>
      </div>
    </div>

    <div class="modal" id="notifyModal">
      <div class="modal-content" style="max-width: 520px">
        <div class="notify-header">
          <div class="notify-icon" id="notifyIcon">🎂</div>
          <div>
            <div class="notify-title" id="notifyTitle">Notifikasi</div>
            <div
              style="font-size: 13px; color: var(--muted)"
              id="notifySub"
            ></div>
          </div>
        </div>
        <div
          class="notify-body"
          id="notifyBody"
          style="padding: 18px; color: var(--accent)"
        ></div>
        <div class="notify-actions" id="notifyActions">
          <button class="btn btn-outline" onclick="closeNotify()">Tutup</button>
        </div>
      </div>
    </div>

    <footer>
      <p>
        <strong>MoodyCake</strong> &mdash; Cake shop kecil dengan sentuhan pink.
        Follow kami di Instagram: <em>@beautiful.gurlch</em>
      </p>
      <small>© MoodyCake 2025</small>
    </footer>

    <?php include 'utils.php'; ?>
    <?php include 'products.php'; ?>
    <?php include 'auth.php'; ?>
    <?php include 'cart.php'; ?>
    <?php include 'main.php'; ?>

    <div class="modal" id="loginModal">
      <div class="modal-content auth-modal-content"> <div class="modal-header">
          <h3 style="margin: 0">Login ke MoodyCake</h3>
          <button class="close-btn" onclick="closeAuthModals()">&times;</button>
        </div>
        <div class="modal-body">
          <div id="loginError" style="display: none"></div>
          <div class="auth-form-group"> <div class="input-icon-group">
                <span class="icon">📧</span>
                <input type="email" id="loginEmail" placeholder="Masukkan Email Anda" />
            </div>
            
            <div class="input-icon-group">
                <span class="icon">🔒</span>
                <input type="password" id="loginPassword" placeholder="Masukkan Password" />
            </div>
            <button
              class="btn btn-pink"
              onclick="handleLogin()"
              style="width: 100%; margin-top: 15px;"
            >
              Login Sekarang
            </button>
            <div
              style="text-align: center; color: var(--muted); font-size: 14px; margin-top: 15px;"
            >
              Belum punya akun?
            </div>
            <button
              class="btn btn-outline"
              onclick="closeAuthModals(); showRegisterModal()"
              style="width: 100%; margin-top: 5px;"
            >
              Daftar Akun Baru
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="registerModal">
      <div class="modal-content auth-modal-content"> <div class="modal-header">
          <h3 style="margin: 0">Daftar Akun Baru</h3>
          <button class="close-btn" onclick="closeAuthModals()">&times;</button>
        </div>
        <div class="modal-body">
          <div id="registerError" style="display: none"></div>
          <div class="auth-form-group"> <div class="input-icon-group">
                <span class="icon">👤</span>
                <input type="text" id="regName" placeholder="Nama Lengkap" />
            </div>

            <div class="input-icon-group">
                <span class="icon">📧</span>
                <input type="email" id="regEmail" placeholder="Email" />
            </div>
            
            <div class="input-icon-group">
                <span class="icon">🔒</span>
                <input type="password" id="regPassword" placeholder="Buat Password" />
            </div>

            <div class="input-icon-group">
                <span class="icon">📞</span>
                <input type="tel" id="regPhone" placeholder="Nomor Telepon" />
            </div>
            
            <div class="form-options">
                <label>
                    <input type="checkbox" id="terms" style="width: auto; margin-right: 5px;" checked>
                    Saya setuju dengan <a href="#" onclick="showNotification('Info', 'Halaman syarat dan ketentuan belum tersedia.', '📑'); return false;">Syarat & Ketentuan</a>
                </label>
            </div>

            <button
              class="btn btn-pink"
              onclick="handleRegister()"
              style="width: 100%; margin-top: 15px;"
            >
              Daftar Sekarang
            </button>
            <div
              style="text-align: center; color: var(--muted); font-size: 14px; margin-top: 15px;"
            >
              Sudah punya akun?
            </div>
            <button
              class="btn btn-outline"
              onclick="closeAuthModals(); showLoginModal()"
              style="width: 100%; margin-top: 5px;"
            >
              Login
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>