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
    $addressTo = getAddress($lat, $lng);
    $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$addressFrom&destinations=$addressTo&key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&language=en-EN&sensor=false");
    $data = json_decode($data);
    $distance = 0;
    foreach($data->rows[0]->elements as $road) {
        $distance += $road->distance->value;
    }
    return $distance;
}



?>