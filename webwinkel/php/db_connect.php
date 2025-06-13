<?php
$servername = "localhost";
$username = "root"; // Standaard MySQL-gebruiker bij XAMPP
$password = ""; // Standaard MySQL-wachtwoord is leeg bij XAMPP
$database = "webwinkel"; // De naam van je geïmporteerde database

// Maak een verbinding
$conn = new mysqli($servername, $username, $password, $database);
