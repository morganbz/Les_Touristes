<?php

function addUser($mail, $firstname, $lastname, $birth_date, $phone, $password, $isAdmin){
        global $base;

        mysqli_real_escape_string($base, $mail);

        mysqli_real_escape_string($base, $firstname);
        
        mysqli_real_escape_string($base, $lastname);

        mysqli_real_escape_string($base, $birth_date);
        
        mysqli_real_escape_string($base, $phone);
        
        mysqli_real_escape_string($base, $password);

        $sql = "INSERT INTO User_info(mail, firstname, lastname, birth_date, phone) 
                VALUES ('$mail', '$firstname', '$lastname', '$birth_date', '$phone')";
    
        //mysqli_query($base, $sql);

        $sql = "INSERT INTO User(mail, password, admin) 
                VALUES ('$mail', '$password', $isAdmin)";

        echo $sql;

        mysqli_query($base, $sql);
}

function getUser($mail){
        global $base;

        $sql = "SELECT 
                        mail
                FROM User 
                WHERE mail = $mail";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        return $user;
}










?>