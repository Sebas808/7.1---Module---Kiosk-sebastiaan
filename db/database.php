<?php

$host = "localhost";
$dbname = "kiosk_menu";
$username = "u240198_kiosk";
$password = "ks4aZ9R2sRpEe8NAWe8v";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}