<?php

include_once "db.php";

include_once "function_db.php";

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST')
{
    $response_code = HTTP_BAD_REQUEST;
    $message = "Il manque le paramètre ACTION";
    $city = null;

    if ($_POST['action'] == "getLocation" && isset($_POST['city']))
    {
        $response_code = HTTP_OK;
        $city = $_POST['city'];
        $message = "OK";
        $data = getData($city);
    }

    response($response_code, $message, $city, $data);
}
else
{
    $response_code = HTTP_METHOD_NOT_ALLOWED;
    $message = "Method not allowed!";

    response($response_code, $message);
}

function response($response_code, $message, $city = null, $data = null)
{
    header('Content-Type: application/json');
    http_response_code($response_code);

    $response = [
        "response_code" => $response_code,
        "message" => $message,
        "city" => $city,
        "data" => $data
    ];
    
    echo json_encode($response);
}

?>