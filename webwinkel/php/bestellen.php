<?php
session_start();
include 'db_connect.php';
include 'account.php';
if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen.");
}


$sql = "SELECT * FROM producten";
$result = $conn->query($sql);

// Bereken totaalprijs van eerdere bestellingen (indien gewenst)
$sqlBestellingen = "
    SELECT p.prijs, b.aantal
    FROM bestellingen b
    JOIN producten p ON b.product_id = p.product_id
    WHERE b.gebruiker_id = ?
";

$stmt = $conn->prepare($sqlBestellingen);
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result_bestellingen = $stmt->get_result();

$totaal = 0;
while ($row = $result_bestellingen->fetch_assoc()) {
    $totaal += $row['prijs'] * $row['aantal'];
}

// Kortingscode verwerken
$kortingscode = isset($_POST['kortingscode']) ? strtoupper(trim($_POST['kortingscode'])) : '';

function berekenKorting($bedrag, $code) {
    $kortingen = [
        "KORTING10" => 10,
        "KORTING15" => 15,
        "KORTING20" => 20
    ];

    if (isset($kortingen[$code])) {
        $percentage = $kortingen[$code];
        return $bedrag - ($bedrag * ($percentage / 100));
    }

    return $bedrag;
}

$totaal_met_korting = berekenKorting($totaal, $kortingscode);
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



            <!-- Kortingscode invoeren -->
        <div class="form-group mt-3">
            <label for="kortingscode">Kortingscode:</label>
            <input type="text" name="kortingscode" id="kortingscode" class="form-control" value="<?php echo htmlspecialchars($kortingscode); ?>">
        </div>

        <!-- Toon totaalbedrag -->
        <div class="mt-3">
            <p><strong>Totaal vóór korting:</strong> €<?php echo number_format($totaal, 2); ?></p>
            <?php if ($totaal != $totaal_met_korting): ?>
                <p><strong>Korting toegepast (<?php echo htmlspecialchars($kortingscode); ?>):</strong> €<?php echo number_format($totaal - $totaal_met_korting, 2); ?></p>
            <?php endif; ?>
            <p><strong>Totaal na korting:</strong> €<?php echo number_format($totaal_met_korting, 2); ?></p>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Bestellen</button>
        </form>
    </div>

    <!-- Voeg Bootstrap JS toe -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
include 'review_zien.php';
include 'reviews.php';
$conn->close();
?>
