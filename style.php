<style>
:root {
  --pink-1: #ffeef8;
  --pink-2: #ffb6d5;
  --pink-3: #ff6fa8;
  --accent: #6b2b4a;
  --muted: #6b5b6b;
  --card-shadow: 0 8px 30px rgba(107, 43, 74, 0.12);
  --glass: rgba(255, 255, 255, 0.6);
}

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto,
    "Helvetica Neue", Arial;
  background: linear-gradient(180deg, var(--pink-1), #fff 40%);
  color: var(--accent);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  line-height: 1.5;
  overflow-x: hidden;
}

header {
  padding: 20px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
  transition: all 0.3s ease;
}

header.scrolled {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1100;
  background: var(--glass);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 12px rgba(107, 43, 74, 0.1);
}

.brand {
  display: flex;
  align-items: center;
  gap: 16px;
}

.logo {
  width: 64px;
  height: 64px;
  border-radius: 12px;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--card-shadow);
  flex-shrink: 0;
  transition: all 0.3s;
  overflow: hidden;
}

.logo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 4px;
}

.logo:hover {
  transform: rotate(5deg) scale(1.05);
}

.brand-name {
  font-family: "Playfair Display";
  font-size: 24px;
  font-weight: 700;
  background: linear-gradient(135deg, var(--pink-3), var(--accent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  letter-spacing: 1px;
  text-shadow: 0 2px 10px rgba(255, 111, 168, 0.2);
}

.brand-tagline {
  font-size: 11px;
  color: var(--pink-3);
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
}

nav {
  display: flex;
  gap: 12px;
  align-items: center;
}

nav a {
  padding: 8px 12px;
  border-radius: 999px;
  text-decoration: none;
  color: var(--muted);
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

nav a:hover {
  background: var(--pink-1);
}

.cart-btn {
  position: relative;
  background: var(--pink-3);
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 999px;
  cursor: pointer;
  font-weight: 600;
  box-shadow: var(--card-shadow);
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s;
}

.cart-btn:hover {
  transform: scale(1.05);
}

.cart-badge {
  background: var(--accent);
  color: white;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
}

/* Floating Cake Character */
.cake-character {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 100px;
  height: 100px;
  z-index: 999;
  animation: float 3s ease-in-out infinite;
  cursor: pointer;
  transition: transform 0.3s;
}

.cake-character:hover {
  transform: scale(1.1) rotate(5deg);
}

@keyframes float {
  0%,
  100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-15px);
  }
}

.cake-character svg {
  filter: drop-shadow(0 4px 12px rgba(107, 43, 74, 0.3));
}

.hero {
  display: grid;
  grid-template-columns: 1fr 520px;
  gap: 24px;
  padding: 24px;
  align-items: center;
  max-width: 1100px;
  margin: 0 auto;
}

.hero-left {
  padding: 28px;
  background: var(--glass);
  border-radius: 18px;
  box-shadow: var(--card-shadow);
}

.hero h1 {
  font-family: "Playfair Display";
  font-size: 44px;
  margin: 0 0 8px;
}

.hero p.lead {
  margin: 0 0 16px;
  color: var(--muted);
}

.hero .btns {
  display: flex;
  gap: 12px;
}

.btn {
  padding: 12px 18px;
  border-radius: 12px;
  border: 0;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: var(--card-shadow);
}

.btn-pink {
  background: var(--pink-3);
  color: white;
}

.btn-outline {
  background: transparent;
  border: 2px solid var(--pink-2);
  color: var(--accent);
}

/* Tambahkan di file style.css */
.featured-cake {
  text-align: center;
  background: white;
  border-radius: 14px;
  padding: 16px;
  box-shadow: var(--card-shadow);
  transition: all 0.3s;
}

.featured-cake:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(107, 43, 74, 0.18);
}

.featured-cake img {
  width: 100%;
  max-width: 300px;
  height: 250px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 12px;
}

.cake-caption h3 {
  margin: 0 0 8px;
  font-family: "Playfair Display";
  color: var(--accent);
}

.cake-caption p {
  margin: 0;
  color: var(--muted);
  font-size: 14px;
}

