<?php


$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    $nom = $announce['nom'];
    $latitude = $announce['latitude'];
    $longitude = $announce['longitude'];
    $description = $announce['description'];


?>

<form action="index.php" method="post" enctype= 'multipart/form-data'>
    <div>
        <label for="name_housing_announce_update">Nom</label>
        <input placeholder="Nom de l'annonce" value="<?php echo $nom;?>" type="text" name="name_housing_announce_update" id="name_housing_announce_update" required>
    </div>

    <div>
        <label for="latitude_housing_announce_update">Latitude</label>
        <input placeholder="latitude" value="<?php echo $latitude;?>" type="text" name="latitude_housing_announce_update" id="latitude_housing_announce_update" required>
    </div>

    <div>
        <label for="longitude_housing_announce_update">Longitude</label>
        <input placeholder="longitude" value="<?php echo $longitude;?>" type="text" name="longitude_housing_announce_update" id="longitude_housing_announce_update" required>
    </div>

    <div>
        <label for="description_housing_announce_update">Description</label>
        <textarea placeholder="Description" name="description_housing_announce_update" id="description_housing_announce_update"><?php echo $description;?></textarea>
    </div>

    <div>
        <label for='uploadImg'>Image :</label>
        <input type='file' name='uploadImg' id='uploadImg'>
    </div>

    <button id="submit" name="submit" value="housing_announce_update" type="submit">Mettre à jour</button>
</form>

<?php
    $cheminImg = $announce["image_folder"];

    $images = scandir($cheminImg);

    foreach($image as $images){
        if ($image != "."){
            echo "<img src='".$image."' alt='".$nom."'/>";
        }
    }

}


?>