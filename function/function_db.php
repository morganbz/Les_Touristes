<?php

// ----------------------------------------------------- ADD  ----------------------------------------

function addAnnounce($price, $date_start, $id_housing, $nb_annouce = 0){
        global $base;

        $date = mysqli_real_escape_string($base, $date_start);

        $sql = "INSERT INTO announce(price, date_start, isTaken, id_housing, nb_for_housing)
                VALUES ($price, '$date', 0, $id_housing, $nb_annouce)";

        mysqli_query($base, $sql);
}

function addHousingAndAnnounce($id_owner, $type, $latitude, $longitude, $name, $description, $price, $date_start, $date_end, $country){
        global $base;

        $sql = "INSERT INTO housing (id_owner, type, latitude, longitude, nom, description, country) 
                VALUES ($id_owner, $type, $latitude, $longitude, '$name', '$description', '$country');";

        mysqli_query($base, $sql);

        $id_housing = mysqli_insert_id($base);

        $sql = "INSERT INTO `Average_rate`(`id_rated`, `is_for_housing`) VALUES ($id_housing,1)";
        mysqli_query($base, $sql);

        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $currDate = $date_start;

        for($i = 1; $i <= $days + 1; $i++ ){

                addAnnounce($price, $currDate, $id_housing);

                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));

        }

        $dossier =  "./picture_housing/".strval($id_owner)."/".strval($id_housing);

        $sql = "UPDATE housing SET image_folder = '$dossier' WHERE id = $id_housing";

        mysqli_query($base, $sql);

        return $id_housing;
}

// ----------------------------------------------------- UPDATE HOUSING ------------------------------

