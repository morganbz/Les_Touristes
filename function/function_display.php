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
                echo "<p>Du ".getNiceDate($info["date_start"])." au ".getNiceDate($info["date_end"])."</p>";
                echo "<p>Nombre de jour ".$info["nb_day"]."</p>";
                echo "<p>Prix à la nuit ".$info["price_by_night"]."</p>";
                echo "<p>Prix total ".$info["nb_day"] * $info["price_by_night"]."</p>";
                echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='id_housing' id='id_housing' value=".$id_housing." required>";
                    echo "<input type='hidden' name='date_start' id='date_start' value=".$info["date_start"]." required>";
                    echo "<input type='hidden' name='date_end' id='date_end' value=".$info["date_end"]." required>";
                    echo "<input type='hidden' name='id_user' id='id_user' value=".$info["id_user"]." required>";
                    echo "<button class='btn btn-outline-primary' id='submit' class='btn-secondary' name='submit' value='Validate_reservation' type='submit'>Valider la demande de reservation</button>";
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
            echo "du ". getNiceDate($announce["date_start"]) . " au " . getNiceDate($announce["date_end"]);
            echo "<br>";
        }
        ?>
        </p>

        <div class="d-flex justify-content-around">

            <form action="index.php" method="post" id="form_display_housing_account">
            
                <input  type='hidden' name='id_housing' id='id_housing' value ="<?php echo $id ?>">
            
                <button class="btn btn-outline-primary " id="submit1" name="submit" value="AskUpdateHousingInfos" type="submit">Modifier le logement </button>

                <button class="btn btn-outline-primary " id="submit2" name="submit" value="AskUpdateHousingDates" type="submit">Modifier les periodes de disponibilités</button>

                <button class="btn btn-outline-primary " id="submit2" name="submit" value="ViewHousingHistory" type="submit">Voir les anciènnes réservations</button>
            </form>

        </div>

        <?php

    echo "</li>";


}

function displayHousingHistory($id, $isForUser){
    global $ORDER_FOR_USER;
    global $ORDER_FOR_OWNER;

    if ($isForUser){
        $ORDER = $ORDER_FOR_USER;
        if (isset($_GET["order"])){
            $housing_history = getHousingHistoryByIdOwner($id, $_GET["order"]);
        } else {
            $housing_history = getHousingHistoryByIdOwner($id);
        } 
    } else {
        $ORDER = $ORDER_FOR_OWNER;
        if (isset($_GET["order"])){
            $housing_history = getHousingHistoryByIdHousing($id, $_GET["order"]);
        } else {
            $housing_history = getHousingHistoryByIdHousing($id);
        }
    }

    if (count($housing_history) == 0){
        echo "<p> Pas d'anciennes réservations </p>";
    } else {
        ?>
        <label for="order">Trier par :</label>
        <select name = 'order' id="order" onchange="window.location.href = (!(window.location.href.includes('&order='))) ? window.location.href.concat(this.value) : (window.location.href).substr(0, (window.location.href).indexOf('&order=')).concat(this.value)">
        <?php
        foreach($ORDER as $order){
            if (isset($_GET["order"])){
                if ($order["value"] == $_GET["order"]){
                    ?><option value = '&order=<?php echo $order['value']; ?>' selected><?php echo $order['nom']; ?></option><?php
                } else {
                    ?><option value = '&order=<?php echo $order['value']; ?>'><?php echo $order['nom']; ?></option><?php
                }
            } else {
                ?><option value = '&order=<?php echo $order['value']; ?>'><?php echo $order['nom']; ?></option><?php
            }
            
        }
        $cpt = 1;
        ?>
        </select>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Début du séjour</th>
                    <th scope="col">Fin du séjour</th>
                    <th scope="col">Logement</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($housing_history as $housing){
                    $id = $housing["id"];
                    ?>
                    <tr>
                        <th scope="row"><?php echo $cpt; ?></th>
                        <td><?php echo getNiceDate($housing["begin_date"]); ?></td>
                        <td><?php echo getNiceDate($housing["end_date"]); ?></td>
                        <?php
                        if ($isForUser){
                            ?><td><a href="?page=housing&h=<?php echo $id; ?>"><?php echo $housing["nom"]; ?></a></td><?php
                        } else {
                            ?><td><a href="?page=user&u=<?php echo $housing["id_user"]; ?>"><?php echo getUserById($housing["id_user"])["firstname"]." ".getUserById($housing["id_user"])["lastname"]; ?></a></td><?php
                        }
                        ?>
                    </tr>
                <?php
                $cpt++;
                }
                ?>
                </tbody>
            </table>
    </div>
    <?php
    }
}

