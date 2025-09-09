<form method="post" action="/recette_add.php">

    <!-- Titre de la recette -->
    <label for="titre">Titre :</label><br>
    <input type="text" name="titre" required><br><br>

    <!-- Description de la recette -->
    <label for="description">Description :</label><br>
    <textarea name="description" required></textarea><br><br>

    <!-- Duree en minute -->
    <label for="duree">Durée (minutes) :</label><br>
    <input type="number" name="duree" required><br><br>

    <!-- Option de difficulte (facile, moyenne, difficile) -->
    <label>Difficulté :</label><br>
    <select name="difficulte" required>
        <option value="Facile">Facile</option>
        <option value="Moyenne">Moyenne</option>
        <option value="Difficile">Difficile</option>
    </select><br><br>

    <!-- Sélection de la farine obligatoire -->
    <h3>Farine (obligatoire)</h3>
    <select name="farine" required>
        <option value="">Choisiser la farine utilisé</option>

        <?php foreach ($liste_farines as $reference => $libelle): ?>

            <option 
            value="<?= ($reference) ?>"><?= ($libelle) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <!-- Quantité associée a la farine -->
    <input type="text" name="quantite_farine" placeholder="Ex: 200g" required><br><br>

    <!-- Bloc pour ajouter d’autres ingrédients libres -->
    <h3>Autres ingrédients</h3>

    <div id="liste-ingredients">
        <div>
            <label>Ingrédient :</label>
            <input type="text" name="ingredient_nom[]" placeholder="ex: œuf">

            <label>Quantité :</label>
            <input type="text" name="ingredient_quantite[]" placeholder="ex: 2">
        </div>
    </div>

    <br>
    
    <!-- Bouton permettant d’ajouter dynamiquement un ingrédient/quantité -->
    <button type="button" id="btn-ajouter-ingredient">+ Ajouter un ingrédient</button>

    <!-- Script JS associé au bouton-->
    <script src="/assets/js/add_indredient.js"></script>

    <button type="submit">Créer la recette</button>
</form>

<!-- Lien pour retourner à la page d’accueil -->
<p><a href="accueil.php">Retour à l'accueil</a></p>
