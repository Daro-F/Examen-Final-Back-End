<?php
include_once __DIR__ . '/../fragments/head.php';

/*
--------------------------------------------------------------------------
Vue : Formulaire d'inscription
--------------------------------------------------------------------------
    - Affiche le formulaire (fragments/register_form.php)
    - Peut afficher un message d'erreur si $_GET['error'] existe
*/

?>

<body>

<?php $titre = "Connexion"; ?>                                          <!-- Titre de la page -->
<?php include __DIR__ . '/../fragments/head.php'; ?>                    <!-- Inclue le head -->
<?php include __DIR__ . '/../fragments/header.php'; ?>                  <!-- Inclue le header -->

    <?php if (!empty($error)): ?>                                       <!-- Si il y a une erreur lors de la validation -->
        <p><?= ($error) ?></p>                                          <!-- On l'affiche -->
    <?php endif; ?>

    <div class="register-container">
        <?php include_once __DIR__ . '/../fragments/register_form.php'; ?>
    </div>
</body>
</html>
