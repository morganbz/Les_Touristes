
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script>

$( document ).ready(function() {
    // All page modals
    var modals = document.querySelectorAll('.modal');


    // Get the <span> element that closes the modal
    var spans = document.getElementsByClassName("btn-close");

    // When the user clicks the button, open the modal
    for (var i = 0; i < modals.length; i++) {
            modals[0].style.display = "block";

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

<?php
if(isset($_GET['resa'])){
    $reservation = getBookById($_GET['resa']);
    $housing = getHousingById($reservation['id_housing']);

    ?>
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">à quelle distance de votre réservation ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-start">
                        <h5><a href="?page=ask_reservation&id_housing=<?php echo $housing["id"]; ?>"><?php echo $housing['nom']?> </a></h5>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="flex">
                            <label for="date_seach_arrive">Distance (en km)</label>
                            <br>
                            <input class="form-control" placeholder="50" type="int" name="distance" id="distanceModal">
                        </div>
                    </div>
                        <?php
                            echo "<input  type='hidden' name='place_search_modal' id='place_search_modal' value ='".getAddress($housing['latitude'], $housing['longitude'])."' >";
                            echo "<input  type='hidden' name='place_search_modal' id='lat_modal' value ='".$housing['latitude']."' >";
                            echo "<input  type='hidden' name='place_search_modal' id='long_modal' value ='".$housing['longitude']."' >";
                            echo "<input  type='hidden' name='place_search_modal' id='housing_modal' value ='1' >";
                        ?>
                        <button class="btn btn-outline-primary recherche_modal" onclick="getLocationActivityModal()">Rechercher</button>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>



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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMapActivity"></script>