<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

$feedback = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['review'])) {
    $gebruiker_id = $_SESSION['gebruiker_id'];
    $review = trim($_POST['review']);
    if ($review !== '') {
        $sql = "INSERT INTO reviews (review, gebruiker_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $review, $gebruiker_id);
        if (mysqli_stmt_execute($stmt)) {
            $feedback = '<span style="color:green">Review succesvol geplaatst!</span>';
        } else {
            $feedback = '<span style="color:red">Er is een fout opgetreden bij het plaatsen.</span>';
        }
        mysqli_stmt_close($stmt);
    } else {
        $feedback = '<span style="color:red">Review mag niet leeg zijn.</span>';
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Review Plaatsen</title>
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
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            color: var(--donkerbruin);
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid var(--donkerbruin);
            border-radius: 4px;
            resize: vertical;
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
            margin-top: 15px;
            font-weight: bold;
        }
        @media (max-width:600px) {
            .navbar a {
                padding: 12px;
                font-size: 14px;
            }
            textarea {
                font-size: 14px;
            }
            .btn-gold {
                padding: 10px 18px;
                font-size: 14px;
            }
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
            "Reviews"    => "reviews.php",
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
            <div class="feedback"><?= $feedback ?></div>
        <?php endif; ?>
        <form method="post">
            <textarea name="review" placeholder="Schrijf hier je review..." required></textarea>
            <button type="submit" class="btn-gold">Plaatsen</button>
        </form>
    </div>
</body>
</html>
