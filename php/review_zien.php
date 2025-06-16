<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['gebruiker_id'])) //checked of de gebruiker een gebruikers id heeft.
{
    header("Location: login.php"); //doorgestuurd naar inlog pagina.
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

$sql= "CREATE TABLE IF NOT EXISTS reviews (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review TEXT NOT NULL,
    gebruiker_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) 
    {
    echo "Tabel 'reviews' is succesvol aangemaakt.";
    }
    else 
    {
    echo "Fout bij aanmaken tabel: " . $conn->error;
    }

$conn->close();
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

<html>
<body>
    <form action="reviews.php" method="POST">
        <label for="review">Review:</label>
        <input type="text" id="review" name="review" value="<?php echo htmlspecialchars($review ??''); ?>">

        <input type="submit" value="Update review">
    </form>
    <div>

    </div>
</body>
</html>
<?php

if (isset($_SESSION['gebruiker_id'])) {
    echo '<a href="account.php">terug naar account</a>';
}
?>
