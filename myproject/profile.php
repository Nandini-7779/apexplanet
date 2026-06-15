<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$user_id  = $_SESSION['user_id'];
$msg_type = "";
$msg_text = "";

// Fetch user
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
$user   = mysqli_fetch_assoc($result);

// Update profile
if (isset($_POST['update_profile'])) {
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    $stmt = mysqli_prepare($conn,
        "UPDATE users SET name=?, email=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $msg_type = "success";
        $msg_text = "Profile updated successfully!";
        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;
        $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
        $user   = mysqli_fetch_assoc($result);
    } else {
        $msg_type = "error";
        $msg_text = "Update failed!";
    }
}

// Upload photo
if (isset($_POST['upload_photo'])) {
    if ($_FILES['photo']['error'] == 0) {
        $allowed  = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024;

        if (!in_array($_FILES['photo']['type'], $allowed)) {
            $msg_type = "error";
            $msg_text = "Only JPG PNG GIF allowed!";
        } elseif ($_FILES['photo']['size'] > $max_size) {
            $msg_type = "error";
            $msg_text = "Max size is 2MB!";
        } else {
            $ext      = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename = "user_" . $user_id . "_" . time() . "." . $ext;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $filename)) {
                $stmt = mysqli_prepare($conn, "UPDATE users SET photo=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "si", $filename, $user_id);
                mysqli_stmt_execute($stmt);
                $msg_type = "success";
                $msg_text = "Photo uploaded!";
                $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
                $user   = mysqli_fetch_assoc($result);
            } else {
                $msg_type = "error";
                $msg_text = "Upload failed! Check uploads folder exists.";
            }
        }
    } else {
        $msg_type = "error";
        $msg_text = "Please select a file!";
    }
}

// Change password
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (!password_verify($current, $user['password'])) {
        $msg_type = "error";
        $msg_text = "Current password is wrong!";
    } elseif ($new !== $confirm) {
        $msg_type = "error";
        $msg_text = "New passwords do not match!";
    } elseif (strlen($new) < 6) {
        $msg_type = "error";
        $msg_text = "Password must be at least 6 characters!";
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt   = mysqli_prepare($conn, "UPDATE users SET password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "si", $hashed, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $msg_type = "success";
            $msg_text = "Password changed successfully!";
        } else {
            $msg_type = "error";
            $msg_text = "Password change failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial; background: #f0f2f5; }
        .navbar { background: #2196F3; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { color: white; font-size: 20px; }
        .navbar a { color: white; text-decoration: none; padding: 8px 15px; background: rgba(255,255,255,0.2); border-radius: 5px; margin-left: 10px; }
        .container { max-width: 700px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #ddd; }
        .card h3 { margin-bottom: 20px; color: #333; padding-bottom: 10px; border-bottom: 2px solid #f0f2f5; }
        label { font-size: 13px; color: #555; display: block; margin-bottom: 5px; }
        input[type=text], input[type=email], input[type=password] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn { padding: 10px 25px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; color: white; }
        .btn-blue  { background: #2196F3; }
        .btn-green { background: #4CAF50; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .error   { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .photo-wrap { display: flex; align-items: center; gap: 20px; margin-bottom: 15px; }
        .photo-circle { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #2196F3; }
        .photo-placeholder { width: 90px; height: 90px; border-radius: 50%; background: #e0e0e0; display: flex; align-items: center; justify-content: center; font-size: 36px; }
        .file-box { border: 2px dashed #ddd; padding: 12px; border-radius: 5px; margin-bottom: 12px; }
    </style>
</head>
<body>

<div class="navbar">
    <h1>My Profile</h1>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

<?php if ($msg_text): ?>
    <div class="<?= $msg_type ?>">
        <?= htmlspecialchars($msg_text) ?>
    </div>
<?php endif; ?>

<!-- Photo Card -->
<div class="card">
    <h3>Profile Photo</h3>
    <div class="photo-wrap">
        <?php if (!empty($user['photo']) && file_exists("uploads/" . $user['photo'])): ?>
            <img src="uploads/<?= $user['photo'] ?>" class="photo-circle">
        <?php else: ?>
            <div class="photo-placeholder">👤</div>
        <?php endif; ?>
        <p style="color:#666; font-size:13px;">JPG, PNG or GIF — Max 2MB</p>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="file-box">
            <input type="file" name="photo" accept="image/*">
        </div>
        <button type="submit" name="upload_photo" class="btn btn-green">
            Upload Photo
        </button>
    </form>
</div>

<!-- Edit Profile Card -->
<div class="card">
    <h3>Edit Profile</h3>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($user['name']) ?>">

        <label>Email Address</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($user['email']) ?>">

        <button type="submit" name="update_profile" class="btn btn-blue">
            Save Changes
        </button>
    </form>
</div>

<!-- Change Password Card -->
<div class="card">
    <h3>Change Password</h3>
    <form method="POST">
        <label>Current Password</label>
        <input type="password" name="current_password"
               placeholder="Enter current password">

        <label>New Password</label>
        <input type="password" name="new_password"
               placeholder="Min 6 characters">

        <label>Confirm New Password</label>
        <input type="password" name="confirm_password"
               placeholder="Repeat new password">

        <button type="submit" name="change_password" class="btn btn-blue">
            Change Password
        </button>
    </form>
</div>

</div>
</body>
</html>