<form action="index.php" method="post">
    <div>
    <label for="id_owner_housing">Type de logement</label>
        <select name="type_housing" id="id_owner_housing">
            <?php
                $indice = 0;
                foreach($TYPE_HOUSING as $type){
                    echo "\n<option value=$indice>$type</option>";
                    $indice++;
                }
            ?>
        </select>
    </div>

    <div>
        <input placeholder="Latitude" type="float" name="latitude_housing" id="latitude_housing" required>
        <label for="latitude_housing">Latitude</label>
    </div>

    <div>
        <input placeholder="Longitude" type="float" name="longitude_housing" id="longitude_housing" required>
        <label for="longitude_housing">Longitude</label>
    </div>

    <div>
        <input placeholder="Nom du logement" type="text" name="name_housing" id="name_housing" required>
        <label for="name_housing">Nom du logement</label>
    </div>

    <div>
        <input placeholder="Description" type="text" name="description_housing" id="description_housing" required>
        <label for="description_housing">Description</label>
    </div>

    <div>
        <input placeholder="Prix de l'annonce" type="int" name="price_announce" id="price_announce" required>
        <label for="price_announce">Prix par nuit</label>
    </div>

    <div>
        <input placeholder="Date du début de l'annonce" type="date" name="date_start_announce" id="date_start_announce" required>
        <label for="date_start_announce">Date du début de l'annonce</label>
    </div>

    <div>
        <input placeholder="Date de fin de l'annonce" type="date" name="date_end_announce" id="date_end_announce" required>
        <label for="date_end_announce">Date de la fin de l'annonce</label>
    </div>

    <button id="submit" name="submit" value="Add_housing_announce" type="submit">Ajouter le logement</button>
</form>
