<?php

echo "voir annonces";



//ébauche de fct
echo "<ul>";

$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    //echo "<li>" + $announce["nom"] + "</li>";
    var_dump ($announce);
}

echo "</ul>";
?>