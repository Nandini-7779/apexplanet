<?php
include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Email already exists!";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role_id  = $_POST['role_id'];

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $password, $role_id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "User added successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .message { padding: 10px; background: #d4edda; color: #155724; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h2>Add New User</h2>

    <?php if ($message): ?>
        <div class="message <?= strpos($message,'Error') !== false || strpos($message,'exists') !== false ? 'error' : '' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text"     name="name"     placeholder="Full Name"  required>
        <input type="email"    name="email"    placeholder="Email"      required>
        <input type="password" name="password" placeholder="Password"   required>
        <select name="role_id">
            <option value="2">User</option>
            <option value="1">Admin</option>
        </select>
        <button type="submit">Add User</button>
    </form>

    <br>
    <a href="index.php">← Back to User List</a>
</body>
</html>