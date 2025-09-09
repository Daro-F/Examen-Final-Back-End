<?php

/*
--------------------------------------------------------------------------
Vue : Page de d'ajout d'une recette
--------------------------------------------------------------------------
*/

$titre = "Ajouter une recette"; 
include __DIR__ . '/../fragments/head.php'; 
include __DIR__ . '/../fragments/header.php'; 

?>

<body>
    <h1>Créer une nouvelle recette</h1>

    <?php if (!empty($error)): ?>                                       <!-- Si il y a une erreur lors de la validation -->
        <p><?= ($error) ?></p>                                          <!-- On l'affiche -->
    <?php endif; ?>

    <?php include __DIR__ . '/../fragments/recette_add_form.php'; ?>    <!-- Inclusion du form -->
</body>
</html>
