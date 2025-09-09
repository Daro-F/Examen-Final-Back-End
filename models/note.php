<?php

class Note extends _model {
    protected $table = "note";
    protected $champs = [
        "id_recette",
        "id_utilisateur",
        "note"
    ];

    static function findByRecetteAndUser($id_recette, $id_utilisateur) {
        // Role : Trouver si un utilisateur a dèjà voté
        // Parametres :
        //          $id_utilisateur : identifiant de l’utilisateur
        //          $id_recette : identifiant de la recette
        // Retour : bddGetRecord pour touver si une ligne existe
        $sql = "SELECT * FROM note WHERE id_recette = :recette AND id_utilisateur = :utilisateur";
        return bddGetRecord ($sql, 
        [
            ":recette" => $id_recette,
            ":utilisateur" => $id_utilisateur
        ]);
    }

    static function countVotes ($id_recette, $valeur) {
        // Role : Mettre a jour le compteur de vote selon le vote de l'utilisateur
        // Parametres :
        //          $valeur : valueur du vote (sois 0 (dislike) ou 1 (like))
        //          $id_recette : identifiant de la recette
        // Retour : Le resultat (0 ou 1) si true 0 sinon
        $sql = "SELECT COUNT(*) as total FROM note WHERE id_recette = :id AND note = :valeur";
        $result = bddGetRecord($sql, [":id" => $id_recette, ":valeur" => $valeur]);
        if ($result) {
            return $result['total'];
        } else {
            return 0;
        }
    }
}