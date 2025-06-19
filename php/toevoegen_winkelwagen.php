<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['winkelwagen'])) {
    $_SESSION['winkelwagen'] = [];
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$aantal     = isset($_POST['aantal'])     ? max(1, (int)$_POST['aantal']) : 1;

if ($product_id > 0) {
    if (isset($_SESSION['winkelwagen'][$product_id])) {
        $_SESSION['winkelwagen'][$product_id] += $aantal;
    } else {
        $_SESSION['winkelwagen'][$product_id] = $aantal;
    }
}

header('Location: bestellen.php');
exit;
