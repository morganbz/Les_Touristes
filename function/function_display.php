<?php

function displaySearch($array_housing){
    echo "<section>";
        foreach($array_housing as $housing){
            echo "<article>";
            $TYPE_HOUSING[intval($housing["type"])];

            echo "</article>";
        }
    echo "</section>";
}
?>
