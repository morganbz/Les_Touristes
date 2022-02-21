google.maps.event.addDomListener(window, 'load', initialize);
function initialize(){
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtautocomplete'));
        google.maps.event.addListener(autocomplete, 'place_changed', function(){
            var place = autocomplete.getPlace();
            var location = {lat: place.geometry.location.A, lng: place.geometry.F};
        });
}

/*function loadMap() {
    let Theo = { lat: 45.5312, lng: 5.9522 };
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: Theo,
    });
    let marker = new google.maps.Marker({
        position: Theo,
        map: map,
    });
}*/

function loadMap() {
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: location,
    });
    let marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}