<?php

echo "voir annonces";



//ébauche de fct
echo "<ul>";

$listeAnnounces  = getHousingByIdOwner($_SESSION["id_user"]);

foreach ($listeAnnounces as $announce){
    $nom = $announce['nom'];
    echo "<li>$nom</li>";
}

echo "</ul>";
?>