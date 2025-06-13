<?php
include 'db_connect.php';
if (!isset($_SESSION['gebruiker_id'])) //checked of de gebruiker een gebruikers id heeft.
{
    header("Location: login.php"); //doorgestuurd naar inlog pagina.
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

$sql = "CREATE TABLE IF NOT EXISTS reviews (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review TEXT NOT NULL,
    gebruiker_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
} else {
    echo "Fout bij aanmaken tabel: " . $conn->error;
}

$conn->close();

?>
<html>

<body>
    <form action="reviews.php" method="POST">
        <label for="review">Review:</label>
        <input type="text" id="review" name="review" value="<?php echo htmlspecialchars($review ?? ''); ?>">

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