<?php


function displaySearch($array_housing){
    $TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");
    echo "<section>";
        foreach($array_housing as $housing){
            echo "<article>";
            echo "<div>";
            echo "type de logement : " . $TYPE_HOUSING[intval($housing["type"])];
            echo "</div>";

            echo "</article>";
        }
    echo "</section>";
}


?>
