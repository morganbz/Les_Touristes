<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div id="page_content">
            <?php
            if(isset($_SESSION['id_user'])){

                $preferences = getPreferenceByIdUser($_SESSION['id_user']);

                if(!empty($preferences)){
                    ?>
                    <div id = "preference">
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <option selected>Voir mes préférences</option>
                            <?php
                            foreach($preferences as $preference){
                                ?>

                                <option> <button class="modal-button"  href ="#myModal<?php echo $preference['id']; ?>" ><?php echo $preference['nom']; ?> </button> </option>

                                <?php
                            }
                            ?>
                    </div>
                    <?php
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

                                            <div>
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
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary annuler" data-bs-dismiss="modal">Annuler</button>
                                            <form action="index.php" method="post" id="form1">
                                                <?php
                                                    echo "<input  type='hidden' name='place_search' id='place_search' value =".$preference['destination']." >";
                                                    echo "<input  type='hidden' name='price_search_min' id='price_search_min' value =".$preference['price_min']." >";
                                                    echo "<input  type='hidden' name='price_search_max' id='price_search_max' value =".$preference['price_max']." >";
                                                    echo "<input  type='hidden' name='distance_search' id='distance_search' value =".$preference['distance']." >";
                                                ?>
                                                <button class="btn btn-primary" id="submit1" name="submit" value="BookHousing" type="submit">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php

                    }
                    ?>

                    <?php

                }

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

        <script>

            var btn = document.querySelectorAll("button.modal-button");

            // All page modals
            var modals = document.querySelectorAll('.modal');

            // Get the <span> element that closes the modal
            var spans = document.getElementsByClassName("btn-close");

            // recupère les boutons annuler
            var annuler_button = document.getElementsByClassName("annuler");

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

            //pour le bouton fermer
            for (var i = 0; i < annuler_button.length; i++) {
                annuler_button[i].onclick = function() {
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
        

    </body>
</html>