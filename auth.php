<script>
// Variabel `currentUser` sekarang diambil dari <script> di index.php
// Hapus `let currentUser` dan `let users` dari sini.

// --- NEW HELPER FUNCTIONS FOR IN-MODAL ERROR ---
function showAuthError(modalId, title, body) {
  const errorDiv = document.getElementById(modalId + "Error");
  if (errorDiv) {
    errorDiv.style.display = "block";
    errorDiv.className = "alert-error";
    errorDiv.innerHTML = `
      <div style="font-weight: 700; display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
        <span style="font-size: 18px;">❌</span> ${title}
      </div>
      <div style="font-size: 13px;">${body}</div>
    `;
  }
}

function clearAuthErrors() {
  const loginError = document.getElementById("loginError");
  const registerError = document.getElementById("registerError");
  if (loginError) {
    loginError.style.display = "none";
    loginError.innerHTML = "";
  }
  if (registerError) {
    registerError.style.display = "none";
    registerError.innerHTML = "";
  }
}

// -----------------------------------------------

function showLoginModal() {
  clearAuthErrors();
  document.getElementById("loginModal").classList.add("active");
  document.body.style.overflow = "hidden";
}

function showRegisterModal() {
  clearAuthErrors();
  document.getElementById("registerModal").classList.add("active");
  document.body.style.overflow = "hidden";
}

function closeAuthModals() {
  document.getElementById("loginModal").classList.remove("active");
  document.getElementById("registerModal").classList.remove("active");
  document.body.style.overflow = "auto";
  clearAuthErrors();
  
  // Kosongkan form fields
  const loginEmail = document.getElementById("loginEmail");
  if (loginEmail) loginEmail.value = "";
  const loginPassword = document.getElementById("loginPassword");
  if (loginPassword) loginPassword.value = "";
  const regName = document.getElementById("regName");
  if (regName) regName.value = "";
  const regEmail = document.getElementById("regEmail");
  if (regEmail) regEmail.value = "";
  const regPassword = document.getElementById("regPassword");
  if (regPassword) regPassword.value = "";
  const regPhone = document.getElementById("regPhone");
  if (regPhone) regPhone.value = "";
}

async function handleRegister() {
  const name = document.getElementById("regName").value.trim();
  const email = document.getElementById("regEmail").value.trim();
  const password = document.getElementById("regPassword").value;
  const phone = document.getElementById("regPhone").value.trim();
  const termsChecked = document.getElementById("terms").checked;

  clearAuthErrors();

  if (!name || !email || !password || !phone) {
    showAuthError("register", "Data Tidak Lengkap", "Harap isi semua field.");
    return;
  }
  if (!termsChecked) {
    showAuthError("register","Syarat & Ketentuan","Anda harus menyetujui Syarat & Ketentuan.");
    return;
  }

  try {
    const response = await fetch(BASE_URL + 'api/register_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, password, phone })
    });
    const result = await response.json();

    if (result.success) {
        // --- PERBAIKAN DI SINI ---
        closeAuthModals(); // 1. Tutup modal register
        // 2. Tampilkan notifikasi
        showNotification("Registrasi Berhasil!", `Selamat datang, ${name}! 🎉`, "👋"); 
        setTimeout(() => window.location.reload(), 1500);
    } else {
        showAuthError("register", "Registrasi Gagal", result.message);
    }
  } catch (error) {
      showAuthError("register", "Terjadi Kesalahan", "Tidak dapat terhubung ke server.");
  }
}

async function handleLogin() {
  const email = document.getElementById("loginEmail").value.trim();
  const password = document.getElementById("loginPassword").value;

  clearAuthErrors();

  if (!email || !password) {
      showAuthError("login", "Data Tidak Lengkap", "Harap isi email dan password.");
      return;
  }

  try {
    const response = await fetch(BASE_URL + 'api/login_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });
    const result = await response.json();

    if (result.success) {
        // --- PERBAIKAN DI SINI ---
        closeAuthModals(); // 1. Tutup modal login
        // 2. Tampilkan notifikasi
        showNotification("Login Berhasil!", `Selamat datang kembali! ✨`, "👋");
        setTimeout(() => window.location.reload(), 1500);
    } else {
        showAuthError("login", "Login Gagal", result.message);
    }
  } catch (error) {
      showAuthError("login", "Terjadi Kesalahan", "Tidak dapat terhubung ke server.");
  }
}

function handleLogout() {
  showNotification(
    "Konfirmasi Logout",
    "Apakah Anda yakin ingin logout?",
    "🔐",
    `
        <button class="btn btn-pink" onclick="confirmLogout()">Ya, Logout</button>
        <button class="btn btn-outline" onclick="closeNotify()">Batal</button>
        `
  );
}

function confirmLogout() {
  closeNotify();
  showNotification("Logout...", "Anda sedang dialihkan...", "👋");
  // Arahkan ke skrip logout PHP
  window.location.href = BASE_URL + 'api/logout_handler.php';
}

function updateAuthUI() {
  // Ambil container dari index.php
  const userControlContainer = document.getElementById('userControlContainer');
  const mobileUserControlContainer = document.getElementById('mobileUserControlContainer');
  
  if (!userControlContainer || !mobileUserControlContainer) return;

  if (currentUser) {
    // User Logged In
    const userHTML = `
      <div id="userControl" style="display: flex; align-items: center; gap: 12px;">
          <span style="color: var(--muted); font-size: 14px;">Halo, ${currentUser.name}</span>
          <button class="btn-ghost" onclick="handleLogout()" style="padding: 6px 12px; font-size: 12px;">Logout</button>
      </div>
    `;
    const mobileUserHTML = `
      <div id="mobileUserControl">
          <div style="padding: 16px; background: var(--pink-1); border-radius: 12px; margin-bottom: 12px;">
              <div style="font-weight: 700; color: var(--accent);">Halo, ${currentUser.name}</div>
              <div style="font-size: 12px; color: var(--muted);">${currentUser.email}</div>
              <button class="btn-ghost" onclick="handleLogout(); toggleMobileMenu()" style="width: 100%; margin-top: 8px; padding: 8px;">Logout</button>
          </div>
      </div>
    `;
    userControlContainer.innerHTML = userHTML;
    mobileUserControlContainer.innerHTML = mobileUserHTML;

  } else {
    // User Guest (Not Logged In)
    const guestHTML = `
      <div id="userControl">
          <button class="btn-ghost" onclick="showLoginModal()" style="padding: 8px 14px; font-size: 13px;">Login/Daftar</button>
      </div>
    `;
    const mobileGuestHTML = `
      <div id="mobileUserControl">
          <button class="btn-ghost" onclick="showLoginModal(); toggleMobileMenu()" style="width: 100%; margin-bottom: 12px; padding: 12px;">Login/Daftar</button>
      </div>
    `;
    userControlContainer.innerHTML = guestHTML;
    mobileUserControlContainer.innerHTML = mobileGuestHTML;
  }
}

function checkAuth() {
  if (!currentUser) {
    showNotification(
      "Login Diperlukan",
      "Silakan login terlebih dahulu untuk melanjutkan.",
      "🔐",
      `
            <button class="btn btn-pink" onclick="showLoginModal(); closeNotify()">Login</button>
            <button class="btn btn-outline" onclick="showRegisterModal(); closeNotify()">Daftar</button>
            `
    );
    return false;
  }
  return true;
}

// Initialize auth on load
document.addEventListener("DOMContentLoaded", function () {
  updateAuthUI();
});
</script>