<?php
include __DIR__ . '/library/init.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: log.php");
    exit;
}

// Récupérer l'ID de la recette
$id_recette = $_GET['id'];
if (!$id_recette) {
    echo "Recette introuvable.";
    exit;
}

// Charger la recette
$sql = "SELECT * FROM recette WHERE id = ?";
$recette = bddGetRecord($sql, [$id_recette]);
if (!$recette) {
    echo "Recette introuvable.";
    exit;
}

// Vérifier que la recette appartient à l'utilisateur connecté
if ($recette['id_utilisateur'] != $_SESSION['id']) {
    echo "Accès interdit.";
    exit;
}

// Supprimer la recette
$ok = bddDelete("recette", $id_recette);

if ($ok) {
    header("Location: load_profil.php");
    exit;
} else {
    echo "Erreur lors de la suppression.";
}
