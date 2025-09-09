<?php

/*
--------------------------------------------------------------------------
Vue : Page de MAJ d'une recette
--------------------------------------------------------------------------
*/

$titre = "Modifier une recette"; 
include __DIR__ . '/../fragments/head.php'; 
include __DIR__ . '/../fragments/header.php'; 

?>

<h1>Modifier la recette</h1>

<?php if (!empty($message)): ?>
    <p><?= ($message) ?></p>
<?php endif; ?>

<form method="post">
    <label for="titre">Titre</label><br>
    <input type="text" name="titre" id="titre" value="<?= ($recette['titre']) ?>"><br><br>

    <label for="description">Description</label><br>
    <textarea name="description" id="description"><?= ($recette['description']) ?></textarea><br><br>

    <label for="duree">Durée (minutes)</label><br>
    <input type="number" name="duree" id="duree" value="<?= ($recette['duree']) ?>"><br><br>

    <label>Difficulté :</label><br>
    <select name="difficulte" required>
        <option value="Facile">Facile</option>
        <option value="Moyenne">Moyenne</option>
        <option value="Difficile">Difficile</option>
    </select><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<p><a href="load_profil.php">Retour au profil</a></p>
