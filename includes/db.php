<?php
// db.php
$host = 'localhost';
$dbname = 'inventory';
$username = 'root';  // change if needed
$password = 'toor';      // change if needed

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
