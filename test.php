<?php

	include_once "db.php";

	include_once "function/function_picture.php";
    include_once "function/function_db.php";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            #page_content{
                height: 100%;
            }
            #contener {
                display: flex;
                height: calc(100% - 5%);
            }
            #search_housing_list {
                height: calc(100% - 5%);
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
                height: 5%;
            }
            .flex{
                flex-grow: 1;
            }
            .test{
                border: black solid 1px;
                height: auto;
            }
        </style>
    </head>
    <body>
        <?php
            $data = getData("Chambéry");
        ?>
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
                
                <button class="flex" onclick="loadMapAddress()">Rechercher</button>
            </div>
            <div id="contener">
                <div id="search_housing_list">
                    <?php
                    foreach($data as $data_info){
                        echo "<div class='test'>";
                        foreach($data_info as $value){
                            echo $value;
                            echo "<br>";
                        }
                        echo"</div>";
                    }
                    ?>
            </div>
            <div id="search_housing_map">
                </div>
            </div>
        </div>
            
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('search_housing_map'), {
                    center: new google.maps.LatLng(46, 2),
					zoom: 6
				});

                var results = <?= json_encode($data); ?>

                setMarkers(map,results);
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

            function setMarkers(map,locations) {
				for(var i=0; i<locations.length; i++){
					var station = locations[i];
					var myLatLng = new google.maps.LatLng(station['latitude'], station['longitude']);
					var infoWindow = new google.maps.InfoWindow();

					var marker = new google.maps.Marker({
						position: myLatLng,
						map: map,
						title: station['marker_ville']
					});

					(function(i){
						google.maps.event.addListener(marker, "click",function(){
							var station = locations[i];
							infoWindow.close();

							infoWindow.setContent(
								"<div id='infoWindow'>"
								+"<p>Nom : "+station['nom']+"<p>"
								+"<p>Adresse : "+station['adresse']+"<p>"
								+"<p>Département : "+station['departement']+"<p>"
								+"<p>Ville : "+station['ville']+"<p>"
								+"<p>Coordonnée : "+station['latitude']+", "+station['longitude']+"<p>"
								+"<p>Description : "+station['description']+"<p>"
								+"</div>"
							);
							infoWindow.open(map,this);
						});
					})(i);
				}
			}
        </script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
    </body>
</html>