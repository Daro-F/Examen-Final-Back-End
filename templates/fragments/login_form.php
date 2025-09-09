<?php

/*
--------------------------------------------------------------------------
Fragment : Formulaire de connexion 
--------------------------------------------------------------------------
*/

?>

<form method="post" action="/log.php">
    <label for="email">Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>