<?php
  $page = "home";
  if (isset($_GET["page"])){
    $page = $_GET["page"];
  }

  $submit = $_POST["submit"];
  if($submit == "register"){
      $mail = $_POST["mail_register"];
      $firstname = $_POST["firstname_register"];
      $lastname = $_POST["lastname_register"];
      $phone = $_POST["phone_register"];
      $pass = $_POST["pass_register"];
      $birth_date = $_POST["birth_date_register"];
      $admin = $_POST["admin"];
  }



?>
