<?php 
    if(isset($_SESSION["id_user"])){
        $user = getUserById($_SESSION["id_user"]);

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $birth_date = $user["birth_date"];
        $phone = $user["phone"];
        $description = $user["description"];

        $profile_picture = "ressources/profile_picture.png";
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

<section class="user_page_home">
    <img src="<?php echo $profile_picture;?>" alt="Profile picture">
    <div>
        <h2><?php echo $firstname . " " . $lastname;?></h2>
        <p>Date de naissance : <?php echo $birth_date;?></p>
        <p>Numéro de téléphone : <?php echo $phone;?></p>
        <p>Description : <?php echo $description;?></p>
    </div>
    <div>
        <h2>Coups de coeurs</h2>
    </div>
    <div>
        <h2>Badges</h2>
    </div>
</section>