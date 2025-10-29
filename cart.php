<?php
/***********************
 * cart.php — صفحة واحدة:
 * - GET: تعرض صفحة السلة (HTML/JS/CSS)
 * - POST (JSON): تحفظ عناصر السلة في MySQL وتُرجع JSON
 ***********************/

// إعدادات قاعدة البيانات
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "product_database";

/**
 * دالة حفظ العناصر في DB (تُستدعى عند POST فقط)
 */
function save_cart_items_and_respond($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
  header("Content-Type: application/json; charset=UTF-8");

  // قراءة JSON
  $raw = file_get_contents("php://input");
  $data = json_decode($raw, true);

  // التأكد من أن البيانات صحيحة
  if (!is_array($data) || !isset($data["items"]) || !is_array($data["items"]) || !count($data["items"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid payload. Expecting { items: [...] }"]);
    exit;
  }

  // التحقق من أن المستخدم مسجل في الجلسة
  session_start();
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

  if ($user_id === null) {
    http_response_code(400);
    echo json_encode(["error" => "User not logged in"]);
    exit;
  }

  // الاتصال بقاعدة البيانات
  $conn = @new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS'], $GLOBALS['DB_NAME']);
  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
  }
  $conn->set_charset("utf8mb4");

  // إنشاء الجدول إن لم يكن موجودًا
  $createSql = "
  CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    price_label VARCHAR(255) DEFAULT NULL,
    type ENUM('service','addon') DEFAULT 'addon',
    full_name VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    event_date VARCHAR(50) DEFAULT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ";
  if (!$conn->query($createSql)) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to ensure table", "details" => $conn->error]);
    exit;
  }

  // تحضير جملة الإدراج مع إضافة user_id
  $sql = "
    INSERT INTO cart_items
    (name, price, price_label, type, full_name, email, phone, event_date, notes, user_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Prepare failed", "details" => $conn->error]);
    exit;
  }

  // تنفيذ داخل معاملة
  $conn->begin_transaction();
  $inserted = 0;

  try {
    foreach ($data["items"] as $item) {
      $name        = isset($item["name"])       ? trim((string)$item["name"])       : "";
      $price       = (isset($item["price"]) && $item["price"] !== "" && $item["price"] !== null && is_numeric($item["price"]))
                     ? (float)$item["price"] : null;
      $priceLabel  = isset($item["priceLabel"]) ? trim((string)$item["priceLabel"]) : null;
      $type        = (isset($item["type"]) && $item["type"] === "service") ? "service" : "addon";
      $fullName    = isset($item["fullName"])   ? trim((string)$item["fullName"])   : null;
      $email       = isset($item["email"])      ? trim((string)$item["email"])      : null;
      $phone       = isset($item["phone"])      ? trim((string)$item["phone"])      : null;
      $eventDate   = isset($item["eventDate"])  ? trim((string)$item["eventDate"])  : null;
      $notes       = isset($item["notes"])      ? trim((string)$item["notes"])      : null;

      if ($name === "") continue;

      $stmt->bind_param("sdsssssssi",
        $name, $price, $priceLabel, $type, $fullName, $email, $phone, $eventDate, $notes, $user_id
      );

      if (!$stmt->execute()) {
        throw new Exception("Insert failed: " . $stmt->error);
      }
      $inserted++;
    }

    $conn->commit();
    echo json_encode(["success" => true, "inserted" => $inserted]);

  } catch (Throwable $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => "Transaction failed", "details" => $e->getMessage()]);
  } finally {
    $stmt->close();
    $conn->close();
  }

  exit;
}

