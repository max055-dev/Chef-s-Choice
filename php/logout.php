<?php
// Start de sessie
session_start();

// Vernietig alle sessievariabelen
session_unset();

// Vernietig de sessie
session_destroy();

// Redirect de gebruiker naar de homepagina
header("Location: Homepagina.php?logout=success");
exit();
