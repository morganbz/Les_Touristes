function initMap() {
    var map = new google.maps.Map(document.getElementById('search_housing_map'), {
        center: new google.maps.LatLng(46, 2),
        zoom: 6
    });

    var results = {};

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

function loadMapAddress(data = null){
    addressCoord(function(){
        var map = new google.maps.Map(document.getElementById('search_housing_map'), {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: 15
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

function getLocation()
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            action: "getLocation",
            city: document.querySelector('#place_search').value
        },
        dataType: "json",
        success: function (response) {
            var results = response["data"];
            loadMapAddress(results);
            for(let i = 0; i < results.length; i++){
                $("#search_housing_list").append("<div class='data_search'><p>Nom : " + results[i]['nom'] + "<p><p>Adresse : " + results[i]['adresse'] + "<p><p>Département : " + results[i]['departement'] + "<p><p>Ville : " + results[i]['ville'] + "<p><p>Coordonnée : " + results[i]['latitude'] + ", " + results[i]['longitude'] + "<p><p>Description : " + results[i]['description'] + "<p></div>");
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