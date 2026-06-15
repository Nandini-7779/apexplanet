<?php
session_start();
include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm) {
        $message = "Passwords do not match!";
    }
    // Validate password length
    elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, 
            "SELECT id FROM users WHERE email='$email'");
        
        if (mysqli_num_rows($check) > 0) {
            $message = "Email already registered!";
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert user with role 2 (regular user)
            $stmt = mysqli_prepare($conn,
                "INSERT INTO users (name, email, password, role_id) 
                 VALUES (?, ?, ?, 2)");
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 10px; width: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        label { font-size: 13px; color: #555; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { border-color: #4CAF50; outline: none; }
        button { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 15px; cursor: pointer; }
        button:hover { background: #45a049; }
        .message { padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .login-link { text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
<div class="card">
    <h2>📝 Create Account</h2>

    <?php if ($message): ?>
        <div class="message <?= strpos($message,'Error') !== false || strpos($message,'match') !== false || strpos($message,'least') !== false || strpos($message,'registered') !== false ? 'error' : '' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Email Address</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Min 6 characters" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Repeat password" required>

        <button type="submit">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>
</body>
</html>