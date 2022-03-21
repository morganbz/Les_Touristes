<?php


/*function displaySearch($array_housing){
    $TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");

    echo "<section>";
        if(count($array_housing) == 0){
            echo "Aucun Logement ne correspond à votre recherche.";
        }
        else{
            echo "il y a ".count($array_housing) ." logements correspondant à votre recherche :";
            foreach($array_housing as $housing){
                echo "<article>";

                echo "<div>";
                echo "Nom : " . $housing["nom"];
                echo "</div>";

                echo "<div>";
                echo "prix par nuit : " . $housing["price"];
                echo "</div>";

                echo "<div>";
                echo "adresse : " . getAddress($housing["latitude"], $housing["longitude"]);
                echo "</div>";

                echo "<div>";
                echo "type de logement : " . $TYPE_HOUSING[intval($housing["type"])];
                echo "</div>";

                echo "</article>";
                echo "<br>";
            }
        }
    echo "</section>";
}*/

/*function displayHousingForBooking($id_housing){

    $housing = getHousingById($id_housing);
    $announces = getAnnounceByIdHousing($id_housing);



}*/

function displayAskReservation($data){
    $id_housing = -1;
    echo "<section class='asking_section'>";
        for($index = 0; $index < count($data); $index++){
            $info = $data[$index];
            if($id_housing != $info["id_housing"]){
                if ($id_housing != -1){
                    echo "</div>";
                }
                echo "<div class='ask_info'>";
                echo "<p>".$info["nom"]."</p>";
                $id_housing = $info["id_housing"];
            }
            $user = getUserById($info["id_user"]);
            echo "<p>Client ".$user["firstname"]." ".$user["lastname"]."</p>";
            echo "<p>Du ".$info["date_start"]." au ".$info["date_end"]."</p>";
            echo "<p>Nombre de jour ".$info["nb_day"]."</p>";
            echo "<p>Prix à la nuit ".$info["price_by_night"]."</p>";
            echo "<p>Prix total ".$info["nb_day"] * $info["price_by_night"]."</p>";

        }
        echo "</div>";
    echo "</section>";
}


?>
