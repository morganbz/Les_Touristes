<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Using MySQL and PHP with Google Maps</title>
    </head>
	<body>
		<input type="text" id="lat">latitude
        <br>
		<input type="text" id="lng">longitude
        <br>
		<button onclick="loadMapCoordTest()">Generer Map</button>
		<br>
        <br>
		<input type="text" id="address">addresse
        <br>
		<button onclick="loadMapAddressTest()">Generer Map</button>
        <br>
        <br>
        <input type="text" id="zoom" value=6>zoom
		<br>
		<div id="map"></div>

		<script src="js/script.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMapTest"></script>
	</body>
</html>