function ModifHousing($housing){
    global $TYPE_HOUSING;

}

function displayHousing($id){
    global $TYPE_HOUSING;
    
    $infos = getHousingById($id);
    if ($infos == null) {
        include_once "./page_404.php";
    } else {

        $adresse = getAddress($infos["latitude"], $infos["longitude"]);

        ?>
        <div>
            <h2><?php echo $infos["nom"];?></h2>
            <p><?php echo getNbRecommandationHousing ($id); displayHeart($id, 1);?></p>
            <p>Type d'hébergement : <?php echo $TYPE_HOUSING[$infos["type"]];?></p>
            <p>Adresse : <?php echo $adresse;?></p>
            <p>Pays : <?php echo getCountryFromCoords($infos["latitude"], $infos["longitude"]);?></p>
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
}

function displayActivity($id){
    global $TYPE_ACTIVITY;

    $infos = getActivityById($id);
    if ($infos == null) {
        include_once "./page_404.php";
    } else {
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
            <p><?php echo getNbRecommandationActivity ($id); displayHeart($id, 2);?></p>
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
}

function displayUser($id){
    $infos = getUserById($id);
    if ($infos == null) {
        include_once "./page_404.php";
    } else {
        $firstname = $infos["firstname"];
        $lastname = $infos["lastname"];
        $birth_date = $infos["birth_date"];
        $phone = $infos["phone"];
        $mail = $infos["mail"];
        $description = $infos["description"];

        $today = date("Y-m-d");
        $diff = date_diff(date_create($birth_date), date_create($today));
        $age = $diff->format('%y');

        $nb_housing = count(getHousingByIdOwner($id));
        $nb_activity = count(getActivityByIdOwner($id));
        $nb_housing_history = count(getHousingHistoryByIdOwner($id));
        $nb_rates = getNbEvaluationUserByID($id);
        $nb_recommandation = getNbRecommandationUser($id);

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
        <section class="section about-section gray-bg" id="about">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-lg-6">
                            <div class="about-text go-to">
                                <h3 class="dark-color"><?php echo $firstname . " " . $lastname;?></h3>
                                <label class=""><?php echo $nb_recommandation; displayHeart($id, 3);?></label>
                                <h6 class="theme-color lead">À propos :</h6>
                                <p><?php echo nl2br($description);?></p>
                                <div class="row about-list">
                                    <div class="col-md-6">
                                        <div class="media">
                                            <label>Date de naissance</label>
                                            <p><?php echo getNiceDate($birth_date);?></p>
                                        </div>
                                        <div class="media">
                                            <label>Âge</label>
                                            <p><?php echo $age;?> ans</p>
                                        </div>                       
                                    </div>
                                    <div class="col-md-6">
                                        <div class="media">
                                            <label>E-mail</label>
                                            <p><?php echo $mail;?></p>
                                        </div>
                                        <div class="media">
                                            <label>Téléphone</label>
                                            <p><?php echo $phone;?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-avatar">
                                <img src="<?php echo $profile_picture;?>" alt="Photo de profil">
                            </div>
                        </div>
                    </div>
                    <div class="counter">
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="<?php echo $nb_activity;?>" data-speed="<?php echo $nb_activity;?>"><?php echo $nb_activity;?></h6>
                                    <p class="m-0px font-w-600">Recommandations d'activités</p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="<?php echo $nb_housing;?>" data-speed="<?php echo $nb_housing;?>"><?php echo $nb_housing;?></h6>
                                    <p class="m-0px font-w-600">Propositions d'hébergements</p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="<?php echo $nb_housing_history;?>" data-speed="<?php echo $nb_housing_history;?>"><?php echo $nb_housing_history;?></h6>
                                    <p class="m-0px font-w-600">Hébergements visités</p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="count-data text-center">
                                    <h6 class="count h2" data-to="<?php echo $nb_rates;?>" data-speed="<?php echo $nb_rates;?>"><?php echo $nb_rates;?></h6>
                                    <p class="m-0px font-w-600">Evaluations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2>Coups de coeurs</h2>
                        <?php displayCoupsDeCoeurs($id); ?>
                    </div>
                    <div>
                        <h2>Badges</h2>
                        <?php displayBadges($id); ?>
                    </div>
                    
                    <?php

                    if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] != $id && !isAlreadyRated($id, $_SESSION["id_user"], 3)){
                        displayFormRateAndComment($id, 3);
                    } 

                    if ($nb_rates != 0){
                        ?><div>
                        <h2>Evaluations</h2>
                        </div>
                        <h3>Moyenne des notes : <?php echo getAverage($id, 3); ?>/5</h3><?php
                        displayRate($id, 3);
                    }
                    ?>         
                </div>
            </section>
    <?php
    }
}

