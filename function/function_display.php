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
    $nb_images = count($images);

    $announces = getAllAnnounceOrderByDistinct($id);

    echo "<li class='list-group-item'>";

        echo "<p>Nom : " .$nom. "</p><p>Type de logement : " .$TYPE_HOUSING[$type]. "</p><p>Adresse : " .$adresse. "</p><p>Description : ".$description. "</p>";

        echo "<p>Periode de disponibilités : ";

        foreach ($announces as $announce){
            echo "du ". $announce["date_start"] . " au " . $announce["date_end"];
            echo "<br>";
        }
        ?>

        <div class="d-flex justify-content-around">

            <form action="index.php" method="post" id="form1">
            <?php
                echo "<input  type='hidden' name='id_housing' id='id_housing' value =".$id." >";
            ?>
                <button class="btn btn-primary" id="submit1" name="submit" value="AskUpdateHousing" type="submit">Modifier le logement </button>
            </form>

            <form action="index.php" method="post" id="form2">
            <?php
                echo "<input  type='hidden' name='id_housing' id='id_housing' value =".$id." >";
            ?>
                <input type='hidden' name='for_announce' id='for_announce' value = 1>
                <button class="btn btn-primary" id="submit2" name="submit" value="AskUpdateHousing" type="submit">Modifier les periodes de disponibilités</button>
            </form>

        </div>

        <?php

        echo "</p>";

    echo "</ul>";


}

function ModifHousing($housing){
    global $TYPE_HOUSING;

}

function displayHousing($id){
    global $TYPE_HOUSING;
    
    $infos = getHousingById($id);

    $adresse = getAddress($infos["latitude"], $infos["longitude"]);

    ?>
     <div>
        <h2><?php echo $infos["nom"];?></h2>
        <p>Type d'hébergement : <?php echo $TYPE_HOUSING[$infos["type"]];?></p>
        <p>Adresse : <?php echo $adresse;?></p>
        <p>Pays : <?php echo getCountry($adresse);?></p>
        <p>Description : <?php echo $infos["description"];?></p>
    </div>

    <?php

    if (isset($_SESSION["id_user"]) && !isAlreadyRated($id, $_SESSION["id_user"], 3)){
        displayFormRateAndComment($id, 1);
    } 

    if (getNbNotes($id, 2) == 0){
        echo "<h3>Aucune évaluations</h3>";
    } else {
        echo "<h3>Moyenne des notes : ". getAverage($id, 1)."/5</h3>";
        displayRate($id, 1);
    }
}

function displayActivity($id){
    global $TYPE_ACTIVITY;

    $infos = getActivityById($id);
    /*
    <div>
        <div
        id="carouselVideoExample"
        class="carousel slide carousel-fade"
        data-mdb-ride="carousel"
        >
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button
            type="button"
            data-mdb-target="#carouselVideoExample"
            data-mdb-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
            ></button>
            <button
            type="button"
            data-mdb-target="#carouselVideoExample"
            data-mdb-slide-to="1"
            aria-label="Slide 2"
            ></button>
            <button
            type="button"
            data-mdb-target="#carouselVideoExample"
            data-mdb-slide-to="2"
            aria-label="Slide 3"
            ></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner">
            <!-- Single item -->
            <div class="carousel-item active">
            <video class="img-fluid" autoplay loop muted>
                <source src="https://mdbcdn.b-cdn.net/img/video/Tropical.mp4" type="video/mp4" />
            </video>
            <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>
                Nulla vitae elit libero, a pharetra augue mollis interdum.
                </p>
            </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
            <video class="img-fluid" autoplay loop muted>
                <source src="https://mdbcdn.b-cdn.net/img/video/forest.mp4" type="video/mp4" />
            </video>
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
            </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
            <video class="img-fluid" autoplay loop muted>
                <source
                src="https://mdbcdn.b-cdn.net/img/video/Agua-natural.mp4"
                type="video/mp4"
                />
            </video>
            <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>
                Praesent commodo cursus magna, vel scelerisque nisl consectetur.
                </p>
            </div>
            </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button
            class="carousel-control-prev"
            type="button"
            data-mdb-target="#carouselVideoExample"
            data-mdb-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-mdb-target="#carouselVideoExample"
            data-mdb-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>
    */
    ?>
    <div>
        <h2><?php echo $infos["nom"];?></h2>
        <p>Type d'activité : <?php echo $TYPE_ACTIVITY[$infos["type"]];?></p>
        <p>Adresse : <?php echo getAddress($infos["latitude"], $infos["longitude"]);?></p>
        <p>Pays : <?php echo $infos["country"];?></p>
        <p>Description : <?php echo $infos["description"];?></p>
    </div>

    <?php

    if (isset($_SESSION["id_user"]) && !isAlreadyRated($id, $_SESSION["id_user"], 2)){
        displayFormRateAndComment($id, 2);
    } 
    if (getNbNotes($id, 2) == 0){
        echo "<h3>Aucune évaluations</h3>";
    } else {
         echo "<h3>Moyenne des notes : ". getAverage($id, 2)."/5</h3>";
        echo "<h3>Anciens commentaires :</h3>";
        displayRate($id, 2);
    }
   
}

