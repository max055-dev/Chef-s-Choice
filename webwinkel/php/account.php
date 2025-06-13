<?php

include 'db_connect.php';
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$sql = "SELECT * FROM gebruikers WHERE gebruiker_id = $gebruiker_id";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $voornaam = $row['voornaam'];
    $achternaam = $row['achternaam'];
    $email = $row['email'];
}


//laat bestellingen zien opgeslagen op database
$sql_bestellingen = "SELECT bestellingen.bestelling_id, producten.naam, bestellingen.aantal, bestellingen.besteldatum 
                     FROM bestellingen 
                     JOIN producten ON bestellingen.product_id = producten.product_id 
                     WHERE bestellingen.gebruiker_id = $gebruiker_id";
$result_bestellingen = mysqli_query($conn, $sql_bestellingen);

if (mysqli_num_rows($result_bestellingen) > 0) //waneer de inhoud van bestellingen niet NULL is gaat hij elke rij na
{
    while ($row = mysqli_fetch_assoc($result_bestellingen)) {
        echo "<p>Product: " . $row['naam'] . " - Aantal: " . $row['aantal'] . " - besteldatum: " . $row['besteldatum'] . "</p>";
    }
} else {
    echo "<p>Je hebt nog geen bestellingen geplaatst.</p>";
}


?>
<html>

<body>
    <form action="update_gebruiker.php" method="POST">
        <label for="naam">voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" value="<?php echo $voornaam; ?>">

        <label for="naam">achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" value="<?php echo $achternaam; ?>">

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>">

        <button type="submit">Bijwerken</button>
    </form>
</body>


<html>