<?php
include __DIR__ . '/library/init.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: log.php");
    exit;
}

// Récupérer l'ID de la recette à modifier
$id_recette = $_GET['id'];
if (!$id_recette) {
    echo "Recette introuvable.";
    exit;
}

// Charger la recette
$recette = bddGetRecord("SELECT * FROM recette WHERE id = ?", [$id_recette]);
if (!$recette) {
    echo "Recette introuvable.";
    exit;
}

// Vérifier que la recette appartient à l'utilisateur connecté
if ($recette['id_utilisateur'] != $_SESSION['id']) {
    echo "Accès interdit.";
    exit;
}

$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = ($_POST['titre']);
    $description = ($_POST['description']);
    $duree = ($_POST['duree']);
    $difficulte = ($_POST['difficulte']);

    if (!empty($titre) && !empty($description) && $duree > 0 && !empty($difficulte)) {
        $valeurs = [
            "titre" => $titre,
            "description" => $description,
            "duree" => $duree,
            "difficulte" => $difficulte
        ];

        $ok = bddUpdate("recette", $valeurs, $id_recette);

        if ($ok) {
            header("Location: load_profil.php");
            exit;
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

// Inclure la vue
include __DIR__ . '/templates/pages/recette_update.php';
