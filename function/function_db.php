<?php

function addUser($mail, $firstname, $lastname, $birth_date, $phone, $password, $isAdmin, $idUserInfo){
    global $base;

    mysqli_real_escape_string($base, $mail);

    mysqli_real_escape_string($base, $firstname);
    
    mysqli_real_escape_string($base, $lastname);

    mysqli_real_escape_string($base, $birth_date);
    
    mysqli_real_escape_string($base, $phone);
    
    mysqli_real_escape_string($base, $password);

    $sql = "INSERT INTO User_info(mail, firstname, lastname, birth_date, phone) 
            VALUES ($mail, $firstname, $lastname, $birth, $phone)";
    
    mysqli_query($base, $sql);

    $sql = "INSERT INTO User(mail, password, admin) 
            VALUES ($mail, $password,$isAdmin)";

    mysqli_query($base, $sql);
}










?>