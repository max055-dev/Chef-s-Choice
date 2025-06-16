<?php
session_start();  // Start de sessie

// Controleer of de gebruiker uitgelogd is en toon een bericht
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "<p>Succesvol uitgelogd! Bedankt voor het bezoeken van Chef's Choice!</p>";
    echo "<p>Volg ons op:</p>";
    echo "<p>Instagram: <a href='https://instagram.com/ChefchoicseAwards'>@ChefchoicseAwards</a></p>";
    echo "<p>TikTok: <a href='https://tiktok.com/@ChefChoices'>#ChefChoices</a></p>";
    echo "<p>Email: <a href='mailto:ChefChoice@gmail.com'>ChefChoice@gmail.com</a></p>";
}

// Inclusies van andere bestanden
include 'db_connect.php';

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
<div>
    <?php
    echo("Welkom bij chef choice's ! wij zijn een familie befrijf gesticht in 1922, en generaties lang bezig u de beste producten te leveren voor chef's die zoeken naar perfectie."); 
    Echo("wilt u aleen even kijken naar onze producten? dat mag! we vragen u zelfs naar uw ervaring in de form van een revieuw voor op onze site (:");
    ?>
</div>


</body>
</html>