function updateHousingAnnounce($id, $name, $latitude, $longitude, $type, $description){
        global $base;

        $name = mysqli_real_escape_string($base, $name);
        $latitude = mysqli_real_escape_string($base, $latitude);
        $longitude = mysqli_real_escape_string($base, $longitude);
        $type = mysqli_real_escape_string($base, $type);
        $description = mysqli_real_escape_string($base, $description);

        $sql = "UPDATE housing SET nom='$name', latitude=$latitude, longitude=$longitude, type=$type, description='$description' WHERE id=$id";

        $update_housing = $base->query($sql);

        if ($update_housing){
                unset($_SESSION["errors_update_housing"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_update_housing"] = $errors;
        }
}

// ----------------------------------------------------- USER ----------------------------------------

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


        if ($insert_user_info){
                $sql = "INSERT INTO user(mail, password, admin) 
                VALUES ('$mail', '$password', $isAdmin)";

                $id_user = $base->insert_id;

                $insert_user = $base->query($sql);   

                if ($insert_user){
                        unset($_SESSION["errors_register"]);
                        $sql = "SELECT id FROM user WHERE mail = '$mail'";
                        $result = mysqli_query ($base, $sql);
                        $id = mysqli_fetch_assoc($result);
                        $_SESSION["id_user"] = $id["id"];


                        $sql = "INSERT INTO `Average_rate`(`id_rated`, `is_for_housing`) VALUES ($id_user,0)";
                        mysqli_query($base, $sql);

                } else {
                        $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                        $_SESSION["errors_register"] = $errors;
                }

        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_register"] = $errors;
        }

        
}

function getUser($mail){
        global $base;

        $mail = mysqli_real_escape_string($base, $mail);

        $sql = "SELECT mail FROM user WHERE mail = '$mail'";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        return $user;
}

function verifUser($mail, $password){
        global $base;
        
        $mail = mysqli_real_escape_string($base, $mail);

        $password = mysqli_real_escape_string($base, $password);

        $sql = "SELECT id, admin, mail, password FROM user WHERE mail = '$mail'";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        $login = false;

        if (password_verify($password, $user['password'])){
                $_SESSION["id_user"] = $user["id"];
                unset($_SESSION["errors_login"]);
                $login = true;
        }

        return $login;
}

function getUserById($id){
        global $base;

        $sql = "SELECT  id, user.mail, admin, firstname, lastname, birth_date, phone, description
        FROM user INNER JOIN user_info ON user.mail = user_info.mail
        WHERE id = $id";
        
        $result = mysqli_query($base, $sql);

        $user = mysqli_fetch_array($result);

        return $user;
}

function getMailById($id){
        global $base;

        $sql = "SELECT mail FROM user WHERE id=$id";

        $result = mysqli_query($base, $sql);

        $mail = mysqli_fetch_array($result);

        return $mail["mail"];
}

function updateUser($firstname, $lastname, $birth_date, $phone, $description){
        global $base;

        $firstname = mysqli_real_escape_string($base, $firstname);
        $lastname = mysqli_real_escape_string($base, $lastname);
        $birth_date = mysqli_real_escape_string($base, $birth_date);
        $phone = mysqli_real_escape_string($base, $phone);
        $description = mysqli_real_escape_string($base, $description);

        $mail = getMailById($_SESSION["id_user"]);

        $sql = "UPDATE user_info SET firstname='$firstname', lastname='$lastname', birth_date='$birth_date', phone='$phone', description='$description' WHERE mail='$mail'";

        $insert_update_user = $base->query($sql);

        if ($insert_update_user){
                unset($_SESSION["errors_modifications"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_modifications"] = $errors;
        }
}

function modificationPassUser($pass){
        global $base;

        $id = $_SESSION["id_user"];

        $sql = "UPDATE user SET password='$pass' WHERE id=$id";

        $insert_modification_pass_user = $base->query($sql);

        if ($insert_modification_pass_user){
                unset($_SESSION["errors_modification_pass"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_modification_pass"] = $errors;
        }
}

// ----------------------------------------------------- ANNOUNCE ----------------------------------------


function getAllNearDate($date_start, $date_end){
        $dates = [];
        
        $currDate = $date_start;
        $nb_day = 0;

        while($currDate <= $date_end ){
                $nb_day++;
                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
        }

        for($i = 1; $i < min(3,$nb_day); $i++){
                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'+ '.$i.' days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'+ '.$i.' days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'+ '.$i.' days')),
                        'date_end' => $date_end
                ));

                array_push($dates,
                array(
                        'date_start' => $date_start,
                        'date_end' => date("Y-m-d", strtotime($date_end.'- '.$i.' days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'- '.$i.' days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'- '.$i.' days'))
                ));

        }
        if($nb_day > 2){

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'- 2 days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'- 1 days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'- 1 days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'- 2 days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'+ 2 days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'+ 1 days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'+ 1 days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'+ 2 days'))
                ));

                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'+ '.$nb_day.' days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'+ '.$nb_day.' days'))
                ));


                array_push($dates,
                array(
                        'date_start' => date("Y-m-d", strtotime($date_start.'- '.$nb_day.' days')),
                        'date_end' => date("Y-m-d", strtotime($date_end.'- '.$nb_day.' days'))
                ));
        }

        return $dates;

}

function searchNearDateAnnounce($priceMin, $priceMax, $date_start, $date_end, $dest, $distance){
        $dates = getAllNearDate($date_start, $date_end);

        $result = [];

        foreach($dates as $date){
                $result = array_merge($result, searchAnnounce($priceMin, $priceMax, $date['date_start'], $date['date_end'], $dest, $distance));
        }

        $nb_day = array_column($result, 'nb_day');
        $dispo_start = array_column($result, 'dispo_start');
        $dispo_end = array_column($result, 'dispo_end');
        array_multisort($nb_day, SORT_DESC, $dispo_start, $dispo_end, $result);

        return $result;
}





