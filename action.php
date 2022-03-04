<?php
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
            $admin = $_POST["admin_register"];
    
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
            }
            if(isTextGoodLength($firstname, 50)){
                $good_firstname = true;
            }
            if(isTextGoodLength($lastname, 50)){
                $good_lastname = true;
            }
            if(isTextGoodLength($firstname, 50)){
                $good_firstname = true;
            }
            if(isTextGoodLength($mail, 150) && filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $good_mail = true;
            }
            if(isTextGoodLength($phone, 25)){
                $good_phone = true;
            }
            if(isGoodDateBeforeToday($birth_date)){
                $good_birth_date = true;
            }
            if(isTextBetweenLength($conf_pass, 6, 50)){
                $goodPassword = true;
            }
            if($good_pass && $conf_pass == $pass){
                $good_conf_pass = true;
            }
            if($good_firstname && $good_lastname && $good_mail && $good_phone && $conf_pass && !($user_exist)){
                addUser($mail, $firstname, $lastname, $birth_date, $phone, hash_password($pass), $admin);
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
        }
        if($submit == "Login"){
            $mail = $_POST["mail_user"];
            $password = $_POST["passWord"];
            verifUser($mail, $password);
        }
    }
    else{
        $page = "home";
    
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
    }

  



?>
