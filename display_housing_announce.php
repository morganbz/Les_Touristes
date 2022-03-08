<?php

echo "voir annonces";



//ébauche de fct
echo "<ul>";

$announces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($announce as $announces){
    echo "<li>" + $announce["nom"] + "</li>";
}

echo "</ul>";
?>