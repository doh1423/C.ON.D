<?php
include "db.php";

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$hashPassword')";

    if ($conn->query($sql)) {
 header("Location: http://localhost/Page-master/Page-master/hash/login.php"); // المسار الصحيح
        exit();
    
    } else {
        echo "Error: " . $conn->error;
    }

} else {

}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التسجيل</title>
    <style>
        body {
            font-family: Arial, sans-serif;
             background: linear-gradient(to bottom right, #1D4350, #A43931);
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.8); /* حقل تسجيل شفاف */
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
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #40207cff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #260564ff;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>التسجيل</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول.</div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="singup.php" method="POST">
            <label for="username">اسم المستخدم:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES); ?>" required>

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>" required>

            <label for="password">كلمة المرور:</label>
            <input type="password" name="password" required>

            <button type="submit">تسجيل</button>
        </form>
    </div>
</body>
</html>
