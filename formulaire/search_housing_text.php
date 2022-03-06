<form action="index.php" method="post">
    <div>
        <input type="date" name="date_start" id="date_start" required>
        <label for="id_housing_announce">Date de début du voyage</label>
    </div>

    <div>
        <input type="date" name="date_end" id="date_end" required>
        <label for="id_housing_announce">Date de fin du voyage</label>
    </div>

    <div>
        <input placeholder="Prix min" type="int" name="price_min" id="price_min" required>
        <label for="price_announce">Prix minimum</label>
    </div>

    <div>
        <input placeholder="Prix max" type="int" name="price_max" id="price_max" required>
        <label for="price_announce">Prix maximum</label>
    </div>

    <button id="submit" name="submit" value="search_housing" type="submit">Rechercher</button>
</form>
