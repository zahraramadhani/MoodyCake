<script>
// Main application logic
document.addEventListener("DOMContentLoaded", function () {
  showHome();
  updateCartBadges();
  updateAuthUI(); // Panggil ini untuk setup tombol login/logout
});

function showHome() {
  const mainContent = document.getElementById("mainContent");
  const cartPage = document.getElementById("cartPage");

  cartPage.classList.remove("active");
  mainContent.style.display = "block";

  mainContent.innerHTML = `
        <section class="hero">
            <div class="hero-left">
                <h1>Mood Booster dengan Setiap Gigitan 🎂</h1>
                <p class="lead">Kue homemade spesial untuk hari bahagiamu. Pesan sekarang, antar besok!</p>
                <div class="btns">
                    <button class="btn btn-pink" onclick="scrollToSection('menu')">Lihat Menu</button>
                    <button class="btn btn-outline" onclick="showNotification('Info', 'Hubungi kami di Instagram: @beautiful.gurlch', '📱')">Kontak</button>
                </div>
            </div>
            <div class="hero-right">
                <div class="featured-cake">
                    <img src="${BASE_URL}img/1.jpg" height="400" width="400" alt="Cake Spesial MoodyCake" />
                    <div class="cake-caption">
                        <h3>Kue Spesial Hari Ini ✨</h3>
                    </div>
                </div>
            </div>
        </section>

        <section id="menu" class="section-transition">
            <div style="max-width: 1100px; margin: 60px auto; padding: 0 24px">
                <h2 style="font-family: 'Playfair Display'; font-size: 36px; text-align: center; margin-bottom: 10px">🍰 Our Menu</h2>
                <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto 30px">Pilih dari berbagai kue lezat yang dibuat dengan bahan premium dan penuh cinta</p>
                
                <div class="menu-tabs">
                    <button class="tab-btn active" onclick="filterProducts('all')">Semua</button>
                    <button class="tab-btn" onclick="filterProducts('cakeChar')">Cake Character</button>
                    <button class="tab-btn" onclick="filterProducts('cakeCust')">Cake Custom</button>
                </div>
                
                <div class="gallery">
                    </div>
            </div>
        </section>

        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Pelanggan Bahagia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Varian Rasa</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Kue Terjual</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9</div>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
        </section>

        <section id="about" class="section-transition">
            <div style="max-width: 1100px; margin: 60px auto; padding: 0 24px">
                <div style="background: var(--glass); border-radius: 18px; padding: 40px; box-shadow: var(--card-shadow);">
                    <h2 style="font-family: 'Playfair Display'; font-size: 36px; text-align: center; margin-bottom: 20px; color: var(--accent)">About Moody Cake</h2>
                    
                    <div class="about-content-grid">
                        <div>
                            <p style="color: var(--muted); line-height: 1.8; font-size: 16px; margin-bottom: 20px">
                                MoodyCake adalah Cake shop buatan Kami Bersama Yaitu <strong>Nur Annisa Chania, Zahra Ramadhani Sanjaya dan Zamziatul Latifah</strong>.
                            </p>
                            <p style="color: var(--muted); line-height: 1.8; font-size: 16px; margin-bottom: 20px">
                                Kami melayani custom design untuk berbagai acara spesial Anda. Mari wujudkan kue impian Anda bersama MoodyCake! 🎂💕
                            </p>
                            
                            <div class="about-team-photos">
                            <div style="text-align: center;">
                                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--pink-2), var(--pink-3)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; overflow: hidden;">
                                    <img src="${BASE_URL}img/14.jpg" alt="Nur Annisa Chania" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="font-weight: 700; color: var(--accent);">Nur Annisa Chania</div>
                                <div style="font-size: 12px; color: var(--muted);">Founder</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--pink-2), var(--pink-3)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; overflow: hidden;">
                                    <img src="${BASE_URL}img/16.jpg" alt="Zahra Ramadhani Sanjaya" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="font-weight: 700; color: var(--accent);">Zahra Ramadhani S</div>
                                <div style="font-size: 12px; color: var(--muted);">Co-Founder</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--pink-2), var(--pink-3)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; overflow: hidden;">
                                    <img src="${BASE_URL}img/15.jpg" alt="Zamziatul Latifah" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="font-weight: 700; color: var(--accent);">Zamziatul Latifah</div>
                                <div style="font-size: 12px; color: var(--muted);">Co-Founder</div>
                            </div>
                        </div>
                        </div>
                        
                        <div style="text-align: center;">
                            <img src="${BASE_URL}img/we.jpg" alt="MoodyCake Team" style="width: 100%; max-width: 300px; border-radius: 15px; box-shadow: var(--card-shadow);">
                            <div style="margin-top: 15px; font-style: italic; color: var(--muted); font-size: 14px;">Tim MoodyCake yang berdedikasi 💖</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="testimonial-section section-transition">
            <h2 style="font-family: 'Playfair Display'; font-size: 36px; text-align: center; margin-bottom: 10px">💬 Testimoni Pelanggan</h2>
            <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto 30px">Apa kata mereka yang sudah mencoba kue MoodyCake</p>
            
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p>"Kuenya enak banget! Lembut dan tidak terlalu manis. Anak-anak suka sekali!"</p>
                    <div style="margin-top: 16px; font-weight: 700">- Sarah, Bandung</div>
                </div>
                <div class="testimonial-card">
                    <p>"Pelayanannya cepat dan kuenya fresh. Packagingnya juga rapi banget. Recommended!"</p>
                    <div style="margin-top: 16px; font-weight: 700">- Rina, Jakarta</div>
                </div>
                <div class="testimonial-card">
                    <p>"Red Velvet cupcakenya juara! Cream cheesenya pas, tidak eneg. Sudah pesen berkali-kali."</p>
                    <div style="margin-top: 16px; font-weight: 700">- Dito, Bekasi</div>
                </div>
            </div>
        </section>

        <section id="location" class="section-transition">
            <div class="map-section">
                <h2 style="font-family: 'Playfair Display'; font-size: 36px; text-align: center; margin-bottom: 10px">📍 Temukan Kami</h2>
                <p style="text-align: center; color: var(--muted); margin-bottom: 30px">Kunjungi toko kami atau pesan online untuk pengalaman terbaik</p>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps?q=-6.2539599,106.7459394&z=17&output=embed" 
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                
                <div class="contact-info">
                    </div>
            </div>
        </section>
    `;

  window.scrollTo(0, 0);

  // Panggil fetchProducts() SETELAH innerHTML di-set
  // Ini memastikan elemen .gallery sudah ada
  fetchProducts(); // Fungsi dari products.js

  // Add animation to sections
  setTimeout(() => {
    document.querySelectorAll(".section-transition").forEach((section) => {
      section.classList.add("active");
    });
  }, 100);
}

// --- LOGIKA STICKY HEADER ---//
window.addEventListener("scroll", function () {
  const header = document.querySelector("header");
  const scrollThreshold = 50;
  if (window.scrollY > scrollThreshold) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

function showCart() {
  const mainContent = document.getElementById("mainContent");
  const cartPage = document.getElementById("cartPage");

  mainContent.style.display = "none";
  cartPage.classList.add("active");

  renderCartItems(); // Fungsi dari cart.js
}
</script>