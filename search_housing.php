        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
        <script>

            $( document ).ready(function() {
                // All page modals
                var modals = document.querySelectorAll('.modal');


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
            });


        </script>
        <div id="page_content">
            <?php
            if(isset($_SESSION['id_user'])){
                ?>
                    <div class = "recherche_preference" id = "recherche_preference">
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
                                                <button class="btn btn-outline-primary recherche_modal<?php echo $preference['id']; ?>" onclick="getLocationbyid(<?php echo $preference['id']; ?>)">Rechercher</button>
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
                    <a class="dark-color" href="?page=user_page&page_account=add_pref_search">Voir mes préférences </a>
            </div>
                    <?php

            }
            ?>
            
            <div class="d-flex flex-nowrap flex-row justify-content-center flex-xxl-fill">
                
                <div class="form-floating">
                    <input class="form-control" placeholder="Où allez vous ?" type="text" name="place_search" id="place_search" required>
                    <label class="form-label" for="place_search">Destination</label>
                </div>
                
                <div class="form-floating">
                    <input class="form-control" placeholder="Quand ?" type="date" name="date_seach_arrive" id="date_seach_arrive">
                    <label class="form-label" for="date_seach_arrive">Arrivée</label>
                </div>
                
                <div class="form-floating">
                    <input class="form-control" placeholder="Quand ?" type="date" name="date_seach_departure" id="date_seach_departure">
                    <label class="form-label" for="date_seach_departure">Départ</label>   
                </div>

                <div class="form-floating">
                    <input class="form-control" placeholder="Quel prix min en €" type="float" name="price_search_min" id="price_search_min" required>
                    <label class="form-label" for="price_search_min">Prix Minimum</label>
                </div>

                <div class="form-floating">
                    <input class="form-control" placeholder="Quel prix max en €" type="float" name="price_search_max" id="price_search_max" required>
                    <label class="form-label" for="price_search_max">Prix Maximum</label>
                </div>

                <div class="form-floating">
                    <input class="form-control" placeholder="Jusqu'où en km" type="float" name="distance_search" id="distance_search" required>
                    <label class="form-label" for="distance_search">Distance</label> 
                </div>
                
                <button class="btn btn-outline-primary ms-5" onclick="getLocation()">Rechercher</button>
           </div> 
            <div id="contener">
                <div id="search_housing_list"></div>
                <div id="search_housing_map"></div>
            </div>
        </div>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
