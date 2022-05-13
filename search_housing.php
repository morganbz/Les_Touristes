<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <title>Document</title>
    </head>
    <body>
        <div id="page_content">
            <?php
            if(isset($_SESSION['id_user'])){
                ?>
                    <div id = "preference">
                            <label >Mes préférences :</label>
                            <?php

                $preferences = getPreferenceByIdUser($_SESSION['id_user']);


                if(!empty($preferences)){
                            foreach($preferences as $preference){
                                ?>

                                <button class="modal-button btn btn-primary"  href ="#myModal<?php echo $preference['id']; ?>" ><?php echo $preference['nom']; ?> </button>

                                <?php
                            }

                    foreach($preferences as $preference){
                        ?>

                        <div class="modal" id="myModal<?php echo $preference['id']; ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Choisir date</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <p> Destination : <?php echo $preference['destination']; ?> </p>
                                                <p> entre <?php echo $preference['price_min']; ?>€ et <?php echo $preference['price_max']; ?>€ la nuit </p>
                                                <p> Distance max : <?php echo $preference['distance']; ?> km </p>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <div class="flex">
                                                    <label for="date_seach_arrive">Arrivée</label>
                                                    <br>
                                                    <input class="form-control" placeholder="Quand ?" type="date" name="date_seach_arrive" id="date_seach_arrive<?php echo $preference['id']; ?>">
                                                </div>
                                                
                                                <div class="flex">
                                                    <label for="date_seach_departure">Départ</label>
                                                    <br>
                                                    <input class="form-control" placeholder="Quand ?" type="date" name="date_seach_departure" id="date_seach_departure<?php echo $preference['id']; ?>">
                                                </div>
                                            </div>
                                                <?php
                                                    echo "<input  type='hidden' name='place_search' id='place_search". $preference['id']."' value =".$preference['destination']." >";
                                                    echo "<input  type='hidden' name='price_search_min' id='price_search_min". $preference['id']."' value =".$preference['price_min']." >";
                                                    echo "<input  type='hidden' name='price_search_max' id='price_search_max". $preference['id']."' value =".$preference['price_max']." >";
                                                    echo "<input  type='hidden' name='distance_search' id='distance_search". $preference['id']."' value =".$preference['distance']." >";
                                                ?>
                                                <button class="btn btn-primary recherche_modal<?php echo $preference['id']; ?>" onclick="getLocationbyid(<?php echo $preference['id']; ?>)">Rechercher</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php

                    }
                    ?>

                    <?php

                }
                ?>
                    <button class="btn btn-primary" href="?page=user_page&page_account=add_pref_search">Voir mes préférences </button>
            </div>
                    <?php

            }
            ?>
            <div class="searchbar">
                <div class="flex">
                    <label for="place_search">Destination</label>
                    <br>
                    <input placeholder="Où allez vous ?" type="text" name="place_search" id="place_search" required>
                </div>
                
                <div class="flex">
                    <label for="date_seach_arrive">Arrivée</label>
                    <br>
                    <input placeholder="Quand ?" type="date" name="date_seach_arrive" id="date_seach_arrive">
                </div>
                
                <div class="flex">
                    <label for="date_seach_departure">Départ</label>
                    <br>
                    <input placeholder="Quand ?" type="date" name="date_seach_departure" id="date_seach_departure">
                </div>

                <div class="flex">
                    <label for="price_search_min">Prix Minimum</label>
                    <br>
                    <input placeholder="Quel prix min en €" type="float" name="price_search_min" id="price_search_min" required>
                </div>

                <div class="flex">
                    <label for="price_search_max">Prix Maximum</label>
                    <br>
                    <input placeholder="Quel prix max en €" type="float" name="price_search_max" id="price_search_max" required>
                </div>

                <div class="flex">
                    <label for="distance_search">Distance</label>
                    <br>
                    <input placeholder="Jusqu'où en km" type="float" name="distance_search" id="distance_search" required>
                </div>
                
                <button class="flex" class= "search_btn" onclick="getLocation()">Rechercher</button>
            </div>
            <div id="contener">
                <div id="search_housing_list"></div>
                <div id="search_housing_map"></div>
            </div>
        </div>

        <script src="js/script.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>

        <script>

            // All page modals
            var modals = document.querySelectorAll('.modal');

            function getLocationbyid(id)
            {
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        action: "getLocationbyid",

                        destination: document.querySelector('#place_search' + id).value,

                        arrive: document.querySelector('#date_seach_arrive' + id).value,

                        departure: document.querySelector('#date_seach_departure' + id).value,

                        price_min: document.querySelector('#price_search_min' + id).value,
                        price_max: document.querySelector('#price_search_max' + id).value,
                        distance: document.querySelector('#distance_search' + id).value

                    },
                    dataType: "json",
                    success: function (response) {
                        var results = response["data"];
                        if(response["distance"] == 0){
                            loadMapAddress(results, 22);
                        }
                        else{
                            var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                            loadMapAddress(results, zoom);
                        }
                        $("#search_housing_list").empty();
                        for(let i = 0; i < results.length; i++){
                            $("#search_housing_list").append("<div class='data_search'><a href='?page=ask_reservation&id_housing="+ results[i]["id"] + "&date_start="+ response["arrive"] +"&date_end=" + response["departure"] + "' class='link_announce'><p>Nom : " + results[i]['nom'] + "</p><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Prix à la nuit : " + results[i]['price'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
                        }
                    },
                    error: function (response) {
                        console.log("ERROR");
                    },
                    complete: function(response) {
                        console.log("COMPLETE");
                    }
                });
                var modals = document.querySelectorAll('.modal');

                for (var index in modals) {
                    if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
                    }
                
                
            }

            var btn = document.querySelectorAll("button.modal-button");



            // Get the <span> element that closes the modal
            var spans = document.getElementsByClassName("btn-close");

            // When the user clicks the button, open the modal
            for (var i = 0; i < btn.length; i++) {
                btn[i].onclick = function(e) {
                    e.preventDefault();
                    modal = document.querySelector(e.target.getAttribute("href"));
                    modal.style.display = "block";
                }
            }

            // When the user clicks on <span> (x), close the modal
            for (var i = 0; i < spans.length; i++) {
                spans[i].onclick = function() {
                    for (var index in modals) {
                    if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
                    }
                }
            }


            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                for (var index in modals) {
                if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
                }
                }
            }

        </script>
        

    </body>
</html>