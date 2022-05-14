


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

function addressCoordById(next, id){
    var adresse = document.querySelector('#place_search' + id).value;
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

function loadMapAddressById(data = null, zoom = 22, id){
    addressCoordById(function(){
        var map = new google.maps.Map(document.getElementById('search_housing_map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoom
        });
        
        setMarkers(map,data);
    }, id);
}

function loadMapAddressActivity(data = null, zoom = 22){
    addressCoord(function(){
        var map = new google.maps.Map(document.getElementById('search_activity_map'), {
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

        var map_icon;
        if(station['isHousing'] == 1){
            map_icon = new google.maps.MarkerImage('ressources/house.png');
        }
        else{
            map_icon = new google.maps.MarkerImage('ressources/house.png');
            if (station['type'] == "Restauration") {
                map_icon = new google.maps.MarkerImage('ressources/restauration.png');
            }
            if (station['type'] == "Randonnée") {
                map_icon = new google.maps.MarkerImage('ressources/randonnee.png');
            }
            if (station['type'] == "Baignade") {
                map_icon = new google.maps.MarkerImage('ressources/baignade.png');
            }
            if (station['type'] == "Espace Culturel") {
                map_icon = new google.maps.MarkerImage('ressources/espace_culturel.png');
            }
        }
        

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: station['marker_ville'],
            icon: map_icon
        });

        (function(i){
            google.maps.event.addListener(marker, "click",function(){
                var station = locations[i];
                infoWindow.close();
                
                if (station['isHousing'] == 0) {
                    infoWindow.setContent(
                        "<div id='infoWindow'>"
                        +"<p>Nom : "+station['nom']+"<p>"
                        +"<p>Type de logement : " + station['type'] + "<p>"
                        +"<p>Adresse : "+station['adresse']+"<p>"
                        +"</div>"
                    );
                }
                else{
                    infoWindow.setContent(
                        "<div id='infoWindow'>"
                        +"<p>Nom : "+station['nom']+"<p>"
                        +"<p>Type de logement : " + station['type'] + "<p>"
                        +"<p>Adresse : "+station['adresse']+"<p>"
                        +"<p>Prix à la nuit : " + station['price'] + "<p>"
                        +"</div>"
                    );
                }


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
                var div = "<div class='data_search'><a href='?page=ask_reservation&id_housing="+ results[i]["id"] + "&date_start="+ response["arrive"] +"&date_end=" + response["departure"] + "' class='link_announce'><p>Nom : " + results[i]['nom'] + "</p><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Prix à la nuit : " + results[i]['price'] + "</p><p>Description : " + results[i]['description'] +"</p>";

                if(results[i]['is_near'] == false){
                    if(results[i]['nb_ask'] > 0){
                        if(results[i]['nb_ask'] == 1){
                            var res = div + "<p class='text-danger'>Il y a déjà "+ results[i]['nb_ask'] +" demande de réservation pour ces dates </p>";
                        }
                        else{
                            var res = div + "<p class='text-danger'>Il y a déjà "+ results[i]['nb_ask'] +" demandes de réservation pour ces dates </p>";
                        }
                        var res = div + "</a></div>";
                    }
                    else{
                        var res = div + "</a></div>";
                    }
                }
                else{
                    var res = div + "</a></div>";
                }
                
                $("#search_housing_list").append(res);
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

function getLocationbyid(id)
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocationbyid",

            destination: document.querySelector('#place_search' + id).value,

            arrive: document.querySelector('#date_seach_arrive' + id).value,

            departure: document.querySelector('#date_seach_departure' + id).value,

            price_min: document.querySelector('#price_search_min' + id).value,
            price_max: document.querySelector('#price_search_max' + id).value,
            distance: document.querySelector('#distance_search' + id).value

        },
        dataType: "json",
        success: function (response) {
            var results = response["data"];
            if(response["distance"] == 0){
                loadMapAddressById(results, 22, id);
            }
            else{
                var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                loadMapAddressById(results, zoom , id);
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
    var modals = document.querySelectorAll('.modal');

    for (var index in modals) {
        if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
        }
    
    
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
                loadMapAddressActivity(results, 22);
            }
            else{
                var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                loadMapAddressActivity(results, zoom);
            }
            $("#search_activity_list").empty();
            for(let i = 0; i < results.length; i++){
                $("#search_activity_list").append("<div class='data_search'><a href='?page=activity&a="+ results[i]["id_activity"]+"' class='link_announce'><p>Nom : " + results[i]['nom'] + "</p><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
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