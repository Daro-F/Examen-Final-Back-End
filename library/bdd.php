<?php

// Librairie de fonctions d'accès à la Base de données

/*
- bddRequest
- bddGetRecord
- bddGetRecords
- bddInsert
- bddUpdate
- bddDelete
*/

function bddRequest ($sql, $param = []) {
    // Rôle : préparer puis éxécuté une requete SQL
    // Paramètres : 
    //          $sql : la requete sql qu'on cherche a éxécuter
    //          $param = [] : tableau de valorisation des paramètres
    // Retour : la requete éxécuté ou false

    // On prepare la requete $bdd
    global $bdd;
    $req = $bdd->prepare($sql);

    // Si $req est false : return false
    if (empty($req)) {
        return false;
    }

    // Une fois que la requete preparer est true on peux l'éxécuter 
    $cr = $req->execute($param);

    // Si $cr est true : on return $req
    if ($cr) {
        return $req;
    } else { // Sinon false
        return false;
    }

}   

function bddGetRecord ($sql, $param = []) {
    // Role : Retourne UNE SEULE ligne récupérée par un SELECT
    // Parametres :
    //          $sql : la requete sql qu'on cherche a éxécuter
    //          $param = [] : tableau de valorisation des paramètres
    // Retour : La ligne récupéré ou false si aucune ligne

    // On utilise bddRequest pour préparer et éxécuter la requete SQL
    $req = bddRequest($sql, $param);

    // Si $req est false on return false
    if ($req === false) {
        return false;
    }

    // Pour récupérer la ligne on utilise fetch donc:
    $ligne = $req->fetch(PDO::FETCH_ASSOC);

    // Si la ligne qu'on a récupérer est vide (aucune ligne) on retourne false
    if (empty($ligne)) {
        return false;
    } else {  // Sinon on retourne la ligne récupérer
        return $ligne;
    }
}

function bddGetRecords ($sql, $param = []) {
    // Role : Retourne TOUTES les lignes récupérées par un SELECT.
    // Parametres :
    //          $sql : la requete sql qu'on cherche a éxécuter
    //          $param = [] : tableau de valorisation des paramètres
    // Retour : les lignes récupérer ou false si aucune ligne

    // Exactement la même methode que bddGetRecord mais on va utiliser fetchAll a la place

    $req = bddRequest($sql, $param);

    if ($req === false) {
        return false;
    }

    $ligne = $req->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ligne)) {
        return false;
    } else {
        return $ligne;
    }
}

function bddInsert($table, $valeurs) {
    // Rôle : Insert un enregistrement dans la base de données et retourne la clé primaire créée 
    // Paramètres :
    //      $table : nom de la table dasn la BDD
    //      $valeurs : tableau donnant les valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    // Retour : 0 en cas d'échec, la clé primaire créée sinon

    // Construire la requête SQL et le tableau de paramètres
    //  INSERT INTO nom de la table SET (pour chaque champ `nomChamp` = :nomChamp )
    //          et pour chaque champ mettre dans la tableau des paramètre l'entrée d'index :nomChamp avec la valeur à donner au champ
    $sql = "INSERT INTO `$table` ";
    // Préparer le tabeau de paramètres 
    $param = [];
    // on doit ajouter pour chque champ de valeurs le texte "`nomChamp` = :nomChamp", en les séparant par une vigule
    // Et ajouter dans le tablea des paramètres : :nomChamp => valeur
    // Pour la partie texte :
    /// On prépare un tabelau des textes "`nomChamp` = :nomChamp", puis on concataène les élémnts séparés par une virgule
    // Préparer le tableau des extarits SQL
    $tab = [];
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $tab[] = "`$nomChamp` = :$nomChamp";
        $param[":$nomChamp"] = $valeurChamp;
    }
    // Concatener les éléments de $tab (dans $sql)
    $sql .= " SET " . implode(", ", $tab);

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne 0
    if ($req == false) {
        return 0;
    }
    // Sinon : on rerourne la valeur de la clé primaire céée, fournie par la méthode lastInsertId de $bdd (variable globale)
    global $bdd;
    return $bdd->lastInsertId();


}

function bddUpdate ($table, $valeurs, $id) {
// Role : Mettre à jour un enregistrement dans la bdd
    // Parametres :
    //          $table : Nom de la table a utiliser dans la bdd
    //          $valeur : Tableau donner les valeurs des colonnes de la table ( [ "nomChamp1" => valeurAdonner, ... ] )
    // Retour : True si c'est ok false sinon

    // On reprend exactement la même methode que pour bddInsert sauf qu'on change la requete INSERT INTO par UPDATE

    $sql = "UPDATE `$table` ";

    $param = [];
    $tab = [];

    foreach($valeurs as $nomChamp => $valeurChamp) {
        if (is_string($nomChamp) && !is_object($valeurChamp)) {
            $tab[] = "`$nomChamp` = :$nomChamp";
            $param[":$nomChamp"] = $valeurChamp;
        }
    }

    if (empty($tab)) {
    return false;
    }

    $sql .= "SET " . implode(", ", $tab);

    // Ici on ajoute la classe WHERE et le parametre :id vu qu'on cible une ligne spécifique de la bdd
    $sql .= " WHERE `id` = :id";
    $param[":id"] = $id;

    $req = bddRequest($sql, $param);

    if ($req == false) {
        return false;
    } else {
        return true;
    }
}

function bddDelete ($table, $id) {
    // Rôle : Supprimer un enregistrement dans la base de données
    // Paramètres :
    //      $table : nom de la table dans la BDD
    //      $id : valeur de la clé primaire (la clé primaire doit s'appeler id)
    // Retour : true si ok, false sinon

    // Construire la requête SQL et le tableau de paramètres
    // DELETE FROM nom de la table WHERE id = :id

    $sql = "DELETE FROM `$table`  WHERE `id` = :id";
    $param = [ ":id" => $id ];

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne false
    if ($req == false) {
        return false;
    } else { // Sinon retourner true
        return true;
    }
}