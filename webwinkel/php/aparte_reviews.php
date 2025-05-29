<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['gebruiker_id'])) //checked of de gebruiker een gebruikers id heeft.
{
    header("Location: login.php"); //doorgestuurd naar inlog pagina.
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

//haalt alle reviews uit de database.
$sql_reviews = "SELECT * 
                FROM reviews 
                WHERE reviews.gebruiker_id = $gebruiker_id";
$result_reviews = mysqli_query($conn, $sql_reviews);

//plaatst alle reviews op het scherm.
if (mysqli_num_rows($result_reviews) > 0) //waneer de inhoud van bestellingen niet NULL is gaat hij elke rij af.
{
    while ($row = mysqli_fetch_assoc($result_reviews)) 
    {
    echo "<p>Review: " . $row['review'] . " - gebruiker_id: " . $row['gebruiker_id'] ."</p>";// container reviews en id
    }
} else 
    {
    echo "<p>Je hebt nog geen reviews geplaatst.</p>";
    }






$conn->close();
?>

<?php
if (isset($_SESSION['gebruiker_id'])) 
{
    echo '<a href="review_zien.php">terug naar reviews maken</a>';
}
?>
