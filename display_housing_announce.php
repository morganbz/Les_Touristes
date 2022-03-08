<?php


$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    $nom = $announce['nom'];
    $latitude = $announce['latitude'];
    $longitude = $announce['longitude'];
    $description = $announce['description'];
    $adresse = getAddress($latitude, $longitude);


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
        <label for="adresse_housing_announce_update">Adresse</label>
        <input placeholder="adresse" value="<?php echo $adresse;?>" type="text" name="adresse_housing_announce_update" id="adresse_housing_announce_update" required>
    </div>

    <div>
        <label for="description_housing_announce_update">Description</label>
        <textarea placeholder="Description" name="description_housing_announce_update" id="description_housing_announce_update"><?php echo $description;?></textarea>
    </div>

    <div>
        <label for='modification_image'>Image :</label>
        <input type='file' name='modification_image' id='modification_image'>
    </div>

    <button id="submit" name="submit" value="housing_announce_update" type="submit">Mettre à jour</button>
</form>

<?php
    $cheminImg = $announce["image_folder"];

    if (isset ($cheminImg)){
        $images = scandir($cheminImg);
        foreach($images as $image){
            if ($image != "." && $image != ".."){
                echo "<img src='".$cheminImg."/".$image."' alt='".$nom."'/>";
            }
        }
    }
    
    if (isset($_SESSION["errors_modification_image"])){
        echo "<p class='error'>Erreurs sur l'ajout d'image :</p>";
        echo "<ul>";
        foreach($_SESSION["errors_upload_img"] as $error_upload_img)
            echo "<li class='error'>$error_upload_img</li>";
        echo "</ul>";
    }

}


?>