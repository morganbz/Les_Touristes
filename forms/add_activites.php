<form action="index.php" method="post">
    <div>
        <input placeholder="Nom de l'activite" type="text" name="nom_activite" id="nom_activite" required>
        <label for="nom_activite">Nom de l'activité</label>
    </div>

    <div>
        <select name="type_activite" id="type_activite" required>
        <?php
            $indice = 1;
            foreach($TYPE_ACTIVITY as $type){
                echo "\n<option value=$indice>$type</option>";
                $indice++;
            }
        ?>
        </select>
        <label for="type_activite">Type de l'activité</label>
    </div>

    <div>
        <input placeholder="Pays de l'activite" type="text" name="country_activite" id="country_activite" required>
        <label for="coutry_activite">Pays de l'activité</label>
    </div>

    <div>
        <input placeholder="Latitude de l'activite" type="double" name="lat_activite" id="lat_activite" required>
        <label for="lat_activite">Latitude de l'activité</label>
    </div>

    <div>
        <input placeholder="Longitude de l'activite" type="double" name="long_activite" id="long_activite" required>
        <label for="long_activite">Longitude de l'activité</label>
    </div>

    <div>
        <input placeholder="Description de l'activite" type="text" name="desc_activite" id="desc_activite" required>
        <label for="desc_activite">Descritpion de l'activité</label>
    </div>

    <button id="submit" name="submit" value="Add_activite" type="submit">Ajouter l'activité</button>
</form>