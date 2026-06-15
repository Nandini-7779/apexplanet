<?php
session_start();

// Protect this page — must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; background: #f0f2f5; margin: 0; }
        .navbar { background: #2196F3; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { color: white; margin: 0; font-size: 20px; }
        .navbar a { color: white; text-decoration: none; padding: 8px 15px; background: rgba(255,255,255,0.2); border-radius: 5px; }
        .navbar a:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .welcome-card { background: white; padding: 30px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .welcome-card h2 { margin: 0 0 10px; color: #333; }
        .welcome-card p { color: #666; margin: 5px 0; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .badge-admin { background: #ff9800; color: white; }
        .badge-user  { background: #2196F3; color: white; }
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-decoration: none; color: #333; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .card .icon { font-size: 40px; margin-bottom: 10px; }
        .card h3 { margin: 0 0 5px; }
        .card p { color: #666; font-size: 13px; margin: 0; }
    </style>
</head>
<body>

<div class="navbar">
    <h1>🏠 My Dashboard</h1>
    <div>
        <span style="color:white; margin-right:15px">
            👤 <?= htmlspecialchars($_SESSION['user_name']) ?>
        </span>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="welcome-card">
        <h2>Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?>! 👋</h2>
        <p>Email: <?= htmlspecialchars($_SESSION['user_email']) ?></p>
        <p>Role: 
            <span class="badge badge-<?= $_SESSION['role_name'] ?>">
                <?= ucfirst($_SESSION['role_name']) ?>
            </span>
        </p>
    </div>

    <div class="cards">
        <a class="card" href="index.php">
            <div class="icon">👥</div>
            <h3>Manage Users</h3>
            <p>View, edit and delete users</p>
        </a>

        <a class="card" href="add_user.php">
            <div class="icon">➕</div>
            <h3>Add User</h3>
            <p>Create a new user account</p>
        </a>

        <a class="card" href="profile.php">
            <div class="icon">👤</div>
            <h3>My Profile</h3>
            <p>Edit your profile & photo</p>
        </a>
    </div>
</div>

</body>
</html>