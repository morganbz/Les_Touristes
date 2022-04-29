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

function getCoords($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    $res = [];
    $res["latitude"] = $lat;
    $res["longitude"] = $long;
    return $res;

}

function getCountry($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
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

function getNumber($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
    $cpt = 0;
    $trouve = false;
    $res = "not_found";

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

function getRoute($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
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

function getRouteAndNumber($address){
    return getNumber($address)." ".getRoute($address);
}

function getPostalCode($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
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

function getCity($address){
    $address = str_replace(" ", "", $address);
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&sensor=false");
    $json = json_decode($json);
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
        $average["average"] = get_average($id_housing, 1);

        $averages[] = $average;
    }

    $ids_activity = getAllActivityID();

    foreach ($ids_activity as $id_activity){
        $average["id"] = $id_activity;
        $average["is_housing"] = false;
        $average["average"] = get_average($id_activity, 0);

        $averages[] = $average;
    }

    $average_not_sort = array();

    foreach($averages as $key => $row){
        $average_not_sort[$key] = $row["average"];
        
    }
    array_multisort($average_not_sort, SORT_DESC, $averages);

    $FiveBest = array();

    for($i=0; $i<5; $i++){
        $FiveBest[] = $averages[$i];
    }

    return $FiveBest;
}

?>