/* Menu Tabs */
.menu-tabs {
  display: flex;
  gap: 12px;
  margin: 20px 0;
  flex-wrap: wrap;
}

.tab-btn {
  padding: 10px 20px;
  border-radius: 999px;
  border: 2px solid var(--pink-2);
  background: white;
  color: var(--accent);
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.tab-btn:hover {
  transform: scale(1.05);
}

.tab-btn.active {
  background: var(--pink-3);
  color: white;
  border-color: var(--pink-3);
}

.gallery {
  max-width: 1100px;
  margin: 28px auto;
  padding: 24px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 18px;
}

.product {
  background: white;
  border-radius: 14px;
  padding: 12px;
  box-shadow: var(--card-shadow);
  overflow: hidden;
  transition: transform 0.3s;
  cursor: pointer;
}

.product:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(107, 43, 74, 0.18);
}

.product img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 10px;
}

.product .meta {
  padding: 10px;
}

.product h3 {
  margin: 0 0 6px;
  font-size: 18px;
}

.product p {
  margin: 0 0 9px;
  color: var(--muted);
  font-size: 14px;
}

.product .price {
  font-weight: 800;
}

.product .actions {
  display: flex;
  gap: 8px;
}

.product .badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 700;
  margin-bottom: 8px;
}

.badge-featured {
  background: #ffd700;
  color: #6b2b4a;
}

.badge-new {
  background: #4ecdc4;
  color: white;
}

.badge-popular {
  background: #ff6b6b;
  color: white;
}

/* Modal (umum) */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  z-index: 1200;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.modal.active {
  display: flex;
}

.modal-content {
  background: white;
  border-radius: 18px;
  max-width: 640px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: slideUp 0.28s cubic-bezier(0.2, 0.8, 0.2, 1);
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-header {
  padding: 18px;
  border-bottom: 1px solid #f6f3f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-body {
  padding: 18px;
}

.close-btn {
  background: transparent;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: var(--muted);
  line-height: 1;
  transition: all 0.3s;
}

.close-btn:hover {
  color: var(--pink-3);
  transform: rotate(90deg);
}

.quantity-control {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 16px 0;
}

.qty-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 2px solid var(--pink-2);
  background: white;
  cursor: pointer;
  font-weight: 700;
  color: var(--accent);
  transition: all 0.3s;
}

.qty-btn:hover {
  background: var(--pink-1);
  transform: scale(1.1);
}

.qty-display {
  font-size: 18px;
  font-weight: 700;
  min-width: 40px;
  text-align: center;
}

/* Cart Page */
.cart-page {
  display: none;
  max-width: 900px;
  margin: 40px auto;
  padding: 24px;
}

.cart-page.active {
  display: block;
}

.cart-item {
  background: white;
  border-radius: 14px;
  padding: 16px;
  margin-bottom: 12px;
  display: flex;
  gap: 16px;
  align-items: center;
  box-shadow: var(--card-shadow);
}

.cart-item img {
  width: 100px;
  height: 80px;
  object-fit: cover;
  border-radius: 10px;
}

.cart-item-info {
  flex: 1;
}

.cart-item-actions {
  display: flex;
  gap: 8px;
  align-items: center;
}

.remove-btn {
  background: #ff4444;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s;
}

.remove-btn:hover {
  background: #cc0000;
  transform: scale(1.05);
}

.cart-summary {
  background: var(--glass);
  border-radius: 14px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: var(--card-shadow);
}

.empty-cart {
  text-align: center;
  padding: 60px 20px;
  color: var(--muted);
}

/* Map & contact */
.map-section {
  max-width: 1100px;
  margin: 40px auto;
  padding: 24px;
  background: var(--glass);
  border-radius: 18px;
  box-shadow: var(--card-shadow);
}

.map-container {
  width: 100%;
  height: 400px;
  border-radius: 14px;
  overflow: hidden;
  margin-top: 16px;
  box-shadow: var(--card-shadow);
}

.map-container iframe {
  width: 100%;
  height: 100%;
  border: none;
}

.contact-info {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 24px;
}

