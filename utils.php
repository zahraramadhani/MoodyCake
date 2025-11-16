<script>
// Utility functions
function showNotification(title, body, icon = "🎂", actions = null) {
  const modal = document.getElementById("notifyModal");
  const notifyIcon = document.getElementById("notifyIcon");
  const notifyTitle = document.getElementById("notifyTitle");
  const notifyBody = document.getElementById("notifyBody");
  const notifyActions = document.getElementById("notifyActions");

  notifyIcon.textContent = icon;
  notifyTitle.textContent = title;
  notifyBody.innerHTML = body;

  if (actions) {
    notifyActions.innerHTML = actions;
  } else {
    notifyActions.innerHTML =
      '<button class="btn btn-outline" onclick="closeNotify()">Tutup</button>';
  }

  modal.classList.add("active");
}

function closeNotify() {
  document.getElementById("notifyModal").classList.remove("active");
}

function closeModalOnBackdrop(event) {
  if (event.target.classList.contains("modal")) {
    closeModal();
    closeNotify();
  }
}

function scrollToSection(sectionId) {
  showHome();
  setTimeout(() => {
    const element = document.getElementById(sectionId);
    if (element) {
      element.scrollIntoView({ behavior: "smooth" });
    }
  }, 100);
}

function toggleMobileMenu() {
  const overlay = document.getElementById("mobileOverlay");
  const nav = document.getElementById("mobileNav");
  overlay.classList.toggle("active");
  nav.classList.toggle("active");
}

function showRandomMessage() {
  const messages = [
    "Hai! Siap untuk pesan kue lezat? 🎂",
    "Kue fresh setiap hari! ✨",
    "Diskon spesial untuk pembelian pertama! 🎉",
    "Pesan sekarang, antar besok! 🚚",
    "Rahasia kebahagiaan: kue dan cinta 💖",
  ];
  const randomMsg = messages[Math.floor(Math.random() * messages.length)];
  showNotification("MoodyCake", randomMsg, "🎂");
}

// Format currency
function formatCurrency(amount) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(amount);
}
</script>