<form action="index.php" method="post">
    <div>
        <input placeholder="Id de l'activite" type="int" name="id_activite" id="id_activite" required>
        <label for="id_activite">Id de l'activité</label>
    </div>

    <div>
        <select name="type_activite">
            <option value="null">type d'activité</option>
            <option value="randonnee">Randonnée</option>
            <option value="Cinema">Cinéma</option>
            <option value="baignade">Baignade</option>
        </select>
        <label for="type_activite">type d'activité</label>
    </div>

    <div>
        <input placeholder="Prix de l'activite" type="int" name="price_activite" id="price_activite" required>
        <label for="price_activite">Prix de l'activité</label>
    </div>

    <button id="submit" name="submit" value="Add_activite" type="submit">Ajouter l'activité</button>
</form>