<?php
include 'config.php';

// Get user id from URL
$id = $_GET['id'];

// Check if user exists
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user   = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found!");
}

// Delete the user
$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    // Redirect back to index after delete
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting user: " . mysqli_error($conn);
}
?>