function displayFormRateAndComment($id, $type_rated){
?>
    <form action="index.php" method="post">
        <div class="rating"> 
            <input type="radio" name="rate" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rate" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rate" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rate" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rate" value="1" id="1"><label for="1">☆</label>
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
       
        <button class="w-30 btn btn-outline-primary btn-lg px-4 me-sm-3" id="submit" name="submit" value="submit_rate_and_comment" type="submit">Envoyer</button>
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

function displayCoupsDeCoeurs($id){
    $coups_de_coeurs = getRecommandationOfUser ($id);

    if (count($coups_de_coeurs) == 0 ){
        ?><p>Pas de coups de coeurs</p><?php
    } else {
        foreach($coups_de_coeurs as $cDc){
            ?>
            <a href="<?php echo $cDc["url"];?>"><?php echo $cDc["nom"];?></a>
            <?php
        }
    } 
}

function displayBadges($id){
    $badges = getBadgesUser($id);
    
    if (count($badges) == 0 ){
        ?><p>Pas de badges</p><?php
    } else {
        foreach($badges as $b){
            ?>
            <p><?php echo $b["nom"]." niveau : ".$b["niveau"];?></p>
            
            <?php
        }
    }
}


function displayHeart($id, $type){
    ?>
    <NOBR class="heartbox">
        <input type="checkbox" class="checkbox" id="checkbox" name="like_checkbox" onchange="
        <?php 
        if (isset($_SESSION["id_user"])){
        ?>
        jQuery.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {
                action: 'addLike',
                infos: {
                    id: <?php echo $id;?>,
                    type: <?php echo $type;?>
                }
            }
        });
        <?php
        } else {
            ?>
            alert('Vous devez être connecté pour ajouter un like')
            <?php
        }?>
        "
        <?php
        if (isset($_SESSION["id_user"])){
            if (alreadyRecommanded($_SESSION["id_user"], $id, $type)){
                echo "checked";
            }
        }
        ?>
        />
        <label for="checkbox">
            <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
            <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#AAB8C2"/>
                <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                <g id="heartgroup7" opacity="0" transform="translate(7 6)">
                <circle id="heart1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                <circle id="heart2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                </g>

                <g id="heartgroup6" opacity="0" transform="translate(0 28)">
                <circle id="heart1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                <circle id="heart2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                </g>

                <g id="heartgroup3" opacity="0" transform="translate(52 28)">
                <circle id="heart2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                <circle id="heart1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                </g>

                <g id="heartgroup2" opacity="0" transform="translate(44 6)">
                <circle id="heart2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                <circle id="heart1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                </g>

                <g id="heartgroup5" opacity="0" transform="translate(14 50)">
                <circle id="heart1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                <circle id="heart2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                </g>

                <g id="heartgroup4" opacity="0" transform="translate(35 50)">
                <circle id="heart1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                <circle id="heart2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                </g>

                <g id="heartgroup1" opacity="0" transform="translate(24)">
                <circle id="heart1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                <circle id="heart2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                </g>
            </g>
            </svg>
        </label>
    </NOBR>
<?php
}

?>
