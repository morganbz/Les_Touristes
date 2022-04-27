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
                if(!isTakenDuration($row["id"], $date_start, $date_end)){
                        if(getDistance($dest, $row["latitude"], $row["longitude"]) <= $distance * 1000){
                                if($row['min_date'] <= $date_start && $row['max_date'] >= $date_end){
                                        if(isset($_SESSION["id_user"])){
                                                if(!alreadyBookPeriod($row["id"], $_SESSION["id_user"], $date_start, $date_end)){
                                                        $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                                                        $row["type"] = $TYPE_HOUSING[$row["type"]];
                                                        array_push($result, $row);    
                                                }
                                        }
                                        else{
                                                $row["adresse"] = getAddress($row["latitude"], $row["longitude"]);
                                                $row["type"] = $TYPE_HOUSING[$row["type"]];
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

function AskbookAnnounce($id_announce, $id_customer){
        global $base;

        $sql = "INSERT INTO `reservation`(`id_user`, `id_announce`) VALUES ($id_customer,$id_announce)";
        mysqli_query($base, $sql);
}

function AskBookHousingPeriod($id_housing, $id_customer, $date_start, $date_end){

        global $base;

        $sql = "SELECT housing.id AS id_housing,
	`id_owner`,
        `type`,
        `latitude`,
        `longitude`,
        `nom`,
        `image_folder`,
        `description`,
        announce.id AS id_announce,
        price,
        date_start
        FROM housing INNER JOIN announce ON housing.id = announce.id_housing

                WHERE id_housing = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        $announce = mysqli_query($base, $sql);

        while($row = mysqli_fetch_array($announce)){
                AskBookAnnounce($row['id_announce'], $id_customer);
        }

}

function getAllBookAskByIdOwner($id_owner){
        
        $demands = [];

        global $base;
        $sql = "SELECT housing.id AS id_housing,
	`id_owner`,
        `nom`,
        MIN(date_start) AS date_start,
        MAX(date_start) AS date_end,
        price,
        reservation.id_user AS id_user,
        COUNT(housing.id) AS nb_day,
        price AS price_by_night
        FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        			INNER JOIN reservation ON announce.id = reservation.id_announce

                WHERE id_owner = $id_owner AND accepted = 0
                GROUP BY reservation.id_user, announce.nb_for_housing";

        $result = mysqli_query($base, $sql);
        while($row = mysqli_fetch_assoc($result)){
                array_push($demands, $row);
        }

        return $demands;


}

function alreadyBookAnnounce($id_announce, $id_customer){
        $res = false;
        global $base;

        $sql = "SELECT `id` FROM `reservation` WHERE id_user = $id_customer AND id_announce = $id_announce";
        $result = mysqli_query($base, $sql);
        if(mysqli_fetch_assoc($result) != null){
                $res = true;
        }
        return $res;
}

function alreadyBookPeriod($id_housing, $id_customer, $date_start, $date_end){
        global $base;

        $res = false;
        $test = "BITE";

        $sql = "SELECT housing.id AS id_housing,
	`id_owner`,
        announce.id AS id_announce,
        reservation.id_user AS id_user
        FROM housing 
        INNER JOIN announce ON housing.id = announce.id_housing
        INNER JOIN reservation on announce.id = reservation.id_announce

                WHERE id_housing = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        $announce = mysqli_query($base, $sql);

        while($row = mysqli_fetch_array($announce)){
 
                if($res == false){
                        $res = alreadyBookAnnounce($row['id_announce'], $id_customer);
                }

        }

        return $res;
}

function bookAnnounce($id_announce, $id_customer){
        global $base;
        $sql = "UPDATE `announce` SET `isTaken`=1 WHERE id = $id_announce
        ";
        echo $sql;
        $result = mysqli_query($base, $sql);

        $sql = "UPDATE `reservation` SET `accepted`=1 WHERE id_user = $id_customer AND id_announce = $id_announce
        ";
        echo $sql;
        $result = mysqli_query($base, $sql);

        $sql = "DELETE FROM `reservation` WHERE id_user != $id_customer AND id_announce = $id_announce
        ";
        echo $sql;
        $result = mysqli_query($base, $sql);

}

function bookHousingPeriod($id_housing, $id_customer, $date_start, $date_end){

        global $base;

        $sql = "SELECT * FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        WHERE housing.id = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        
        $announce = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($announce)){
                bookAnnounce(intval($row['id']), $id_customer);
        }

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

function get_average($id_rated, $is_for_housing){
        global $base;

        $sql = "SELECT rate FROM Rate WHERE id_rated = $id_rated AND is_for_housing = $is_for_housing";
        
        $results =  mysqli_query($base, $sql);

        $nb_rates = mysqli_num_rows($results);

        $som_rates = 0;
        while ($row = mysqli_fetch_assoc($results)){

                $som_rates += $row['rate'];
        }

        return $som_rates / $nb_rates;
}

function addRating($id_rated, $id_rater, $rate, $title, $message, $is_housing){
        global $base;

        $sql = "INSERT INTO `Rate`(`id_rated`, `id_rater`, `rate`, `title`, `message`, `is_for_housing`) VALUES ($id_rated,$id_rater,$rate,'$title', '$message',$is_housing)";
        
        $result = mysqli_query($base, $sql);

}

function addRatingUser($id_rated, $id_rater, $rate, $title, $message){
        addRating($id_rated, $id_rater, $rate, $title, $message, 0);
}

function addRatingHousing($id_rated, $id_rater, $rate, $title, $message){
        addRating($id_rated, $id_rater, $rate, $title, $message, 1);
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
        WHERE id_housing = 120 GROUP BY nb_for_housing";
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

        $sql = "INSERT INTO `activity` (`id_owner`, `type`, `latitude`, `longitude`, `country`, `name`, `description`) VALUES ($id_user,$idtype, $lat, $long, '$pays', '$nom', '$desc')";

        mysqli_query($base, $sql);
        var_dump(mysqli_error($base));
        var_dump($sql);

        $id_activity = mysqli_insert_id($base);

        $folder = "./picture_activity/".strval($id_user)."/".strval($id_activity);

        $sql = "UPDATE `activity` SET `image_folder` = '$folder' WHERE `id_activity` = '$id_activity'";

        mysqli_query($base, $sql);

        return $id_activity;
}

function getActivityByIdOwner($id){
        global $base;

        $activity = [];

        $sql = "SELECT id_activity, type, latitude, longitude, country, name, description, image_folder
                FROM activity
                WHERE id_owner = $id";
        $result = mysqli_query($base, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $activity[] = $row;
        }

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

        $sql = "UPDATE activity SET name='$name', latitude=$latitude, longitude=$longitude, country='$pays', type=$type, description='$description' WHERE id_activity=$id";

        $update_housing = $base->query($sql);

        if ($update_housing){
                unset($_SESSION["errors_update_activity"]);
        } else {
                $errors[] = "Erreur au moment de l'ajout dans la base de donnée";
                $_SESSION["errors_update_housing"] = $errors;
        }
}


?>