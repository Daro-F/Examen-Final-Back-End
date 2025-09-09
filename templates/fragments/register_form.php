<?php

/*
--------------------------------------------------------------------------
Fragment : Formulaire d'inscription
--------------------------------------------------------------------------
*/

?>

<form method="post" action="/register.php">
    <label for="pseudo">Pseudo :</label><br>
    <input type="text" name="pseudo" required><br><br>

    <label for="email">Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">S'inscrire</button>
</form>

<p><a href="acceuil.php">Retour à l'accueil</a></p>
