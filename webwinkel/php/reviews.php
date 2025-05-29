<?php 
session_start(); //start de sessie.
include 'db_connect.php'; //verbind met database.

if (!isset($_SESSION['gebruiker_id'])) //als de gebruiker geen "id" heeft, word hij naar inlog.php gestuurd.
{
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['review'])) //haalt review op van database.
{
    //variabelen van opgehaalden data van database, zodat ik dit kan heroproepen.
    $gebruiker_id = $_SESSION['gebruiker_id'];
    $review = $_POST['review'];

    //sql query die de ingevoerde data uit het formulier van review_zien.php in de database zet.
    $sql = "INSERT INTO reviews (review, gebruiker_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $review, $gebruiker_id);

    if (mysqli_stmt_execute($stmt)) 
    {
        header("Location: aparte_reviews.php");
        exit();
    } else 
    {
        echo "Er is een fout opgetreden bij het bijwerken van je gegevens.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else 
{
    echo "Geen geldige review ontvangen.";
}
?>