.contact-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: var(--card-shadow);
  display: flex;
  align-items: center;
  gap: 16px;
  transition: all 0.3s;
}

.contact-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(107, 43, 74, 0.18);
}

.contact-icon {
  font-size: 32px;
  flex-shrink: 0;
  animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

.contact-details h4 {
  margin: 0 0 4px;
  font-size: 14px;
  color: var(--muted);
  font-weight: 600;
}

.contact-details p {
  margin: 0;
  font-weight: 600;
  color: var(--accent);
}

/* Testimonial */
.testimonial-section {
  max-width: 1100px;
  margin: 40px auto;
  padding: 24px;
}

.testimonial-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 24px;
}

.testimonial-card {
  background: rgb(255, 188, 216);
  padding: 24px;
  border-radius: 14px;
  box-shadow: var(--card-shadow);
  transition: all 0.3s;
  position: relative;
  overflow: hidden;
}

.testimonial-card::before {
  content: "❝";
  position: absolute;
  top: -10px;
  left: 10px;
  font-size: 80px;
  color: var(--pink-2);
  opacity: 0.3;
  font-family: "Playfair Display";
}

.testimonial-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 15px 50px rgba(21, 8, 14, 0.2);
}

/* stats */
.stats-section {
  max-width: 1100px;
  margin: 40px auto;
  padding: 24px;
  background: linear-gradient(135deg, var(--pink-3), var(--accent));
  border-radius: 18px;
  box-shadow: var(--card-shadow);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 24px;
}

.stat-item {
  text-align: center;
  padding: 20px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 12px;
  backdrop-filter: blur(10px);
  transition: all 0.3s;
}

.stat-item:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: scale(1.05);
}

.stat-number {
  font-size: 42px;
  font-weight: 700;
  color: white;
  font-family: "Playfair Display";
  margin-bottom: 8px;
}

.stat-label {
  color: white;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

footer {
  padding: 28px;
  text-align: center;
  color: var(--muted);
}

/* Mobile Menu */
.mobile-menu-btn {
  display: none;
  background: transparent;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: var(--accent);
}

.mobile-nav {
  display: none;
  position: fixed;
  top: 0;
  right: -100%;
  width: 280px;
  height: 100vh;
  background: white;
  box-shadow: -5px 0 20px rgba(0, 0, 0, 0.1);
  padding: 80px 20px 20px;
  transition: right 0.3s;
  z-index: 1001;
}

.mobile-nav.active {
  right: 0;
}

.mobile-nav a,
.mobile-nav button {
  display: block;
  width: 100%;
  padding: 16px;
  margin-bottom: 8px;
  text-align: left;
  border-radius: 12px;
  border: none;
  background: white;
  color: var(--accent);
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.mobile-nav a:hover,
.mobile-nav button:hover {
  background: var(--pink-1);
}

.mobile-nav .cart-btn {
  background: var(--pink-3);
  color: white;
  justify-content: center;
}

.close-mobile-menu {
  position: absolute;
  top: 20px;
  right: 20px;
  background: transparent;
  border: none;
  font-size: 32px;
  cursor: pointer;
  color: var(--muted);
}

.mobile-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.mobile-overlay.active {
  display: block;
}

.notify-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
  background: linear-gradient(135deg, var(--pink-3), var(--accent));
  color: white;
  font-size: 22px;
}

.notify-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 18px;
  border-bottom: 1px solid #ffecf5;
}

.notify-title {
  font-weight: 800;
  color: var(--accent);
  font-size: 18px;
}

.notify-body {
  padding: 18px;
}

.notify-actions {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
  padding: 12px 18px;
  border-top: 1px solid #f3e9f2;
}

