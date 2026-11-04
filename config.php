<?php
// Campus Connect database connection
$host = "localhost";
$dbname = "campus_connect";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("Database connection failed. Check XAMPP MySQL and config.php. Details: " .
        htmlspecialchars($e->getMessage()));
}
if (session_status() === PHP_SESSION_NONE) session_start();
function h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function require_login() {
    if (empty($_SESSION['user_id'])) { header("Location: login.php"); exit; }
}
function require_admin() {
    if (empty($_SESSION['admin_id'])) { header("Location: admin_login.php"); exit; }
}
