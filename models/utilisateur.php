<?php

// Classe représentant un utilisateur de l'application

class utilisateur extends _model {

    protected $table = "utilisateur";
    protected $champs = [
        "pseudo",
        "password"
    ];
    protected $liens = [];

    function loadByPseudo($pseudo) {
        // Rôle : charger un utilisateur en connaissant son pseudo (unique)
        // Paramètres :
        //      $pseudo : pseudo cherché
        // Retour : true, false sinon

        // Construction de la requête SQL :
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE `pseudo`= :pseudo";
        $param = [ ":pseudo" => $pseudo];

        // Récupère la ligne
        $ligne = bddGetRecord($sql, $param);

        // On vérifie qu'on a bien récupérer la ligne
        if (empty($ligne)) {
            return false;
        }

        $this->loadFromTab($ligne);
        $this->id = $ligne["id"];
        return true;
    }

    static function verifyLogin($pseudo, $password) {
        // Rôle : Vérifier si identifiant correspondent avec ceux en base
        // Paramètres :
        //      $pseudo : pseudo de l'utilisateur
        //      $password : mot de passe saisi
        // Retour : tableau utilisateur si les identifiants sont valides, false sinon
        $sql = "SELECT * FROM utilisateur WHERE pseudo = ?";
        $user = bddGetRecord($sql, [$pseudo]);

        if ($user && $user['password'] === $password) {
            return $user;
        }
        return false;
    }

    static function findByPseudo($pseudo) {
        // Rôle : Chercher si un pseudo est présent en base
        // Paramètres :
        //      $pseudo : pseudo cherché
        // Retour : bddGetRecord() pour charger une ligne de la base, avec la requete SQL
        return bddGetRecord('SELECT * FROM utilisateur WHERE pseudo = ?', [$pseudo]);
    }

    static function findByid($id) {
        // Rôle : Chercher si un id est présent en base
        // Paramètres :
        //      $id : id cherché
        // Retour : bddGetRecord() pour charger une ligne de la base, avec la requete SQL
        return bddGetRecord('SELECT * FROM utilisateur WHERE id = ?', [$id]);
    }

    static function create($new) {
        // Rôle : Inséré un pseudo en base
        // Paramètres :
        //      $new : données a insérer
        // Retour : bddInsert() pour inserer en base
        return bddInsert('utilisateur', $new);
    }
}
