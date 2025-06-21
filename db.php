<?php
// db.php — shared database connection

$DB_HOST = 'localhost';
$DB_NAME = 'contact_db';
$DB_USER = 'root';
$DB_PASS = '';  // update if needed

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed: " . $e->getMessage());
}
?>
