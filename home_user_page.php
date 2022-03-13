<?php 
    if(isset($_SESSION["id_user"])){
        $user = getUserById($_SESSION["id_user"]);

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $birth_date = $user["birth_date"];
        $phone = $user["phone"];
        $description = $user["description"];
    }
?>

<section class="user_page" id="user_page_home">
    <img src="ressources/profile_picture.png" alt="Profile picture">
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