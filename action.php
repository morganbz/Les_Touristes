<?php
    $page = "home";
    if (isset($_GET["page"])){
        $page = $_GET["page"];
    }
    $pageCompte = "home";
    if (isset($_GET["pageCompte"])){
        $pageCompte = $_GET["pageCompte"];
    }
    if(!empty($_POST)&&array_key_exists("submit", $_POST)){
        $submit = $_POST["submit"];
        if($submit == "register"){
            $mail = $_POST["mail_register"];
            $firstname = $_POST["firstname_register"];
            $lastname = $_POST["lastname_register"];
            $phone = $_POST["phone_register"];
            $pass = $_POST["pass_register"];
            $birth_date = $_POST["birth_date_register"];
            $admin = $_POST["admin"];
    
            $good_firstname = false;
            $good_lastname = false;
            $good_mail = false;
            $good_phone = false;
            $good_pass = false;
            $good_birth_date = false;
    }

  }



?>
