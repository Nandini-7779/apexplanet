<?php
include 'config.php';

$message = "";
$id = $_GET['id'];

// Fetch current user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user   = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found!");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $role_id = $_POST['role_id'];

    // Check if email exists for OTHER users
    $check = mysqli_query($conn, 
        "SELECT id FROM users WHERE email='$email' AND id != $id");
    
    if (mysqli_num_rows($check) > 0) {
        $message = "Email already used by another user!";
    } else {
        // Update without changing password
        $stmt = mysqli_prepare($conn,
            "UPDATE users SET name=?, email=?, role_id=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssii", $name, $email, $role_id, $id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "User updated successfully!";
            // Refresh user data
            $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
            $user   = mysqli_fetch_assoc($result);
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { padding: 10px 20px; background: #2196F3; color: white; border: none; cursor: pointer; border-radius: 4px; }
        button:hover { background: #1976D2; }
        .message { padding: 10px; background: #d4edda; color: #155724; margin: 10px 0; border-radius: 4px; }
        .error { background: #f8d7da; color: #721c24; }
        a { color: #2196F3; }
    </style>
</head>
<body>
    <h2>✏️ Edit User</h2>

    <?php if ($message): ?>
        <div class="message <?= strpos($message,'Error') !== false || strpos($message,'used') !== false ? 'error' : '' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" 
               value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" 
               value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Role</label>
        <select name="role_id">
            <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
            <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
        </select>

        <br><br>
        <button type="submit">Update User</button>
        <a href="index.php" style="margin-left:15px">← Cancel</a>
    </form>
</body>
</html>