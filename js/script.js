function initMap() {
    var map = new google.maps.Map(document.getElementById('search_housing_map'), {
        center: new google.maps.LatLng(46, 2),
        zoom: 6
    });
}

function initMapActivity() {
    var map = new google.maps.Map(document.getElementById('search_activity_map'), {
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

function loadMapAddress(data = null, zoom = 22){
    addressCoord(function(){
        var map = new google.maps.Map(document.getElementById('search_housing_map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoom
        });
        
        setMarkers(map,data);
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
            title: station['marker_ville'],
            icon: new google.maps.MarkerImage('ressources/house.png')
        });

        (function(i){
            google.maps.event.addListener(marker, "click",function(){
                var station = locations[i];
                infoWindow.close();

                infoWindow.setContent(
                    "<div id='infoWindow'>"
                    +"<p>Nom : "+station['nom']+"<p>"
                    +"<p>Type de logement : " + station['type'] + "<p>"
                    +"<p>Adresse : "+station['adresse']+"<p>"
                    +"<p>Prix à la nuit : " + station['price'] + "<p>"
                    +"</div>"
                );
                infoWindow.open(map,this);
            });
        })(i);
    }
}

function getLocation()
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocation",
            destination: document.querySelector('#place_search').value,
            arrive: document.querySelector('#date_seach_arrive').value,
            departure: document.querySelector('#date_seach_departure').value,
            price_min: document.querySelector('#price_search_min').value,
            price_max: document.querySelector('#price_search_max').value,
            distance: document.querySelector('#distance_search').value
        },
        dataType: "json",
        success: function (response) {
            var results = response["data"];
            if(response["distance"] == 0){
                loadMapAddress(results, 22);
            }
            else{
                var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                loadMapAddress(results, zoom);
            }
            $("#search_housing_list").empty();
            for(let i = 0; i < results.length; i++){
                $("#search_housing_list").append("<div class='data_search'><a href='?page=ask_reservation&id_housing="+ results[i]["id"] + "&date_start="+ response["arrive"] +"&date_end=" + response["departure"] + "' class='link_announce'><p>Nom : " + results[i]['nom'] + "</p><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Prix à la nuit : " + results[i]['price'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
            }
        },
        error: function (response) {
            console.log("ERROR");
        },
        complete: function(response) {
            console.log("COMPLETE");
        }
    });
}

function getLocationActivity()
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocationActivity",
            destination: document.querySelector('#place_search').value,
            distance: document.querySelector('#distance_search').value
        },
        dataType: "json",
        success: function (response) {
            var results = response["data"];
            if(response["distance"] == 0){
                loadMapAddress(results, 22);
            }
            else{
                var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                loadMapAddress(results, zoom);
            }
            $("#search_activity_list").empty();
            for(let i = 0; i < results.length; i++){
                $("#search_activity_list").append("<div class='data_search'><a href='#' class='link_announce'><p>Nom : " + results[i]['nom'] + "</p><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
            }
        },
        error: function (response) {
            console.log("ERROR");
        },
        complete: function(response) {
            console.log("COMPLETE");
        }
    });
}