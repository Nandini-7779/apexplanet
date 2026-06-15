<?php
// Database connection settings
$host     = "localhost";
$username = "root";
$password = "";        // XAMPP default has no password
$database = "mydb";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>