function searchAnnounce($priceMin, $priceMax, $date_start, $date_end, $dest, $distance){
        global $base;
        $TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");
        $country = getCountry($dest);

        $sql = "SELECT housing.id, 
        id_owner, 
        latitude, 
        longitude, 
        nom, 
        description, 
        price, 
        MIN(date_start) AS min_date,
        MAX(date_start) AS max_date,
        isTaken,
        type
                FROM housing JOIN announce ON housing.id = id_housing
                WHERE (price BETWEEN $priceMin AND $priceMax) AND date_start <= '$date_end' AND country = '$country'
                GROUP BY id_housing";
        
        $announce = mysqli_query($base, $sql);
        $result = [];
        while($row = mysqli_fetch_assoc($announce)){
                if(getDistance($dest, $row["latitude"], $row["longitude"]) <= $distance * 1000){
                        if($row['min_date'] <= $date_start && $row['max_date'] >= $date_end){

                                if(!isTakenDuration($row["id"], $date_start, $date_end)){

                                        if(isset($_SESSION["id_user"])){
                                                if(!alreadyBookPeriod($row["id"], $_SESSION["id_user"], $date_start, $date_end)){
                                                        $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                                                        $row["type"] = $TYPE_HOUSING[$row["type"]];
                                                        $row["isHousing"] = 1;
                                                        $row['is_near'] = false;
                                                        $row['nb_ask'] = nbBookAskPeriod($row["id"], $date_start, $date_end);
                                                        array_push($result, $row);    
                                                }
                                        }
                                        else{
                                                $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                                                $row["type"] = $TYPE_HOUSING[$row["type"]];
                                                $row["isHousing"] = 1;
                                                $row['is_near'] = false;
                                                $row['nb_ask'] = nbBookAskPeriod($row["id"], $date_start, $date_end);
                                                array_push($result, $row);
                                        }
                                }
                                else{
                                        $dates = durationDispo($row["id"], $date_start, $date_end);
                                        if(!empty($dates)){
                                                $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                                                $row["type"] = $TYPE_HOUSING[$row["type"]];
                                                $row["isHousing"] = 1;
                                                $row['dates'] = $dates;
                                                $row['is_near'] = true;
                                                array_push($result, $row);    


                                        }

                                }
                        }

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

function durationDispo($id_housing, $date_start, $date_end){

        $results = [];
        $dates = getAllNearDate($date_start, $date_end);

        foreach($dates as $date){
                if(!isTakenDuration($id_housing , $date["date_start"], $date["date_end"])){
                        array_push($results, $date);
                }
        }
        return $results;
        
        
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

function getIdByInfos($id_owner, $type, $name, $latitude, $longitude){
        global $base;

        $sql = "SELECT id FROM housing WHERE id_owner = 8 AND type = 0 AND nom = 'z' AND latitude = 12 AND longitude = 12";

        $result = mysqli_query($base, $sql);

        $id = mysqli_fetch_array($result);

        return $id["id"];
        
}

function getHousingById($id){
        global $base;

        $housings = [];

        $sql = "SELECT id, id_owner, type, latitude, longitude, nom, image_folder, description 
                FROM housing
                WHERE id = $id";
        $result = mysqli_query($base, $sql);

        return mysqli_fetch_assoc($result);

}

function getHousingByIdOwner($id){
        global $base;

        $housings = [];

        $sql = "SELECT id, id_owner, type, latitude, longitude, nom, image_folder, description 
                FROM housing
                WHERE id_owner = $id";
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $housings[] = $row;
        }

        return $housings;

}

function getAnnounceByIdHousing($id){
        global $base;

        $announces = [];

        $sql = "SELECT id, price, date_start, isTaken, id_housing FROM announce WHERE id_housing = $id";
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $announces[] = $row;
        }

        return $announces;
}

function getPriceAnnounceByDate($id, $date_start){
        global $base;

        $sql = "SELECT id, price, date_start, isTaken, id_housing FROM announce WHERE id_housing = $id AND date_start = '$date_start'";
        $result = mysqli_query($base, $sql);

        $row = mysqli_fetch_assoc($result);

        return $row['price'];
}

function getAnnounceGrpNbByIdHousing($id_housing){
        global $base;

        $announces = [];

        $sql = "SELECT id, price, MIN(date_start) AS date_start, MAX(date_start) AS date_end, COUNT(id) AS nb_day, isTaken, id_housing 
        FROM announce WHERE id_housing = $id_housing GROUP BY nb_for_housing";
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $announces[] = $row;
        }

        return $announces;
}

function askbookAnnounce($id_housing, $id_customer, $date_start, $date_end){
        global $base;

        $sql = "INSERT INTO `reservation`(`id_user`, `id_housing`,`date_start`, `date_end`) 
                VALUES ($id_customer,$id_housing,'$date_start', '$date_end')";
        mysqli_query($base, $sql);
}

function askBookHousingPeriod($id_housing, $id_customer, $date_start, $date_end){

        global $base;

        $sql = "INSERT INTO `reservation`(`id_user`, `id_housing`,`date_start`, `date_end`) 
        VALUES ($id_customer,$id_housing,'$date_start', '$date_end')";
        $announce = mysqli_query($base, $sql);
}
/*
function getAllBookAskByIdOwner($id_owner){
        
        $demands = [];

        global $base;
        $sql = "SELECT housing.id AS id_housing,
	`id_owner`,
        `nom`,
        reservation.date_start AS date_start,
        reservation.date_end AS date_end,
        price,
        reservation.id_user AS id_user,
        COUNT(housing.id) AS nb_day,
        price AS price_by_night
        FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        			INNER JOIN reservation ON announce.id = reservation.id_housing

                WHERE id_owner = $id_owner AND accepted = 0";

        $result = mysqli_query($base, $sql);
        while($row = mysqli_fetch_assoc($result)){
                array_push($demands, $row);
        }

        return $demands;


}
*/
function getAllBookAskByIdOwner($id_owner){
        
        $demands = [];

        global $base;
        $sql = "SELECT 
                        id_owner,
                        date_start,
                        date_end,
                        housing.id AS id_housing,
                        nom,
                        reservation.id_user AS id_user
                FROM reservation
                JOIN housing ON housing.id = reservation.id_housing
                WHERE housing.id_owner = $id_owner";

        $result = mysqli_query($base, $sql);
        while($row = mysqli_fetch_assoc($result)){

                $dateDifference = abs(strtotime($row['date_end']) - strtotime($row['date_start']));
                $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

                $currDate = $row['date_start'];
                $nb_day = 0;

                while($currDate <= $row['date_end'] ){
                        $nb_day++;
                        $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
                }
                $row['nb_day'] = $nb_day;

                $row['price'] = getTotalPrice($row['id_housing'], $row['date_start'], $row['date_end']);

                array_push($demands, $row);
        }

        return $demands;


}

function getTotalPrice($id_housing, $date_start, $date_end){
        global $base;

        $dateDifference = abs(strtotime($date_start) - strtotime($date_end));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $currDate = $date_start;
        $price = 0;
        while($currDate <= $date_end){
                $price = $price + getPriceAnnounceByDate($id_housing, $currDate);
                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
        }
        return $price;
}

function nbBookAskPeriod($id_housing, $date_start, $date_end){
        global $base;
        $cpt = 0;

        $sql = "SELECT * FROM `reservation` 
        WHERE accepted = 0 AND id_housing = $id_housing AND
                (date_start BETWEEN '$date_start' AND '$date_end')
            OR
            (date_end BETWEEN '$date_start' AND '$date_end')";
        
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
                $cpt++;
        }
        return $cpt;

}


