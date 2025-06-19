<?php session_start();  // Start sessie 
// Inclusies
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Chef's Choice</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* Luxe kleurenpalet */
        :root {
            --donkerbruin: #3E2723;
            --champagne-goud: #D4AF37;
            --crème: #FAF3E0;
            --diep-roodbruin: #7B3F00;
        }

        body {
            margin: 0;
            font-family: 'Lora', serif;
            background: url(../img/keuken.jpg);
            background-size: cover;
            color: var(--donkerbruin);
        }

        /* Navbar */
        .navbar {
            background-color: var(--donkerbruin);
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(212, 175, 55, 0.2);
            border-bottom: 2px solid var(--champagne-goud);
            display: flex;
            align-items: center;
        }

        .navbar .logo img {
            height: 60px;
            margin: 0px 30px;
        }

        .navbar a {
            display: block;
            color: var(--champagne-goud);
            text-transform: uppercase;
            font-weight: bold;
            padding: 16px 22px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar a:hover {
            background-color: var(--champagne-goud);
            color: var(--donkerbruin);
        }

        /* Content */
        .content {
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
            margin-top: 30px;
            line-height: 1.8;
            font-size: 18px;
            background-color: rgba(62, 39, 35, 0.7);
            color: #D4AF37;
        }

        .content a {
            color: var(--champagne-goud);
            text-decoration: underline;
            transition: color 0.3s;
        }

        .content a:hover {
            color: var(--diep-roodbruin);
        }

        /* Knop */
        .btn-gold {
            background-color: var(--champagne-goud);
            color: var(--donkerbruin);
            border: none;
            padding: 12px 24px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-gold:hover {
            background-color: #b89130;
            color: var(--donkerbruin);
        }

        /* Footer */
        footer {
            background-color: var(--donkerbruin);
            color: var(--champagne-goud);
            text-align: center;
            padding: 60px 10px;
            border-top: 1px solid var(--champagne-goud);
            margin-top: 50px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer a {
            color: var(--champagne-goud);
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
            color: var(--diep-roodbruin);
        }

        /* Koppen */
        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: var(--champagne-goud);
        }

        /* Responsief */
        @media (max-width: 600px) {
            .navbar a {
                padding: 12px;
                font-size: 14px;
            }

            .content {
                padding: 20px 10px;
                font-size: 16px;
            }

            .btn-gold {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="index.php" class="logo">
            <img src="../img/logo.png">
        </a>
        <?php
        $navItems = [
            "Registreren/Inloggen" => "index.php",
            "Homepagina" => "Homepagina.php",
            "Bestellen" => "bestellen.php",
            "Account" => "account.php",
            "Reviews" => "review_zien.php",
            "Uitloggen" => "logout.php"
        ];
        foreach ($navItems as $name => $url) {
            echo "<a href='$url'>$name</a>";
        }
        ?>
    </div>

    <?php
    if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
        echo '<div class="content">';
        echo '<p>✅ Succesvol uitgelogd! Bedankt voor het bezoeken van <strong>Chef\'s Choice</strong>!</p>';
        echo '<p>Volg ons op:</p>';
        echo '<ul>
            <li>Instagram: <a href="https://instagram.com/ChefchoicseAwards" target="_blank">@ChefchoicseAwards</a></li>
            <li>TikTok: <a href="https://tiktok.com/@ChefChoices" target="_blank">#ChefChoices</a></li>
            <li>Email: <a href="mailto:ChefChoice@gmail.com">ChefChoice@gmail.com</a></li>
          </ul>';
        echo '</div>';
    }
    ?>


    <!-- Welkomsttekst en knop -->
    <div class="content">
        <h1>Welkom bij <strong>Chef's Choice</strong>!</h1>
        <p>Wij zijn een familiebedrijf, opgericht in 1922. Al generaties lang leveren wij hoogwaardige producten voor chefs die streven naar perfectie.</p>
        <p>Even rondkijken? Dat mag natuurlijk! We horen ook graag uw mening in de vorm van een review op onze website. 😊</p>
        <a class="btn-gold" href="bestellen.php">Bekijk Producten</a>
    </div>

    <!-- Footer -->
    <footer>
        <p>Volg ons op:</p>
        <a href="https://instagram.com/ChefchoicseAwards" target="_blank">Instagram</a> |
        <a href="https://tiktok.com/@ChefChoices" target="_blank">TikTok</a> |
        <a href="mailto:ChefChoice@gmail.com">Email</a>
        <p>&copy; 2025 Chef's Choice. Alle rechten voorbehouden.</p>
    </footer>

</body>

</html>