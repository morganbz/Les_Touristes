<?php


$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    $nom = $announce['nom'];
    $latitude = $announce['latitude'];
    $longitude = $announce['longitude'];
    $description = $announce['description'];
    $type = $announce['type'];

    $adresse = getAddress($latitude, $longitude);

    $id = $announce['id'];


?>

<form action="index.php" method="post" enctype= 'multipart/form-data'>
    <div>
        <label for="name_housing_announce_update">Nom</label>
        <input placeholder="Nom de l'annonce" value="<?php echo $nom;?>" type="text" name="name_housing_announce_update" id="name_housing_announce_update" required>
    </div>

    <div>
        <label for="id_owner_housing">Type de logement</label>
        <select name="type_housing" id="id_owner_housing">
            <?php
                $indice = 0;
                foreach($TYPE_HOUSING as $type){
                    if($type == $indice){
                        echo "\n<option value=$indice selected>$type</option>";
                    } else {
                        echo "\n<option value=$indice>$type</option>";
                    }
                    $indice++;
                }
            ?>
        </select>
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
        <p>Ce qui correspond à l'adresse : <?php echo $adresse;?></p> 
    </div>

    <div>
        <label for="description_housing_announce_update">Description</label>
        <textarea placeholder="Description" name="description_housing_announce_update" id="description_housing_announce_update"><?php echo $description;?></textarea>
    </div>

    <div>
        <label for='modification_image'>Image :</label>
        <input type='file' name='modification_image' id='modification_image'>
    </div>

    <div class = "id_housing_announce" private>
        <label for="id_housing_announce_update">ID Housing announce</label>
        <input placeholder="id" value="<?php echo $id;?>" type="text" name="id_housing_announce_update" id="id_housing_announce_update">
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
                ?>
                <form action="index.php" method="post">
                    <button id="del_img" name="del_img" value="<?php echo $cheminImg;?>">Supprimer</button>
                </form>
                <?php
            }
        }
    }
    
    if (isset($_SESSION["errors_modification_image"])){
        echo "<p class='error'>Erreurs sur l'ajout d'image :</p>";
        echo "<ul>";
        foreach($_SESSION["errors_modification_image"] as $error_upload_img)
            echo "<li class='error'>$error_upload_img</li>";
        echo "</ul>";
    }

}
?>
