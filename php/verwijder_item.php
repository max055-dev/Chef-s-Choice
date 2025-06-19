<?php
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0 && isset($_SESSION['winkelwagen'][$id])) {
    unset($_SESSION['winkelwagen'][$id]);
}

header('Location: bestellen.php');
exit;
