<?php

function createFolder($folder){
    mkdir("test", 0777);
}

function getData($ville){
    global $base;

    $res = [];

    $sql = "SELECT id, departement, ville, adresse, latitude, longitude, nom, description FROM test_search WHERE ville = $ville";
    
    $result = mysqli_query($base, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $res[] = $row;
    }

    return $res;
}

?>