function getAllBookAskByIdHousing($id_housing){

        $demands = [];

        global $base;
        $sql = "SELECT 
                        reservation.id AS id_reservation,
                        id_owner,
                        date_start,
                        date_end,
                        housing.id AS id_housing,
                        nom,
                        reservation.id_user AS id_user
                FROM reservation
                JOIN housing ON housing.id = reservation.id_housing
                WHERE housing.id = $id_housing AND accepted = 0";

        $result = mysqli_query($base, $sql);
        while($row = mysqli_fetch_assoc($result)){

                $dateDifference = abs(strtotime($row['date_end']) - strtotime($row['date_start']));
                $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

                $currDate = $row['date_start'];
                $nb_day = 0;

                while($currDate <= $row['date_end'] ){
                        $nb_day++;
                        $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
                }
                $row['nb_day'] = $nb_day;

                $row['price'] = getTotalPrice($id_housing, $row['date_start'], $row['date_end']);

                array_push($demands, $row);
        }


        return $demands;
}
/*
function alreadyBookAnnounce($id_announce, $id_customer){
        $res = false;
        global $base;

        $sql = "SELECT `id` FROM `reservation` WHERE id_user = $id_customer AND id_announce = $id_announce";
        $result = mysqli_query($base, $sql);
        if(mysqli_fetch_assoc($result) != null){
                $res = true;
        }
        return $res;
}*/

