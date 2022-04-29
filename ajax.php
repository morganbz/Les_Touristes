<?php

include_once "db.php";

include_once "function/utils.php";

include_once "function/function_db.php";

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST')
{
    $response_code = HTTP_BAD_REQUEST;
    $message = "Il manque le paramètre ACTION";
    
    $price_min = null;
    $price_max = null;
    $arrive = null;
    $departure = null;
    $destination = null;
    $distance = null;
    $data = null;
    $date = null;
    
    if ($_POST['action'] == "getLocation" && isset($_POST['destination']))
    {
        $response_code = HTTP_OK;
        $destination = $_POST['destination'];
        if(isset($_POST['arrive'])){
            $arrive = $_POST['arrive'];
        }
        if(isset($_POST['departure'])){
            $departure = $_POST['departure'];
        }
        if(isset($_POST['price_min'])){
            $price_min = $_POST['price_min'];
            if($_POST['price_min'] == ''){
                $price_min = 0;
            }
        }
        if(isset($_POST['price_max'])){
            $price_max = $_POST['price_max'];
            if($_POST['price_max'] == ''){
                $price_max = 999999999;
            }
        }
        if(isset($_POST['distance'])){
            $distance = $_POST['distance'];
            if($_POST['distance'] == ''){
                $distance = 20;
            }
        }
        $message = "OK";
        $data = searchAnnounce($price_min, $price_max, $arrive, $departure, $destination, $distance);
    }

    elseif ($_POST['action'] == "getLocationActivity" && isset($_POST['destination'])) 
    {
        $response_code = HTTP_OK;
        $destination = $_POST['destination'];
        if(isset($_POST['arrive'])){
            $arrive = $_POST['arrive'];
        }
        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
        if(isset($_POST['distance'])){
            $distance = $_POST['distance'];
            if($_POST['distance'] == ''){
                $distance = 20;
            }
        }
        $message = "OK";
        $data = searchAnnounce($price_min, $price_max, $arrive, $departure, $destination, $distance, $date);
    }

    response($response_code, $message, $destination, $arrive, $departure, $price_min, $price_max, $distance, $data, $date);
}
else
{
    $response_code = HTTP_METHOD_NOT_ALLOWED;
    $message = "Method not allowed!";

    response($response_code, $message);
}

function response($response_code, $message, $destination = null, $arrive = null, $departure = null, $price_min = null, $price_max = null, $distance = null, $data = null, $date = null)
{
    header('Content-Type: application/json');
    http_response_code($response_code);

    $response = [
        "response_code" => $response_code,
        "message" => $message,
        "destination" => $destination,
        "arrive" => $arrive,
        "departure" => $departure,
        "price_min" => $price_min,
        "price_max" => $price_max,
        "distance" => $distance,
        "data" => $data,
        "date" => $date
    ];
    
    echo json_encode($response);
}

?>