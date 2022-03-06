<?php

function displaySearch($array_housing){
    echo "<section>";
        foreach($array_housing as $housing){
            echo "<article>";
            echo Get_Address_From_Google_Maps(45.56734848022461, 5.915475368499756);

            echo "</article>";
        }
    echo "</section>";
}
?>
