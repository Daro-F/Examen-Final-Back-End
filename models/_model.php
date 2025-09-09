<?php

/*
Classe _model : Classe mère de tous les objets manipulés en base
Toutes les classes spécifiques héritent de celle-ci
*/

class _model {

    protected $table = "";       // Nom de la table
    protected $champs = [];      // Liste des champs simples (hors id)
    protected $liens = [];       // Liste des champs liés à d’autres objets

    protected $valeurs = [];     // Valeurs des champs simples
    protected $id = null;        // ID de l’objet (clé primaire)

    function __construct($id = null) {
        // Role : Crée un nouvel objet, et charge les données si un ID est fourni
        // Paramètres : $id (optionnel) = identifiant de la ligne à charger
        // Retour : aucun
        if (!is_null($id)) {
            $this->loadFromId($id);
        }
    }

    function is() {
        // Role : Vérifie si l'objet est chargé (c’est-à-dire a un ID)
        // Paramètres : aucun
        // Retour : true si chargé, false sinon
        return !empty($this->id);
    }

    function id() {
        // Role : Retourne l’ID de l’objet
        // Paramètres : aucun
        // Retour : int = id ou 0
        return $this->id;
    }

    function get($nom) {
        // Role : Récupère la valeur d’un champ
        // Paramètres : $nom = nom du champ à récupérer
        // Retour : soit une valeur simple (ex : "Dupont"), soit un objet (si c’est un lien)

        // Si ce n’est pas un champ connu → on retourne vide
        if (!in_array($nom, $this->champs)) return "";

        // Si c’est un champ de type lien (ex : pere, mere)
        if (isset($this->liens[$nom])) {
            $typeObjet = $this->liens[$nom];
            $idLien = $this->valeurs[$nom] ?? null;

            // Si l’ID est non vide → on retourne l’objet pointé
            if (!empty($idLien)) {
                return new $typeObjet($idLien);
            } else {
                return new $typeObjet(); // Objet vide
            }
        }

        // Sinon, on retourne la valeur du champ si elle existe, ou une chaîne vide
        return $this->valeurs[$nom] ?? "";
    }


    function set($nom, $valeur) {
        // Role : Modifie la valeur d’un champ
        // Paramètres : $nom = champ à modifier, $valeur = nouvelle valeur
        // Retour : true si le champ est autorisé, false sinon
        if (!in_array($nom, $this->champs)) return false;
        $this->valeurs[$nom] = $valeur;
        return true;
    }

    function loadFromId($id) {
        // Role : Charge un objet depuis la base à partir de son ID
        // Paramètres : $id = identifiant recherché
        // Retour : true si trouvé, false sinon
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE id = :id";
        $tab = bddGetRecord($sql, [":id" => $id]);

        if (!$tab) {
            $this->valeurs = [];
            $this->id = null;
            return false;
        }

        $this->loadFromTab($tab);
        $this->id = $id;
        return true;
    }

    function insert() {
        // Role : Ajoute un nouvel enregistrement en base
        // Paramètres : aucun
        // Retour : true si succès, false sinon
        if ($this->is()) return false;

        $id = bddInsert($this->table, $this->valeurs);
        if (!$id) return false;

        $this->id = $id;
        return true;
    }

    function update() {
        // Role : Met à jour un enregistrement existant en base
        // Paramètres : aucun
        // Retour : true si succès, false sinon
        if (!$this->is()) return false;
        return bddUpdate($this->table, $this->valeurs, $this->id);
    }

    function delete() {
        // Role : Supprime l’enregistrement courant en base
        // Paramètres : aucun
        // Retour : true si supprimé, false sinon
        if (!$this->is()) return false;

        $ok = bddDelete($this->table, $this->id);
        if ($ok) $this->id = null;
        return $ok;
    }

    function listAll() {
        // Role : Récupère tous les objets de cette table
        // Paramètres : aucun
        // Retour : tableau d’objets indexé par id
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table`";
        $tab = bddGetRecords($sql);
        return $this->tab2TabObjects($tab);
    }

    function listFiltree($filtres = [], $tri = []) {
        // Role : Récupère des objets avec filtres et tri
        // Paramètres :
        //   $filtres : tableau [champ => valeur]
        //   $tri : tableau [champ1, champ2...]
        // Retour : tableau d’objets filtrés et triés
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table`";
        $param = [];
        $conditions = [];

        foreach ($filtres as $champ => $valeur) {
            $conditions[] = "`$champ` = :$champ";
            $param[":$champ"] = $valeur;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!empty($tri)) {
            $sql .= " ORDER BY " . implode(", ", $tri);
        }

        $tab = bddGetRecords($sql, $param);
        return $this->tab2TabObjects($tab);
    }

    function loadFromTab($tab) {
        // Role : Remplit les valeurs de l’objet à partir d’un tableau associatif
        // Paramètres : $tab = tableau [champ => valeur]
        // Retour : true
        foreach ($this->champs as $nomChamp) {
            if (isset($tab[$nomChamp])) {
                $this->set($nomChamp, $tab[$nomChamp]);
            }
        }
        return true;
    }

    function listeChampsPourSelect() {
        // Role : Génère une chaîne pour SELECT avec tous les champs + id
        // Paramètres : aucun
        // Retour : string du type `id`, `champ1`, `champ2`...
        $texte = "`id`";
        foreach ($this->champs as $nomChamp) {
            $texte .= ",`$nomChamp`";
        }
        return $texte;
    }

    function tab2TabObjects($tab) {
        // Role : Transforme un tableau de lignes SQL en objets PHP
        // Paramètres : $tab = tableau de lignes (avec "id")
        // Retour : tableau d’objets indexés par id
    if (!is_array($tab)) {
            return []; // retourne un tableau vide si pas de résultats
        }

        $result = [];
        foreach ($tab as $elt) {
            $objet = new static();
            $objet->loadFromTab($elt);
            $objet->id = $elt["id"];
            $result[$objet->id()] = $objet;
        }

        return $result;
    }
}
