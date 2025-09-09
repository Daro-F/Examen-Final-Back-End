<?php
include_once __DIR__ . '/library/init.php';

// Vérifie si l'utilisater est connecter, si oui, on le redirige vers l'accueil
if (isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit;
}

/*
===============================================
Préparation du formulaire d'inscription
===============================================
*/

// Préparation des l'erreurs potentiel du form
$error = "";

// Le form doit être en post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = ($_POST['pseudo']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);

    // Si le pseudo, l'email et le mot de passe ne sont pas vide,
    if (!empty($pseudo) && !empty($email) && !empty($password)) {
        
     
        // Vérifie si l'email ou le pseudo sont déja utilisé avec bddGetRecord()
        $checkUser = 
        bddGetRecord("SELECT * FROM utilisateur WHERE email = :email OR pseudo = :pseudo", 
        [
            ":email" => $email,
            ":pseudo" => $pseudo
        ]);

        // Erreur si le pseudo ou email déja utilisé
        if ($checkUser) {
            $error = "Cet email ou pseudo est déjà utilisé.";
        } else {

            // Sinon ils sont libre, on peux les inclure en base
            $newUser = 
            [
                "pseudo"   => $pseudo,
                "email"    => $email,
                "password" => $password
            ];

            // On utilise bddInsert pour insérer en base
            $new = bddInsert("utilisateur", $newUser);

            // Puis on redirige vers la connexion
            header("Location: log.php");
            exit;
        
        }
    
    // Sinon les champs sont vides, on met a jour l'erreur
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

include __DIR__ . '/templates/pages/register.php';