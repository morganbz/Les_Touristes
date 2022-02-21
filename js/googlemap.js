function loadMap() {
    let Theo = { lat: 45.5312, lng: 5.9522 };
    let map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: Theo,
    });
    let marker = new google.maps.Marker({
        position: Theo,
        map: map,
    });
}