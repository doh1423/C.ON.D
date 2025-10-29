<?php
// تأكد من تفعيل الجلسة قبل أي مخرجات
session_start();
include("db.php");

// استرجاع بيانات المستخدم إذا كان قد سجل الدخول
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // استعلام لجلب البيانات من قاعدة البيانات بدون صورة الملف الشخصي
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
} else {
    // إذا لم يكن المستخدم قد سجل الدخول، إعادة التوجيه إلى صفحة تسجيل الدخول
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الملف الشخصي</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
   .profile-card {
    background: #f7f7f7; /* خلفية فاتحة للكارد */
    width: 250px;
    height: 400px;
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 2;
    transform: translate(-50%, -50%);
    border-radius: 15px; /* جعل الزوايا أكثر انحناء */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* تأثير الظل الجذاب */
    opacity: 0;
    animation: fadeIn 1s forwards;
    overflow: hidden;
}

.profile-card header {
    width: 100%;
    padding: 20px;
    background: #e91e63; /* خلفية وردية للكارد */
    text-align: center;
    border-bottom: 3px solid #ffffff; /* إضافة خط أبيض تحت العنوان */
    border-top-left-radius: 15px; /* انحناء الزوايا */
    border-top-right-radius: 15px; /* انحناء الزوايا */
}

.profile-card h1 {
    color: white; /* تغيير لون النص إلى الأبيض */
    margin-top: 10px;
}

.profile-bio {
    padding: 20px;
    background: #ffffff; /* خلفية بيضاء للفاصل بين العنوان والمحتوى */
    color: #333333; /* اللون الرصاصي الداكن للنص */
    text-align: center;
}

.social-links {
    padding: 20px;
    background: #ffffff;
    text-align: center;
}

.social-links li {
    display: inline-block;
    margin: 0 10px;
}

.social-links li a {
    font-size: 20px;
    color: #e91e63; /* اللون الوردي */
    text-decoration: none;
    transition: color 0.3s ease;
}

.social-links li a:hover {
    color: #333333; /* تغيير اللون إلى اللون الداكن عند التمرير */
}

/* تأثيرات التحميل */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.5);
    }
    100% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

  </style>
</head>

<body>
  <div class="profile-card">
    <header>
      <!-- عرض اسم المستخدم فقط -->
      <h1><?php echo htmlspecialchars($username); ?></h1>
    </header>
    <div class="profile-bio">
      <p>مرحبًا بك في صفحة بروفايلك!</p>
    </div>
    <ul class="social-links">
      <!-- روابط الشبكات الاجتماعية، يتم إخفائها أو تعطيلها إذا لم تكن بياناتها موجودة -->
      <li><a target="_blank" href="https://www.facebook.com/<?php echo htmlspecialchars($username); ?>"><i class="fa fa-facebook"></i></a></li>
      <li><a target="_blank" href="https://twitter.com/<?php echo htmlspecialchars($username); ?>"><i class="fa fa-twitter"></i></a></li>
      <li><a target="_blank" href="https://github.com/<?php echo htmlspecialchars($username); ?>"><i class="fa fa-github"></i></a></li>
      <li><a target="_blank" href="https://www.behance.net/<?php echo htmlspecialchars($username); ?>"><i class="fa fa-behance"></i></a></li>
    </ul>
  </div>
</body>
</html>
