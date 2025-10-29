<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>C.ON.D</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Material Icons (لأيقونة البحث والإغلاق) -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

  <!-- ✅ CSS الخاص بزر البحث -->
  <style>
    .search-drawer {
      position: absolute;
      inset-inline: 0;
      top: 0;
      height: 64px;
      background: #8b50b0;
      transform: translateX(100%);
      transition: transform 0.35s ease;
      z-index: 1085;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .search-drawer.is-open { transform: translateX(0); }
    .search-inner {
      display: flex;
      align-items: center;
      gap: .75rem;
      width: 80%;
      max-width: 700px;
    }
    #in-search {
      flex: 1;
      height: 42px;
      background: #f5f5f5;
      border: none;
      border-radius: 12px;
      padding-inline: 15px;
      font-size: 1rem;
    }
    #in-search:focus { outline: none; background: #fff; }
    #search-submit {
      background: transparent;
      color: #fff;
      border: none;
      font-weight: bold;
    }
    #search-btn {
      background: transparent;
      border: none;
      color: #fff;
      font-size: 22px;
      cursor: pointer;
    }
    #search-close {
      background: transparent;
      border: none;
      color: #fff;
      font-size: 26px;
      cursor: pointer;
      position: absolute;
      left: 10px;
    }
    #overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.55);
      display: none;
      opacity: 0;
      transition: opacity .25s ease;
      z-index: 1080;
    }
    #overlay.is-visible { display: block; opacity: 1; }
  </style>
</head>
<body>
<div id="root"></div>

  <!-- ✅ Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">C.on.D</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item ms-3">
            <a class="nav-link position-relative" href="cart.php" id="cartLink">
              <i class="fa-solid fa-cart-shopping"></i>
              <span id="cart-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size: 0.65rem; padding: 4px 6px; display:none;">0</span>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link active" href="#hero">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="#portfolio">أعمالنا</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">خدماتنا</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">تواصل</a></li>

          <?php if (!empty($_SESSION['user_id'])): ?>
            <li class="nav-item ms-2"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
          <?php else: ?>
            <li class="nav-item ms-2"><a class="nav-link" href="login.php">تسجيل الدخول</a></li>
          <?php endif; ?>

          <!-- 🔍 زر البحث -->
          <li class="nav-item ms-3">
            <button id="search-btn" type="button"><span class="material-icons">search</span></button>
          </li>
        </ul>
      </div>

      <!-- 🟣 درج البحث -->
      <div class="search-drawer" id="nav-search">
        <button id="search-close" type="button"><span class="material-icons">clear</span></button>
        <div class="search-inner">
          <form id="search-form" class="w-100 d-flex" onsubmit="return false;">
            <input id="in-search" type="text" placeholder="ابحث عن خدمة..." autocomplete="off">
            <button id="search-submit" type="submit">بحث</button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <div id="overlay"></div>

  <!-- باقي محتوى صفحتك يبقى كما هو -->
  <div class="hero_section" id="hero" style="margin-top:56px;">
    <video autoplay muted loop id="background-video">
      <source src="images/herosection.mp4" type="video/mp4">
    </video>
    <div class="hero_text text-center text-white position-absolute top-50 start-50 translate-middle">
      <h2>Welcome to C.on.D</h2>
      <h3>Event and More</h3>
      <p>We are here to provide you with the best services.</p>
      <a href="#services" class="btn btn-primary">اكتشف خدماتنا</a>
    </div>
  </div>

  <!-- ✅ سكريبت Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ✅ سكريبت تفعيل البحث -->
  <script>
    const drawer  = document.getElementById('nav-search');
    const overlay = document.getElementById('overlay');
    const btnOpen = document.getElementById('search-btn');
    const btnClose= document.getElementById('search-close');
    const input   = document.getElementById('in-search');

    function openSearch(){
      drawer.classList.add('is-open');
      overlay.classList.add('is-visible');
      input.focus();
    }
    function closeSearch(){
      drawer.classList.remove('is-open');
      overlay.classList.remove('is-visible');
    }

    btnOpen.addEventListener('click', openSearch);
    btnClose.addEventListener('click', closeSearch);
    overlay.addEventListener('click', closeSearch);
    document.addEventListener('keydown', e => { if(e.key === 'Escape') closeSearch(); });
  </script>

</body>
</html>
