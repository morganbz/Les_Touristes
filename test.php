<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Using MySQL and PHP with Google Maps</title>
        <style>
            #map {
                height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
	<body>
		<input type="text" id="lat" value=46>latitude
		<input type="text" id="lng" value=2>longitude
		<input type="text" id="zoom" value=6>zoom
		<button onclick="initMap()">Generer Map</button>
		<div id="map"></div>

		<script>
			function initMap() {
				let lat = parseFloat(document.querySelector('#lat').value);
				let lng = parseFloat(document.querySelector('#lng').value);
				let zoom = parseFloat(document.querySelector('#zoom').value);
				var map = new google.maps.Map(document.getElementById('map'), {
					center: new google.maps.LatLng(lat, lng),
					zoom: zoom
				});

				let marker = new google.maps.Marker({
				position: {lat, lng},
				map: map
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
								+"<p>Département : "+station['departement']+"<p>"
								+"<p>Direction : "+station['direction']+"<p>"
								+"<p>Département : "+station['emplacement']+"<p>"
								+"<p>Coordonnée : "+station['latitude']+", "+station['longitude']+"<p>"
								+"<p>Route : "+station['route']+"<p>"
								+"<p>Type : "+station['type']+"<p>"
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

