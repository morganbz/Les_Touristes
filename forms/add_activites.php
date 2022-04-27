<form action="index.php" method="post">
    <div>
        <input placeholder="Nom de l'activite" type="text" name="nom_activite" id="nom_activite" required>
        <label for="nom_activite">Nom de l'activité</label>
    </div>

    <div>
        <select name="type_activite" id="type_activite" required>
        <?php
            $indice = 0;
            foreach($TYPE_ACTIVITY as $type){
                echo "\n<option value=$indice>$type</option>";
                $indice++;
            }
        ?>
        </select>
        <label for="type_activite">Type de l'activité</label>
    </div>

    <div>
        <input placeholder="Ville de l'activite" type="text" name="city_activite" id="city_activite" required>
        <label for="city_activite">Ville de l'activité</label>
    </div>

    <div>
        <input placeholder="Adresse de l'activite" type="text" name="adress_activite" id="adress_activite" required>
        <label for="adress_activite">Adresse de l'activité</label>
    </div>

    <div>
        <input placeholder="Code postal de l'activite" type="double" name="post_activite" id="post_activite" required>
        <label for="post_activite">Code Postal de l'activité</label>
    </div>

    <div>
        <input placeholder="Description de l'activite" type="text" name="desc_activite" id="desc_activite" required>
        <label for="desc_activite">Descritpion de l'activité</label>
    </div>

    <button id="submit" name="submit" value="Add_activite" type="submit">Ajouter l'activité</button>
</form>