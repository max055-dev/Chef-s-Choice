<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formuliergegevens ophalen en opslaan in variabelen
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $wachtwoord_bevestiging = $_POST['wachtwoord_bevestiging'];
    if ($wachtwoord != $wachtwoord_bevestiging) {
        $fout_bericht = "De wachtwoorden komen niet overeen!";
        echo $fout_bericht;
    } else {
        // Hier kun je de registratie verder verwerken, bijvoorbeeld de gegevens opslaan in een database.
        // Voor nu laten we een succesbericht zien.
        $succes_bericht = "Registratie succesvol! Welkom, $voornaam $achternaam.";
        echo $succes_bericht;

        // Verwerking van de gegevens (bijvoorbeeld opslaan in de database of andere acties)
        echo "Voornaam: " . htmlspecialchars($voornaam) . "<br>";
        echo "Achternaam: " . htmlspecialchars($achternaam) . "<br>";
        echo "E-mail: " . htmlspecialchars($email) . "<br>";
        echo "Wachtwoord: " . htmlspecialchars($wachtwoord) . "<br>";
        echo "wachtwoord_bevestiging: " . htmlspecialchars($wachtwoord_bevestiging) . "<br>";

?>
<?php
        //verbinding maken met de database
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $voornaam = $_POST['voornaam'];
            $achternaam = $_POST['achternaam'];
            $email = $_POST['email'];
            $wachtwoord = $_POST['wachtwoord'];
            $wachtwoord_bevestiging = $_POST['wachtwoord'];


            //controleert of wachtwoorden overeen komen
            if ($wachtwoord === $wachtwoord_bevestiging) {
                //beveilig wachtwoord met hash
                $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
                //sql query om gegevens in de database te doen 
                $sql = "INSERT INTO gebruikers(voornaam, achternaam,  email, wachtwoord) VALUES ('$voornaam', '$achternaam', '$email', '$hashedPassword')";


                if ($conn->query($sql) === TRUE) {
                    echo "registratie succesvol! ";
                } else {
                    echo "fout bij het registreren: " . $conn - die;
                }
            } else {
                echo "wachtwoorden komen niet overeen!";
            }
            header("Location: Homepagina.php?registratie=success");
            //sluit de database connectie
            $conn->close();
        }
    }
}

?>