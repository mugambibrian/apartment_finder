"use strict";
function initMap() {
    var myLatlng = { lat: -1.0514713586858206, lng: 37.05237337344281 };
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: myLatlng,
    });

    window.mapData.map((element) => {
        console.log(element);
        new google.maps.Marker({
            position: { lat: Number(element.lat), lng: Number(element.lng) },
            map: map,
            title: "Hello World!",
        });
    });
}
window.initMap = initMap;
