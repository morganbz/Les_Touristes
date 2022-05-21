<?php
if(isset($_SESSION["id_user"])){
    if (isset($_GET["id_housing"])){
        $id_housing = $_GET["id_housing"];

        $housing = getHousingById($id_housing);
        
        if ($_SESSION["id_user"] == $housing["id_owner"]){
            $address = getAddress($housing["latitude"], $housing["longitude"]);
            ?>
            <div class="container">
                <div class="align-items-center m-3 display-form-bg">
                    <div class="col-lg-15" >
                        <div class="about-text go-to">
                            <h3 class="dark-color"><?php echo $housing["nom"]; ?></h3>
                            <form action="index.php" method="post" enctype= 'multipart/form-data' class="align-items-center">
                                
                                <div>
                                    <h3 class="dark-color"><label class="h3" for="name_housing_announce_update">Nom</label></h3>
                                    
                                    <input class="form-control w-30" value ="<?php echo $housing["nom"]; ?>" type='text' name='name_housing_announce_update' id='name_housing_announce_update' required>
                                    
                                </div>

                                <div>
                                    <h3 class="dark-color"><label class="h3" for="type_housing">Type de logement</label></h3>
                                    <select class="form-select w-30" name="type_housing" id="type_housing">
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
                                    <h3 class="dark-color"><label class="h3" for="address_housing_announce_update">Adresse</label></h3>
                                    <input class="form-control w-30" placeholder="adresse" value="<?php echo $address;?>" type="text" name="address_housing_announce_update" id="address_housing_announce_update" required>
                                </div>

                                <div>
                                    <h3 class="dark-color"><label class="h3" for="description_housing_announce_update">Description</label></h3>
                                    <textarea class="form-control w-30" name='description_housing_announce_update' placeholder="Description du logement" id='description_housing_announce_update'><?php echo $housing["description"];?></textarea>
                                    
                                </div>

                                <div>
                                    <h3 class="dark-color"><label class="h3" for='modification_image'>Ajout d'images</label></h3>
                                    <input class="form-control w-30" type='file' name='modification_image' id='modification_image'>
                                </div>

                                <input value="<?php echo $id_housing;?>" type="hidden" name="id_housing_announce_update" id="id_housing_announce_update">

                                <button class="btn btn-outline-primary" id="submit" name="submit" value="housing_announce_update" type="submit">Mettre à jour</button>

                            </form>
                        </div>
                        <div class="d-flex flex-row justify-content-around align-self-center flex-wrap">     
                        <?php
                        $cheminImg = $housing["image_folder"];

                        if (isset ($cheminImg)){
                            $images = scandir($cheminImg);
                            foreach($images as $image){
                                if ($image != "." && $image != ".."){
                                    $imgLink = $cheminImg."/".$image;
                                    ?>
                                    <div  class="text-center">
                                    <img class="m-1 img-size img-fluid " src="<?php echo $imgLink;?>" alt="<?php echo $housing["nom"];?>"/>
                                    
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
} else {
    include_once "./page_404.php";
}