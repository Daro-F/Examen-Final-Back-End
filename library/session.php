<?php

// Librairie : fonctions de gestion de la session

/*
    connecter($id)           connecte un utilisateur
    deconnecter()            déconnecte l'utilisateur connecté
    estConnecte()            retourne true si un utilisateur est connecté
    verifLogin()             vérifie les identifiants et retourne l'utilisateur ou false
    moi()                    retourne l'objet utilisateur connecté (ou vide si non connecté)
*/

/*
    $_SESSION["id"] :
        - vide ou 0 = personne connectée
        - contient un id = utilisateur connecté
*/


function connecter($id) {
    // Rôle : connecter un utilisateur (enregistrer son id en session)
    // Paramètres : $id = id de l'utilisateur à connecter
    // Retour : true
    $_SESSION["id"] = $id;
    return true;
}


function deconnecter() {
    // Rôle : déconnecter l'utilisateur actuel (vider l'id en session)
    // Paramètres : néant
    // Retour : true
    $_SESSION["id"] = 0;
    return true;
}


function estConnecte() {
    // Rôle : vérifier si un utilisateur est actuellement connecté
    // Paramètres : néant
    // Retour : true si connecté, false sinon
    return (!empty($_SESSION["id"]));
}


function verifLogin($login, $password) {
    // Rôle : vérifier si les identifiants sont valides
    // Paramètres : 
    //      $login = email de l'utilisateur
    //      $password = mot de passe saisi
    // Retour : l'objet utilisateur correspondant si valide, false sinon

    $utilisateur = new utilisateur();              // Création d’un objet utilisateur vide
    $utilisateur->loadByPseudo($login);             // Recherche par email

    if (!$utilisateur->is()) {
        return false;                              // Aucun utilisateur trouvé
    }

    if ($password == $utilisateur->get("password")) {
        return $utilisateur;                       // Mot de passe correct
    } else {
        return false;                              // Mot de passe incorrect
    }
}


function moi() {
    // Rôle : récupérer l'utilisateur actuellement connecté
    // Paramètres : néant
    // Retour : un objet utilisateur (chargé si connecté, vide sinon)
    if (estConnecte()) {
        return new utilisateur($_SESSION["id"]);
    } else {
        return new utilisateur(); // Objet vide
    }
}
