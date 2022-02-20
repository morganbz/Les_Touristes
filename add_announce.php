<form action="index.php" method="post">
    <div>
        <input placeholder="Id du logement" type="int" name="id_housing_announce" id="id_housing_announce" required>
        <label for="id_housing_announce">Id du logement</label>
    </div>

    <div>
        <input placeholder="Prix de l'annonce" type="int" name="price_announce" id="price_announce" required>
        <label for="price_announce">Prix de l'annonce</label>
    </div>

    <div>
        <input placeholder="Date du début de l'annonce" type="date" name="date_start_announce" id="date_start_announce" required>
        <label for="date_start_announce">Date du début de l'annonce</label>
    </div>

    <button id="submit" name="submit" value="Add_announce" type="submit">Ajouter l'annonce</button>
</form>
