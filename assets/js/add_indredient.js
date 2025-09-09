document.getElementById("btn-ajouter-ingredient").addEventListener("click", function () {
    const liste = document.getElementById("liste-ingredients");

    const div = document.createElement("div");
    div.innerHTML = `
        <label>Ingrédient :</label>
        <input type="text" name="ingredient_nom[]" placeholder="ex: farine">

        <label>Quantité :</label>
        <input type="text" name="ingredient_quantite[]" placeholder="ex: 200g">
    `;

    liste.appendChild(div);
});
