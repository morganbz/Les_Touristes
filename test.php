<!DOCTYPE html>
<html>
<head>
	<title>Access Google Maps API in PHP</title>
	<script type="text/javascript" src="js/googlemap.js"></script>
	<style type="text/css">
		.container {
			height: 450px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid blue;
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
</html>

