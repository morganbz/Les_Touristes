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
    return $date < date("Y-m-d", strtotime(time()));
}

function hash_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

function verif_password($password, $hash){
    return password_verify($password, $hash);
}

?>