function displayUser($id){
    $infos = getUserById($id);
    $firstname = $infos["firstname"];
    $lastname = $infos["lastname"];
    $birth_date = $infos["birth_date"];
    $phone = $infos["phone"];
    $description = $infos["description"];

    $profile_picture = "./ressources/profile_picture.png";
    $profile_picture_folder = "picture_profile/".$id;
    if (isset($profile_picture_folder)){
        $files = scandir ($profile_picture_folder);
        foreach($files as $file){
            if ($file != "." && $file != ".."){
                $profile_picture = $profile_picture_folder."/".$file;
            }
        }
    }
    ?>
    <img src="<?php echo $profile_picture;?>" alt="Profile picture">
    <div>
        <h2><?php echo $firstname . " " . $lastname;?></h2>
        <p>Date de naissance : <?php echo $birth_date;?></p>
        <p>Numéro de téléphone : <?php echo $phone;?></p>
        <p>Description : <?php echo $description;?></p>
    </div>
    <div>
        <h2>Coups de coeurs</h2>
    </div>
    <div>
        <h2>Badges</h2>
    </div>
    <div>
        <h2>Evaluations</h2>
    </div>

    <?php

    if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] != $id && !isAlreadyRated($id, $_SESSION["id_user"], 3)){
        displayFormRateAndComment($id, 3);
    } 

    if (getNbNotes($id, 2) == 0){
        echo "<h3>Aucune évaluations</h3>";
    } else {
        echo "<h3>Moyenne des notes : ". getAverage($id, 3)."/5</h3>";
        displayRate($id, 3);
    }
}

function displayFormRateAndComment($id, $type_rated){
?>
    <form action="index.php" method="post">
        <div>
            <label for="rate">Note :</label>
            <NOBR>0</NOBR>   
            <input type="range" id="rate" name="rate" min="0" max="5" step="0.2" required>
            <NOBR>5</NOBR>   
        </div>

        <div>
            <label for="title">Titre : </label>
            <input placeholder="Titre" type="text" name="title" id="title">
        </div>

        <div>
            <label for="message">Message : </label>
            <input placeholder="Message" type="text" name="message" id="message">
        </div>

        <input value="<?php echo $id;?>" type="hidden" name="id_rated" id="id_rated">

        <input value="<?php echo $type_rated;?>" type="hidden" name="rated_is_housing" id="rated_is_housing">

        <button class="w-30 btn btn-primary btn-lg px-4 me-sm-3" id="submit" name="submit" value="submit_rate_and_comment" type="submit">Envoyer</button>
    </form>
<?php
}

function displayRate($id, $type_rated){
    $rates = getRates($id, $type_rated);

    foreach($rates as $rate) {
    ?>
    <div class="rate_and_comment"> 
        <h4><?php echo $rate["title"];?></h4>
        <p><?php echo $rate["rate"];?></p>
        <p><?php echo $rate["message"];?></p>
        <p> - <?php echo getUserById($rate["id_rater"])["firstname"]." ".getUserById($rate["id_rater"])["lastname"];?></p>
    </div>
    <?php
    }
}

?>
