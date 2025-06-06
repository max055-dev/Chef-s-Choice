<?php
session_start();
include 'db_connect.php';
print_r($_SESSION);
if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen.");
}


$sql = "SELECT * FROM producten";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelproducten</title>
    <!-- Voeg Bootstrap CSS toe -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Bestellen bij onze Webwinkel</h2>

        <!-- Bestelformulier -->
        <form action="verwerk_bestelling.php" method="POST">
            <div class="row">
                <?php while ($product = $result->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $product['afbeelding']; ?>" class="card-img-top" alt="<?php echo $product['naam']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['naam']; ?></h5>
                                <h6 class="card-text">Beschrijving:<?php echo $product['beschrijving']; ?></h6>
                                <p class="card-text">Prijs: €<?php echo number_format($product['prijs'], 2); ?></p>
                                <div class="form-group">
                                    <label for="product_<?php echo $product['product_id']; ?>">Aantal:</label>
                                    <input type="number" name="product_<?php echo $product['product_id']; ?>" id="product_<?php echo $product['product_id']; ?>" class="form-control" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Bestellen</button>
            </div>
        </form>
    </div>

    <!-- Voeg Bootstrap JS toe -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php

$conn->close();
?>