function hasAskBooking($id_housing){
        global $base;
        $res = false;
        $sql = "SELECT id FROM `reservation` WHERE id_housing = $id_housing AND accepted = 0";
        $result = mysqli_query($base, $sql);
        if(mysqli_fetch_assoc($result) != null){
                $res = true;
        }

        
        return $res;

}

function getAllBookByIdHousing($id_housing){
        $announces = [];
        global $base;
        $sql = "SELECT 
                        date_start,
                        date_end,
                        reservation.id_user AS id_user
                FROM reservation
                JOIN housing ON housing.id = reservation.id_housing
        WHERE housing.id = $id_housing AND accepted = 1";

        $result_sql = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result_sql)){
                array_push($announces, $row);
        }
        return $announces;


}

function hasBooking($id_housing){
        global $base;
        $sql = "SELECT announce.id
        FROM announce JOIN housing ON housing.id = announce.id_housing
        WHERE isTaken = 1 AND housing.id = $id_housing";

        $result = mysqli_query($base, $sql);
        return isset(mysqli_fetch_assoc($result)["id"]);
}

function alreadyBookPeriod($id_housing, $id_customer, $date_start, $date_end){
        global $base;

        $res = false;

        $sql = "SELECT id FROM `reservation` WHERE 
        accepted = 0 AND id_housing = $id_housing AND id_user = $id_customer
        AND(
            date_start BETWEEN '$date_start' AND '$date_end'
            OR
            date_end BETWEEN '$date_start' AND '$date_end'
            )";
        $result = mysqli_query($base, $sql);

        if(mysqli_fetch_assoc($result) != null){
                $res = true;
        }

        return $res;
}

function bookAnnounce($id_announce, $id_customer){
        global $base;
        $sql = "UPDATE `announce` SET `isTaken`=1 WHERE id = $id_announce
        ";
        $result = mysqli_query($base, $sql);

}

function bookReservation($id_housing, $id_customer, $date_start, $date_end){
        global $base;

        $sql = "UPDATE `reservation` SET accepted = 1 
                WHERE id_housing = $id_housing AND id_user = $id_customer AND date_start = '$date_start' AND date_end = '$date_end'";
        $result = mysqli_query($base, $sql);
        
        $sql = "DELETE FROM `reservation`
                WHERE id_housing = $id_housing AND
                (
                (date_start BETWEEN '$date_start' AND '$date_end')
                OR (date_end BETWEEN '$date_start' AND '$date_end')
                )
                AND accepted = 0";
        $result = mysqli_query($base, $sql);

        
}

function bookHousingPeriod($id_housing, $id_customer, $date_start, $date_end){

        global $base;

        $sql = "SELECT announce.id AS id FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        WHERE housing.id = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        
        $announce = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($announce)){
                bookAnnounce(intval($row['id']), $id_customer);

        }

        bookReservation($id_housing, $id_customer, $date_start, $date_end);

}

function getConflict($demands){
        $res = [];
        $cpt = 1;
        $num_conflict = 1;
        $no_conflicts = [];
        $is_done = false;

        foreach($demands as $curr_demands){


                foreach($res as $curr_conflict){
                        if(in_array($curr_demands, $curr_conflict)){
                                $is_done = true;
                        }
                }

                if(!$is_done){
                        $conflicts = [];
                        if(isset($curr_demands['date_start']) && isset($curr_demands['date_end'] )){

                                $curr_start = $curr_demands['date_start'];
                                $curr_end = $curr_demands['date_end'];
                                $new_demands = $demands;

                                foreach($new_demands as $demand){

                                        if(isset($demand['date_start']) && isset($demand['date_end'])){

                                                if($demand != $curr_demands){
                                                        if(($demand['date_start'] >= $curr_start && $demand['date_start'] <= $curr_end)
                                                        || ($demand['date_end'] >= $curr_start && $demand['date_end'] <= $curr_end) ){
                                                                array_push($conflicts, $demand);
                                                        }
                                                }


                                        }

                                }

                                if($conflicts == []){
                                        array_push($no_conflicts,$curr_demands);
                                }
                                else{
                                        array_push($conflicts, $curr_demands);

                                        
                                        $nb_day = array_column($conflicts, 'nb_day');
                                        array_multisort($nb_day, SORT_DESC, $conflicts);

                                        array_push($res, $conflicts);
                                }

                        }
                        $cpt++;
                }
                $is_done =  false;
                

        }

        array_push($res, $no_conflicts);

        return $res;

}



