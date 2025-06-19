<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen.");
}

$gebruiker_id = $_SESSION['gebruiker_id'];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestellen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #343a40;
        }
        .navbar-custom a {
            color: #f8f9fa;
            margin-right: 10px;
            text-decoration: none;
        }
        .navbar-custom a:hover {
            color: #ffc107;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        :root {
  --donkerbruin: #3E2723;
  --champagne-goud: #D4AF37;
  --crème: #FAF3E0;
  --diep-roodbruin: #7B3F00;
}

/* Body & container */
body {
  background-color: var(--crème);
  color: var(--donkerbruin);
}
.container {
  padding-top: 2rem;
  padding-bottom: 2rem;
}

/* Navbar */
.navbar {
  background-color: var(--donkerbruin) !important;
}
.navbar .nav-link {
  color: var(--champagne-goud) !important;
  font-weight: bold;
  text-transform: uppercase;
  padding: 14px 20px;
  transition: background-color 0.3s, color 0.3s;
}
.navbar .nav-link:hover {
  background-color: var(--champagne-goud) !important;
  color: var(--donkerbruin) !important;
}

/* Kaarten */
.card {
  background-color: var(--donkerbruin);
  color: var(--crème);
  border: none;
  border-radius: 8px;
}
.card-img-top {
  height: 200px;
  object-fit: cover;
}

/* Formuliervelden in kaarten */
.card .form-control {
  background-color: #4e3a36;
  border: 1px solid var(--champagne-goud);
  color: var(--crème);
}
.card .form-control:focus {
  background-color: #5e4b47;
  border-color: var(--diep-roodbruin);
  box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.25);
  color: #fff;
}

/* Knop */
.btn-primary {
  background-color: var(--champagne-goud) !important;
  border-color: var(--champagne-goud) !important;
  color: var(--donkerbruin) !important;
  text-transform: uppercase;
  font-weight: bold;
  transition: background-color 0.3s, border-color 0.3s;
}
.btn-primary:hover {
  background-color: #b89130 !important;
  border-color: #b89130 !important;
}

/* Samenvatting */
.summary p {
  font-size: 1.1rem;
}

/* Responsief voor kaarten */
@media (max-width: 767px) {
  .row > .col-md-4 {
    margin-bottom: 1.5rem;
  }
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
    <?php
    $navItems = [
        "Registreren/inloggen" => "index.php",
        "Homepagina" => "Homepagina.php",
        "Bestellen" => "bestellen.php",
        "Account" => "account.php",
        "Revieuws" => "review_zien.php",
        "Uitloggen" => "logout.php",
    ];
    foreach ($navItems as $name => $url) {
        echo "<a class='nav-link d-inline' href='$url'>$name</a>";
    }
    ?>
</nav>

<?php
// Producten ophalen
$sql = "SELECT * FROM producten";
$result_producten = $conn->query($sql);

// Bestellingen ophalen
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
    $kortingen = ["KORTING10" => 10, "KORTING15" => 15, "KORTING20" => 20];
    if (isset($kortingen[$code])) {
        return $bedrag - ($bedrag * ($kortingen[$code] / 100));
    }
    return $bedrag;
}
$totaal_met_korting = berekenKorting($totaal, $kortingscode);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Bestellen bij onze Webwinkel</h2>

    <form action="verwerk_bestelling.php" method="POST">
        <div class="row">
            <?php while ($product = $result_producten->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo $product['afbeelding']; ?>" class="card-img-top" alt="<?php echo $product['naam']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $product['naam']; ?></h5>
                            <p class="card-text"><?php echo $product['beschrijving']; ?></p>
                            <p class="card-text">Prijs: €<?php echo number_format($product['prijs'], 2); ?></p>
                            <div class="form-group mt-auto">
                                <label for="product_<?php echo $product['product_id']; ?>">Aantal:</label>
                                <input type="number" name="product_<?php echo $product['product_id']; ?>" id="product_<?php echo $product['product_id']; ?>" class="form-control" value="0" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="form-group mt-4">
            <label for="kortingscode">Kortingscode:</label>
            <input type="text" name="kortingscode" id="kortingscode" class="form-control" value="<?php echo htmlspecialchars($kortingscode); ?>">
        </div>

        <div class="mt-4">
            <p><strong>Totaal vóór korting:</strong> €<?php echo number_format($totaal, 2); ?></p>
            <?php if ($totaal != $totaal_met_korting): ?>
                <p><strong>Korting toegepast (<?php echo htmlspecialchars($kortingscode); ?>):</strong> €<?php echo number_format($totaal - $totaal_met_korting, 2); ?></p>
            <?php endif; ?>
            <p><strong>Totaal na korting:</strong> €<?php echo number_format($totaal_met_korting, 2); ?></p>
        </div>

        <button type="submit" class="btn btn-success mt-3">Bestellen</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
