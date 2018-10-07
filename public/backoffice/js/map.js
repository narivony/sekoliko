/**
 * Traitement affichage google map
 */

var geocoder = new google.maps.Geocoder();

/**
 * Geocode position
 * @param pos
 */
function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function (responses) {
        if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address.replace(", Allemagne", "").split(", ").splice(-1, 1));

        } else {
            //updateMarkerAddress('Aucune coordonnÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e trouvÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e!');
        }
    });
}

/**
 * Mise à jour marqeur position
 * @param latLng
 */
function updateMarkerPosition(latLng) {
    var latitude  = latLng.lat();
    var longitude = latLng.lng();
    var lng       = (longitude).toString().replace('.', ',');
    var lat       = (latitude).toString().replace('.', ',');

    setLatitudeLongitude(longitude, latitude);
}

/**
 * Mise à jour marqueur adresse
 * @param str
 */
function updateMarkerAddress(str) {
    //document.getElementById('searchTextField').value = str;
}

/**
 * Récuperer latitude
 */
function getLatitude() {
    var _lat = '';

    // Groupe
    if ($('#buro_service_metiermanagerbundle_groupe_latitude').length > 0) {
        _lat = document.getElementById('buro_service_metiermanagerbundle_groupe_latitude').value;
    }

    // Espace
    if ($('#buro_service_metiermanagerbundle_space_latitude').length > 0) {
        _lat = document.getElementById('buro_service_metiermanagerbundle_space_latitude').value;
    }

    // Office
    if ($('#buro_service_metiermanagerbundle_office_latitude').length > 0) {
        _lat = document.getElementById('buro_service_metiermanagerbundle_office_latitude').value;
    }

    return _lat;
}

/**
 * Récuperer longitude
 */
function getLongitude() {
    var _long = '';

    // Groupe
    if ($('#buro_service_metiermanagerbundle_groupe_latitude').length > 0) {
        _long = document.getElementById('buro_service_metiermanagerbundle_groupe_longitude').value;
    }

    // Espace
    if ($('#buro_service_metiermanagerbundle_space_latitude').length > 0) {
        _long = document.getElementById('buro_service_metiermanagerbundle_space_longitude').value;
    }

    // Office
    if ($('#buro_service_metiermanagerbundle_office_latitude').length > 0) {
        _long = document.getElementById('buro_service_metiermanagerbundle_office_longitude').value;
    }

    return _long;
}

/**
 * Ajouter une valeur latitude et longitude
 * @param integer longitude
 * @param integer latitude
 */
function setLatitudeLongitude(_longitude, _latitude) {
    // Groupe
    if ($('#buro_service_metiermanagerbundle_groupe_latitude').length > 0) {
        document.getElementById('buro_service_metiermanagerbundle_groupe_longitude').value = _longitude;
        document.getElementById('buro_service_metiermanagerbundle_groupe_latitude').value = _latitude;
    }

    // Espace
    if ($('#buro_service_metiermanagerbundle_space_latitude').length > 0) {
        document.getElementById('buro_service_metiermanagerbundle_space_longitude').value = _longitude;
        document.getElementById('buro_service_metiermanagerbundle_space_latitude').value = _latitude;
    }

    // Office
    if ($('#buro_service_metiermanagerbundle_office_latitude').length > 0) {
        document.getElementById('buro_service_metiermanagerbundle_office_longitude').value = _longitude;
        document.getElementById('buro_service_metiermanagerbundle_office_latitude').value = _latitude;
    }
}

/**
 * Initialisation google map
 */
function initialize() {
    var lat    = getLatitude();
    var lng    = getLongitude();
    var latLng = new google.maps.LatLng(lat, lng);

    // Zoom
    var valZoom = 10;
    if (lat == 0 && lng == 0) {
        valZoom = 1;
    }

    var map    = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: valZoom,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false

    });

    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title: "Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
    });

    // Groupe
    if ($('#buro_service_metiermanagerbundle_groupe_ville').length > 0) {
        var input_ville = 'buro_service_metiermanagerbundle_groupe_ville';
    }

    // Espace
    if ($('#buro_service_metiermanagerbundle_space_ville').length > 0) {
        var input_ville = 'buro_service_metiermanagerbundle_space_ville';
    }

    var input        = document.getElementById(input_ville);
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Update current position info.
    updateMarkerPosition(latLng);
    //geocodePosition(latLng);

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function () {
        //updateMarkerAddress('Dragging...');;
    });

    google.maps.event.addListener(marker, 'drag', function () {
        updateMarkerPosition(marker.getPosition());
    });

    google.maps.event.addListener(marker, 'dragend', function () {
        document.getElementById(input_ville).focus();
        document.getElementById(input_ville).blur();
        geocodePosition(marker.getPosition());

        var latitude  = this.getPosition().lat();
        var longitude = this.getPosition().lng();
        var lng       = (longitude).toString().replace('.', ',');
        var lat       = (latitude).toString().replace('.', ',');

        setLatitudeLongitude(longitude, latitude);
        var lat = parseFloat(getLatitude());
        var lng = parseFloat(getLongitude());
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        input.className = 'form-control';
        var place       = autocomplete.getPlace();
        var lat         = place.geometry.location.lat();
        var lng         = place.geometry.location.lng();
        if (!place.geometry) {
            // Inform the user that the place was not found and return.
            input.className = 'notfound form-control controls';
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            setLatitudeLongitude(lng, lat);
            //console.log(lat);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(22);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        updateMarkerPosition(marker.getPosition());
        geocodePosition(marker.getPosition());
    });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
$(document).ready(function () {
    $('.kl_adresseReloadMap').mouseleave(function () {
        initialize();
    })
});

function toFixed(value, precision) {
    var precision = precision || 0,
        power = Math.pow(10, precision),
        absValue = Math.abs(Math.round(value * power)),
        result = (value < 0 ? '-' : '') + String(Math.floor(absValue / power));

    if (precision > 0) {
        var fraction = String(absValue % power),
            padding = new Array(Math.max(precision - fraction.length, 0) + 1).join('0');
        result += '.' + padding + fraction;
    }
    return result;
}