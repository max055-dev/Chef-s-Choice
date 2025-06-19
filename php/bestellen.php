<?php
session_start();
include 'db_connect.php';

// Winkelwagen initialiseren
if (!isset($_SESSION['winkelwagen'])) {
  $_SESSION['winkelwagen'] = [];
}

// Kortingscode verwerken
$kortingscode = isset($_POST['kortingscode']) ? strtoupper(trim($_POST['kortingscode'])) : '';
function berekenKorting($bedrag, $code)
{
  $kortingen = ["KORTING10" => 10, "KORTING15" => 15, "KORTING20" => 20];
  if (isset($kortingen[$code])) {
    return $bedrag * (1 - $kortingen[$code] / 100);
  }
  return $bedrag;
}
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
      box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
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
      .row>.col-md-4 {
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
      "Reviews" => "review_zien.php",
      "Uitloggen" => "logout.php",
    ];
    foreach ($navItems as $label => $url) {
      echo "<a class='nav-link d-inline' href='$url'>$label</a>";
    }
    ?>
  </nav>

  <div class="container mt-5">
    <div class="row">
      <!-- Producten -->
      <div class="col-md-8">
        <h2>Producten</h2>
        <div class="row">
          <?php
          $sql = "SELECT * FROM producten";
          $res = $conn->query($sql);
          while ($p = $res->fetch_assoc()):
          ?>
            <div class="col-md-6 mb-4">
              <div class="card h-100">
                <img src="<?= $p['afbeelding'] ?>" class="card-img-top" alt="<?= htmlspecialchars($p['naam']) ?>">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($p['naam']) ?></h5>
                  <p class="card-text"><?= htmlspecialchars($p['beschrijving']) ?></p>
                  <p class="card-text">€<?= number_format($p['prijs'], 2) ?></p>
                  <form action="toevoegen_winkelwagen.php" method="POST" class="mt-auto">
                    <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                    <div class="input-group mb-2">
                      <input type="number" name="aantal" class="form-control" min="1" value="1">
                      <button class="btn btn-primary">In winkelwagen</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

      <!-- Winkelwagen -->
      <div class="col-md-4">
        <h2>Winkelwagen</h2>
        <?php if (empty($_SESSION['winkelwagen'])): ?>
          <p>Je winkelwagen is leeg.</p>
        <?php else: ?>
          <ul class="list-group mb-3">
            <?php
            $subtotaal = 0;
            foreach ($_SESSION['winkelwagen'] as $pid => $qty):
              $stmt = $conn->prepare("SELECT naam, prijs FROM producten WHERE product_id=?");
              $stmt->bind_param("i", $pid);
              $stmt->execute();
              $prod = $stmt->get_result()->fetch_assoc();
              $lijnprijs = $prod['prijs'] * $qty;
              $subtotaal += $lijnprijs;
            ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($prod['naam']) ?> x <?= $qty ?>
                <div>
                  €<?= number_format($lijnprijs, 2) ?>
                  <a href="verwijder_item.php?id=<?= $pid ?>" class="btn btn-sm btn-danger ms-2">×</a>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>

          <!-- Kortingscode -->
          <form method="POST" action="bestellen.php">
            <div class="mb-3">
              <label for="kortingscode" class="form-label">Kortingscode</label>
              <input type="text" class="form-control" id="kortingscode" name="kortingscode" value="<?= htmlspecialchars($kortingscode) ?>">
            </div>
            <button class="btn btn-secondary btn-sm mb-3">Toepassen</button>
          </form>

          <!-- Totaal -->
          <?php $totaalNaKorting = berekenKorting($subtotaal, $kortingscode); ?>
          <p><strong>Subtotaal:</strong> €<?= number_format($subtotaal, 2) ?></p>
          <?php if ($totaalNaKorting != $subtotaal): ?>
            <p><strong>Korting (<?= $kortingscode ?>):</strong> -€<?= number_format($subtotaal - $totaalNaKorting, 2) ?></p>
          <?php endif; ?>
          <p><strong>Totaal:</strong> €<?= number_format($totaalNaKorting, 2) ?></p>

          <a href="verwerk_bestelling.php" class="btn btn-success w-100">Verder naar afrekenen</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>