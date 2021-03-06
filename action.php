<?php
    $page = "home";
    $page_account = "home";
    fromResaToHistory();

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    if(isset($_GET["page_account"])){
        $page_account = $_GET["page_account"];
    }

    if($page=="login"){
        $back_page = "home";
        if(isset($_GET["back_page"])){
            $back_page = $_GET["back_page"];
            if ($back_page == "login" || $back_page == "ask_reservation" || $back_page == "activity" ) {
                $back_page = "user_page";
            }
        }
    }
    else if($page=="register"){
        $back_page = "home";
        if(isset($_GET["back_page"])){
            $back_page = $_GET["back_page"];
            if ($back_page == "register" || $back_page == "ask_reservation" || $back_page == "activity" ) {
                $back_page = "user_page";
            }
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
                $errors[] = "Cette adresse mail poss??de d??j?? un compte";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($firstname, 50)){
                $good_firstname = true;
            } else {
                $errors[] = "Nom trop long (50 caract??res autoris??)";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($lastname, 50)){
                $good_lastname = true;
            }else {
                $errors[] = "Nom trop long (50 caract??res autoris??)";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextGoodLength($mail, 150) && filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $good_mail = true;
            }else {
                if (!isTextGoodLength($mail, 150)){
                    $errors[] = "Email trop long (150 caract??res autoris??)";
                    $_SESSION["errors_register"] = $errors;
                }
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                    $errors[] = "Email entr?? ne correspond pas ?? une adresse mail";
                    $_SESSION["errors_register"] = $errors;
                }
            }
            if(isTextGoodLength($phone, 25)){
                $good_phone = true;
            } else {
                $errors[] = "Num??ro de t??l??phone ne doit pas d??passer 25 caract??res";
                $_SESSION["errors_register"] = $errors;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            } else {
                $errors[] = "Vous ne pouvez pas ??tre n?? dans le futur";
                $_SESSION["errors_register"] = $errors;
            }
            if(isTextBetweenLength($pass, 6, 50)){
                $good_pass = true;
            } else {
                $errors[] = "Pas assez s??curis?? (min : 6 caract??res) ou trop de caract??res (max : 50 caract??res)";
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
                askBookHousingPeriod($id_housing, $id_customer, $date_start_reservation, $date_end_reservation);
                $url = getURL()."?page=user_page&message=booking_completed&start=".$date_start_reservation."&end=".$date_end_reservation;
            }

            header('Location: '.$url.'');
        }


        // ---------------- AJOUT ANNONCE HEBERGEMENT --------------------------------

        if($submit == "Add_housing_announce"){
            $id_owner = $_SESSION["id_user"];
            $type = $_POST["type_housing"];
            $address = $_POST["address_housing"];
            $postal_code = $_POST["postal_code_housing"];
            $city = $_POST["city_housing"];
            $name = $_POST["name_housing"];
            $description = $_POST["description_housing"];
            $price = $_POST["price_announce"];
            $date_start = $_POST["date_start_announce"];
            $date_end = $_POST["date_end_announce"];

            $address_housing = $postal_code." ".$city." ".$address;

            $coord = getCoords($address_housing);
            $country = getCountryFromCoords($coord["latitude"], $coord["longitude"]);
    
            $idAnnounce = addHousingAndAnnounce($id_owner, $type, $coord["latitude"], $coord["longitude"], $name, $description, $price, $date_start, $date_end, $country);

            $dossier = "./picture_housing/".strval($id_owner);
            createFolder("$dossier");
            
            $dossier = $dossier."/".strval($idAnnounce);
            createFolder("$dossier");
        }

        // ---------------- MODIFICATION ANNONCE HEBERGEMENT --------------------------------

        if($submit == "housing_announce_update"){
            $type = $_POST["type_housing"];
            $address = $_POST["address_housing_announce_update"];
            $coord = getCoords($address);
            $latitude = $coord["latitude"];
            $longitude = $coord["longitude"];
            $name = $_POST["name_housing_announce_update"];
            $description = $_POST["description_housing_announce_update"];
            $id = $_POST["id_housing_announce_update"];

            $address_activity = $postal_code." ".$city." ".$address;

            $coord = getCoords($address_activity);
            $pays = getCountryFromCoords($coord["latitude"], $coord["longitude"]);

            $dossier = "picture_housing/".strval($_SESSION["id_user"])."/".$_POST["id_housing_announce_update"];

            updateHousingAnnounce($id, $name, $coord["latitude"], $coord["longitude"], $type, $description);

            if (isset($_FILES)){
                if ($_FILES["modification_image"]["error"] != 4){
                    uploadImg($dossier, "modification_image");
                }   
            }

            $url = getURL()."?page=user_page&page_account=see_announce";
            header("Location: ".$url);
        }

        if ($submit == "modif_price") {
            $id = $_POST["id_announce_update"];
            $prix = $_POST["prix_announce_update"];

            updatePriceAnnounce($id, $prix);

            $page = "user_page"; 
            $page_account = "see_announce";
        }

        if ($submit == "Add_date") {
            $price = $_POST["price_date"];
            $date = $_POST["date_start_date"];
            $id = $_POST["id_housing_announce"];

            addHousingAnnounceDate($id, $price, $date);

            $page = "user_page"; 
            $page_account = "see_announce";
        }
        if($submit == "add_announce_period"){
            $date_start = $_POST["date_start"];
            $date_end = $_POST["date_end"];
            $price = $_POST["price"];
            $id_housing = $_POST["id_housing"];
            $curr_date = date("Y-m-d");
            if($date_start >= $curr_date){
                addDistinctAnnounce($id_housing, $date_start, $date_end, $price);
                $url = "./?page=update_housing_announces&id_housing=".$id_housing;
                header("Location: ".$url);


            }
            else{
                $url = "./?page=update_housing_announces&id_housing=".$id_housing."&error=past";
                header("Location: ".$url);
            }

        }

        if ($submit == "del_announce") {
            $id = $_POST["id_announce_update"];
            
            delDateAnnounceHousing($id);

            $page = "user_page"; 
            $page_account = "see_announce";
 
        }
        // ---------------- RESERVATION ANNONCES --------------------------------
        if($submit == "Validate_reservation"){
            $id_housing = $_POST['id_housing'];
            $date_start = $_POST['date_start'];
            $date_end = $_POST['date_end'];
            $id_customer = $_POST['id_user'];

            bookHousingPeriod($id_housing, $id_customer, $date_start, $date_end);

        }

        // ---------------- CONNEXION UTILISATEURS --------------------------------

        if($submit == "Login"){
            $mail = $_POST["mail_user"];
            $password = $_POST["password"];
            $back_page = $_POST["back_page"];

            if ($back_page == "register"){
                $back_page = "user_page";
            }

            $user = getUser($mail);
            $errors = [];

            if($user == null){
                $errors[] = "Cette adresse mail ne poss??de pas de compte"; 
            }
            if (!isTextGoodLength($mail, 150)){
                $errors[] = "Email trop long (150 caract??res autoris??)";
            }
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $errors[] = "Le mail ne correspond pas ?? une adresse mail";
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
        // ---------------- MODIFICATION DONN??ES UTILISATEURS --------------------------------
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
                $errors[] = "Nom trop long (50 caract??res autoris??)";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextGoodLength($lastname, 50)){
                $good_lastname = true;
            }else {
                $errors[] = "Nom trop long (50 caract??res autoris??)";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextGoodLength($phone, 25)){
                $good_phone = true;
            } else {
                $errors[] = "Num??ro de t??l??phone ne doit pas d??passer 25 caract??res";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            } else {
                $errors[] = "Vous ne pouvez pas ??tre n?? dans le futur";
                $_SESSION["errors_modifications"] = $errors;
            }
            if(isTextBetweenLength($description, 0, 10000)){
                $good_description = true;
            } else {
                $errors[] = "La description ne peut pas d??passer 10000 caract??res";
                $_SESSION["errors_modifications"] = $errors;
            }
            if($good_firstname && $good_lastname && $good_phone && $good_description){
                updateUser($firstname, $lastname, $birth_date, $phone, $description);
                $page = "user_page";
            } else {
                $page = "user_page";
                $page_account = "change_info";
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
            $old_pass = $_POST["old_pass_modif"];
            $pass = $_POST["pass_modif"];
            $conf_pass = $_POST["conf_pass_modif"];

            $good_pass = false;
            $good_conf_pass = false;

            if(isTextBetweenLength($pass, 6, 50)){
                $good_pass = true;
            } else {
                $errors[] = "Pas assez s??curis?? (min : 6 caract??res) ou trop de caract??res (max : 50 caract??res)";
                $_SESSION["errors_modification_pass"] = $errors;
            }
            if($good_pass && $conf_pass == $pass){
                $good_conf_pass = true;
            } else if ($conf_pass != $pass){
                $errors[] = "Les deux mots de passe ne correspondent pas";
                $_SESSION["errors_modification_pass"] = $errors;
            }
           
            if($good_pass && $good_conf_pass){
                $ok = modificationPassUser($old_pass, hash_password($pass));
                if (!$ok){
                    $page = "user_page";
                    $page_account = "change_password";
                }
            } else {
                $page = "user_page";
                $page_account = "change_password";
            }
        }

        // ----------- MAJ LOGEMENTS -------------------------------
        if($submit == "AskUpdateHousingDates"){
            $id_housing = $_POST["id_housing"];
            $url = getURL()."?page=update_housing_announces&id_housing=".$id_housing;
            header('Location: '.$url.'');
        }

        if($submit == "AskUpdateHousingInfos"){
            $id_housing = $_POST["id_housing"];
            $url = getURL()."?page=update_housing&id_housing=".$id_housing;
            header('Location: '.$url.'');
        }

        if ($submit == "AskUpdateHousingMap"){
            $id_housing = $_POST["id_housing"];
            $url = getURL()."?page=map_housing&id_housing=".$id_housing;
            header('Location: '.$url.'');
        }

        //  ----------- HISTORIQUE LOGEMENTS ------------------------
        if($submit == "ViewHousingHistory"){
            $id_housing = $_POST["id_housing"];
            $url = getURL()."?page=housing_history&h=".$id_housing;
            header('Location: '.$url.'');
        }

