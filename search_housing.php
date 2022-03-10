<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            #page_content{
                height: calc(100%-80%);
            }
            #contener {
                display: flex;
                height: calc(100% - 8%);
            }
            #search_housing_list {
                height: calc(100% - 8%);
                width: 50%;
                overflow-y: scroll;
                position: fixed;
            }
            #search_housing_map {
                height: 100%;
                width: 50%;
                margin-left: 50%;
            }
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .searchbar{
                display: flex;
                height: 8%;
            }
            .flex{
                flex-grow: 1;
            }
            .data_search{
                border: black solid 1px;
                height: auto;
            }
        </style>
    </head>
    <body>
        <div id="page_content">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="js/script.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
    </body>
</html>