<?php

function isTextGoodLength($text, $max_length){
    if(is_string($text)){
        $good_length = strlen($text) > 0 && strlen($text) <= $max_length;
    }
    else{
        $good_length = false;
    }
    return $good_length;
}

function isTextBetweenLength($text, $minLength, $maxLength){
    if(is_string($text)) {
        $good_length = strlen($text) >= $minLength && strlen($text) <= $maxLength;   
    }
    else {
        $good_length = false;   
    }
    return $good_length;
}

function clean($string) {
    $string = str_replace(' ', '', $string);
    $string = str_replace("'", '', $string);
    $accents = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $simple = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
 
    $string = str_replace($accents, $simple, $string); 

    return preg_replace('/[^A-Za-z0-9]-/', '', $string);
}

function isGoodDateBeforeToday($date){
    date_default_timezone_set('Europe/Paris');
    return $date < date("Y-m-d");
}

function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

function verif_password($password, $hash){
    return password_verify($password, $hash);
}

function getAddress($latitude, $longitude)
{
        $url = "https://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=AIzaSyAMo3P3AMsyG2sPjxzc6Vzs5ekRGoUEUk4";
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $address = $json->results[0]->formatted_address;
        return $address;
}

function getURL(){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $url = "https";
    }
    else{
        $url = "http"; 
    }  
    $url .= "://"; 
    $url .= $_SERVER['HTTP_HOST']; 
    $url .= $_SERVER['REQUEST_URI']; 
    return $url;
}

function getDistance($addressFrom, $lat, $lng){
    $addressTo = urlencode(getAddress($lat, $lng));
    $addressFrom = urlencode($addressFrom);
    $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$addressFrom&destinations=$addressTo&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&language=en-EN&sensor=false");
    $data = json_decode($data);
    $distance = 0;
    foreach($data->rows[0]->elements as $road) {
        $distance += $road->distance->value;
    }
    return $distance;
}

function getJSONFromAdress($address){
    $address = clean($address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
    if (count($json->{'results'}) == 0){
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
        $json = json_decode($json);
    }
    return $json;
}

function getJSONFromCoords($latitude, $longitude){
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=AIzaSyAMo3P3AMsyG2sPjxzc6Vzs5ekRGoUEUk4");
    return json_decode($json);
}

function getCoords($address){
    $json = getJSONFromAdress($address);

    $res = array();

    if (count($json->{'results'}) != 0){
        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $res = [];
        $res["latitude"] = $lat;
        $res["longitude"] = $long;
    } else {
        $_SESSION["error_requete_google"] = "Erreur dans la fonction getCoords.";
    }
    return $res;
}

function getCountryFromCoords($latitude, $longitude){
    $json = getJSONFromCoords($latitude, $longitude);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "country"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }
    return $res;
}

function getCountryFromAddress($address){
    $json = getJSONFromAdress($address);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "country"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }
    return $res;
}

function getNumber($latitude, $longitude){
    $json = getJSONFromCoords($latitude, $longitude);
    $cpt = 0;
    $trouve = false;
    $res = "";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "street_number"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }

    return $res;
}

function getRoute($latitude, $longitude){
    $json = getJSONFromCoords($latitude, $longitude);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "route"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }

    return $res;
}

function getRouteAndNumber($latitude, $longitude){
    return getNumber($latitude, $longitude)." ".getRoute($latitude, $longitude);
}

function getPostalCode($latitude, $longitude){
    $json = getJSONFromCoords($latitude, $longitude);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "postal_code"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }

    return $res;
}

function getCity($latitude, $longitude){
    $json = getJSONFromCoords($latitude, $longitude);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

    $add_comp = $json->{'results'}[0]->{'address_components'};

    while($cpt < count($add_comp) && !$trouve){
        if($add_comp[$cpt]->{'types'}[0] == "locality"){
            $trouve = true;
            $res = $add_comp[$cpt]->{'long_name'};
        }
        $cpt++;
    }

    return $res;
}


function getFiveBestAnnounces(){
    $ids_housing = getAllHousingID();

    $averages = Array();
    
    foreach ($ids_housing as $id_housing){
        $average["id"] = $id_housing;
        $average["is_housing"] = true;
        $average["average"] = getAverage($id_housing, 1);

        $averages[] = $average;
    }

    $ids_activity = getAllActivityID();

    foreach ($ids_activity as $id_activity){
        $average["id"] = $id_activity;
        $average["is_housing"] = false;
        $average["average"] = getAverage($id_activity, 0);

        $averages[] = $average;
    }

    $average_not_sort = array();

    foreach($averages as $key => $row){
        $average_not_sort[$key] = $row["average"];
        
    }
    array_multisort($average_not_sort, SORT_DESC, $averages);

    $FiveBest = array();

    for($i=0; $i<=5; $i++){
        $FiveBest[] = $averages[$i];
    }

    return $FiveBest;
}

function getNiceDate($date){
    global $MOIS;
    global $DAY_WEEK;

    $day_week = strftime("%w", strtotime($date));
    $day = strftime("%d", strtotime($date));
    $month = strftime("%m", strtotime($date));
    $year = strftime("%Y", strtotime($date));

    $nice_date = $DAY_WEEK[$day_week]." ".$day." ".$MOIS[$month -1]." ".$year;
    return $nice_date;
}

function getNbDay($date_start, $date_end){

    $currDate = $date_start;
    $nb_day = 0;

    while($currDate <= $date_end ){
            $nb_day++;
            $currDate = date("Y-m-d", strtotime($currDate.'+ 1 days'));
    }

    return $nb_day;

}


function sendMailOwner($id_housing, $id_customer, $date_start, $date_end){
    $mail_subject = 'Demande de réservation';
    $mail_body = '';
    $mail_receiver = '';
    send_mail($mail_subject, $mail_body, $mail_receiver);
}

function sendMailAccepted($id_housing, $id_customer, $date_start, $date_end){
    $mail_subject = 'Demande de réservation acceptée';
    $mail_body = '';
    $mail_receiver = '';
    send_mail($mail_subject, $mail_body, $mail_receiver);
}

function sendMailRefused($id_housing, $id_customer, $date_start, $date_end){
    $mail_subject = 'Demande de réservation refusée';
    $mail_body = '';
    $mail_receiver = '';
    send_mail($mail_subject, $mail_body, $mail_receiver);
}

?>