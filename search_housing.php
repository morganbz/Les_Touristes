<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
        <div id="page_content">
            <?php
            if(isset($_SESSION['id_user'])){
                ?>
                    <div class = "recherche_preference" id = "recherche_preference">
                            <label >Mes préférences :</label>
                            <?php

                $preferences = getPreferenceByIdUser($_SESSION['id_user']);


                if(!empty($preferences)){
                    $cpt = 0;
                            foreach($preferences as $preference){

                                echo "<input  type='hidden' name='place_search". $cpt."' id='place_search". $cpt."' value =".$preference['destination']." >";
                                echo "<input  type='hidden' name='price_search_min". $cpt."' id='price_search_min". $cpt."' value =".$preference['price_min']." >";
                                echo "<input  type='hidden' name='price_search_max". $cpt."' id='price_search_max". $cpt."' value =".$preference['price_max']." >";
                                echo "<input  type='hidden' name='distance_search". $cpt."' id='distance_search". $cpt."' value =".$preference['distance']." >";
                                echo "<input  type='hidden' name='cpt' id='cpt". $cpt."' value =".$cpt." >";

                                ?>

                                <button value = <?php echo $cpt; ?> name="preference_search<?php echo $cpt;?>" id ="preference_search<?php echo $cpt;?>" class="btn btn-outline-primary preference_search"><?php echo $preference['nom']; ?> </button>

                                <?php
                                $cpt++;
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

        <script> 


            var theButtons = $(".preference_search");

            console.log(theButtons);
            theButtons.each(function(index) {
                var currentButton = $(this);
                currentButton.click(function() {
                    $('input[name=place_search]').val( $('#place_search' + this.value).val() );
                    $('input[name=place_search]').val( $('#place_search' + this.value).val() );
                    $('input[name=price_search_min]').val( $('#price_search_min' + this.value).val() );
                    $('input[name=price_search_max]').val( $('#price_search_max' + this.value).val() );
                    $('input[name=distance_search]').val( $('#distance_search' + this.value).val() );
                });
            });
        </script>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
