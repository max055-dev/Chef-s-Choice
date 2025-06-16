<?php
session_start();
include 'db_connect.php';

// Controleer of de gebruiker ingelogd is
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");  // Verplaats de header bovenaan
    exit();
}

// Verkrijg gegevens van de gebruiker uit de database
$gebruiker_id = $_SESSION['gebruiker_id'];
$sql = "SELECT * FROM gebruikers WHERE gebruiker_id = $gebruiker_id";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $voornaam = $row['voornaam'];
    $achternaam = $row['achternaam'];
    $email = $row['email'];
}

// Verkrijg bestellingen van de gebruiker
$sql_bestellingen = "SELECT bestellingen.bestelling_id, producten.naam, bestellingen.aantal, bestellingen.besteldatum 
                     FROM bestellingen 
                     JOIN producten ON bestellingen.product_id = producten.product_id 
                     WHERE bestellingen.gebruiker_id = $gebruiker_id";
$result_bestellingen = mysqli_query($conn, $sql_bestellingen);
?>




<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn Pagina</title>
    <style>
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

<div class="navbar">
    <?php
    // Navigatie items
    $navItems = [
        "Registreren/inloggen" => "index.php",
        "Homepagina" =>"Homepagina.php",
        "Bestellen" => "bestellen.php",
        "Account" => "account.php",
        "Revieuws" =>"review_zien.php",
        "Uitloggen" => "logout.php",
    ];

    foreach ($navItems as $name => $url) {
        echo "<a href='$url'>$name</a>";
    }
    ?>
</div>

<!-- Toon bestellingen van de gebruiker -->
<div class="content">
    <?php
    echo("Uw Bestellingen: ");
    if (mysqli_num_rows($result_bestellingen) > 0) {
        while ($row = mysqli_fetch_assoc($result_bestellingen)) {
            echo "<p>Product: " . $row['naam'] . " - Aantal: " . $row['aantal'] . " - Besteldatum: " . $row['besteldatum'] . "</p>";
        }
    } else {
        echo "<p>Je hebt nog geen bestellingen geplaatst.</p>";
    }
    ?>
</div>

<!-- Gebruiker gegevens bewerken -->
<form action="update_gebruiker.php" method="POST">
    <label for="voornaam">Voornaam:</label>
    <input type="text" id="voornaam" name="voornaam" value="<?php echo $voornaam; ?>">

    <label for="achternaam">Achternaam:</label>
    <input type="text" id="achternaam" name="achternaam" value="<?php echo $achternaam; ?>">
    
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
    
    <button type="submit">Bijwerken</button>
</form>

<!-- Link naar reviews -->
<?php
if (isset($_SESSION['gebruiker_id'])) {
    echo '<a href="review_zien.php">Bekijk mijn reviews</a>';
}
?>

</body>
</html>
