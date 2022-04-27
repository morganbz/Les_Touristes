<?php
$id_housing = $_GET["id_housing"];
echo $id_housing;
$housing = getHousingById($id_housing);
?>

<form action="index.php" method="post" enctype= 'multipart/form-data'>
    <div>
        <label for="name_housing_announce_update">Nom</label>
        <?php
        echo "<input value =".$housing["nom"]." type='text' name='name_housing_announce_update' id='name_housing_announce_update' required>";
        ?>
    </div>

    <div>
        <label for="type_housing">Type de logement</label>
        <select name="type_housing" id="type_housing">
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
        <?php
        //echo "<textarea placeholder=".$housing["description"]."type='text' name='name_housing_announce_update' id='name_housing_announce_update' required>";
        echo "<textarea name='description_housing_announce_update' id='description_housing_announce_update'>".$housing["description"]."</textarea>";
        ?>
    </div>

    <div>
        <label for='modification_image'>Image :</label>
        <input type='file' name='modification_image' id='modification_image'>
    </div>

    <input value="<?php echo $id;?>" type="hidden" name="id_housing_announce_update" id="id_housing_announce_update">

    <button id="submit" name="submit" value="housing_announce_update" type="submit">Mettre à jour</button>

</form>