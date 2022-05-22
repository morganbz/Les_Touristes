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


function addressCoordModal(next){
    var adresse = document.querySelector('#place_search_modal').value;
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


function loadMapAddressActivity(data = null, zoom = 22){
    addressCoord(function(){
        var map = new google.maps.Map(document.getElementById('search_activity_map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoom
        });
        
        setMarkers(map,data);
    });
}

function loadMapAddressActivitModal(data = null, zoom = 22, latitude, longitude){
    addressCoordModal(function(){
        var map = new google.maps.Map(document.getElementById('search_activity_map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoom
        });
        
        setMarkersModal(map,data, latitude, longitude);
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
                        +"<a target = '_blank' href='?page=ask_reservation&id_housing="+ station["id"] + "&date_start="+ station["arrive"] +"&date_end=" + station["departure"] + "' class='link_announce'>"
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

function setMarkersModal(map,locations, latitude, longitude) {

    for(var i=0; i<=locations.length; i++){
        if(i == locations.length){
            var myLatLng = new google.maps.LatLng(latitude, longitude);
            var infoWindow = new google.maps.InfoWindow();
        }
        else{
            var station = locations[i];
            var myLatLng = new google.maps.LatLng(station['latitude'], station['longitude']);
            var infoWindow = new google.maps.InfoWindow();
        }

        var map_icon;
        if(station['isHousing'] == 1 || i == locations.length){
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
        

        if(i != locations.length){
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: station['marker_ville'],
                icon: map_icon
            });
        }
        else{
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: "logement",
                icon: map_icon
            });
        }

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
                    if(i != locations.length){
                        infoWindow.setContent(
                            "<div id='infoWindow'>"
                            +"<p>Nom : "+station['nom']+"<p>"
                            +"<p>Type de logement : " + station['type'] + "<p>"
                            +"<p>Adresse : "+station['adresse']+"<p>"
                            +"<p>Prix à la nuit : " + station['price'] + "<p>"
                            +"</div>"
                        );
                    }
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
        beforeSend: function () {
            $("#search_housing_list").append("<div class='page-center'><div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div></div>");
            console.log("recher");
        },
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

                if(results[i]['is_near'] == false){
                    var div = "<div class='data_search border-secondary'><a target = '_blank' href='?page=ask_reservation&id_housing="+ results[i]["id"] + "&date_start="+ response["arrive"] +"&date_end=" + response["departure"] + "' class='link_announce'><h4>" + results[i]["nom"] + "</h4>"+ results[i]['type'] + " situé au " + results[i]['adresse'] + "</p><p><em>" + results[i]['price'] + "€ la journée</em></p><p>" + results[i]['description'] +"</p>";

                    if(results[i]['nb_ask'] > 0){
                        if(results[i]['nb_ask'] == 1){
                            var res = div + "<p class='text-secondary'><em>Il y a déjà "+ results[i]['nb_ask'] +" demande de réservation pour ces dates </p></em>";
                        }
                        else{
                            var res = div + "<p class='text-secondary'><em>Il y a déjà "+ results[i]['nb_ask'] +" demandes de réservation pour ces dates </p></em>";
                        }
                        var res = res + "</a></div>";
                    }
                    else{
                        var res = div + "</a></div>";
                    }
                }
                else{
                    var string1 = results[i]['dates'][0]['date_start'].split('-');
                    var string2 = results[i]['dates'][0]['date_end'].split('-');

                    var date1 = new Date(parseInt(string1[0]), parseInt(string1[1]) - 1, parseInt(string1[2]));
                    var date2 = new Date(parseInt(string2[0]), parseInt(string2[1]) - 1, parseInt(string2[2]));

                    let dateLocale1 = date1.toLocaleString('fr-FR',{
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'});
                    
                    let dateLocale2 = date2.toLocaleString('fr-FR',{
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'});


                        var div = "<div class='data_search border-secondary'><a target = '_blank' href='?page=ask_reservation&id_housing="+ results[i]["id"] + "&date_start="+ response["arrive"] +"&date_end=" + response["departure"] + "&near=ok' class='link_announce'><h4>" + results[i]["nom"] + "</h4>"+ results[i]['type'] + " situé au " + results[i]['adresse'] + "</p><p><em>" + results[i]['price'] + "€ la journée</em></p><p>" + results[i]['description'] +"</p>" + "<p class='text-danger'><em>" + "indisponible pour ces dates, voir du <strong>" + dateLocale1 + "</strong> au <strong>" + dateLocale2 + "</strong>";

                    var size = results[i]['dates'].length;

                    if(size > 1){
                        div = div + " (<strong>" + (size - 1) + "</strong>";
                        if(size > 2){
                            div = div + " autres suggestions)";
                        }
                        else{
                            div = div + " autre suggestion)";
                        }
                    }


                    var res = div + "</em></p></a></div>";
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


function getLocationActivity()
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocationActivity",
            destination: document.querySelector('#place_search').value,
            distance: document.querySelector('#distance_search').value,
            type: document.querySelector('#type_search').value

        },
        dataType: "json",
        beforeSend: function () {
            $("#search_activity_list").append("<div class='page-center'><div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div></div>");
        },
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
                $("#search_activity_list").append("<div class='data_search'><a target = '_blank' href='?page=activity&a="+ results[i]["id"]+"' class='link_announce'><h4>" + results[i]['nom'] + "</h4><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
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

function getLocationActivityModal()
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocationActivity",
            destination: document.querySelector('#place_search_modal').value,
            distance: document.querySelector('#distanceModal').value,
            type: document.querySelector('#type_searchModal').value
        },
        dataType: "json",
        beforeSend: function () {
            $("#search_activity_list").append("<div class='page-center'><div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div></div>");
        },
        success: function (response) {
            var results = response["data"];
            var latitude =  document.querySelector('#lat_modal').value;
            var longitude =  document.querySelector('#long_modal').value;
            if(response["distance"] == 0){
                loadMapAddressActivitModal(results, 22, latitude, longitude);
            }
            else{
                var zoom = 22 - Math.ceil(Math.log(response["distance"]*100)/Math.log(2));
                loadMapAddressActivitModal(results, zoom, latitude, longitude);
            }
            $("#search_activity_list").empty();
            for(let i = 0; i < results.length; i++){
                $("#search_activity_list").append("<div class='data_search'><a target = '_blank' href='?page=activity&a="+ results[i]["id"]+"' class='link_announce'><h4>" + results[i]['nom'] + "</h4><p>Type de logement : " + results[i]['type'] + "</p><p>Adresse : " + results[i]['adresse'] + "</p><p>Description : " + results[i]['description'] + "</p></a></div>");
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