//--------------------- RESERVATION LOGEMENT ---------------------------------
        if($submit == "BookHousing"){

            $id_housing = $_POST["id_housing"];
            $id_user = $_POST["id_user"];
            $date_start = $_POST["date_start"];
            $date_end = $_POST["date_end"];

            bookHousingPeriod($id_housing, $id_user, $date_start, $date_end);

            $url = getURL()."?page=user_page&page_account=see_resa";
            header('Location: '.$url.'');


        }

 // ---------------- AJOUT D'ACTIVITES --------------------------------
        if($submit == "Add_activite"){

            $name = $_POST["nom_activite"];
            $type = $_POST["type_activite"];
            $address = $_POST["adress_activite"];
            $postal_code = $_POST["post_activite"];
            $city = $_POST["city_activite"];
            $id_user = $_SESSION["id_user"];
            $desc = $_POST["desc_activite"];

            $address_activity = $postal_code." ".$city." ".$address;

            $coord = getCoords($address_activity);
            $country = getCountryFromCoords($coord["latitude"], $coord["longitude"]);

            $id_activity = addActivity($name, $type, $country, $coord["latitude"], $coord["longitude"], $id_user, $desc);

            $folder = "./picture_activity/".strval($id_user);
            createFolder("$folder");

            $folder = $folder."/".strval($id_activity);
            createFolder("$folder");

            $page = "user_page";
            $page_account = "see_activity";
        }

        // ---------------- MODIFICATION ACTIVITE --------------------------------

        if($submit == "AskUpdateActivityInfos"){
            $id_activity = $_POST["id_activity"];
            $url = getURL()."?page=update_activity&id_activity=".$id_activity;
            header('Location: '.$url.'');
        }

        if ($submit == "AskUpdateActivityMap"){
            $id_activity = $_POST["id_activity"];
            $url = getURL()."?page=map_activity&id_activity=".$id_activity;
            header('Location: '.$url.'');
        }

        if($submit == "activity_update"){
            $type = $_POST["type_activity"];
            $city = $_POST["city_activity_update"];
            $postal_code = $_POST["postal_code_activity_update"];
            $address = $_POST["adress_activity_update"];
            $name = $_POST["name_activity_update"];
            $description = $_POST["description_activity_update"];
            $id = $_POST["id_activity_update"];

            $address_activity = $postal_code." ".$city." ".$address;

            $coord = getCoords($address_activity);
            $pays = getCountryFromCoords($coord["latitude"], $coord["longitude"]);

            $dossier = "picture_activity/".strval($_SESSION["id_user"])."/".$id;

            updateActivity($id, $name, $type, $pays, $coord["latitude"], $coord["longitude"],  $description);

            if (isset($_FILES)){
                if ($_FILES["modification_image"]["error"] != 4){
                    uploadImg($dossier, "modification_image");
                }   
            }

            $page = "user_page";
            $page_account = "see_activity";
        }

        //---------------------- MODIFICATION DES COORDONNEE GEOGRAPHIQUES UNIQUEMENT ----------------
        if ($submit == "update_map_position"){
            $id = $_POST["id_update_map_position"];
            $is_housing = $_POST["is_housing_update_map_position"];

            $latitude = $_POST["update_map_position_latitude"];
            $longitude = $_POST["update_map_position_longitude"];

            if(is_numeric($latitude) && is_numeric($longitude)){
                updateCoords($id, $is_housing, $latitude, $longitude);
            }

            if ($is_housing){
                $url = "?page=map_housing&id_housing=".$id;
            } else {
                $url = "?page=map_activity&id_activity=".$id;
            }

            header('Location: '.$url.'');
        }
        

        //---------------------- AJOUT D'UNE PREFERENCE POUR RECHERCHE LOGEMENT ----------------------

        else if($submit == "add_pref_search"){
            $id_user = $_SESSION["id_user"];

            $name = $_POST['name_pref_search'];
            $price_min = $_POST['price_min_pref_search'];
            $price_max = $_POST['price_max_pref_search'];
            $dest = $_POST['dest_pref_search'];
            $distance = $_POST['distance_pref_search'];

            addPreferenceSearchHousing($id_user, $name, $dest, $distance, $price_min, $price_max);

            $page = "user_page";



        }
        
        // ---------------- AJOUT D'UNE NOTE ET COMMENTAIRE --------------------------------

        if($submit == "submit_rate_and_comment"){
            $rate = $_POST["rate"];
            $title = $_POST["title"];
            $message = $_POST["message"];
            $is_housing = $_POST["rated_is_housing"];
            $id_rated = $_POST["id_rated"];

            $id_rater = $_SESSION["id_user"];

            addRating($id_rated, $id_rater, $rate, $title, $message, $is_housing);

            header("Location: ".$_SESSION["back_page"]);
        }


    } else if (!empty($_POST)&&array_key_exists("del_img", $_POST)) {
        if(isset($_POST["del_img"])){
            unlink($_POST["del_img"]);
        }
        header("Location: ".$_SESSION["back_page"]);
    } else if (!empty($_POST)&&array_key_exists("del_img_profile", $_POST)) {
        if(isset($_POST["del_img_profile"])){
            unlink($_POST["del_img_profile"]);
        }
        $page = "user_page";
    }
?>
