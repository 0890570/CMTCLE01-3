
window.addEventListener('load', init);
function init()
{
    getLocation();
}

var lat = 1;
var lng = 1;
//var link = 'https://maps.googleapis.com/maps/api/geocode/json?&address=Sint-Jobsweg%20Rotterdam&key=AIzaSyD6utbVE6k67WwLhRDMx9MLi_diAQb3VsY';
var link = 'https://maps.googleapis.com/maps/api/geocode/json?&address=Wijnhaven%20107%20Rotterdam&key=AIzaSyD6utbVE6k67WwLhRDMx9MLi_diAQb3VsY';
$.ajax(link, {
    dataType: "json",
    success: function(location) {
        console.log(location);
        lat = location.results[0].geometry.location.lat;
        lng = location.results[0].geometry.location.lng
    }
});

var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocatie is niet beschikbaar.";
    }
}

function showPosition(position) {

    voteable = (position.coords.latitude > lat - 0.005 &&
                position.coords.latitude < lat + 0.005 &&
                position.coords.longitude > lng  - 0.005 &&
                position.coords.longitude < lng + 0.005) ?
        "WELKOM":"De quiz is niet beschikbaar. U moet zich naar de St.Jobshaven in Rotterdam begeven om de quiz te spelen.";
 var latplus = lat + 0.005;
    console.log("Api lat + zoveel " + latplus);
   console.log("browser lat:"+ position.coords.latitude );
   console.log("browser lng:"+ position.coords.longitude );
   console.log("api lat:"+ lat );
   console.log("api lng:"+ lng );
    console.log(voteable);
    document.getElementById("error").innerHTML = voteable;

    x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;

    var str = "U mag door naar de website :)";
//        Als de locatie goed is dan mag de gebruiker door naar de website
    if(voteable == "WELKOM") {
        $(".quiz").show();
    }
}
//    Errors voor als de geolocation niet werkt
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}/**
 * Created by raymo on 4-4-2016.
 */
