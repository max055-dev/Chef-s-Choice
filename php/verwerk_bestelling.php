<?php
session_start();
include 'db_connect.php';

// 1) Check inloggen
if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen.");
}
$gebruiker_id = (int) $_SESSION['gebruiker_id'];

// 2) Check winkelwagen
if (empty($_SESSION['winkelwagen']) || !is_array($_SESSION['winkelwagen'])) {
    die("Je winkelwagen is leeg.");
}

// 3) Haal kortingscode (indien meegestuurd)
$kortingscode = isset($_POST['kortingscode'])
    ? strtoupper(trim($_POST['kortingscode']))
    : '';

// 4) Korting-functie
function berekenKorting(float $bedrag, string $code): float
{
    $kortingen = [
        "KORTING10" => 10,
        "KORTING15" => 15,
        "KORTING20" => 20
    ];
    if (isset($kortingen[$code])) {
        return $bedrag * (1 - $kortingen[$code] / 100);
    }
    return $bedrag;
}

// 5) Start transaction
$conn->begin_transaction();

try {
    // 6) Bereken subtotaal en insert bestellingen
    $subtotaal = 0.0;

    // Prepared statement voor insert
    $insStmt = $conn->prepare(
        "INSERT INTO bestellingen (gebruiker_id, product_id, aantal) VALUES (?, ?, ?)"
    );
    $insStmt->bind_param("iii", $gebruiker_id, $pid, $qty);

    foreach ($_SESSION['winkelwagen'] as $pid => $qty) {
        $pid = (int) $pid;
        $qty = max(1, (int) $qty);

        // 6a) Haal prijs op om subtotaal te berekenen
        $pStmt = $conn->prepare("SELECT prijs FROM producten WHERE product_id = ?");
        $pStmt->bind_param("i", $pid);
        $pStmt->execute();
        $res = $pStmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $subtotaal += $row['prijs'] * $qty;
        }
        $pStmt->close();

        // 6b) Insert in bestellingen
        if (!$insStmt->execute()) {
            throw new Exception("Fout bij toevoegen product $pid: " . $insStmt->error);
        }
    }

    // 7) Sluit insert-statement
    $insStmt->close();

    // 8) Bereken totaal na korting
    $totaalNaKorting = berekenKorting($subtotaal, $kortingscode);

    // 9) Commit
    $conn->commit();

    // 10) Leeg winkelwagen
    unset($_SESSION['winkelwagen']);

    // 11) Redirect naar account of bevestiging
    //    Je kunt subtotaal en totaalNaKorting in de URL meegeven of in sessie stoppen
    header("Location: account.php?subtotaal=" . urlencode($subtotaal) .
        "&totaal=" . urlencode($totaalNaKorting));
    exit;
} catch (Exception $e) {
    // Rollback bij fout
    $conn->rollback();
    die("Er is iets misgegaan: " . htmlspecialchars($e->getMessage()));
}
