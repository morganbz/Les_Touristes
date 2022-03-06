<?php
     $firstname = "Prénom";
     $lastname = "Nom";
     $email = "Email";
     $birth_date = "Date de naissance";
     $phone = "Numéro de téléphone";
     $description = "Description";

     $affichage = "placeholder";
    
    if(isset($_SESSION["id_user"])){
        $user = getUserById($_SESSION["id_user"]);

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $email = $user["mail"];
        $birth_date = $user["birth_date"];
        $phone = $user["phone"];
        if ($user["description"] != NULL){
            $description = $user["description"];
        }

        $affichage = "value";
    }
?>

<form action="index.php" method="post">
    <div>
        <label for="firstname_modification">Prénom</label>
        <input <?php echo $affichage;?>="<?php echo $firstname;?>" type="text" name="firstname_modification" id="firstname_modification" required>
    </div>

    <div>
        <label for="lastname_modification">Nom</label>
        <input <?php echo $affichage;?>="<?php echo $lastname;?>" type="text" name="lastname_modification" id="lastname_modification" required>
    </div>

    <div>
        <label for="email_modification">Email</label>
        <input <?php echo $affichage;?>="<?php echo $email;?>" type="email" name="email_modification" id="email_modification" required>
    </div>

    <div>
        <label for="birth_date_modification">Date de naissance</label>
        <input <?php echo $affichage;?>="<?php echo $birth_date;?>" type="date" name="birth_date_modification" id="birth_date_modification" required>
    </div>

    <div>
        <label for="phone_modification">Numéro de Téléphone</label>
        <input <?php echo $affichage;?>="<?php echo $phone;?>" type="text" name="phone_modification" id="phone_modification" required>
    </div>

    <div>
        <label for="description_modification">Description</label>
        <textarea <?php echo $affichage;?>="<?php echo $description;?>" name="description_modification" id="description_modification"></textarea>
    </div>

    <button id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
</form>