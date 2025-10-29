<?php
/***********************
 * orders.php — صفحة تتبع الطلبات:
 * - GET: تعرض طلبات المستخدم المسجل
 ***********************/

// إعدادات قاعدة البيانات
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "product_database";

// دالة عرض الطلبات للمستخدم
function display_orders($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
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

  // جلب الطلبات الخاصة بالمستخدم
  $sql = "SELECT * FROM cart_items WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Prepare failed", "details" => $conn->error]);
    exit;
  }

  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  $orders = [];
  while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
  }

  $stmt->close();
  $conn->close();

  return $orders;
}

// عرض الصفحة
$orders = display_orders($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تتبع الطلبات | C.ON.D</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    body { font-family: "Tajawal", Arial, sans-serif; background:#f7f7f7; padding-top:90px; padding-bottom:110px; }
    header { position:fixed; top:0; left:0; right:0; background:#222; color:#fff; z-index:999; box-shadow:0 3px 10px rgba(0,0,0,.3); }
    header .container { display:flex; align-items:center; justify-content:space-between; padding:15px 0; }
    header a { color:#fff; text-decoration:none; font-weight:bold; font-size:1.1rem; }
    .orders-container { max-width:960px; margin:auto; background:#fff; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.08); padding:25px; }
    .order-item { display:flex; align-items:center; gap:12px; border-bottom:1px solid #eee; padding:12px 0; }
    .order-item img { width:80px; height:70px; object-fit:cover; border-radius:10px; }
    .order-item .info { flex:1; margin-inline:8px; }
    .order-item .info h5 { margin:0 0 4px; font-size:1rem; }
    .order-item .info .small > div { line-height:1.5; }
    .price { min-width:120px; text-align:center; font-weight:700; }
    footer { position:fixed; bottom:0; left:0; right:0; background:#222; color:#fff; text-align:center; padding:10px; font-size:0.9rem; }
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

  <!-- 🛍 محتوى الطلبات -->
  <div class="orders-container">
    <h4 class="mb-4"><i class="fa-solid fa-bag-shopping me-2"></i> طلباتك</h4>

    <?php if (count($orders) > 0): ?>
      <div id="orderList">
        <?php foreach ($orders as $order): ?>
          <div class="order-item">
            <img src="images/placeholder.jpg" alt="<?= $order['name'] ?>">
            <div class="info">
              <h5 class="mb-1"><?= $order['name'] ?></h5>
              <div class="small text-muted">
                <div>السعر: <?= $order['price'] ?> ر.س</div>
                <div>الاسم: <?= $order['full_name'] ?></div>
                <div>البريد: <?= $order['email'] ?></div>
                <div>الجوال: <?= $order['phone'] ?></div>
                <div>تاريخ الحدث: <?= $order['event_date'] ?></div>
                <div>ملاحظات: <?= $order['notes'] ?></div>
              </div>
            </div>
            <div class="price"><?= $order['price'] ?> ر.س</div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center text-muted mt-4">
        🛒 لا توجد طلبات حالياً.
      </div>
    <?php endif; ?>
  </div>

  <footer>
    © 2025 C.ON.D | جميع الحقوق محفوظة
  </footer>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
