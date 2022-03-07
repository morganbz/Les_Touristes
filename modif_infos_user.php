<?php
     $firstname = "";
     $lastname = "";
     $birth_date = "";
     $phone = "";
     $description = "";
    
    if(isset($_SESSION["id_user"])){
        $user = getUserById($_SESSION["id_user"]);

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $birth_date = $user["birth_date"];
        $phone = $user["phone"];
        $description = $user["description"];
    }
?>

<form action="index.php" method="post">
    <div>
        <label for="firstname_modification">Prénom</label>
        <input placeholder="Prénom" value="<?php echo $firstname;?>" type="text" name="firstname_modification" id="firstname_modification" required>
    </div>

    <div>
        <label for="lastname_modification">Nom</label>
        <input placeholder="Nom" value="<?php echo $lastname;?>" type="text" name="lastname_modification" id="lastname_modification" required>
    </div>

    <div>
        <label for="birth_date_modification">Date de naissance</label>
        <input placeholder="Date de naissance" value="<?php echo $birth_date;?>" type="date" name="birth_date_modification" id="birth_date_modification" required>
    </div>

    <div>
        <label for="phone_modification">Numéro de Téléphone</label>
        <input placeholder="Numéro de téléphone" value="<?php echo $phone;?>" type="text" name="phone_modification" id="phone_modification" required>
    </div>

    <div>
        <label for="description_modification">Description</label>
        <textarea placeholder="Description" name="description_modification" id="description_modification"><?php echo $description;?></textarea>
    </div>

    <button id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
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