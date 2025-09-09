<?php
include __DIR__ . '/library/init.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: log.php");
    exit;
}

// Charger l'utilisateur
$utilisateur = utilisateur::findByid($_SESSION['id']);
if (!$utilisateur) {
    echo "Utilisateur introuvable.";
    exit;
}

// Charger ses recettes
$recettes = Recette::findRecetteByPseudo($utilisateur['pseudo']);

// Inclure la vue
include __DIR__ . '/templates/pages/profil.php';