function updatePriceAnnounce($id, $price) {
        global $base;

        $prix = mysqli_real_escape_string($base, $price);
        $sql = "UPDATE announce SET price = $prix WHERE id = $id";

        $insert_update_price_announce = $base->query($sql);

        if ($insert_update_price_announce){
                unset($_SESSION["errors_update_price_announce"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_update_price_announce"] = $errors;
        }
}

function addHousingAnnounceDate($id, $price, $date) {
        global $base;

        $prix = mysqli_real_escape_string($base, $price);
        $date = mysqli_real_escape_string($base, $date);

        $sql = "INSERT INTO announce (date_start, price, isTaken, id_housing) VALUES ('$date', $prix, 0, $id)" ;
       
        $insert_add_housing_announce_date = $base->query($sql);

        if ($insert_add_housing_announce_date){
                unset($_SESSION["errors_add_housing_date"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_add_housing_date"] = $errors;
        }

}

function delDateAnnounceHousing($id) {
        global $base;

        $sql = "DELETE FROM announce WHERE id = $id";

        $insert_del_date_announce_housing = $base->query($sql);

        if ($insert_del_date_announce_housing){
                unset($_SESSION["errors_del_housing_date"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_del_housing_date"] = $errors;
        }

}

function getAverage($id_rated, $type_rated){
        global $base;

        $sql = "SELECT rate FROM rate WHERE id_rated = $id_rated AND type_rated = $type_rated";
        
        $results =  mysqli_query($base, $sql);

        $nb_rates = mysqli_num_rows($results);

        $som_rates = 0;
        while ($row = mysqli_fetch_assoc($results)){

                $som_rates += $row['rate'];
        }

        if ($nb_rates == 0){
                $average = 0;
        } else {
                $average = $som_rates / $nb_rates;
        }

        return $average;
}

function getNbNotes($id_rated, $type_rated){
        global $base;

        $sql = "SELECT COUNT(id) AS nb FROM rate WHERE id_rated = $id_rated AND type_rated = $type_rated";
        $result = mysqli_query($base, $sql);

        return mysqli_fetch_assoc($result)["nb"];

}

function addRating($id_rated, $id_rater, $rate, $title, $message, $type_rated){
        global $base;

        $title = mysqli_real_escape_string($base, $title);
        $message = mysqli_real_escape_string($base, $message);

        $sql = "INSERT INTO `rate`(`id_rated`, `id_rater`, `rate`, `title`, `message`, `type_rated`) VALUES ($id_rated,$id_rater,$rate,'$title', '$message',$type_rated)";
        
        $result = mysqli_query($base, $sql);

}

function addRatingUser($id_rated, $id_rater, $rate, $title, $message){
        addRating($id_rated, $id_rater, $rate, $title, $message, 3);
}

function addRatingHousing($id_rated, $id_rater, $rate, $title, $message){
        addRating($id_rated, $id_rater, $rate, $title, $message, 1);
}

function addRatingActivity($id_rated, $id_rater, $rate, $title, $message){
        addRating($id_rated, $id_rater, $rate, $title, $message, 2);
}

function isAlreadyRated($id_rated, $id_rater, $type_rated){
        global $base;

        $sql = "SELECT id FROM rate WHERE id_rated = $id_rated AND id_rater = $id_rater AND type_rated = $type_rated";

        $result = mysqli_query($base, $sql);

        return !empty(mysqli_fetch_assoc($result));
}

function hasRatedHistory($id_history){
        global $base;

        $sql = "SELECT id FROM rate WHERE id_history = $id_history";

        $result = mysqli_query($base, $sql);

        return !empty(mysqli_fetch_assoc($result));
}

function getRates($id_rated, $type_rated){
        global $base;

        $sql = "SELECT id_rater, rate, title, message FROM rate WHERE id_rated = $id_rated AND type_rated = $type_rated";

        $results = mysqli_query($base, $sql);

        $rates = array();

        while($row = mysqli_fetch_assoc($results)){
                array_push($rates, $row);
        }

        return $rates;
}

function getRate($id_history){
        global $base;

        $sql = "SELECT id_rater, rate, title, message FROM rate WHERE id_history = $id_history";

        $results = mysqli_query($base, $sql);

        return mysqli_fetch_assoc($results);

}

function numberAnnounceDistinctByIdHousing($id_housing){
        global $base;
        $cpt = 0;

        $sql = "SELECT `id` FROM `announce` WHERE id_housing = $id_housing
                GROUP BY id_housing, nb_for_housing";

        $announces = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($announces)){
                $cpt++;
        }
        return $cpt;

}

function getAllAnnounceOrderByDistinct($id_housing){
        global $base;
        $result = [];

        $sql = "SELECT `id`, `price`, MIN(date_start) AS date_start, MAX(date_start) AS date_end FROM `announce` 
        WHERE id_housing = $id_housing GROUP BY nb_for_housing";
        $announces = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($announces)){
                array_push($result, $row);
        }
        return $result;
}

function getAnnounceByNb($id_housing, $nb_announce){
        global $base;
        $result = [];
        
        $sql = "SELECT `id`, `price`, `date_start`, `isTaken`, `id_housing`, `nb_for_housing` FROM `announce` 
                        WHERE id_housing = $id_housing AND nb_for_housing = $nb_announce";
        
        $announces = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($announces)){
                array_push($result, $row);
        }
        return $result;

}

function addDistinctAnnounce($id_housing, $date_start, $date_end, $price){
        global $base;
        $nb_announce_distinct = numberAnnounceDistinctByIdHousing($id_housing);

        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $currDate = $date_start;

        for($i = 1; $i <= $days + 1; $i++ ){

                addAnnounce($price, $currDate, $id_housing, $nb_announce_distinct);

                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));

        }

}

function announceExist($id_housing, $date){
        global $base;

        $sql = "SELECT `id` FROM `announce` WHERE id_housing = $id_housing and date_start = '$date'";

        $announce = mysqli_query($base, $sql);

        return mysqli_fetch_assoc($announce) != null;

}


function addActivity($nom, $idtype, $pays, $lat, $long, $id_user, $desc){
        global $base;

        $nom = mysqli_real_escape_string($base, $nom);
        $idtype = mysqli_real_escape_string($base, $idtype);
        $pays = mysqli_real_escape_string($base, $pays);
        $lat = mysqli_real_escape_string($base, $lat);
        $long = mysqli_real_escape_string($base, $long);
        $desc = mysqli_real_escape_string($base, $desc);

        $sql = "INSERT INTO `activity` (`id_owner`, `type`, `latitude`, `longitude`, `country`, `nom`, `description`) VALUES ($id_user,$idtype, $lat, $long, '$pays', '$nom', '$desc')";

        mysqli_query($base, $sql);

        $id_activity = mysqli_insert_id($base);

        $folder = "./picture_activity/".strval($id_user)."/".strval($id_activity);

        $sql = "UPDATE `activity` SET `image_folder` = '$folder' WHERE `id_activity` = '$id_activity'";

        mysqli_query($base, $sql);

        return $id_activity;
}

function getActivityByIdOwner($id){
        global $base;

        $activity = [];

        $sql = "SELECT id_activity, type, latitude, longitude, country, nom, description, image_folder
                FROM activity
                WHERE id_owner = $id";
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $activity[] = $row;
        }

        return $activity;       
}

