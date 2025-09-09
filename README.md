Farine & Potiron – Site de partage de recettes

Projet réalisé dans le cadre de l’examen Back-End (Bloc 2 du RNCP).

L’objectif est de développer un site web pour partager des recettes utilisant les farines spéciales de Farine & Potiron.
Le site permet de noter et gérer ses recettes, en respectant une architecture MVC et des pratiques POO en PHP.

Fonctionnalités :

  Utilisateurs

    - Création de compte avec pseudo, email et mot de passe

    - Connexion par pseudo ou email

    - Gestion de session (connexion/déconnexion)

    - Page profil avec possibilité de :

    - Consulter ses recettes

    - Modifier ou supprimer ses recettes

  Recettes

    - Création de recettes avec :

      - Titre

      - Description détaillée

      - Durée

      - Difficulté

      - Ingrédients (séparation Farine & autres ingrédients)

    - Modification et suppression (seulement par le créateur)

    - Consultation libre (même sans compte)

  Interactions

    - Noter une recette (Like / Dislike)

    - Commenter une recette

    - Modifier ou supprimer ses commentaires / notes

    API externe

  Intégration de l’API Farine & Potiron pour afficher la liste des farines disponibles :

    - Catalogue complet : https://api.mywebecom.ovh/play/fep/catalogue.php

  Améliorations possibles

    - Sécuriser les mots de passe avec password_hash() / password_verify()

    - Ajouter un CAPTCHA à l’inscription (anti-robots)

    - Permettre la modification du compte utilisateur

    - Afficher les dates (création / mise à jour) des recettes et commentaires

    - Recherche multi-critères avancée
