<?php

/*
--------------------------------------------------------------------------
Fragment : DOCTYPE + head
--------------------------------------------------------------------------
    - Ce fragment sert a afficher le head de la page dans les différents fichiers
    - Inclue :
        - Le fichier css qui sera inclue dans les pages
        - <?= $titre ?> pour mettre a jour le titre de la page
*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>