function getActivityById($id){
        global $base;

        $activity = [];

        $sql = "SELECT id_activity, type, latitude, longitude, country, nom, description, image_folder
                FROM activity
                WHERE id_activity = $id";
        $result = mysqli_query($base, $sql);

        $activity = mysqli_fetch_assoc($result);

        return $activity;       
}

function updateActivity($id, $nom, $idtype, $pays, $lat, $long, $desc){
        global $base;

        $name = mysqli_real_escape_string($base, $nom);
        $type = mysqli_real_escape_string($base, $idtype);
        $pays = mysqli_real_escape_string($base, $pays);
        $latitude = mysqli_real_escape_string($base, $lat);
        $longitude = mysqli_real_escape_string($base, $long);
        $description = mysqli_real_escape_string($base, $desc);

        $sql = "UPDATE activity SET nom='$name', latitude=$latitude, longitude=$longitude, country='$pays', type=$type, description='$description' WHERE id_activity=$id";

        $update_housing = $base->query($sql);

        if ($update_housing){
                unset($_SESSION["errors_update_activity"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_update_housing"] = $errors;
        }
}

function getAllHousingID(){
        global $base;

        $sql = "SELECT id FROM housing";

        $results = mysqli_query($base, $sql);

        $ids = Array();

        while ($row = mysqli_fetch_assoc($results)){
                $ids[] = $row["id"];
        }

        return $ids;
}

function getAllActivityID(){
        global $base;

        $sql = "SELECT id_activity FROM activity";

        $results = mysqli_query($base, $sql);

        $ids = Array();

        while ($row = mysqli_fetch_assoc($results)){
                $ids[] = $row["id_activity"];
        }

        return $ids;
}

function deleteReservationById($id){
        global $base;

        $sql = "DELETE FROM `reservation` WHERE id = $id";

        mysqli_query($base, $sql);
}

//---------------------------HISTORIQUE------------------------------

function addHousingHistory($begin_date, $end_date, $id_user, $id_housing){
        global $base;

        $sql = " INSERT INTO `housing_history` (`begin_date`, `end_date`, `id_user`, `id_housing`) VALUES ('$begin_date', '$end_date', $id_user, $id_housing)";

        mysqli_query($base, $sql);

}

function getHistoryByIdUser($id){
        $history = [];
        global $base;

        $sql = "SELECT * FROM housing_history WHERE id_user = $id";

        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
                array_push($history, $row);

        }
        return $history;
}

function getHistoryByIdHousing($id){
        $history = [];
        global $base;

        $sql = "SELECT * FROM housing_history WHERE id_housing = $id";

        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
                array_push($history, $row);

        }
        return $history;
}



