<?php 
//de sessie word gestard en de connectie met de database word toegevoegd.
session_start();
include 'db_connect.php';
if (!isset($_SESSION['gebruiker_id'])) //checked of de gebruiker een gebruikers id heeft.
{
    header("Location: login.php"); //doorgestuurd naar inlog pagina.
    exit();
}


//het geven van heroproepbare variabele aan specifieke data van de POST in de database.
$gebruiker_id = $_SESSION['gebruiker_id'];
$voornaam = $_POST['voornaam'];
$achternaam= $_POST['achternaam'];
$email = $_POST['email'];


//zorgt dat de gegevens van de database op basis van sql commando's gewijzigd worden
$sql = "UPDATE gebruikers SET voornaam = ?, achternaam = ?, email = ? WHERE gebruiker_id = ?"; 
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $voornaam, $achternaam, $email, $gebruiker_id);

if (mysqli_stmt_execute($stmt)) //als de query goed gaat word de gebruiker naar account.php gestuurd
{
    header("Location: account.php");
    exit();
} else 
{
    echo "Er is een fout opgetreden bij het bijwerken van je gegevens.";
}

?>