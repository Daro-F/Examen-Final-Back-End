<?php
include_once __DIR__ . '/library/init.php';

// Récupère l'ID de la reette selectionné
$id_recette = $_GET['id'];

// Vérifie si la méthode est bien post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vote = (int) $_POST['vote'];
    $id_utilisateur = $_SESSION['id'];

    /* 
        Il faut qu'on vérifie si l'utilisateur a déjà voté ou non pour bloquer le compteur
            - Si il a deja voter,
                - Il doit pouvoir supprimer son vote si il appuie sur le bouton de son vote actuel
                - Changer son vote si il appuie sur l'autre bouton
            - Sinon,
                - On enregistre son premier vote
    */

    // Vérifie si l'utilisateur a déja voter 
    $ancien_vote = Note::findByRecetteAndUser($id_recette, $id_utilisateur);

    // Si l'utilisateur a déja un vote
    if ($ancien_vote) {
        
        // Et son vote est le meme que celui présent en base
        if ($ancien_vote['note'] == $vote) {

            // Si on clique sur le même vote on le supprime via bddDelete() 
            bddDelete("note", $ancien_vote['id']);

        } else {
            // Sinon on met à jour avec son nouveau vote via bddUpdate()
            bddUpdate("note", ["note" => $vote], $ancien_vote['id']);
        }

    // Sinon c'est que l'utilisateur n'a pas de vote
    } else {

        // Donc on enregistre son nouveau vote via bddInsert()
        bddInsert("note", 
        [
            "id_recette" => $id_recette,
            "id_utilisateur"=> $id_utilisateur,
            "note" => $vote
        ]);
    }

    // On reste sur la même page mais met a jour le compteur
    header("Location: recette_detail.php?id=" . $id_recette);
    exit;
}

/* ================================================
    Ensuite on charge la recette et son contenu
================================================ */

$sql = "SELECT * FROM recette WHERE id = :id";
$recette = bddGetRecord($sql, [":id" => $id_recette]);

// On récupère toutes les quantités de la recette
$sql = "SELECT * FROM quantite WHERE id_recette = :id";
$quantites = bddGetRecords($sql, [":id" => $id_recette]);

$ingredients = []; // tableau qui contiendra les ingrédients avec leur quantité

// Pour chaque ligne trouvée dans "quantite"
if ($quantites) {
    foreach ($quantites as $q) {
        // On récupère l'ingrédient lié
        $sql = "SELECT * FROM ingredient WHERE id = :id";
        $ingredient = bddGetRecord($sql, [":id" => $q['id_ingredient']]);

        if ($ingredient) {
            // On ajoute la quantité dans le tableau
            $ingredient['quantite'] = $q['quantite'];
            $ingredients[] = $ingredient;
        }
    }
}

/* ================================================
    Puis on prépare le compteur de like
================================================ */

// Compter les likes (note = 1)
$likes = Note::countVotes($id_recette, 1);

// Compter les dislikes (note = 0)
$dislikes = Note::countVotes($id_recette, 0);

include __DIR__ . '/templates/pages/detail.php';
 