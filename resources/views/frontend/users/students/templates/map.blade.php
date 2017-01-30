<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 570px;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #pac-input {
        background-color: #fff;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
    }
    #pac-input:focus {
        border-color: #4d90fe;
    }
    .pac-container {
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }
    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
    #target {
        width: 345px;
    }
</style>
<input id="pac-input" class="form-control" type="text" placeholder="Search your company here...">

<script>
</script>
<script>
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initAutocomplete() {
            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                    if(document.getElementById('pac-input').value == 'Bulacan State University - Sarmiento Campus'){
                        document.getElementById("name").innerHTML='Bulacan State University - Sarmiento Campus';
                        document.getElementById("address").innerHTML='Kaypian Road, City of San Jose Del Monte, Bulacan';
                        document.getElementById("company_name").value='Bulacan State University- Sarmiento Campus';
                        document.getElementById("company_address").value='Kaypian Road, City of San Jose Del Monte, Bulacan';;
                        document.getElementById("company_lat").value=14.814173;
                        document.getElementById("company_lng").value=121.057059;
                    }else{
                        document.getElementById("company_name").value=place.name;
                        document.getElementById("company_address").value=place.formatted_address;
                        document.getElementById("company_lat").value=place.geometry.location.lat();
                        document.getElementById("company_lng").value=place.geometry.location.lng();
                    }
                });
                map.fitBounds(bounds);
            });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5VVviYHGf2WP3e_HcBGoSViuzNJiTiss&libraries=places&callback=initAutocomplete"
        async defer></script>