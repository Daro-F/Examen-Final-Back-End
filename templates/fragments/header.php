<?php

/*
--------------------------------------------------------------------------
Fragment : Header + Nav
--------------------------------------------------------------------------
    - Ce fragment sert a afficher le header de la page dans les différents fichiers
*/

?>

<header>
        <nav>

            <!-- Vérifie si une connexion est en cours -->
           <?php if (isset($_SESSION['id'])): ?>

                <!-- Si oui, on affiche le bouton de déconnexion -->
                <div>
                    <a href="/logout.php">Déconnexion</a>
                    <a href="/recette_add.php">Crée votre recette</a>
                    <a href="/load_profil.php">Mon profil</a>
                </div>

            <?php else: ?>
                <!-- Sinon, bouton de connexion -->
                <a href="/log.php">Connexion</a>
                <a href="/register.php">Inscription</a>
            <?php endif; ?>

        </nav>

        
    </header>