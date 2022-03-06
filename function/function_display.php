<?php


function displaySearch($array_housing){
    $TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");
    echo "<section>";
        foreach($array_housing as $housing){
            echo "<article>";
            echo $TYPE_HOUSING[intval($housing["type"])];

            echo "</article>";
        }
    echo "</section>";
}
?>
