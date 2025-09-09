<?php

/*
--------------------------------------------------------------------------
Vue : Page de profil
--------------------------------------------------------------------------
*/


$titre = "Profil"; ?>                                                <!-- Titre de la page -->
<?php include __DIR__ . '/../fragments/head.php'; ?>                    <!-- Inclue le head -->
<?php include __DIR__ . '/../fragments/header.php'; ?>                  <!-- Inclue le header -->

<h1>Mon profil</h1>

<section>
    <h2>Bonjour <?= ($utilisateur['pseudo']) ?></h2>
</section>

<section>
    <h2>Mes recettes</h2>
    <?php if (!empty($recettes)): ?>
        <ul>
            <?php foreach ($recettes as $recette): ?>
                <li>
                    <a href="recette_detail.php?id=<?= $recette['id'] ?>">
                        <?= ($recette['titre']) ?>
                    </a>
                    
                    <br>
                    Durée : <?= ($recette['duree']) ?> min 
                    <br>

                    <!-- Boutons d'action -->
                    <a href="recette_update.php?id=<?= $recette['id'] ?>">Modifier</a> 
                    <br>
                    <a href="recette_delete.php?id=<?= $recette['id'] ?>">Supprimer</a>
                </li>
                <br>
                <br>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune recette publiée pour le moment.</p>
    <?php endif; ?>
</section>
