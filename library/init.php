<?php

// Initialisations communes à tous les controleurs 
// (à inclure en début de chaque controleur)


// mettre en place les messages d'erreur (pour la mise au point)
ini_set('display_errors',1);
error_reporting(E_ALL);

// Initialiser / récupérer les infos de session
session_start();    // gère le cookie, récupère $_SESSION avec sa dernière valeur connue

// Charger les librairies
include __DIR__ . '/bdd.php';
include __DIR__ . '/session.php';

// Charger les différentes classes de modèle de données
include __DIR__ . '/../models/_model.php';
include __DIR__ . '/../models/utilisateur.php';
include __DIR__ . '/../models/ingredient.php';
include __DIR__ . '/../models/note.php';
include __DIR__ . '/../models/quantite.php';
include __DIR__ . '/../models/recette.php';
include __DIR__ . '/../models/commentaire.php';

// Ouvrir la BDD dans la variable globale $bdd
global $bdd;
$bdd = new PDO("mysql:host=172.18.0.1;dbname=fep-fldr;charset=UTF8", "fep-fldr", "O-21povhqn");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);