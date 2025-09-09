<?php

/*
--------------------------------------------------------------------------
Vue : Page de connexion
--------------------------------------------------------------------------
    - Inclue le fragment "head.php" pour afficher l'entête HTML
    - Inclue le fragment "login_form.php" pour afficher le formulaire de connexion
*/


$titre = "Connexion"; ?>                                                <!-- Titre de la page -->
<?php include __DIR__ . '/../fragments/head.php'; ?>                    <!-- Inclue le head -->

<body>
    <h1>Connexion</h1>

    <?php if (!empty($error)): ?>                                       <!-- Si il y a une erreur lors de la validation -->
        <p><?= ($error) ?></p>                                          <!-- On l'affiche -->
    <?php endif; ?>

    <?php include __DIR__ . '/../fragments/login_form.php'; ?>          <!-- Inclue le formulaire de connexion -->

    <p><a href="accueil.php">Retour à l'accueil</a></p>                 <!-- Bouton pour retourner a l'accueil -->
</body>
</html>
