<?php

function displaySearch($array_housing){
    echo "<section>";
        foreach($array_housing as $housing){
            echo "<article>";
            echo getaddress(45.56734848022461, 5.915475368499756);

            echo "</article>";
        }
    echo "</section>";
}
?>
