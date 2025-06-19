<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// 1. Maak reviews-tabel aan indien nodig
$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review TEXT NOT NULL,
    gebruiker_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// 2. Opslaan nieuwe review
$feedback = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['review'])) {
    $review = trim($_POST['review']);
    if ($review !== '') {
        $stmt = mysqli_prepare($conn, "INSERT INTO reviews (review, gebruiker_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "si", $review, $gebruiker_id);
        if (mysqli_stmt_execute($stmt)) {
            $feedback = 'Review succesvol geplaatst!';
        } else {
            $feedback = 'Fout bij plaatsen review.';
        }
        mysqli_stmt_close($stmt);
    } else {
        $feedback = 'Review mag niet leeg zijn.';
    }
}

// 3. Haal bestaande reviews op (van alle gebruikers, of filter bijv. per gebruiker)
$result = mysqli_query($conn, "SELECT r.review, r.created_at, u.voornaam FROM reviews r JOIN gebruikers u ON r.gebruiker_id = u.gebruiker_id ORDER BY r.created_at DESC");

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reviews & Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Playfair+Display&display=swap" rel="stylesheet">
    <style>
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
            box-shadow: 0 4px 6px rgba(212,175,55,0.2);
            border-bottom: 2px solid var(--champagne-goud);
        }
        .navbar a {
            float: left;
            display: block;
            color: var(--champagne-goud);
            text-transform: uppercase;
            font-weight: bold;
            padding: 16px 22px;
            text-decoration: none;
            transition: background-color .3s, color .3s;
        }
        .navbar a:hover {
            background-color: var(--champagne-goud);
            color: var(--donkerbruin);
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            color: var(--donkerbruin);
        }
        textarea, input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid var(--donkerbruin);
            border-radius: 4px;
            margin-top: 10px;
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
            transition: background-color .3s;
            margin-top: 10px;
        }
        .btn-gold:hover {
            background-color: #b89130;
        }
        .feedback {
            margin: 15px 0;
            font-weight: bold;
        }
        .review-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid var(--champagne-goud);
        }
        .review-item small {
            color: var(--diep-roodbruin);
        }
        @media (max-width:600px) {
            textarea, input[type="text"] { font-size: 14px; }
            .btn-gold { padding: 10px 18px; font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <?php
        $navItems = [
            "Homepagina" => "Homepagina.php",
            "Bestellen"  => "bestellen.php",
            "Account"    => "account.php",
            "Reviews"    => "review_zien.php",
            "Uitloggen"  => "logout.php",
        ];
        foreach ($navItems as $name => $url) {
            echo "<a href='$url'>$name</a>";
        }
        ?>
    </div>

    <div class="container">
        <h1>Review plaatsen</h1>
        <?php if ($feedback !== ''): ?>
            <div class="feedback"><?= htmlspecialchars($feedback) ?></div>
        <?php endif; ?>
        <form method="post">
            <textarea name="review" placeholder="Schrijf hier je review..." required><?= htmlspecialchars($review ?? '') ?></textarea>
            <button type="submit" class="btn-gold">Plaatsen</button>
        </form>

        <h2>Recente Reviews</h2>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="review-item">
                <p><?= nl2br(htmlspecialchars($row['review'])) ?></p>
                <small>– <?= htmlspecialchars($row['voornaam']) ?> op <?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
