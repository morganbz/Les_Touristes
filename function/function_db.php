<?php

function addUser($mail, $firstname, $lastname, $birth_date, $phone, $password, $isAdmin){
        global $base;

        $mail = mysqli_real_escape_string($base, $mail);

        $firstname = mysqli_real_escape_string($base, $firstname);
        
        $lastname = mysqli_real_escape_string($base, $lastname);

        $birth_date = mysqli_real_escape_string($base, $birth_date);
        
        $phone = mysqli_real_escape_string($base, $phone);
        
        $password = mysqli_real_escape_string($base, $password);

        $sql = "INSERT INTO user_info(mail, firstname, lastname, birth_date, phone) 
                VALUES ('$mail', '$firstname', '$lastname', '$birth_date', '$phone')";

        $insert_user_info = $base->query($sql);

        $sql = "INSERT INTO user(mail, password, admin) 
                VALUES ('$mail', '$password', $isAdmin)";

        $insert_user = $base->query($sql);

        if ($insert_user_info && $insert_user){
                unset($_SESSION["errors_register"]);
                $sql = "SELECT id FROM user WHERE mail = '$mail'";
                $result = mysqli_query ($base, $sql);
                $id = mysqli_fetch_assoc($result);
                $_SESSION["id_user"] = $id;
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée" + var_dump($insert_user_info === TRUE && $insert_user === TRUE);
                var_dump($insert_user_info == TRUE);
                var_dump($insert_user_info === TRUE);
                var_dump($insert_user_info);
                $_SESSION["errors_register"] = $errors;
        }
}

function getUser($mail){
        global $base;

        $sql = "SELECT mail FROM user WHERE mail = '$mail'";
        
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

        $sql = "INSERT INTO housing (id_owner, type, latitude, longitude, nom, description) 
                VALUES ($id_owner, $type, $latitude, $longitude, '$name', '$description')";

        echo $sql;

        mysqli_query($base, $sql);

        $id_housing = mysqli_insert_id($base);

        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $currDate = $date_start;

        for($i = 1; $i <= $days; $i++ ){

                addAnnounce($price, $currDate, $id_housing);

                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));

        }


}

function verifUser($mail, $password){
        global $base;
        
        mysqli_real_escape_string($base, $mail);

        mysqli_real_escape_string($base, $password);

        $sql = "SELECT id, admin, mail, password FROM user WHERE mail = '$mail' AND password = '$password'";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        echo $sql;

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

function searchAnnounce($priceMin, $priceMax, $date_start, $date_end){
        global $base;

        $sql = "SELECT housing.id, id_owner, type, latitude, longitude, nom, price, date_start, isTaken
        FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        WHERE (price BETWEEN $priceMin AND $priceMax) AND (NOT isTaken) AND date_start >=  '$date_start' AND date_start <= '$date_end'
        GROUP BY housing.id";
        
        $announce = mysqli_query($base, $sql);
        $result = [];
        while($row = mysqli_fetch_array($announce)){
                if(!isTakenDuration($row["id"], $date_start, $date_end)){
                        array_push($result, $row);
                }
        }
        return $result;
}

function isTakenDay($housing){
        global $base; 
        return $housing["isTaken"] == "1";
}

function isTakenDuration($id_housing , $date_start, $date_end){
        global $base;
        $taken = false;
        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $sql = "SELECT * FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        WHERE housing.id = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        
        $announce = mysqli_query($base, $sql);

        $currDate = $date_start;

        while(($row = mysqli_fetch_array($announce)) && !$taken){
                if(isTakenDay($row)){
                        $taken = true;
                }
                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
        }

        return $taken;


}

function getData($ville){
        global $base;
    
        $res = [];
    
        $sql = "SELECT id, departement, ville, adresse, latitude, longitude, nom, description FROM test_search WHERE ville = '$ville'";
    
        $result = mysqli_query($base, $sql);
    
        while($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
        }
    
        return $res;
}

?>