<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Find user by email
    $stmt = mysqli_prepare($conn, 
        "SELECT users.*, roles.role_name 
         FROM users 
         JOIN roles ON users.role_id = roles.id 
         WHERE users.email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Password correct — save to session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email']= $user['email'];
        $_SESSION['role']      = $user['role_id'];
        $_SESSION['role_name'] = $user['role_name'];

        // Redirect based on role
        if ($user['role_id'] == 1) {
            header("Location: dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 10px; width: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        label { font-size: 13px; color: #555; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { border-color: #2196F3; outline: none; }
        button { width: 100%; padding: 12px; background: #2196F3; color: white; border: none; border-radius: 5px; font-size: 15px; cursor: pointer; }
        button:hover { background: #1976D2; }
        .message { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; background: #f8d7da; color: #721c24; }
        .register-link { text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
<div class="card">
    <h2>🔐 Login</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Email Address</label>
        <input type="email" name="email" 
               placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" 
               placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</div>
</body>
</html>