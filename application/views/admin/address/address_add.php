<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Address</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>address">Address</a></li>

            <li class="active">Create Address</li>

        </ol>

    </section>

   <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">Create Address</h3>

                </div>

                <div class="pull-right box-tools">

                    <a href="<?php echo base_url().MODULE_NAME;?>address" class="btn btn-info btn-sm">Back</a>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Address</div>

                        <div class="panel-body">

                            <form action="" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                <div class="box-body">

                                    <div>

                                        <div id="msg_div">

                                            <?php echo $this->session->flashdata('message');?>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="item form-group col-md-12">

                                            <div class="input text">

                                               <label>Address Name<span class="text-danger">*</span></label>

                                                <input data-validation="required" autocomplete="off" id="autocomplete" placeholder="Enter your address" name="user_address" onFocus="geolocate()" class="form-control has-border" type="text" value="<?php echo set_value('user_address'); ?>"/>

                                            </div>
                                            <input type="hidden" name="txtLat" id="txtLat" value="" >
                                            <input type="hidden" name="txtLng" id="txtLng" value="" >

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="map"></div>
                                                <div id="infowindow-content">
                                                  <span id="place-name" class="title"></span><br />
                                                  <span id="place-address"></span>
                                                </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- /.box-body -->      

                                <div class="box-footer">

                                   <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Save</button>

                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>address">Cancel</a>

                                </div>

                            </form>

                           

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /.box -->

    </section>

    <!-- /.content -->

</aside>

<!-- /.right-side -->

<script type="text/javascript">
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name',
  txtLat: 'txtLat',
  txtLng: 'short_name'
};
var map;
var marker;

function initAutocomplete() {
  var mapCanvas = document.getElementById("map");
  var myCenter = new google.maps.LatLng(39.67284207121872, -100.06897010156251);
  var mapOptions = {
    center: myCenter,
    zoom: 5
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
  var txtLat = place.geometry.location.lat();
    $("#txtLat").val(txtLat);
    var txtLng =place.geometry.location.lng();
    $("#txtLng").val(txtLng);
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

