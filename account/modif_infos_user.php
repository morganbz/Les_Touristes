<?php
     $firstname = "";
     $lastname = "";
     $birth_date = "";
     $phone = "";
     $description = "";
     $profile_picture = "ressources/profile_picture.png";
    
    if(isset($_SESSION["id_user"])){
        $user = getUserById($_SESSION["id_user"]);

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $birth_date = $user["birth_date"];
        $phone = $user["phone"];
        $description = $user["description"];

        $profile_picture_folder = "picture_profile/".$_SESSION["id_user"];
        if (isset($profile_picture_folder)){
            $files = scandir ($profile_picture_folder);
            foreach($files as $file){
                if ($file != "." && $file != ".."){
                    $profile_picture = $profile_picture_folder."/".$file;
                }
            }
        }
    }
?>
<section class="section about-section gray-bg" id="about">
<form action="index.php" method="post" enctype= 'multipart/form-data'>
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="about-text go-to">
                            <h3 class="dark-color">
                                <input class="dark-color input-text-profile" placeholder="Prénom" value="<?php echo $firstname;?>" type="text" name="firstname_modification" id="firstname_modification" required>
                                <input class="dark-color input-text-profile" placeholder="Nom" value="<?php echo $lastname;?>" type="text" name="lastname_modification" id="lastname_modification" required>
                            </h3>
                            <h6 class="theme-color lead">À propos :</h6>
                            <textarea class="form-control" placeholder="Description" name="description_modification" id="description_modification" row="3" cols="40"><?php echo $description;?></textarea>
                            <div class="row about-list">
                                <div class="col-md-6">
                                    <div class="media">
                                        <label for="birth_date_modification">Date de naissance</label>
                                        <p><input class="form-control" placeholder="Date de naissance" value="<?php echo $birth_date;?>" type="date" name="birth_date_modification" id="birth_date_modification" required></p>
                                    </div>
                                    <div class="media">
                                        <label for="phone_modification">Téléphone</label>
                                        <p><input class="form-control" placeholder="Numéro de téléphone" value="<?php echo $phone;?>" type="text" name="phone_modification" id="phone_modification" required></p>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary" id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-avatar">
                            <img class="img-size img-profile" src="<?php echo $profile_picture;?>" alt="Photo de profil">
                        </div>
                    </div>
                </div>
                <div class="counter">
                    <div class="row">
                        <div class="col-6 col-lg-5">
                            <div class="count-data text-center">
                                <h6 class="count h2" data-to="" data-speed="">Modifier la photo de profil</h6>
                                <input class="form-control w-10" type='file' name='modification_profile_picture' id='modification_profile_picture'>
                                <button class="btn btn-outline-primary" id="del_img_profile" name="del_img_profile" value="<?php echo $profile_picture;?>" type="del_img_profile">Supprimer ma photo de profil</button>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="count-data text-center">
                           </div>
                        </div>
                    </div>
                        
                </div>       
            </div>
</form>

<?php
    if (isset($_SESSION["errors_modifications"])){
        echo "<p class='error'>Erreurs lors de la modification du compte :</p>";
        echo "<ul>";
        foreach($_SESSION["errors_modifications"] as $error_modifications)
            echo "<li class='error'>$error_modifications</li>";
        echo "</ul>";
    }  
?>
</section>