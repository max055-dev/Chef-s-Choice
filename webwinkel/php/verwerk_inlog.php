<?php
session_start();
include 'db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST")    //haalt gegevens op van database
{
    $email= $_POST['email'];
    $wachtwoord= $_POST['wachtwoord'];

    $sql = "SELECT * FROM gebruikers WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();    //gaat elke data rij na
    

        if (password_verify($wachtwoord, $row['wachtwoord']))    
        {
            echo"Inloggen gelukt! welkom, " . htmlspecialchars($row['voornaam']);
            $_SESSION['gebruiker_id'] = $row['gebruiker_id']; 
            header('location:bestellen.php');    // Waar $gebruikers_id de ID van de ingelogde gebruiker is
        }   else 
            {
                echo "ongeldig wachtwoord.";
            }
    } else
      {
        echo "geen gebruiker gevonden met dit email adress. ";
      }

    $conn->close();
    }
?>