<?php 

$titre = "Détail de la recette"; 
include __DIR__ . '/../fragments/head.php';
include __DIR__ . '/../fragments/header.php'; 

?>



<body>
    <h1><?= ($recette['titre']) ?></h1>

    <p>
        Description :<br><br>
        <?= (($recette['description'])) ?>
    </p>

    <p>
        Durée :
        <?= ($recette['duree']) ?> min
    </p>
    <p>
        Difficulté : 
            <?= ($recette['difficulte']) ?>
    </p>

    <!---------------------------
        Gestion des ingrédients
    ---------------------------->
    <?php
    /* 
    On veut afficher chaque ingrédient avec sa quantité
    Donc ici on peut faire un foreach et afficher chaque ligne dans un <li>
    Puis dans un <li> on indique simplement le nom et la quantité via ['nom'] et ['quantite']
    */
    ?>

    <h2>Ingrédients</h2>
    <?php if (!empty($ingredients)): ?>
        <ul>
            <?php foreach ($ingredients as $ing): ?>
                <li>
                    <?= ($ing['nom']) ?> : 
                    <?= ($ing['quantite']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!---------------------------
    Gestion des votes
    ---------------------------->

    <?php
    /*
    Pour les votes, normalement on a juste besoin de faire un form avec 2 buttons
    Le premier (like) avec "value = 1" vu que dans le controlleur 1 = like
    Et pour le deuxième (dislike) "value = 0" car 0 = dislike

    Il faut juste s'assurer qu'un utilisateur est connecté pour afficher les bouttons
    Si pas de connexion, on envoie un lien pour se connecter
    */
    ?>

    <h2>Votes</h2>
    <?php if (isset($_SESSION['id'])): ?>
        <form method="post" action="recette_detail.php?id=<?= $recette['id'] ?>">
            <button type="submit" name="vote" value="1">Like</button>
            <span><?= $likes ?></span>

            <button type="submit" name="vote" value="0">Dislike</button>
            <span><?= $dislikes ?></span>
        </form>
    <?php else: ?>
        <p><a href="log.php">Connectez-vous</a> pour voter.</p>
    <?php endif; ?>

    <p><a href="accueil.php">Retour à l'accueil</a></p>
</body>
</html>
