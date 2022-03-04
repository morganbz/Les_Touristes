<?php

function addUser($mail, $firstname, $lastname, $birth_date, $phone, $password, $isAdmin){
        global $base;

        mysqli_real_escape_string($base, $mail);

        mysqli_real_escape_string($base, $firstname);
        
        mysqli_real_escape_string($base, $lastname);

        mysqli_real_escape_string($base, $birth_date);
        
        mysqli_real_escape_string($base, $phone);
        
        mysqli_real_escape_string($base, $password);

        $sql = "INSERT INTO user_info(mail, firstname, lastname, birth_date, phone) 
                VALUES ('$mail', '$firstname', '$lastname', '$birth_date', '$phone')";
    
        mysqli_query($base, $sql);

        $sql = "INSERT INTO user(mail, password, admin) 
                VALUES ('$mail', '$password', $isAdmin)";

        mysqli_query($base, $sql);
}

function getUser($mail){
        global $base;

        $sql = "SELECT 
                        mail
                FROM user 
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

        $sql = "INSERT INTO announce(price, date_start, isTaken, id_housing)
                VALUES ($price, '$date_start', 0, $id_housing)";

        mysqli_query($base, $sql);
}

function addHousingAndAnnounce($id_owner, $type, $latitude, $longitude, $name, $description, $price, $date_start, $date_end){
        global $base;

        $sql = "INSERT INTO announce(price, date_start, isTaken, id_housing)
                VALUES ($price, '$date_start', 0, $id_housing)";

        mysqli_query($base, $sql);

        $id_housing = mysqli_insert_id($base);

        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $currDate = new DateTime($date_start);

        for($i = 1; $i <= $days; $i++ ){

                $sql = "INSERT INTO announce(price, date_start, isTaken, id_housing)
                VALUES ($price, '$currDate->format('Y-m-d')', 0, $id_housing)";

                mysqli_query($base, $sql);

                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));

        }


}

function verifUser($mail, $password){
        global $base;
        
        mysqli_real_escape_string($base, $mail);

        mysqli_real_escape_string($base, $password);

        $sql = "SELECT id, admin, mail, password FROM user WHERE mail = $mail AND password = $password";
        
        $user = mysqli_fetch_array($base, $sql);

        return $user;
}

function getUserById($id){
        global $base;

        $sql = "SELECT  id, User.mail, admin, firstname, lastname, birth_date, phone, description
        FROM User INNER JOIN User_info ON User.mail = User_info.mail
        WHERE id = $id";
        
        $user = mysqli_fetch_array($base, $sql);

        return $user;
}

function seachAnnounce(){
        global $base;

        $sql = "SELECT housing.id id_owner, type, latitude, longitude, nom, price, date_start, isTaken
        FROM housing INNER JOIN Announce ON housing.id = Announce.id_housing
        WHERE (price BETWEEN $priceMin AND $priceMax) AND (date_start BETWEEN $dateStart AND $dateEnd) AND (NOT isTaken) AND type IN $types 
        GROUP BY housing.id";
        
        $announce = mysqli_fetch_array($base, $sql);

        return $announce;
}
?>