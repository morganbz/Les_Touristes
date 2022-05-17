<?php
if(isset($_GET['resa'])){
    $reservation = getBookById($_GET['resa']);
    $housing = getHousingById($reservation['id_housing']);
}
?>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choisir date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p> Destination : <?php echo $housing['nom']?> </p>
                </div>
                <div class="d-flex align-items-start">
                    <div class="flex">
                        <label for="date_seach_arrive">Distance (en km)</label>
                        <br>
                        <input class="form-control" placeholder="Quand ?" type="int" name="distance" id="distanceModal">
                    </div>
                </div>
                    <?php
                        echo "<input  type='hidden' name='place_search' id='place_search' value =".$housing['latitude']." ".$housing['longitude']." >";
                    ?>
                    <button class="btn btn-outline-primary recherche_modal<?php echo $preference['id']; ?>" onclick="getLocationActivity()">Rechercher</button>
            </div>
        </div>
    </div>
    </div>


<div id="page_content">
    <div class="d-flex flex-nowrap flex-row justify-content-center flex-xxl-fill">
        <div class="form-floating">
            <input class="form-control" placeholder="Où allez vous ?" type="text" name="place_search" id="place_search" required>
            <label class="form-label" for="place_search">Destination</label>
        </div>

        <div class="form-floating">
            <input class="form-control" placeholder="Jusqu'où en km" type="float" name="distance_search" id="distance_search" required>
            <label class="form-label" for="distance_search">Distance</label>
        </div>
        
        <button class="btn btn-outline-primary ms-5" onclick="getLocationActivity()">Rechercher</button>
    </div>
    <div id="contener">
        <div id="search_activity_list"></div>
        <div id="search_activity_map"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMapActivity"></script>