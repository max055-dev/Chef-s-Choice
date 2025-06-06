<?php
session_start();

include 'db_connect.php';
print_r($_SESSION);
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen.");
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Doorloop alle POST-gegevens van het bestelformulier
foreach ($_POST as $key => $value) {
    if (strpos($key, 'product_') === 0 && $value > 0) {
        $product_id = str_replace('product_', '', $key);
        $aantal = (int)$value;

        // SQL-query om de bestelling op te slaan
        $sql = "INSERT INTO bestellingen (gebruiker_id, product_id, aantal) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Controleer of de query goed is voorbereid
        if (!$stmt) {
            die("Fout bij het voorbereiden van de query: " . $conn->error);
        }

        $stmt->bind_param("iii", $gebruiker_id, $product_id, $aantal);
        $stmt->execute();

        // Sluit de statement alleen als deze correct is geïnitialiseerd
        $stmt->close();
    }
}

// Sluit de databaseverbinding
$conn->close();

echo "Je bestelling is geplaatst!";
header('Location: account.php');
exit();
