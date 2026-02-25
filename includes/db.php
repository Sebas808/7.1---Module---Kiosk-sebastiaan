<?php
$host = 'localhost';
$dbname = 'kiosk_sebastiaan_jeran';
$username = 'root';
$password = ''; // Standaard XAMPP wachtwoord is leeg

try {
    // Create new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set error mode to exception for better debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If connection fails, show error
    die("Kan geen verbinding maken met de database. Foutmelding: " . $e->getMessage());
}
?>