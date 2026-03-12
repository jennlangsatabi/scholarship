<?php
// Database configuration
$host     = "localhost";
$username = "root";      // Default XAMPP username
$password = "";          // Default XAMPP password is empty
$dbname   = "scholarship_db"; // Change this to your actual database name

// Create connection using MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful (Optional: comment this out later for a cleaner UI)
// echo "Connected successfully";
?>