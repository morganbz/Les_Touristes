<?php
    /*$page = "home";
    if (isset($_GET["page"])){
        $page = $_GET["page"];
    }
    if ($page = "compte"){
         $pageCompte = "home";
        if (isset($_GET["pageCompte"])){
            $pageCompte = $_GET["pageCompte"];
        }
    }*/
   
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
            if(isGoodBirthDate($birth_date)){
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
    }

    else{
        $page = "home";
    
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
    }

  



?>