.notify-success {
  background: linear-gradient(135deg, #fff5fb, #fffafc);
  border: 1px solid #ffd9ec;
}

.form-row {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.form-row .col {
  flex: 1;
}

.btn-ghost {
  background: transparent;
  border: 2px solid var(--pink-2);
  color: var(--accent);
  padding: 8px 12px;
  border-radius: 8px;
}

/* small tweaks */
.small-muted {
  font-size: 13px;
  color: var(--muted);
}

pre.debug {
  white-space: pre-wrap;
  word-break: break-word;
  font-size: 13px;
  color: #333;
  background: #fff;
  padding: 10px;
  border-radius: 8px;
  box-shadow: var(--card-shadow);
}

/* CSS BARU UNTUK FITUR TAMBAHAN */
.additional-options {
  margin: 16px 0;
  padding: 16px;
  background: var(--pink-1);
  border-radius: 12px;
}

.additional-options label {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
  cursor: pointer;
}

.qris-image {
  max-width: 200px;
  margin: 16px auto;
  display: block;
  border-radius: 8px;
  border: 1px solid var(--pink-2);
}

.bank-details {
  background: var(--pink-1);
  padding: 16px;
  border-radius: 12px;
  margin: 16px 0;
}

.bank-details h4 {
  margin-top: 0;
  margin-bottom: 8px;
  color: var(--accent);
}

.bank-details p {
  margin: 4px 0;
  font-family: monospace;
  font-size: 14px;
}

.proof-upload {
  margin: 16px 0;
  padding: 16px;
  border: 2px dashed var(--pink-2);
  border-radius: 12px;
  text-align: center;
}

.proof-upload input {
  margin: 8px 0;
}

.auto-reload-info {
  background: var(--pink-1);
  padding: 8px 12px;
  border-radius: 8px;
  margin: 8px 0;
  font-size: 12px;
  color: var(--muted);
  display: flex;
  align-items: center;
  gap: 8px;
}

/* ANIMASI TRANSISI BARU */
.section-transition {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.section-transition.active {
  opacity: 1;
  transform: translateY(0);
}

.fade-in {
  animation: fadeIn 0.5s ease forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.slide-up {
  animation: slideUp 0.5s ease forwards;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.pulse {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

/* Auth Modal Styles */
.modal-content input {
  width: 100%;
  padding: 12px;
  border: 1px solid var(--pink-2);
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s;
}

.modal-content input:focus {
  outline: none;
  border-color: var(--pink-3);
  box-shadow: 0 0 0 3px rgba(255, 111, 168, 0.1);
}

.modal-content .btn {
  margin-top: 8px;
}

/* User Control Styles */
#userControl {
  display: flex;
  align-items: center;
  gap: 12px;
}

#mobileUserControl {
  margin-bottom: 12px;
}

/* Cart Item Actions */
.cart-item-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.cart-item-actions .quantity-control {
  margin: 0 !important;
}

/* Enhanced Additional Options Styles */
.additional-options {
  margin: 20px 0;
  padding: 20px;
  background: linear-gradient(135deg, var(--pink-1), #fff);
  border-radius: 12px;
  border: 1px solid var(--pink-2);
}

.additional-options h4 {
  margin: 0 0 16px 0;
  font-family: "Playfair Display";
  font-size: 18px;
  color: var(--accent);
  display: flex;
  align-items: center;
  gap: 8px;
}

.additional-options h4::before {
  content: "✨";
  font-size: 16px;
}

.option-group {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.option-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 16px;
  background: white;
  border: 2px solid var(--pink-2);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
}

.option-item:hover {
  border-color: var(--pink-3);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 111, 168, 0.15);
}

.option-item.selected {
  border-color: var(--pink-3);
  background: linear-gradient(135deg, var(--pink-1), #fff);
  box-shadow: 0 4px 12px rgba(255, 111, 168, 0.2);
}

.option-checkbox {
  display: none;
}

.option-content {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.option-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: var(--pink-2);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: var(--accent);
  transition: all 0.3s ease;
}

.option-item.selected .option-icon {
  background: var(--pink-3);
  color: white;
}

.option-details {
  flex: 1;
}

.option-name {
  font-weight: 600;
  color: var(--accent);
  margin-bottom: 2px;
  font-size: 14px;
}

.option-price {
  font-size: 12px;
  color: var(--pink-3);
  font-weight: 700;
}

.option-checkmark {
  width: 20px;
  height: 20px;
  border: 2px solid var(--pink-2);
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.option-checkmark::after {
  content: "✓";
  color: white;
  font-size: 12px;
  font-weight: bold;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.option-item.selected .option-checkmark {
  background: var(--pink-3);
  border-color: var(--pink-3);
}

.option-item.selected .option-checkmark::after {
  opacity: 1;
}

/* Total Price Display */
.options-total {
  margin-top: 16px;
  padding: 12px 16px;
  background: white;
  border: 1px solid var(--pink-2);
  border-radius: 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 600;
}

.options-total-label {
  color: var(--muted);
  font-size: 14px;
}

.options-total-price {
  color: var(--pink-3);
  font-size: 16px;
}

.alert-error {
  background: #fee;
  color: #c33;
  padding: 12px 15px;
  border: 1px solid #fcc;
  border-radius: 5px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  animation: slideDown 0.3s ease;

  /* TAMBAHKAN INI: */
  position: relative;
  z-index: 1000; /* Nilai tinggi untuk memastikan di depan */
}

.login-container {
  background: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 400px;

  /* PASTIKAN INI: */
  position: relative;
  z-index: 1; /* Nilai lebih rendah dari notifikasi */
}

/* style.css */

.hero {
  /* Diperbesar dari 24px */
  padding: 40px 24px;

  /* Diperbesar dari 1fr 520px */
  grid-template-columns: 1fr 560px;

  /* Diperbesar dari 24px */
  gap: 32px;
}

.hero h1 {
  font-family: "Playfair Display";
  /* Diperbesar dari 44px */
  font-size: 56px;
  /* Diperbesar dari 8px */
  margin: 0 0 16px;
}

.hero p.lead {
  /* Ditambahkan ukuran font */
  font-size: 18px;
  /* Diperbesar dari 16px */
  margin: 0 0 24px;
}

.hero-left {
  /* Diperbesar dari 28px */
  padding: 50px;
}

.hero .btns {
  /* Diperbesar dari 12px */
  gap: 16px;
}

.featured-cake img {
  width: 100%;
  /* Diperbesar dari 300px */
  max-width: 350px;
  /* Diperbesar dari 250px */
  height: 300px;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 12px;
}

/* CSS BARU UNTUK ABOUT SECTION */
.about-content-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  align-items: center;
}

.about-team-photos {
  display: flex;
  gap: 15px;
  margin-top: 30px;
  flex-wrap: wrap;
  justify-content: center;
}

/* --- STYLE BARU UNTUK AUTH MODAL (LOGIN/REGISTER) --- */

.auth-modal-content {
  max-width: 400px; /* Ukuran modal yang lebih pas */
}

.auth-form-group {
  display: flex;
  flex-direction: column;
  gap: 15px; /* Jarak antar field */
}

.input-icon-group {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-group .icon {
  position: absolute;
  left: 12px;
  color: var(--pink-3);
  font-size: 18px;
  /* Mengatur tampilan ikon agar tidak mengganggu input */
  pointer-events: none;
}

/* Mengubah style input di dalam modal agar lebih rapih */
.auth-modal-content input[type="text"],
.auth-modal-content input[type="email"],
.auth-modal-content input[type="password"],
.auth-modal-content input[type="tel"] {
  width: 100%;
  padding: 14px 14px 14px 45px; /* Tambah padding kiri untuk ikon */
  border: 1px solid var(--pink-2);
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s;
  background-color: var(--pink-1); /* Sedikit warna latar belakang */
}

.auth-modal-content input:focus {
  outline: none;
  border-color: var(--pink-3);
  box-shadow: 0 0 0 2px rgba(255, 111, 168, 0.1);
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.form-options label {
  display: flex;
  align-items: center;
  color: var(--muted);
  cursor: pointer;
}

.form-options a {
  color: var(--pink-3);
  text-decoration: none;
  font-weight: 600;
}

.form-options a:hover {
  text-decoration: underline;
}

/* Mengatur ulang style tombol login/daftar di modal */
.modal-body .btn {
  margin-top: 0;
}

#menu {
  scroll-margin-top: 230px;
}

#about {
  scroll-margin-top: 230px;
}

#testimonials {
  scroll-margin-top: 280px;
}

#location {
  scroll-margin-top: 280px;
}
</style>