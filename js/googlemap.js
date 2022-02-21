function loadMap() {
    var Theo = { lat: 45.5312, lng: 5.9522 };
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: Theo,
    });
    var marker = new google.maps.Marker({
        position: Theo,
        map: map,
    });
}