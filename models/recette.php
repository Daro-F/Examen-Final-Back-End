<?php
class Recette extends _model {
    protected $table = "recette";
    protected $champs = ["id_utilisateur", "titre", "description", "duree", "difficulte"];
    protected $liens = [];

    public static function findRecetteByPseudo($pseudo) {
        // Rôle : Récupérer toutes les recettes d'un utilisateur via son pseudo
        // Paramètres :
        //      $pseudo : pseudo cherché
        // Retour : bddGetRecord() pour charger une ligne de la base, avec la requete SQL

        // Récupérer l'utilisateur
        $user = utilisateur::findByPseudo($pseudo);

        $sql = "SELECT * FROM recette WHERE id_utilisateur = ?";
        return bddGetRecords($sql, [$user['id']]);
    }
}
