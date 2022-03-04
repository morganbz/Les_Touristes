<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            #search_housing_map {
                height: 100%;
            }
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .searchbar{
                display: flex;
            }
            .flex{
                flex-grow: 1;
            }
        </style>
    </head>
    <body>
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
            
            <button class="flex" onclick="loadMapAddress()">Rechercher</button>
        </div>
        <div id="search_housing_map"></div>

        <script>
            function initMap() {
				var map = new google.maps.Map(document.getElementById('search_housing_map'), {
					center: new google.maps.LatLng(46, 2),
					zoom: 6
				});
			}

            function addressCoord(next){
				var adresse = document.querySelector('#place_search').value;
				if(adresse != ""){
					var geocoder =  new google.maps.Geocoder();
					geocoder.geocode( { 'address': adresse}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							latitude = results[0].geometry.location.lat();
							longitude = results[0].geometry.location.lng();
						}
                        else {
							alert("Something got wrong " + status);
						}
                        next();
					});
				}
			}

            function loadMapAddress(){
                addressCoord(function(){
                    var map = new google.maps.Map(document.getElementById('search_housing_map'), {
                        center: new google.maps.LatLng(latitude, longitude),
                        zoom: 15
				    });
                });
            }
        </script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
    </body>
</html>