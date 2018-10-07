/**
 * Initialisation google map
 */
function initialize() {
    var input        = document.getElementById('buro_userbundle_user_city');
    var autocomplete = new google.maps.places.Autocomplete(input);
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
$(document).ready(function () {
    initialize();
});