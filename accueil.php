<?php
include_once __DIR__ . '/library/init.php';

$recetteModel = new Recette();
$recettes = $recetteModel->listAll();

include __DIR__ . '/templates/pages/home.php';