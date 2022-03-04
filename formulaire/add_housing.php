<form action="index.php" method="post">
    <div>
        <input placeholder="Id du propriétaire" type="int" name="id_owner_housing" id="id_owner_housing" required>
        <label for="id_owner_housing">Id du propriétaire</label>
    </div>

    <div>
        <input placeholder="Type de logement" type="int" name="type_housing" id="type_housing" required>
        <label for="type_housing">Type de logement</label>
    </div>

    <div>
        <input placeholder="Latitude"type="float" name="latitude_housing" id="latitude_housing" required>
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

    <button id="submit" name="submit" value="Add_housing" type="submit">Ajouter le logement</button>
</form>
