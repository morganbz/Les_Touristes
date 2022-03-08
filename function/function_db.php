<?php

// ----------------------------------------------------- ADD  ----------------------------------------

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

        $date = mysqli_real_escape_string($base, $date_start);

        $sql = "INSERT INTO announce(price, date_start, isTaken, id_housing)
                VALUES ($price, '$date', 0, $id_housing)";

        mysqli_query($base, $sql);
}

function addHousingAndAnnounce($id_owner, $type, $latitude, $longitude, $name, $description, $price, $date_start, $date_end){
        global $base;

        $sql = "INSERT INTO housing (id_owner, type, latitude, longitude, nom, description) 
                VALUES ($id_owner, $type, $latitude, $longitude, '$name', '$description');";

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

        $dossier =  "./picture_housing/".strval($id_owner)."/".strval($id_housing);

        $sql = "UPDATE housing SET image_folder = '$dossier' WHERE id = $id_housing";

        mysqli_query($base, $sql);

        return $id_housing;
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

                $insert_user = $base->query($sql);   

                if ($insert_user){
                        unset($_SESSION["errors_register"]);
                        $sql = "SELECT id FROM user WHERE mail = '$mail'";
                        $result = mysqli_query ($base, $sql);
                        $id = mysqli_fetch_assoc($result);
                        $_SESSION["id_user"] = $id;
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

function getIdByInfos($id_owner, $type, $name, $latitude, $longitude){
        global $base;

        $sql = "SELECT id FROM housing WHERE id_owner = 8 AND type = 0 AND nom = 'z' AND latitude = 12 AND longitude = 12";

        $result = mysqli_query($base, $sql);

        $id = mysqli_fetch_array($result);

        return $id["id"];
        
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

function bookAnnounce($id_announce, $id_customer){
        global $base;
        $sql = "UPDATE `announce` SET `isTaken`=1 WHERE id = $id_announce";
        echo $sql;
        mysqli_query($base, $sql);

        $sql = "INSERT INTO `reservation`(`id_user`, `id_announce`) VALUES ($id_customer,$id_announce)";
        echo $sql;
        mysqli_query($base, $sql);
}

function bookHousingPeriod($id_housing, $id_customer, $date_start, $date_end){

        global $base;

        $dateDifference = abs(strtotime($date_end) - strtotime($date_start));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $sql = "SELECT * FROM housing INNER JOIN announce ON housing.id = announce.id_housing
        WHERE housing.id = $id_housing AND date_start >=  '$date_start' AND date_start <= '$date_end'";
        
        $announce = mysqli_query($base, $sql);

        $currDate = $date_start;

        while($row = mysqli_fetch_array($announce)){
                var_dump($row);
                bookAnnounce($row['id'], $id_customer);
                $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
        }

}
?>