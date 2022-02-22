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

			var results = <?= json_encode($data); ?>

			setMarkers(map,results);
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMo3P3AMsyG2sPjxzc6Vzs5ekRGoUEUk4&callback=initMap"></script>
</html>

