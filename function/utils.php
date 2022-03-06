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

function getaddress($lat,$lng){
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
    $json = @file_get_contents($url);
    $data=json_decode($json);
    $status = $data->status;
    if($status=="OK"){
        return $data->results[0]->formatted_address;
    }
    else{
        return false;
    }
}

function Get_Address_From_Google_Maps($lat, $lon) {

    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";
    
    // Make the HTTP request
    $data = @file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);
    
    // If the json data is invalid, return empty array
    if (!check_status($jsondata))   return array();
    
    $address = array(
        'country' => google_getCountry($jsondata),
        'province' => google_getProvince($jsondata),
        'city' => google_getCity($jsondata),
        'street' => google_getStreet($jsondata),
        'postal_code' => google_getPostalCode($jsondata),
        'country_code' => google_getCountryCode($jsondata),
        'formatted_address' => google_getAddress($jsondata),
    );
    
    return $address;
    }
 
    
/* 
* Check if the json data from Google Geo is valid 
*/

function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

/*
* Given Google Geocode json, return the value in the specified element of the array
*/

function google_getCountry($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata) {
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata) {
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata) {
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata) {
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

/*
* Searching in Google Geo json, return the long name given the type. 
* (If short_name is true, return short name)
*/

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach( $array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)    
                return $value["short_name"];
            return $value["long_name"];
        }
    }
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
    return $date < date("Y-m-d", strtotime(time()));
}

function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

function verif_password($password, $hash){
    return password_verify($password, $hash);
}

?>