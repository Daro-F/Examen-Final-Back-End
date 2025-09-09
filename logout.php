<?php
include_once __DIR__ . '/library/init.php';

// Si une session est ouverte on la détruit
session_unset();    // vide toutes les variables de session
session_destroy();  // détruit la session

// Redirection vers l'accueil
header("Location: accueil.php");
exit;
