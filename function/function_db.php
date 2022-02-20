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
    
        mysqli_query($base, $sql);

        $sql = "INSERT INTO User(mail, password, admin) 
                VALUES ('$mail', '$password', $isAdmin)";

        mysqli_query($base, $sql);
}

function getUser($mail){
        global $base;

        $sql = "SELECT 
                        mail
                FROM User 
                WHERE mail = '$mail'";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        return $user;
}

function addHousing($id_owner, $type, $latitude, $longitude, $name, $description){
        global $base;

        mysqli_real_escape_string($base, $name);

        mysqli_real_escape_string($base, $description);

        $sql = "INSERT INTO housing (id_owner, type, latitude, longitude, nom, description) 
                VALUES ($id_owner, $type, $latitude, $longitude, '$name', '$description')";

        mysqli_query($base, $sql);        
}

function addAnnounce($price, $date_start, $id_housing){
        global $base;

        mysqli_real_escape_string($base, $date);

        $sql = "INSERT INTO Announce(price, date_start, isTaken, id_housing)
                VALUES ($price, '$date_start', 0, $id_housing)";

        mysqli_query($base, $sql);
}

function verifUser($mail, $password){
        global $base;
        
        mysqli_real_escape_string($base, $mail);

        mysqli_real_escape_string($base, $password;

        $sql = "SELECT id, admin, mail, password FROM User WHERE mail = $mail AND password = $password";
        
        $user = mysqli_fetch_array($base, $sql);
}

?>