<div id="page_content">
    <div class="searchbar">
        <div class="flex">
            <label for="place_search">Destination</label>
            <br>
            <input placeholder="Où allez vous ?" type="text" name="place_search" id="place_search" required>
        </div>

        <div class="flex">
            <label for="distance_search">Distance</label>
            <br>
            <input placeholder="Jusqu'où en km" type="float" name="distance_search" id="distance_search" required>
        </div>
        
        <button class="flex" class= "search_btn" onclick="getLocationActivity()">Rechercher</button>
    </div>
    <div id="contener">
        <div id="search_activity_list"></div>
        <div id="search_activity_map"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMapActivity"></script>