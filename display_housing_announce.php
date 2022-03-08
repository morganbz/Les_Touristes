<?php

echo "voir annonces";



//ébauche de fct
echo "<ul>";

$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    $nom = $announce['nom'];
    $latitude = $announce['latitude'];
    $longitude = $announce['longitude'];
    $description = $announce['description'];


?>

<form action="index.php" method="post">
    <div>
        <label for="name_housing_announce_update">Prénom</label>
        <input placeholder="Nom de l'annonce" value="<?php echo $nom;?>" type="text" name="name_housing_announce_update" id="name_housing_announce_update" required>
    </div>

    <div>
        <label for="name_housing_announce_update">Nom</label>
        <input placeholder="Nom" value="<?php echo $lastname;?>" type="text" name="name_housing_announce_update" id="name_housing_announce_update" required>
    </div>

    <div>
        <label for="birth_date_modification">Date de naissance</label>
        <input placeholder="Date de naissance" value="<?php echo $birth_date;?>" type="date" name="birth_date_modification" id="birth_date_modification" required>
    </div>

    <div>
        <label for="description_modification">Description</label>
        <textarea placeholder="Description" name="description_modification" id="description_modification"><?php echo $description;?></textarea>
    </div>

    <button id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
</form>

<?php
}

echo "</ul>";
?>