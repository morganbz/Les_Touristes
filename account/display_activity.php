<?php

if (isset($_SESSION["errors_update_activity"])){
    echo "<ul>";
    foreach ($_SESSION["errors_update_activity"] as $error){
        echo "<li>$error</li>";
    }
    echo "</ul>";
}

$listeActivity  = getActivityByIdOwner($_SESSION["id_user"]);

foreach ($listeActivity as $activity){
    $nom = $activity['name'];
    $latitude = $activity['latitude'];
    $longitude = $activity['longitude'];
    $description = $activity['description'];
    $type = $activity['type'];

    $adress_all = getAddress($latitude, $longitude);

    $adress = getRouteAndNumber($adress_all);
    $city = getCity($adress_all);
    $postal_code = getPostalCode($adress_all);

    $id = $activity['id_activity'];
?>

<form action="index.php" method="post" enctype= 'multipart/form-data'>
    <div>
        <label for="name_activity_update">Nom</label>
        <input placeholder="Nom de l'annonce" value="<?php echo $nom;?>" type="text" name="name_activity_update" id="name_activity_update" required>
    </div>

    <div>
        <label for="type_activity">Type d'activité</label>
        <select name="type_activity" id="type_activity">
            <?php
                $indice = 0;
                foreach($TYPE_ACTIVITY as $name_activity){
                    if($type == $indice){
                        echo "\n<option value=$indice selected>$name_activity</option>";
                    } else {
                        echo "\n<option value=$indice>$name_activity</option>";
                    }
                    $indice++;
                }
            ?>
        </select>
    </div>

    <div>
        <label for="adress_activity_update">Adresse</label>
        <input placeholder="Adresse" value="<?php echo $adress;?>" type="text" name="adress_activity_update" id="adress_activity_update" required>
    </div>

    <div>
        <label for="postal_code_activity_update">Code postal</label>
        <input placeholder="Code postal" value="<?php echo $postal_code;?>" type="text" name="postal_code_activity_update" id="postal_code_activity_update" required>
    </div>

    <div>
        <label for="city_activity_update">Ville</label>
        <input placeholder="Ville" value="<?php echo $city;?>" type="text" name="city_activity_update" id="city_activity_update" required>
    </div>

    <div>
        <label for="description_activity_update">Description</label>
        <textarea placeholder="Description" name="description_activity_update" id="description_activity_update"><?php echo $description;?></textarea>
    </div>

    <div>
        <label for='modification_image'>Image :</label>
        <input type='file' name='modification_image' id='modification_image'>
    </div>

    <input value="<?php echo $id;?>" type="hidden" name="id_activity_update" id="id_activity_update">

    <button id="submit" name="submit" value="activity_update" type="submit">Mettre à jour</button>

</form>
<?php
    $cheminImg = $activity["image_folder"];

    if (isset ($cheminImg)){
        $images = scandir($cheminImg);
        foreach($images as $image){
            if ($image != "." && $image != ".."){
                $imgLink = $cheminImg."/".$image;
                echo "<img src='".$imgLink."' alt='".$nom."'/>";
                ?>
                <form action="index.php" method="post">
                    <button id="del_img" name="del_img" value="<?php echo $imgLink;?>" type = "submit">Supprimer</button>
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