// إذا كان POST بتنسيق JSON: نفّذ الحفظ وارجع JSON فقط (بدون HTML)
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_SERVER['CONTENT_TYPE'])
    && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
  save_cart_items_and_respond($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  // exit في الدالة
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>سلة الحجز | C.ON.D</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    body { font-family: "Tajawal", Arial, sans-serif; background:#f7f7f7; padding-top:90px; padding-bottom:110px; }
    header { position:fixed; top:0; left:0; right:0; background:#222; color:#fff; z-index:999; box-shadow:0 3px 10px rgba(0,0,0,.3); }
    header .container { display:flex; align-items:center; justify-content:space-between; padding:15px 0; }
    header a { color:#fff; text-decoration:none; font-weight:bold; font-size:1.1rem; }
    .cart-container { max-width:960px; margin:auto; background:#fff; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.08); padding:25px; }
    .cart-item { display:flex; align-items:center; gap:12px; border-bottom:1px solid #eee; padding:12px 0; }
    .cart-item img { width:80px; height:70px; object-fit:cover; border-radius:10px; }
    .cart-item .info { flex:1; margin-inline:8px; }
    .cart-item .info h5 { margin:0 0 4px; font-size:1rem; }
    .cart-item .info .small > div { line-height:1.5; }
    .price { min-width:120px; text-align:center; font-weight:700; }
    .checkout-btn { background:#750303; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-weight:bold; }
    footer { position:fixed; bottom:0; left:0; right:0; background:#222; color:#fff; text-align:center; padding:10px; font-size:0.9rem; }
    .upsell-card { display:flex; align-items:center; gap:12px; padding:10px; border:1px solid #eaeaea; border-radius:12px; width:300px; background:#fff; box-shadow:0 2px 10px rgba(0,0,0,.04); }
    .upsell-card img { width:56px; height:56px; object-fit:cover; border-radius:8px; }
    .btn-plus { border-radius:10px; }
  </style>
</head>
<body>

  <!-- 🔝 الهيدر -->
  <header>
    <div class="container">
      <a href="index.html">C.ON.D</a>
      <a href="cart.php" class="position-relative">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="display:none">0</span>
      </a>
    </div>
  </header>

  <!-- 🛍 محتوى السلة -->
  <div class="cart-container">
    <!-- 🔹 مقترحات تسويقية (+) -->
    <div id="upsell" class="mb-4" style="display:none;">
      <h5 class="mb-3">قد يعجبك أيضًا</h5>
      <div class="d-flex flex-wrap gap-3"></div>
    </div>

    <h4 class="mb-4"><i class="fa-solid fa-bag-shopping me-2"></i> سلة الحجز</h4>
    <div id="cartList"></div>

    <div id="cartSummary" class="d-flex justify-content-between align-items-center mt-4" style="display:none;">
      <h5 class="mb-0">الإجمالي الكلي: <span id="cartTotal">0 ر.س</span></h5>
      <button id="checkoutBtn" class="checkout-btn">إتمام الحجز</button>
    </div>

    <div id="emptyCart" class="text-center text-muted mt-4" style="display:none;">
      🛒 السلة فارغة حاليًا
    </div>
  </div>

  <footer>
    © 2025 C.ON.D | جميع الحقوق محفوظة
  </footer>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- 🧠 سكربت إدارة السلة -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const STORAGE_KEY = 'cond_cart';
    const cartList = document.getElementById('cartList');
    const cartSummary = document.getElementById('cartSummary');
    const emptyCart = document.getElementById('emptyCart');
    const cartTotal = document.getElementById('cartTotal');
    const cartCount = document.getElementById('cart-count');
    const checkoutBtn = document.getElementById('checkoutBtn');

    const upsellWrap = document.querySelector('#upsell');
    const upsellContainer = upsellWrap?.querySelector('.d-flex');

    const getCart = () => {
      try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); }
      catch { return []; }
    };
    const setCart = (items) => localStorage.setItem(STORAGE_KEY, JSON.stringify(items));

    // تنسيق السعر
    const fmt = (n, label) => {
      if (label) return label; // "حسب الاتفاق" للخدمات
      if (n === null || n === undefined || isNaN(Number(n))) return '—';
      return (Number(n) || 0).toFixed(2) + ' ر.س';
    };

    // تحديث شارة العربة في الهيدر
    function updateBadge(items) {
      const count = items.length;
      cartCount.textContent = count;
      cartCount.style.display = count > 0 ? 'inline-block' : 'none';
    }

    // 🔹 عناصر المقترحات (٣ منتجات)
    const suggestedItems = [
      { id: 'add1', name: 'مسكات عروس', price: 180, thumb: 'images/wrd.png', type: 'addon' },
      { id: 'add2', name: 'كورنر استقبال وعطورات', price: 250, thumb: 'images/cornr.png', type: 'addon' },
      { id: 'add3', name: 'تصوير لحظي (زفات)', price: 350, thumb: 'images/ph.png', type: 'addon' },
    ];

    function renderUpsell() {
      if (!upsellWrap || !upsellContainer) return;
      upsellContainer.innerHTML = '';
      suggestedItems.forEach(item => {
        const card = document.createElement('div');
        card.className = 'upsell-card';
        card.innerHTML = `
          <img src="${item.thumb}" alt="${item.name}">
          <div class="me-auto">
            <div class="fw-bold" style="font-size:.95rem">${item.name}</div>
            <small class="text-muted">${fmt(item.price)}</small>
          </div>
          <button class="btn btn-sm btn-outline-primary btn-plus" data-add="${item.id}" title="أضف للعربة">
            <i class="fa-solid fa-plus"></i>
          </button>
        `;
        card.querySelector('[data-add]').onclick = () => {
          const cart = getCart();
          cart.push({
            name: item.name,
            price: item.price,
            priceLabel: null,
            thumb: item.thumb,
            fullName: null, email: null, phone: null, eventDate: null, notes: null,
            type: item.type
          });
          setCart(cart);
          render();
        };
        upsellContainer.appendChild(card);
      });
    }

    function render() {
      const cart = getCart();
      cartList.innerHTML = '';

      if (cart.length === 0) {
        emptyCart.style.display = 'block';
        cartSummary.style.display = 'none';
        if (upsellWrap) upsellWrap.style.display = 'none';
        updateBadge(cart);
        return;
      }

      emptyCart.style.display = 'none';
      cartSummary.style.display = 'flex';
      if (upsellWrap) upsellWrap.style.display = 'block';

      let total = 0;
      let hasPriced = false;

      cart.forEach((item, index) => {
        const numeric = Number(item.price);
        const line = isNaN(numeric) ? null : numeric;
        if (line !== null) { total += line; hasPriced = true; }

        const row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML = `
          <img src="${item.thumb || 'images/placeholder.jpg'}" alt="${item.name}">
          <div class="info">
            <h5 class="mb-1">${item.name}</h5>
            ${item.type === 'service' ? `
              <div class="small text-muted">
                <div>السعر: <span class="badge bg-secondary">${item.priceLabel || '—'}</span></div>
                <div>الاسم: ${item.fullName || '—'}</div>
                <div>البريد: ${item.email || '—'}</div>
                <div>الجوال: ${item.phone || '—'}</div>
                <div>تاريخ الحدث: ${item.eventDate || '—'}</div>
                <div>ملاحظات: ${item.notes || '—'}</div>
              </div>
            ` : `
              <div class="small text-muted">السعر: ${fmt(item.price)}</div>
            `}
          </div>
          <div class="price">${fmt(line, item.priceLabel)}</div>
          <button class="btn btn-link text-danger p-0" data-act="del" title="حذف">
            <i class="fa-solid fa-trash-can"></i>
          </button>
        `;

        row.querySelector('[data-act="del"]').onclick = () => {
          const c = getCart();
          c.splice(index, 1);
          setCart(c);
          render();
        };

        cartList.appendChild(row);
      });

      cartTotal.textContent = hasPriced ? fmt(total) : 'سيتم تحديد السعر';
      updateBadge(cart);
      renderUpsell();
    }

    // ✅ إرسال إلى نفس الصفحة (cart.php) عند التأكيد — تخزين فقط
    checkoutBtn.onclick = () => {
      const items = getCart();
      if (!items.length) return;
      const ok = confirm('هل تريد تأكيد الحجز وإرساله؟');
      if (!ok) return;

      fetch(window.location.href, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ items })
      })
      .then(r => r.json())
      .then(d => {
        if (d && d.success) {
          alert(`✨ تم حفظ الحجز في قاعدة البيانات! تم إدراج ${d.inserted} عنصر(عناصر).`);
          localStorage.removeItem('cond_cart');
          render();
        } else {
          alert('❌ حدث خطأ أثناء الحفظ في قاعدة البيانات');
        }
      })
      .catch(err => {
        console.error(err);
        alert('⚠️ فشل الاتصال بالخادم');
      });
    };

    // أول تحميل
    render();
  });
  </script>
</body>
</html>
