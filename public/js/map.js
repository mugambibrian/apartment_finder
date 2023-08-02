"use strict";
function initMap() {
    var myLatlng = { lat: -1.0514713586858206, lng: 37.05237337344281 };
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: myLatlng,
    });
    // Create the initial InfoWindow.
    var infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });
    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", function (mapsMouseEvent) {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        let latlang = mapsMouseEvent.latLng.toJSON();
        let latInput = document.getElementById("latitude");
        let longInput = document.getElementById("longitude");
        latInput.value = latlang.lat;
        longInput.value = latlang.lng;
        infoWindow.open(map);
    });
}
window.initMap = initMap;
