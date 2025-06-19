<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Gebruikersgegevens ophalen
$stmt = $conn->prepare("SELECT voornaam, achternaam, email FROM gebruikers WHERE gebruiker_id = ?");
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$stmt->bind_result($voornaam, $achternaam, $email);
$stmt->fetch();
$stmt->close();

// Bestellingen ophalen
$sql_bestellingen = "
    SELECT b.bestelling_id, p.naam AS product_naam, b.aantal, b.besteldatum 
    FROM bestellingen b
    JOIN producten p ON b.product_id = p.product_id 
    WHERE b.gebruiker_id = ?";
$stmt2 = $conn->prepare($sql_bestellingen);
$stmt2->bind_param("i", $gebruiker_id);
$stmt2->execute();
$result_bestellingen = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Mijn Account & Bestellingen</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Playfair+Display&display=swap" rel="stylesheet">
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
            background-color: var(--crème);
            color: var(--donkerbruin);
        }

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
            margin: 20px 30px;
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

        .content {
            padding: 40px 20px;
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.8;
            font-size: 18px;
        }

        .content a {
            color: var(--champagne-goud);
            text-decoration: underline;
            transition: color 0.3s;
        }

        .content a:hover {
            color: var(--diep-roodbruin);
        }

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

        footer {
            background-color: var(--donkerbruin);
            color: var(--champagne-goud);
            text-align: center;
            padding: 20px 10px;
            border-top: 1px solid var(--champagne-goud);
            margin-top: 50px;
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

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: var(--donkerbruin);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid var(--diep-roodbruin);
            text-align: left;
        }

        th {
            background-color: var(--champagne-goud);
            color: var(--donkerbruin);
        }

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
    <nav class="navbar">
        <div class="logo">
            <a href="index.php"><img src="../img/logo.png"></a>
        </div>
        <a href="Homepagina.php">Home</a>
        <a href="account.php">Mijn account</a>
        <a href="logout.php">Uitloggen</a>
    </nav>

    <div class="content">
        <h1>Welkom, <?= htmlspecialchars($voornaam . ' ' . $achternaam) ?>!</h1>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

        <h2>Jouw bestellingen</h2>
        <?php if ($result_bestellingen->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Bestelnummer</th>
                        <th>Product</th>
                        <th>Aantal</th>
                        <th>Besteldatum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_bestellingen->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['bestelling_id']) ?></td>
                            <td><?= htmlspecialchars($row['product_naam']) ?></td>
                            <td><?= htmlspecialchars($row['aantal']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y', strtotime($row['besteldatum']))) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Je hebt nog geen bestellingen geplaatst.</p>
        <?php endif; ?>

        <a class="btn-gold" href="producten.php">Meer producten bekijken</a>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Jouw Bedrijf | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a>
    </footer>
</body>

</html>