<aside class="right-side">

    <section class="content-header">

        <h1>Profile</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>

            <li class="active">Profile </li>

        </ol>

    </section>

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">Profile</h3>

                </div>

                <div class="pull-right">

                    <a href="<?php echo base_url().MODULE_NAME;?>dashboard" class="btn btn-info btn-sm">Back</a>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">

                        <div class="panel-heading" style="background-color: #8bd040; color: #f9f9ff;">Profile</div>

                        <div class="panel-body">

                        <?php

                            foreach ($user_details as $value){

                                ?>

                                <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="login_form">

                                    <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                    <div class="box-body">

                                        <div>

                                            <div id="msg_div">

                                                <?php echo $this->session->flashdata('message');?>

                                            </div>

                                        </div> 

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>User Name</label>

                                                    <input readonly name="user_name" id="user_name" class="form-control" type="text" value="<?php echo $value->user_name; ?>" />

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>First Name<span class="text-danger">*</span></label>

                                                    <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_fname" id="user_fname" class="form-control" type="text" value="<?php echo $value->user_fname; ?>" />

                                                    <?php echo form_error('user_fname','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Last Name<span class="text-danger">*</span></label>

                                                    <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_lname" id="user_lname" class="form-control" type="text" value="<?php echo $value->user_lname; ?>" />

                                                    <?php echo form_error('user_lname','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <?php

                                            if($role_id != '2')

                                            {

                                                ?>

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Phone Number<span class="text-danger">*</span></label>

                                                        <input required="required" data-validation="number length" data-validation-length="10"  data-validation-error-msg="Phone no. has to be 10 chars" name="user_mobile_no" id="user_mobile_no" class="form-control" type="number" min="0" value="<?php echo $value->user_mobile_no; ?>" />

                                                        <?php echo form_error('user_mobile_no','<span class="text-danger">','</span>'); ?>

                                                    </div>

                                                </div>

                                                <?php

                                            }

                                            ?>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Email<span class="text-danger">*</span></label>

                                                    <input required="required" data-validation="email" name="user_email" id="user_email" class="form-control" type="email" value="<?php echo $value->user_email; ?>" />

                                                    <?php echo form_error('user_email','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Password<span class="text-danger">*</span></label>

                                                    <input name="user_password" id="user_password" class="form-control" type="password" value="<?php echo set_value('user_password'); ?>" />

                                                    <?php echo form_error('user_password','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Confirm Password<span class="text-danger">*</span></label>

                                                    <input data-validation="confirmation" data-validation-confirm="user_password" name="user_cpassword" id="user_cpassword" class="form-control" type="password" value="<?php echo set_value('user_cpassword'); ?>" />

                                                    <?php echo form_error('user_cpassword','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Country<span class="text-danger">*</span></label>

                                                    <select data-validation="required" name="country_id" id="country_id" class="form-control" onchange="getStateListByCountryID(this.value);">

                                                        <option value="">--select--</option>

                                                        <?php

                                                        foreach($country_list as $c_list){

                                                            ?>

                                                            <option <?php if($value->country_id == $c_list->country_id){ echo "selected"; } ?>  value="<?php echo $c_list->country_id; ?>"><?php echo $c_list->country_name; ?></option>

                                                            <?php

                                                        }

                                                        ?>

                                                    </select>

                                                    <?php echo form_error('country_id','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>State<span class="text-danger">*</span></label>

                                                    <select data-validation="required" name="state_id" class="form-control" id="state_id" ?>

                                                    <?php

                                                        $state_list = $this->common_model->getStateListByCountryID($value->country_id);

                                                        foreach($state_list as $s_list){

                                                            ?>

                                                            <option <?php if($value->state_id == $s_list->state_id){ echo "selected"; } ?>  value="<?php echo $s_list->state_id; ?>"><?php echo $s_list->state_name; ?></option>

                                                            <?php

                                                        }

                                                    ?>

                                                    </select>

                                                    <?php echo form_error('state_id','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>City<span class="text-danger">*</span></label>

                                                    <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_city" id="user_city" class="form-control" type="text" value="<?php echo $value->user_city; ?>" />

                                                    <?php echo form_error('user_city','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Address<span class="text-danger">*</span></label>
                                                    <input data-validation="required" autocomplete="off" id="autocomplete" placeholder="Enter your address" name="user_address" onFocus="geolocate()" class="form-control has-border" type="text" value="<?php echo $value->user_address; ?>"/>
                                                    <?php echo form_error('user_address','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>
                                            <input type="hidden" name="txtLat" id="txtLat" value="<?php echo (!empty($value->user_latitude)) ? $value->user_latitude : ''; ?>" >
                                            <input type="hidden" name="txtLng" id="txtLng" value="<?php echo (!empty($value->user_longitude)) ? $value->user_longitude : ''; ?>" >

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>ZIP Code<span class="text-danger">*</span></label>

                                                    <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" min="0" name="user_postal_code" id="user_postal_code" class="form-control" type="text" value="<?php echo $value->user_postal_code; ?>" />

                                                    <?php echo form_error('user_postal_code','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-4">

                                                <div class="input text">

                                                    <label>Date of Birth<span class="text-danger">*</span></label>
                                                        <input data-validation="date" type="text" class="form-control date_val" name="user_dob" id="user_dob" placeholder="" value="<?php echo $value->user_dob; ?>">
                                                    <?php echo form_error('user_dob','<span class="text-danger">','</span>'); ?>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <?php

                                            if($role_id == '4')

                                            {

                                                ?>

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Email Reminder</label>

                                                        <br>

                                                        <label><input <?php if($value->email_reminder == 'ON'){ echo "checked"; } ?> name="email_reminder" id="email_reminder"type="radio"  value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  

                                                        <label><input <?php if($value->email_reminder == 'OFF'){ echo "checked"; } ?> name="email_reminder" id="email_reminder"type="radio" value="OFF" /> <b>OFF</b></label>

                                                    </div>

                                                </div>

                                                <div class="form-group col-md-4">

                                                    <div class="input text">

                                                        <label>Sms Reminder</label>

                                                        <br>

                                                        <label><input <?php if($value->text_reminder == 'ON'){ echo "checked"; } ?> name="text_reminder" id="text_reminder"type="radio"  value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  

                                                        <label><input <?php if($value->text_reminder == 'OFF'){ echo "checked"; } ?> name="text_reminder" id="text_reminder"type="radio" value="OFF" /> <b>OFF</b></label>

                                                    </div>

                                                </div>

                                                <?php

                                            }

                                            ?>

                                            <div class="form-group col-md-2">

                                                <div class="input text">

                                                    <label>Profile Image</label>

                                                    <img width="100px" src="<?php echo base_url().''.$value->user_profile_img; ?>">

                                                </div>

                                            </div>

                                            <div class="form-group col-md-2">

                                                <div class="input text">

                                                    <label>&nbsp;</label>

                                                    <input data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="3M" name="user_profile_img" type="file" id="user_profile_img" value="" />

                                                    <small>Max upload size is 3MB</small>

                                                </div>

                                                <span class="text-danger" id="error_id"></span>

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

                                        <?php

                                        if($role_id == '2')

                                        {

                                            ?>

                                            <hr>

                                            <div class="row">

                                                <?php

                                                $phone_no_res = $this->common_model->getData('tbl_phone_no', array('user_id'=>$user_id), 'multi');

                                                if(!empty($phone_no_res)){

                                                    $count = 1;

                                                    foreach($phone_no_res as $res){

                                                        ?>

                                                            <div class="col-md-12" id="slider_img_<?php echo $res->phone_id; ?>">

                                                                <div class="box box-success box-solid">

                                                                    <div class="box-header with-border">

                                                                        <h3 class="box-title">Phone No-<?php echo $count; ?>

                                                                        </h3>

                                                                        <span class="pull-right box-tools">

                                                                            <button class="btn btn-danger btn-xs pull-right" type="button" onclick="removePhoneNo('<?php echo $res->phone_id; ?>')"><i class="fa fa-trash"></i></button>

                                                                        </span>

                                                                    </div>

                                                                    <div class="box-body">

                                                                        <div class="row">

                                                                            <div class="col-md-6 form-group">

                                                                                <div class="input text">

                                                                                    <label>Phone No.<span class=text-danger>*</span></label>

                                                                                   <input autocomplete="off" type="text" class="form-control" id="f_user_mobile_no_<?php echo $res->phone_id?>" name="f_user_mobile_no_<?php echo $res->phone_id?>" value="<?php echo $res->user_mobile_no; ?>">

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        <?php

                                                        $count++;

                                                    }

                                                }

                                                ?>

                                            </div>

                                            <br><br>

                                            <div class="clearfix" ></div>

                                            <hr>

                                            <h4 class="label-primary" style="margin-bottom: 18px; color: #fff; padding: 6px;"><b>Add Phone No Details:</b></h4>

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group col-md-4 pull-left">

                                                        <input type="hidden" name="no_of_phone" id="no_of_phone" value="">

                                                        <button type="button" id="add_slider" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add more phone no</button>

                                                        <button class="btn btn-danger btn-sm" type="button" style="margin-left: 20px; display: none;" id="remove_slider"><i class="fa fa-remove"></i></button><br><br>

                                                    </div>

                                                </div>

                                            </div>

                                            <div id="document_status" >

                                                <div id="add_phone_div">

                                                </div>

                                            </div>

                                            <div class="clearfix">

                                            </div>

                                            <hr>

                                            <?php

                                        }

                                        ?>

                                    </div>   

                                    <div class="box-footer">

                                        <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Profile" >Submit</button>

                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>dashboard">Cancel</a>

                                    </div>

                                </form>

                                <?php

                            }

                        ?>

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</aside>

<script type="text/javascript">

     $(document).ready(function(){

        var counter_img = '<?= !empty($phone_no_res) ? $count : 0; ?>';

        var counter_img_n = parseInt(counter_img) + '<?= !empty($phone_no_res) ? '' : 1; ?>'; 

        $("#add_slider").click(function (){

            $('#remove_slider').show();

            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'rm_slider_div' + counter_img);

            newTextBoxDiv.after().html('<div class="row"><div class="col-md-12"><div class="box box-success box-solid"><div class="box-header with-border"><h3 class="box-title">Phone No -'+counter_img_n+'</h3></div><div class="box-body"><div class="row"><div class="col-md-6 form-group"><div class="input text"> <label>Phone No<span class=text-danger>*</span></label> <input data-validation="required" autocomplete="off" class=form-control id=user_mobile_no_n[] name=user_mobile_no_n[]></div></div></div></div></div></div></div></div>');            

            newTextBoxDiv.appendTo("#add_phone_div");        

            $('#no_of_phone').val(counter_img_n);

            counter_img++;

            counter_img_n++;

        });

        $("#remove_slider").click(function (){

            counter_img--;

            counter_img_n--;

            counter_img_val = parseInt(counter_img_n)-1; 

            $('#no_of_phone').val(counter_img_val);

            $("#rm_slider_div" + counter_img).remove();         

            if(counter_img == <?= !empty($phone_no_res) ? $count : 0; ?>){

                $('#remove_slider').hide();

            }

        });

    });

    function removePhoneNo(phone_id){

        var PAGE = '<?php echo base_url().MODULE_NAME; ?>profile/removePhoneNo/'+phone_id;        

        var str = 'phone_id='+phone_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        $.ajax({

            url: PAGE,

            type: 'POST',

            data: str,

            success: function(response){                

                if(response){

                    $('#slider_img_'+phone_id).remove();

                }

                else{

                    $('#error_image_'+phone_id).html('Image removing faild please try again!')

                }

            }

        });

    }

    function  getStateListByCountryID(country_id){

        var str = 'country_id='+country_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        var PAGE = '<?php echo base_url().MODULE_NAME; ?>common/getStateListByCountryID';

        jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            success:function(data){        

                $('#state_id').html(data);

            } 

        });

    }



    $("#login_form").submit(function(){

        if(!checkFiletype()){

            return false;

        }

        var user_password = $('[name=user_password]').val();

        if(user_password){

            $('[name=user_password]').val(sha256(user_password));

        }

        var user_cpassword = $('[name=user_cpassword]').val();

        if(user_cpassword){

            $('[name=user_cpassword]').val(sha256(user_cpassword));

        }

    });



    function checkFiletype(){      

        if($('#user_profile_img').val() == ''){

            return true;

        }

        var filename = $('#user_profile_img').val();

        var extension = filename.replace(/^.*\./, '');

        extension = extension.toLowerCase();

        if(extension == 'png' || extension == 'gif' || extension == 'jpe' || extension == 'jpe' || extension == 'jpeg' || extension == 'jpg'){  

            $('#error_id').html("");

            return true;             

        }

        else{

            $('#user_profile_img').val('');

            $('#error_id').html("<p></p>Invalid file type please choose only image file!");

            return false; 

        }

    }

</script>

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
  var myCenter = new google.maps.LatLng(<?php echo (!empty($value->user_latitude)) ? $value->user_latitude : '33.883991'; ?>, <?php echo (!empty($value->user_longitude)) ? $value->user_longitude : '-84.514374'; ?>);
  var mapOptions = {
    center: myCenter,
    zoom: 10
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