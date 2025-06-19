<?php
$servername = "localhost";
$username = "root"; // Standaard MySQL-gebruiker bij XAMPP
$password = ""; // Standaard MySQL-wachtwoord is leeg bij XAMPP
$database = "webwinkel"; // De naam van je geïmporteerde database

// Maak een verbinding
$conn = new mysqli($servername, $username, $password, $database);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