function fromResaToHistory(){
        $current_date = date("Y-m-d");

        global $base;

        $sql = "SELECT `id`, `id_user`, `id_housing`, `date_start`, `date_end` FROM `reservation` 
                WHERE date_end <= '$current_date' AND accepted = 1";

        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){

                addHousingHistory($row['date_start'], $row['date_end'], $row['id_user'], $row['id_housing']);

                deleteReservationById($row['id']);

        }


}

function searchActivity($dest, $distance){
        global $base;
        $TYPE_ACTIVITY = array("Randonnée", "Espace Culturel", "Restauration", "Baignade");
        $country = getCountry($dest);

        $sql = "SELECT * FROM `activity` WHERE country = '$country'";


        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
                if(getDistance($dest, $row["latitude"], $row["longitude"]) <= $distance * 1000){
                        $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                        $row["type"] = $TYPE_ACTIVITY[$row["type"]];
                        $row["isHousing"] = 0;
                        $activity[] = $row;
                }
        }

        return $activity;   
}

function getHousingHistoryBy($what, $id, $order = DATE_ORDER){
        global $base;

        $history = [];

        $sql = "SELECT DISTINCT h.id, h.type, h.latitude, h.longitude, h.nom, h.image_folder, h.description, hh.begin_date, hh.end_date, hh.id_user 
                FROM `housing_history` hh INNER JOIN `housing` h 
                ON hh.id_housing = h.id
                WHERE hh.$what = $id
                ORDER BY hh.$order";
              
        $result = mysqli_query($base, $sql);
        
        while($row = mysqli_fetch_assoc($result)){
            $history[] = $row;
        }

        return $history;
}

function getHousingHistoryByIdOwner($id, $order = DATE_ORDER){
        return getHousingHistoryBy("id_user", $id, $order);
}

function getHousingHistoryByIdHousing($id, $order = DATE_ORDER){
        return getHousingHistoryBy("id_housing", $id, $order);
}

?>