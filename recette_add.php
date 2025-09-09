<?php
include_once __DIR__ . '/library/init.php';

// Vérifier que l’utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$erreur = "";

/* 
===============================================
    Charger la liste des farines depuis l’API
===============================================
*/ 

/*
https://www.php.net/manual/fr/ref.curl.php

On veut récupérer une liste au format JSON depuis une URL,
Pour la récupérer, il faut utiliser la fonction "curl" pour ça.
    - curl_init initialise une nouvelle session
    - curl_setopt() : permet de définir des options sur la session
        - CURLOPT_URL : l’URL de la ressource à récupérer
        - CURLOPT_RETURNTRANSFER : si défini à true, le résultat est stocké
    - curl_exec() : Renvoie la réponse (ici du JSON brut)
    - curl_close() : ferme la session 
    - json_decode() : convertit le JSON reçu en tableau PHP (associatif si on passe "true")
*/

$curl = curl_init();                                                                        // Ouvre la sessions curl
curl_setopt($curl, CURLOPT_URL, "https://api.mywebecom.ovh/play/fep/catalogue.php");        // Récupère l'URL
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                           // Stock au lieu d'affiché

$reponse = curl_exec($curl);                                                                // Exécute la requête en renvoyant du JSON
curl_close($curl);                                                                          // Ferme la session

$liste_farines = json_decode($reponse, true);                                               // Convertit le JSON en tableau '[xxx, xxx, xxx]

/*
===============================================
    Préparation du formulaire d'ajout d'une recette
===============================================
*/

// Le form doit être en post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = ($_POST['titre']);
    $description = ($_POST['description']);
    $duree = ($_POST['duree']);
    $difficulte = ($_POST['difficulte']);
    $farine = $_POST['farine'];
    $quantite_farine = ($_POST['quantite_farine']);

    // Si les champs "titre", "description", "duree", difficulte" ont été remplis :
    if (!empty($titre) && !empty($description) && $duree > 0 && !empty($difficulte)) {

        // MAIS si le champs "farine" est laissé vide (Au moins 1 farine obligatoire) :
        if (empty($farine)) {

            // Mis a jour de l'erreur
            $erreur = "Vous devez sélectionner au moins une farine.";

        // Sinon, farine est remplis
        } else {
            // On insère la recette en basse avec bddInsert() (pour le moment sans les ingredients)
            $nouvelle_recette = 
            [
                "id_utilisateur" => $_SESSION['id'],
                "titre"          => $titre,
                "description"    => $description,
                "duree"          => $duree,
                "difficulte"     => $difficulte
            ];

            $id_recette = bddInsert("recette", $nouvelle_recette);

            // Si la recette a bien été ajouté
            if ($id_recette) {

                /* ================================
                Ajoute de la farine obligatoire 
                (en utilisant curl)
                ================================ */

                // Même utilisation de curl que pour récupérer le catalogue complet, sauf qu'on rajoute "urlencode($farine)", où $farine vaudra la farine choisi
                // (ex : $farine = "FEP-CACT") et url
                $url_detail = "https://api.mywebecom.ovh/play/fep/catalogue.php?ref=" . ($farine);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url_detail);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $reponse_detail = curl_exec($curl);
                curl_close($curl);

                $detail_farine = json_decode($reponse_detail, true);

                // Si le récupération a réussi, on insert le libellé de la référence choisi dans le champs "nom" de la table "ingredient"
                if ($detail_farine) {
                    $id_farine = bddInsert("ingredient", 
                    [
                        "nom" => $detail_farine['libelle'],
                        "type" => "farine"
                    ]);

                    // Puis on met a jour la table quantité (Les quantités sont ajouter librement depuis le form)
                    bddInsert("quantite", 
                    [
                        "id_recette" => $id_recette,
                        "id_ingredient" => $id_farine,
                        "quantite" => $quantite_farine
                    ]);
                }

                /* ================================
                Ajouter les autres ingrédients
                ================================ */

                // On récupère les tableaux envoyés par le formulaire
                $noms_ingredients = $_POST['ingredient_nom'];
                $quantites_ingredients = $_POST['ingredient_quantite'];

                // On parcourt les deux tableaux
                for ($i = 0; $i < count($noms_ingredients); $i++) {         // Boucle pour parcourir un tableau
                    $nom_ing = trim($noms_ingredients[$i]);                 // Supprime les espaces et récupère le champs de ['ingredient_nom']
                    $quantite_ing = trim($quantites_ingredients[$i]);       // Supprime les espaces et récupère le champs de ['ingredient_quantite']

                    // Si les champs ne sont pas vides on insert dans la table ingredient
                    if (!empty($nom_ing) && !empty($quantite_ing)) {
                        $id_ing = bddInsert("ingredient", 
                        [
                            "nom"  => $nom_ing,
                            "type" => "ingredient"
                        ]);

                        // Puis on met a jour la table quantité (Les quantités sont ajouter librement depuis le form)
                        bddInsert("quantite", [
                            "id_recette"    => $id_recette,
                            "id_ingredient" => $id_ing,
                            "quantite"      => $quantite_ing
                        ]);
                    }
                }

                // Redirection vers la page détail
                header("Location: recette_detail.php?id=" . $id_recette);
                exit;

            // Sinon, la recette n'a pas été ajouter et on met a jour l'erreur
            } else {
                $erreur = "Erreur lors de l'ajout de la recette.";
            }
        }

    // Sinon les champs sont vides et on met a jour l'erreur
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}

// On affiche la vue
include __DIR__ . '/templates/pages/recette_add.php';
