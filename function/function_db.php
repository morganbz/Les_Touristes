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
                array_push($result, $row);
        }
        //var_dump($result);
        return $result;
}

function searchAnnounce2($priceMin, $priceMax, $date_start, $date_end){
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
                        echo $row["id"];
                }

        }
        //var_dump($result);
        return $result;
}

function isTakenDay($housing){
        global $base; 
        return $housing[7] == "1";
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

        while($row = mysqli_fetch_array($announce) && !$taken){
                if(isTakenDay($row)){
                        $taken = true;
                }
                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
        }

        return $taken;


}

?>