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
                echo "<div class='ask_info_housing'>";
                echo "<p>".$info["nom"]."</p>";
                $id_housing = $info["id_housing"];
                echo "<a href='?page=ask_reservation&id_housing=".$id_housing."' class='btn btn-secondary' role='button'>Annonce</a>";
            }
            $user = getUserById($info["id_user"]);
            echo "<div class='ask_info'>";
                echo "<p>Client ".$user["firstname"]." ".$user["lastname"]."</p>";
                echo "<p>Du ".$info["date_start"]." au ".$info["date_end"]."</p>";
                echo "<p>Nombre de jour ".$info["nb_day"]."</p>";
                echo "<p>Prix à la nuit ".$info["price_by_night"]."</p>";
                echo "<p>Prix total ".$info["nb_day"] * $info["price_by_night"]."</p>";
                echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='id_housing' id='id_housing' value=".$id_housing." required>";
                    echo "<input type='hidden' name='date_start' id='date_start' value=".$info["date_start"]." required>";
                    echo "<input type='hidden' name='date_end' id='date_end' value=".$info["date_end"]." required>";
                    echo "<input type='hidden' name='id_user' id='id_user' value=".$info["id_user"]." required>";
                    echo "<button id='submit' class='btn-secondary' name='submit' value='Validate_reservation' type='submit'>Valider la demande de reservation</button>";
                echo "</form>";
            echo "</div>";
        }
        echo "</div>";
    echo "</section>";
}


function displayHousingAccount($housing){

    global $TYPE_HOUSING;

    $nom = $housing['nom'];
    $latitude = $housing['latitude'];
    $longitude = $housing['longitude'];
    $description = $housing['description'];
    $type = $housing['type'];
    $adresse = getAddress($latitude, $longitude);
    $id = $housing['id'];

    $log_directory = $housing["image_folder"];

    $images = [];

    foreach(glob($log_directory.'/*.*') as $file) {
        $images[] = $file;
    }

    $announces = getAllAnnounceOrderByDistinct($id);

    echo "<div class='data_search'>";

    echo "<p>Nom : " .$nom. "</p><p>Type de logement : " .$TYPE_HOUSING[$type]. "</p><p>Adresse : " .$adresse. "</p><p>Description : ".$description. "</p>";

    echo "<p>Periode de disponibilitées : ";

    foreach ($announces as $announce){
        echo "du ". $announce["date_start"] . " au " . $announce["date_end"];
        echo "<br>";
    }

    echo "</p>";
    ?>

    <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <?php
    if($nb_images != 0){
        echo '<ol class="carousel-indicators">';
        for($index = 0; $index < $nb_images; $index++){
            if ($index == 0) {
                echo '<li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>';
            }
            else {
                echo '<li data-bs-target="#myCarousel" data-bs-slide-to="'.$index.'"></li>';
            }
        }
            echo '</ol>';
    }
    ?>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            if ($nb_images == 0) {
                # code...
            }
            else {
                echo '<div class="overlay-image" style="background-image:url('.$images[0].');"></div>';
            }
            ?>
            <div class="container">
                
            </div>
        </div>
        <?php
        for ($index = 1; $index < $nb_images; $index++) { 
            echo '<div class="carousel-item">';
            echo '<div class="overlay-image" style="background-image:url('.$images[$index].');"></div>';
                echo '<div class="container">';
            
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <a href="#myCarousel" class="carousel-control-prev" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a href="#myCarousel" class="carousel-control-next" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>
<?

    echo "</div>";


}

?>
