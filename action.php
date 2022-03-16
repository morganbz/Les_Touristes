<?php
    $page = "home";
    $pageCompte = "home";

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    if(isset($_GET["pageCompte"])){
        $pageCompte = $_GET["pageCompte"];
    }

    if($page=="login"){
        $back_page = "home";
        if(isset($_GET["back_page"])){
            $back_page = $_GET["back_page"];
            echo "PUTEEEEEEE";
        }
        echo "PUTEEEEEEE";
    }
    else if($page=="register"){
        $back_page = "home";
        if(isset($_GET["back_page"])){
            $back_page = $_GET["back_page"];
        }
    }

    // ---------------------- POST FORMULAIRE ----------------------------
    if(!empty($_POST)&&array_key_exists("submit", $_POST)){
        $submit = $_POST["submit"];
        if($submit == "Register"){
            $back_page = $_POST["back_page"];
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
                $errors[] = "Numéro de téléphone ne doit pas dépasser 25 caractères";
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
                if(isset($_SESSION["id_user"])){
                    $id = $_SESSION["id_user"];
                    $dossier = "./picture_profile/".$id;
                    createFolder("$dossier");
                }
                
            } else {
                $page = "register";
            }
            $url = "./?page=".$back_page;
            header("Location: ".$url);
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

            if(strtotime($date_start) > strtotime($date_end)){
                $url = getURL()."?page=search_housing_text&statut_search=failed&error=date";
            }
            else if($price_min > $price_max){
                $url = getURL()."?page=search_housing_text&statut_search=failed&error=price";
            }
            else{
                $url = getURL()."?page=search_housing_text&statut_search=send&price_min=".$price_min."&price_max=".$price_max."&date_start=".$date_start."&date_end=".$date_end;   
            }
            header('Location: '.$url.'');

        }
        // ---------------- RESERVATION HEBERGEMENT --------------------------------

        if($submit == "Ask_reservation"){
            $id_customer = $_SESSION["id_user"];
            $date_start_reservation = $_POST["date_start_reservation"];
            $date_end_reservation = $_POST["date_end_reservation"];
            $id_housing = $_POST["id_housing"];
            if(getHousingById($id_housing) != null){
                AskBookHousingPeriod($id_housing, $id_customer, $date_start_reservation, $date_end_reservation);
                $url = getURL()."?page=user_page&message=booking_completed&start=".$date_start_reservation."&end=".$date_end_reservation;
            }

            header('Location: '.$url.'');
        }


        // ---------------- AJOUT ANNONCE HEBERGEMENT --------------------------------

        if($submit == "Add_housing_announce"){
            $id_owner = $_SESSION["id_user"];
            $type = $_POST["type_housing"];
            $adress = $_POST["adress"];
            $coord = getCoords($adress);
            $name = $_POST["name_housing"];
            $description = $_POST["description_housing"];
            $price = $_POST["price_announce"];
            $date_start = $_POST["date_start_announce"];
            $date_end = $_POST["date_end_announce"];

    
            $idAnnounce = addHousingAndAnnounce($id_owner, $type, $coord["latitude"], $coord["longitude"], $name, $description, $price, $date_start, $date_end);

            $dossier = "./picture_housing/".strval($id_owner);
            createFolder("$dossier");
            
            $dossier = $dossier."/".strval($idAnnounce);
            createFolder("$dossier");
        }

        // ---------------- MODIFICATION ANNONCE HEBERGEMENT --------------------------------

        if($submit == "housing_announce_update"){
            $type = $_POST["type_housing"];
            $latitude = $_POST["latitude_housing_announce_update"];
            $longitude = $_POST["longitude_housing_announce_update"];
            $name = $_POST["name_housing_announce_update"];
            $description = $_POST["description_housing_announce_update"];
            $id = $_POST["id_housing_announce_update"];

            $dossier = "picture_housing/".strval($_SESSION["id_user"])."/".$_POST["id_housing_announce_update"];

            updateHousingAnnounce($id, $name, $latitude, $longitude, $type, $description);

            if (isset($_FILES)){
                if ($_FILES["modification_image"]["error"] != 4){
                    uploadImg($dossier, "modification_image");
                }   
            }

            $page = "user_page";
            $pageCompte = "voirAnnonces";
        }

        if ($submit == "modif_price") {
            $id = $_POST["id_announce_update"];
            $prix = $_POST["prix_announce_update"];

            updatePriceAnnounce($id, $prix);

            $page = "user_page"; 
            $pageCompte = "voirAnnonces";
        }

        if ($submit == "Add_date") {
            $price = $_POST["price_date"];
            $date = $_POST["date_start_date"];
            $id = $_POST["id_housing_announce"];

            addHousingAnnounceDate($id, $price, $date);

            $page = "user_page"; 
            $pageCompte = "voirAnnonces";
        }

        if ($submit == "del_announce") {
            $id = $_POST["id_announce_update"];
            
            delDateAnnounceHousing($id);

            $page = "user_page"; 
            $pageCompte = "voirAnnonces";
 
        }

        // ---------------- CONNEXION UTILISATEURS --------------------------------

        if($submit == "Login"){
            $mail = $_POST["mail_user"];
            $password = $_POST["password"];
            $back_page = $_POST["back_page"];

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
                $login = verifUser($mail, $password);
                if (!$login){
                    $errors[] = "Mauvais mot de passe";
                    $_SESSION["errors_login"] = $errors;
                    $page = "login";
                }	
			}
            $url = "./?page=".$back_page;
            header("Location: ".$url);
            
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
            $good_description = false;

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
                $errors[] = "Numéro de téléphone ne doit pas dépasser 25 caractères";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            } else {
                $errors[] = "Vous ne pouvez pas être né dans le futur";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextBetweenLength($description, 0, 10000)){
                $good_description = true;
            } else {
                $errors[] = "La description ne peut pas dépasser 10000 caractères";
                $_SESSION["errors_modifications"] = $errors;
            }
            if($good_firstname && $good_lastname && $good_phone && $good_description){
                updateUser($firstname, $lastname, $birth_date, $phone, $description);
                $page = "user_page";
            } else {
                $page = "user_page";
                $pageCompte = "modifInfos";
            }

            $dossier = "picture_profile/".$_SESSION["id_user"];

            if (isset($_FILES)){
                if ($_FILES["modification_profile_picture"]["error"] != 4){
                    $files = scandir ($dossier);
                    foreach($files as $file){
                        if ($file != "." && $file != ".."){
                            unlink($dossier."/".$file);
                        }
                    }
                    uploadImg($dossier, "modification_profile_picture");
                }   
            }
            $page = "user_page";
        }

        // ---------------- MODIFICATION MOT DE PASSE UTILISATEURS --------------------------------

        if($submit == "modification_pass_user"){
            $pass = $_POST["pass_modif"];
            $conf_pass = $_POST["conf_pass_modif"];

            $good_pass = false;
            $good_conf_pass = false;

            if(isTextBetweenLength($pass, 6, 50)){
                $good_pass = true;
            } else {
                $errors[] = "Pas assez sécurisé (min : 6 caractères) ou trop de caractères (max : 50 caractères)";
                $_SESSION["errors_modification_pass"] = $errors;
            }
            if($good_pass && $conf_pass == $pass){
                $good_conf_pass = true;
            } else if ($conf_pass != $pass){
                $errors[] = "Les deux mots de passe ne correspondent pas";
                $_SESSION["errors_modification_pass"] = $errors;
            }
           
            if($good_pass && $good_conf_pass){
                modificationPassUser(hash_password($pass));
            } else {
                $page = "user_page";
                $pageCompte = "modifMDP";
            }
        }
    } else if (!empty($_POST)&&array_key_exists("del_img", $_POST)) {
        if(isset($_POST["del_img"])){
            unlink($_POST["del_img"]);
        }
        $page = "user_page";
        $pageCompte = "voirAnnonces";
    } else if (!empty($_POST)&&array_key_exists("del_img_profile", $_POST)) {
        if(isset($_POST["del_img_profile"])){
            unlink($_POST["del_img_profile"]);
        }
        $page = "user_page";
    }
    
?>
