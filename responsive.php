<style>
/* Tablet (768px - 900px) */
@media (max-width: 900px) and (min-width: 768px) {
  .hero {
    grid-template-columns: 1fr;
    gap: 24px;
    padding: 25px 24px;
  }

  .hero h1 {
    font-size: 42px;
    text-align: center;
  }

  .hero p.lead {
    text-align: center;
    font-size: 16px;
  }

  .hero .btns {
    justify-content: center;
  }

  .hero-left {
    padding: 32px;
    text-align: center;
  }

  .hero-right {
    display: flex;
    justify-content: center;
  }

  .featured-cake img {
    max-width: 400px;
    height: 280px;
  }

  .gallery {
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }

  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Mobile Large (360px - 800px) */
@media (max-width: 800px) and (min-width: 360px) {
  header {
    padding: 10px 16px;
  }

  .hero {
    grid-template-columns: 1fr;
    gap: 20px;
    padding: 24px 16px;
  }

  .hero h1 {
    font-size: 36px;
    line-height: 1.2;
    margin: 0 0 12px;
  }

  .hero p.lead {
    font-size: 15px;
    margin: 0 0 20px;
  }

  .hero-left {
    padding: 24px;
  }

  .hero .btns {
    flex-direction: column;
    gap: 12px;
  }

  .btn {
    width: 100%;
    padding: 14px 18px;
  }

  .featured-cake img {
    max-width: 100%;
    height: 220px;
  }

  nav {
    display: none;
  }

  .mobile-menu-btn {
    display: block;
  }

  .mobile-nav {
    display: block;
  }

  .cake-character {
    width: 70px;
    height: 70px;
    bottom: 20px;
    right: 20px;
  }

  .gallery {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 16px;
  }

  .product img {
    height: 160px;
  }

  .brand-name {
    font-size: 20px;
  }

  .brand-tagline {
    font-size: 10px;
  }

  .logo {
    width: 50px;
    height: 50px;
  }

  .testimonial-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }

  .contact-info {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .modal-content {
    margin: 16px;
    max-height: 90vh;
  }

  .cart-item {
    flex-direction: column;
    gap: 12px;
  }

  .cart-item img {
    width: 100%;
    height: 140px;
  }

  .cart-item-actions {
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
  }

  /* Penyesuaian khusus untuk halaman About */
  .about-content-grid {
    grid-template-columns: 1fr; /* Tumpuk menjadi 1 kolom di HP */
    gap: 30px;
  }

  /* Ini akan meratakan teks ke kiri di kolom kiri section About */
  .about-content-grid > div:first-child {
    text-align: left;
  }

  #menu {
    scroll-margin-top: 200px;
  }

  #about {
    scroll-margin-top: 180px;
  }

  #testimonials {
    scroll-margin-top: 130px;
  }

  #location {
    scroll-margin-top: 280px;
  }
}
</style>