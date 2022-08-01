<style type="text/css">
    html,
body,
#map {
  height: 100%;
  width: 100%;
  margin: 0px;
  padding: 0px
}

#locationField,
#controls {
  position: relative;
  width: 480px;
}

#autocomplete {
  position: absolute;
  top: 0px;
  left: 0px;
  width: 99%;
}

.label {
  text-align: right;
  font-weight: bold;
  width: 100px;
  color: #303030;
}

#address {
  border: 1px solid #000090;
  background-color: #f0f0ff;
  width: 480px;
  padding-right: 2px;
}

#address td {
  font-size: 10pt;
}

.field {
  width: 99%;
}

.slimField {
  width: 80px;
}

.wideField {
  width: 200px;
}

#locationField {
  height: 20px;
  margin-bottom: 2px;
}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRzUFxKZlyVppkwsQEYqo3wPLqQw5W1SY&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
<div id="locationField">
  <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text" />
</div>

<table id="address">
  <!-- <tr>
    <td class="label">Street address</td>
    <td class="slimField">
      <input class="field" id="street_number" disabled="true" />
    </td>
    <td class="wideField" colspan="2">
      <input class="field" id="route" disabled="true" />
    </td>
  </tr>
  <tr>
    <td class="label">City</td>
    <td class="wideField" colspan="3">
      <input class="field" id="locality" disabled="true" />
    </td>
  </tr>
  <tr>
    <td class="label">State</td>
    <td class="slimField">
      <input class="field" id="administrative_area_level_1" disabled="true" />
    </td>
    <td class="label">Zip code</td>
    <td class="wideField">
      <input class="field" id="postal_code" disabled="true" />
    </td>
  </tr>
  <tr>
    <td class="label">Country</td>
    <td class="wideField" colspan="3">
      <input class="field" id="country" disabled="true" />
    </td>
  </tr> -->
  <label for="latitude">
        Latitude:
    </label>
    <input id="txtLat" type="text" style="color:red" value="28.47399" />
    <label for="longitude">
        Longitude:
    </label>
    <input id="txtLng" type="text" style="color:red" value="77.026489" /><br />
    <br />
</table>
<div id="map"></div>
<script type="text/javascript">
    var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};
var map;
var marker;

function initAutocomplete() {
  var mapCanvas = document.getElementById("map");
  var myCenter = new google.maps.LatLng(62, -110.0);
  var mapOptions = {
    center: myCenter,
    zoom: 3
  };
  map = new google.maps.Map(mapCanvas, mapOptions);
  marker = new google.maps.Marker({
    position: myCenter,
    draggable: true,
    animation: google.maps.Animation.BOUNCE
  });
  google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(2 * mapOptions.zoom);
    map.setCenter(marker.getPosition());
  });

   /*google.maps.event.addListener(marker, 'dragend', function (evt) {
                $("#txtLat").val(evt.latLng.lat().toFixed(6));
                $("#txtLng").val(evt.latLng.lng().toFixed(6));

                map.panTo(evt.latLng);
            });*/
  marker.setMap(map);

  google.maps.event.addListener(map, "click", function(e) {

    //lat and lng is available in e object
    placeMarker(map, e.latLng);
    // var latLng = e.latLng;
    // console.log("lat" + latLng.lat() + "long" + latLng.lng());
  });

  function placeMarker(map, location) {

    marker.setPosition(location);
    var txtLat = location.lat();
    $("#txtLat").val(txtLat);
    var txtLng =location.lng();
    $("#txtLng").val(txtLng);

    var infowindow = new google.maps.InfoWindow({
      content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
    });
    infowindow.open(map, marker);
  }

  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */
    (document.getElementById('autocomplete')), {
      types: ['geocode']
    });

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
  if (marker && marker.setMap)
    marker.setMap(null);
  marker = new google.maps.Marker({
    position: place.geometry.location,
    animation: google.maps.Animation.BOUNCE,
    map: map
  });
  marker.setPosition(place.geometry.location);
  map.setCenter(place.geometry.location);
  if (place.geometry.viewport)
    map.fitBounds(place.geometry.viewport);

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      console.log(val);
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      console.log(geolocation.lat);
    });
  }
}
google.maps.event.addDomListener(window, "load", initAutocomplete);
</script>
