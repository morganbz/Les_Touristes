<?php
    $page = "home";
    $pageCompte = "home";

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    if(isset($_GET["pageCompte"])){
        $pageCompte = $_GET["pageCompte"];
    }

    // ---------------------- POST FORMULAIRE ----------------------------
    if(!empty($_POST)&&array_key_exists("submit", $_POST)){
        $submit = $_POST["submit"];
        if($submit == "Register"){
            $mail = $_POST["mail_register"];
            $firstname = $_POST["firstname_register"];
            $lastname = $_POST["lastname_register"];
            $phone = $_POST["phone_register"];
            $birth_date = date('Y-m-d', strtotime($_POST["birth_date_register"]));
            $pass = $_POST["pass_register"];
            $conf_pass = $_POST["conf_pass_register"];
            if (isset($_POST["admin_register"])){
                $admin = $_POST["admin_register"];
            } else {
                $admin = 0;
            }
    
            $user_exist = true;
            $good_firstname = false;
            $good_lastname = false;
            $good_mail = false;
            $good_phone = false;
            $good_birth_date = false;
            $good_pass = false;
            $good_conf_pass = false;

            $user = getUser($mail);

            if($user == null){
                $user_exist = false;   
            } else {
                $errors[] = "Cette adresse mail possède déjà un compte";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($firstname, 50)){
                $good_firstname = true;
            } else {
                $errors[] = "Nom trop long (50 caractères autorisé)";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($lastname, 50)){
                $good_lastname = true;
            }else {
                $errors[] = "Nom trop long (50 caractères autorisé)";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($mail, 150) && filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $good_mail = true;
            }else {
                if (!isTextGoodLength($mail, 150)){
                    $errors[] = "Email trop long (150 caractères autorisé)";
                    $_SESSION["errors_register"] = $errors;
                }
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                    $errors[] = "Email entré ne correspond pas à une adresse mail";
                    $_SESSION["errors_register"] = $errors;
                }
            }
            if(isTextGoodLength($phone, 25)){
                $good_phone = true;
            } else {
                $errors[] = "Numéro de téléphone ne doit pas dépassé 25 caractères";
                $_SESSION["errors_register"] = $errors;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            } else {
                $errors[] = "Vous ne pouvez pas être né dans le futur";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextBetweenLength($pass, 6, 50)){
                $good_pass = true;
            } else {
                $errors[] = "Pas assez sécurisé (min : 6 caractères) ou trop de caractères (max : 50 caractères)";
                $_SESSION["errors_register"] = $errors;
            }
            if($good_pass && $conf_pass == $pass){
                $good_conf_pass = true;
            } else if ($conf_pass != $pass){
                $errors[] = "Les deux mots de passe ne correspondent pas";
                $_SESSION["errors_register"] = $errors;
            }
            if($good_firstname && $good_lastname && $good_mail && $good_phone && $good_conf_pass && !($user_exist)){
                addUser($mail, $firstname, $lastname, $birth_date, $phone, hash_password($pass), $admin);
            } else {
                $page = "register";
            }
        }
        if($submit == "Add_housing"){
            $id_owner = $_POST["id_owner_housing"];
            $type = $_POST["type_housing"];
            $latitude = $_POST["latitude_housing"];
            $longitude = $_POST["longitude_housing"];
            $name = $_POST["name_housing"];
            $description = $_POST["description_housing"];

            $good_id_owner = false;
            $good_type = false;
            $good_latitude = false;
            $good_longitude = false;
            $good_name = false;
            $good_description = false;

            if(isTextGoodLength($name, 50)){
                $good_name = true;
            }
            if(is_float($longitude)){
                $good_longitude = true;
            }
            if(is_float($latitude)){
                $good_latitude = true;
            }
            if(is_int($type)){
                $good_type = true;
            }
            if(is_int($id_owner)){
                $good_id_owner = true;
            }
            if(is_string($description)){
                $good_description = true;
            }
            if($good_id_owner && $good_type && $good_latitude && $good_longitude && $good_name && $good_description){
                addHousing($id_owner, $type, $latitude, $longitude, $name, $description);
            }
        }
        if($submit == "Add_announce"){
            $id_housing = $_POST["id_housing_announce"];
            $price = $_POST["price_announce"];
            $date_start = $_POST["price_announce"];

            $good_id_housing = false;
            $good_price = false;
            $good_date_start = false;

            if(is_int($type)){
                $good_type = true;
            }
            if(is_int($id_housing)){
                $good_id_housing = true;
            }
            if(isGoodDateBeforeToday($date_start)){
                $good_date_start = true;
            }
            if($good_date_start && $good_id_housing && $good_type){
                addAnnounce($price, $date_start, $id_housing);
            }
        }
        if($submit == "Search_Announce"){
                
        }
        if($submit == "search_housing_text"){
            $price_min = $_POST["price_min"];
            $price_max = $_POST["price_max"];
            $date_start = $_POST["date_start"];
            $date_end = $_POST["date_end"];

            $result = searchAnnounce($price_min, $price_max, $date_start, $date_end);
            
            displaySearch($result);

        }
        if($submit == "Add_housing_announce"){
            $id_owner = $_POST["id_owner_housing"];
            $type = $_POST["type_housing"];
            $latitude = $_POST["latitude_housing"];
            $longitude = $_POST["longitude_housing"];
            $name = $_POST["name_housing"];
            $description = $_POST["description_housing"];
            $price = $_POST["price_announce"];
            $date_start = $_POST["date_start_announce"];
            $date_end = $_POST["date_end_announce"];
    
            addHousingAndAnnounce($id_owner, $type, $latitude, $longitude, $name, $description, $price, $date_start, $date_end);
            createFolder("./Les_Touristes/picture_housing/test");
        }
        // ---------------- CONNEXION UTILISATEURS --------------------------------
        if($submit == "Login"){
            $mail = $_POST["mail_user"];
            $password = $_POST["passWord"];

            $user = getUser($mail);
            $errors = [];

            if($user == null){
                $errors[] = "Cette adresse mail ne possède pas de compte"; 
            }
            if (!isTextGoodLength($mail, 150)){
                $errors[] = "Email trop long (150 caractères autorisé)";
            }
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $errors[] = "Le mail ne correspond pas à une adresse mail";
            }

            if (empty($password)){
                $errors[] = "Veuillez saisir un mot de passe";
            }
				
            if (count($errors) > 0) {
			    $_SESSION["errors_login"] = $errors;
                $page = "login";
			} else {
                verifUser($mail, $password);	
			}
            
        }
        // ---------------- MODIFICATION DONNÉES UTILISATEURS --------------------------------
        if($submit == "update_user_info"){
            $firstname = $_POST["firstname_modification"];
            $lastname = $_POST["lastname_modification"];
            $birth_date = $_POST["birth_date_modification"];
            $phone = $_POST["phone_modification"];
            $description = $_POST["description_modification"];

            $good_firstname = false;
            $good_lastname = false;
            $good_phone = false;
            $good_birth_date = false;

            if(isTextGoodLength($firstname, 50)){
                $good_firstname = true;
            } else {
                $errors[] = "Nom trop long (50 caractères autorisé)";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextGoodLength($lastname, 50)){
                $good_lastname = true;
            }else {
                $errors[] = "Nom trop long (50 caractères autorisé)";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextGoodLength($phone, 25)){
                $good_phone = true;
            } else {
                $errors[] = "Numéro de téléphone ne doit pas dépassé 25 caractères";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            } else {
                $errors[] = "Vous ne pouvez pas être né dans le futur";
                echo date($birth_date);
                date_default_timezone_set('Europe/Paris');
                echo date("Y-m-d");
                $_SESSION["errors_modifications"] = $errors;
            }
            if($good_firstname && $good_lastname && $good_phone){
                updateUser($firstname, $lastname, $birth_date, $phone, $description);
            } else {
                $page = "user_page";
                $pageCompte = "modifInfos";
            }
        }
    }
?>
