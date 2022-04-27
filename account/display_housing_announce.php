<?php


$listeHousing  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeHousing as $housing){
    $nom = $housing['nom'];
    $latitude = $housing['latitude'];
    $longitude = $housing['longitude'];
    $description = $housing['description'];
    $type = $housing['type'];

    $adresse = getAddress($latitude, $longitude);

    $id = $housing['id'];

    displayHousingAccount($housing);


?>



