<?php
/*
--------------------------------------------------------------------------
Vue : Page d'acceuil
--------------------------------------------------------------------------
   - Liste toute les recettes
   - Permet de rediriger vers une recette en passant l'id dans l'url ("detail.php?id=<?= $recette->id() ?>")
   - Bouton de connexion et déconnexion selon si l'utilisateur est connecté
*/

?>

<body>
<?php $titre = "Accueil"; 
include __DIR__ . '/../fragments/head.php'; 
include __DIR__ . '/../fragments/header.php'; 
?>
                
    <!-- Liste des recettes-->
    <section>

        <h1>Liste des recettes</h1>

        <!-- Si il y a au moins 1 recettes -->
        <?php if (!empty($recettes)): ?>

            <ul>
                <!-- Pour chaques recettes trouvé -->
                <?php foreach ($recettes as $recette): ?>

                    <li class="recette-card">

                        <!-- On affiche le titre, la description et la durée de la recette dans une balise <a> -->
                        <a href="recette_detail.php?id=<?= $recette->id() ?>">
                            <h2><?= ($recette->get("titre")) ?></h2>
                            <p><?= ($recette->get("description")) ?></p>
                            <p><?= ($recette->get("duree")) ?> min</p>
                        </a>
                        
                    </li>
                <?php endforeach; ?>
            </ul>

        <!-- Sinon, il n'y a pas de recette et on affcihe le texte "Aucune recette trouvée." -->
        <?php else: ?>
            <p>Aucune recette trouvée.</p>
        <?php endif; ?>
    </section>

</body>
</html>