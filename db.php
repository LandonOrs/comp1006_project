<?php
// Database Credintals
$host = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "comp1006_project";
// Create a new PDO instance
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
