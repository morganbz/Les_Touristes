<?php
$activity = getActivityById($_GET["id_activity"]);

$_SESSION["back_page"] = "?page=update_activity&id_activity=".$_GET["id_activity"];

$nom = $activity['nom'];
$latitude = $activity['latitude'];
$longitude = $activity['longitude'];
$description = $activity['description'];
$type = $activity['type'];

$adress = getRouteAndNumber($latitude, $longitude);
$city = getCity($latitude, $longitude);
$postal_code = getPostalCode($latitude, $longitude);

$id = $activity['id'];

if (isset($_SESSION["id_user"])){
    if ($_SESSION["id_user"] == $activity["id_owner"]){
        ?>
        <div class="container">
            <div class="align-items-center m-3 display-form-bg">
                <div class="col-lg-15" >
                    <div class="about-text go-to">
                        <h3 class="dark-color"><?php echo $nom; ?></h3>
                        <?php

                        if (isset($_SESSION["errors_update_activity"])){
                            echo "<ul>";
                            foreach ($_SESSION["errors_update_activity"] as $error){
                                echo "<li>$error</li>";
                            }
                            echo "</ul>";
                        }
                        ?>

                        <form action="index.php" method="post" enctype= 'multipart/form-data' class="align-items-center">
                            <div>
                            <h3 class="dark-color"><label class="h3" for="name_activity_update">Nom</label>
                                <input class="form-control w-30" placeholder="Nom de l'annonce" value="<?php echo $nom;?>" type="text" name="name_activity_update" id="name_activity_update" required>
                            </div>

                            <div>
                            <h3 class="dark-color"><label class="h3" for="type_activity">Type d'activité</label>
                                <select class="form-select w-30" name="type_activity" id="type_activity">
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
                                <h3 class="dark-color"><label class="h3" for="adress_activity_update">Adresse</label>
                                <input class="form-control w-30" placeholder="Adresse" value="<?php echo $adress;?>" type="text" name="adress_activity_update" id="adress_activity_update" required>
                            </div>

                            <div>
                                <h3 class="dark-color"><label class="h3" for="postal_code_activity_update">Code postal</label>
                                <input class="form-control w-30" placeholder="Code postal" value="<?php echo $postal_code;?>" type="text" name="postal_code_activity_update" id="postal_code_activity_update" required>
                            </div>

                            <div>
                                <h3 class="dark-color"><label class="h3" for="city_activity_update">Ville</label>
                                <input class="form-control w-30" placeholder="Ville" value="<?php echo $city;?>" type="text" name="city_activity_update" id="city_activity_update" required>
                            </div>

                            <div>
                                <h3 class="dark-color"><label class="h3" for="description_activity_update">Description</label>
                                <textarea class="form-control w-30" placeholder="Description" name="description_activity_update" id="description_activity_update"><?php echo $description;?></textarea>
                            </div>

                            <div>
                                <h3 class="dark-color"><label class="h3" for='modification_image'>Image :</label>
                                <input class="form-control w-30" type='file' name='modification_image' id='modification_image'>
                            </div>

                            <input class="form-control w-30" value="<?php echo $id;?>" type="hidden" name="id_activity_update" id="id_activity_update">

                            <button class="btn btn-outline-primary" id="submit" name="submit" value="activity_update" type="submit">Mettre à jour</button>

                        </form>
                    </div>
                    <div class="d-flex flex-row justify-content-around align-self-center flex-wrap">
                    <?php
                        $cheminImg = $activity["image_folder"];

                        if (isset ($cheminImg)){
                            $images = scandir($cheminImg);
                            foreach($images as $image){
                                if ($image != "." && $image != ".."){
                                    $imgLink = $cheminImg."/".$image;
                                    ?>
                                    <div class="text-center">
                                    <img class="m-1 img-fluid img-size" src="<?php echo $imgLink;?>" alt="<?php echo $nom;?>"/>
                                    
                                    <form action="index.php" method="post">
                                        <button class="btn btn-outline-primary align-center" id="del_img" name="del_img" value="<?php echo $imgLink;?>" type = "submit">Supprimer</button>
                                    </form>
                                    </div>
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

                    ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        include_once "./page_404.php";
    }
} else {
    include_once "./page_404.php";
}
