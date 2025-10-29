<?php
// ✅ تفعيل الجلسات قبل أي مخرجات
session_start();
include("db.php");




$error_message = '';

// معالجة نموذج تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    // تنظيف مدخلات أساسية
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // استعلام للتحقق من وجود المستخدم (باستخدام Prepared Statements)
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ? LIMIT 1");
    if ($stmt === false) {
        $error_message = "خطأ داخلي في النظام.";
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // إذا كان هناك مستخدم بهذا البريد
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($uid, $uname, $uemail, $hashedPassword);
            $stmt->fetch();

            // التحقق من كلمة المرور
            if (password_verify($password, $hashedPassword)) {
                // ✅ نجاح: خزّن بيانات الجلسة
                $_SESSION['user_id']  = (int)$uid;
                $_SESSION['username'] = $uname;
                $_SESSION['email']    = $uemail;

                // إعادة التوجيه إلى الصفحة المطلوبة (عدّل حسب رغبتك)
                header("Location: cond.php");
                exit();
            } else {
                $error_message = "كلمة المرور غير صحيحة.";
            }
        } else {
            $error_message = "لا يوجد مستخدم بهذا البريد الإلكتروني.";
        }

        $stmt->close();
    }
}

// يمكن إغلاق الاتصال الآن
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <?php if (!empty($_SESSION['user_id'])): ?>
  <a href="logout.php">تسجيل الخروج</a>
<?php else: ?>
  <a href="login.php">. </a> | <a href="signup.php">.</a>
<?php endif; ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
         background: linear-gradient(to bottom right, #1D4350, #A43931);

            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            min-height: 100vh;

            /* محاذاة وسط الصفحة */
            display: flex;
            justify-content: center;
            align-items: center;

            color: #333;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.7); /* شفاف بنسبة 70% */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #777;
            text-align: right;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color:  #40207cff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color:  #260564ff;
        }

        .error-message {
            color: #b30000;
            margin-bottom: 15px;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ffcccc;
        }

        .sign-up-link {
            display: inline-block;
            margin-top: 12px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .sign-up-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>تسجيل الدخول</h2>

        <!-- عرض رسالة الخطأ إن وجدت -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message, ENT_QUOTES); ?></div>
        <?php endif; ?>

        <!-- نموذج تسجيل الدخول -->
        <form action="login.php" method="POST" novalidate>
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" name="email" id="email" required placeholder="name@example.com"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : '';?>">

            <label for="password">كلمة المرور:</label>
            <input type="password" name="password" id="password" required placeholder="********">

            <button type="submit">دخول</button>
        </form>

        <!-- رابط صفحة التسجيل (تأكد من اسم الملف لديك: signup.php أو singup.php) -->
        <a href="singup.php" class="sign-up-link">ليس لديك حساب؟ سجّل الآن</a>
    
    </div>
</body>
</html>
