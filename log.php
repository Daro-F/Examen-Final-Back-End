<?php
include_once __DIR__ . '/library/init.php';

// Si déjà connecté, on renvoie direct vers l'accueil
if (isset($_SESSION['id'])) {
    header("Location: accueil.php");
    exit;
}

/*
===============================================
Préparation du formulaire de connextion
===============================================
*/

// Préparation des l'erruers potentiel du form
$error = "";

// Le form doit être en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = ($_POST['email']);
    $password = ($_POST['password']);

    // Vérifie que les champs ont été remplis
    if (!empty($email) && !empty($password)) {

        $sql = "SELECT * FROM utilisateur WHERE email = :email";                // Récupère l'email en base
        $user = bddGetRecord($sql, [":email" => $email]);                       // Utilise bddGetRecord() avec l'émail donné puis le compare avec l'émail en base

        // Si les emails ET le mdp correspondent (ATTENTION PAS DE password_verify / hash DONC SECURITE FAIBLE)
        if ($user && $password === $user["password"]) {

            // On ouvre une SESSION en passant l'id de l'utilisateur connecté
            $_SESSION['id'] = $user["id"];
            $_SESSION['pseudo'] = $user["pseudo"];                              // Attribut le pseudo de l'utilisateur a la SESSION (Utile surtout pour afficher "Bonjour, "pseudo")
            header("Location: accueil.php");                                    // Puis on redirige vers l'accueil
            exit;
        // Sinon, les emails et mdp ne correspndent pas et on met a jour l'erreur
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    // Sinon, les champs n'ont pas été remplis et met a jour l'erreur
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Affiche le formulaire de connexion
include __DIR__ . '/templates/pages/login.php';