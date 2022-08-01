<aside class="right-side">
    <section class="content-header">
        <h1>Patient</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>">Patient</a></li>
            <li class="active">Create Patient</li>
        </ol>
    </section>
    <section class="content">       
        <div class="box box-success">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Create Patient</h3>
                </div>
                <div class="pull-right box-tools">
                    <a href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>" class="btn btn-info btn-sm">Back</a>                           
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info" style="box-shadow: none; background-color: #dfe7f1;">
                        <div class="panel-heading" style="background-color: #bad59c; color: #22255a;">Patient</div>
                        <div class="panel-body">
                            <form action="" id="login_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div>
                                        <div id="msg_div">
                                            <?php echo $this->session->flashdata('message');?>
                                        </div>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>First Name<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_fname" id="user_fname" class="form-control" type="text" value="<?php echo set_value('user_fname'); ?>" />
                                                <?php echo form_error('user_fname','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Last Name<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_lname" id="user_lname" class="form-control" type="text" value="<?php echo set_value('user_lname'); ?>" />
                                                <?php echo form_error('user_lname','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Role<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="role_id" id="role_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                                    <?php
                                                        $role_list= $this->common_model->getData('tbl_role', array('role_status'=>'1'), 'multi');
                                                        if(!empty($role_list)){
                                                            foreach ($role_list as $val){
                                                                if($val->role_id !='1'){
                                                                ?>
                                                                   <option value="<?php echo $val->role_id; ?>"><?php echo $val->role_name; ?></option>
                                                                <?php 
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <?php echo form_error('role_id','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div> -->
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Username (Small letters only)<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-z]+)$" data-validation-allowing="- _" name="user_name" id="user_name" class="form-control" type="text" value="<?php echo set_value('user_name'); ?>" />
                                                <?php echo form_error('user_name','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <input required="required" name="user_password" id="user_password" class="form-control" type="password" value="" />
                                                <?php echo form_error('user_password','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Confirm Password<span class="text-danger">*</span></label>
                                                <input required="required" data-validation="confirmation" data-validation-confirm="user_password" name="user_cpassword" id="user_cpassword" class="form-control" type="password" value="" />
                                                <?php echo form_error('user_cpassword','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <input onchange="check_user_email_address(this.value)"  required="required" data-validation="email" name="user_email" id="user_email" class="form-control" type="email" value="<?php echo set_value('user_email'); ?>" />
                                                <?php echo form_error('user_email','<span class="text-danger">','</span>'); ?>
                                                <span id="error_user_Rmail" style="color:red;"></span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Phone Number<span class="text-danger">*</span></label>
                                                <input onchange="checkMobileNo(this.value)"  required="required" data-validation="number length" data-validation-length="10"  data-validation-error-msg="Phone no. has to be 10 chars" name="user_mobile_no" id="user_mobile_no" class="form-control" type="number" min="0" value="<?php echo set_value('user_mobile_no'); ?>" />
                                                <?php echo form_error('user_mobile_no','<span class="text-danger">','</span>'); ?>
                                                <span id="error_user_Rmob" style="color:red;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Date of Birth<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control date_val" name="user_dob" id="user_dob" placeholder="" value="<?php echo set_value('user_dob'); ?>">
                                                <?php echo form_error('user_dob','<span class="text-danger">','</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>State<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="state_id" class="form-control" id="state_id" ?>
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                    $state_list = $this->common_model->getData('tbl_state', array('country_id'=>'223'), 'multi');
                                                    foreach($state_list as $s_list) 
                                                    {
                                                        ?>
                                                        <option value="<?php echo $s_list->state_id; ?>"><?php echo $s_list->state_name; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Country<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="country_id" id="country_id" class="form-control" onchange="getStateListByCountryID(this.value)">
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                        $country_res = $this->common_model->getData('tbl_country', array('country_status'=>'1', 'country_id'=>223), 'multi');
                                                        if(!empty($country_res)){
                                                            foreach($country_res as $c_val){
                                                                ?>
                                                                <option value="<?php echo $c_val->country_id; ?>"><?php echo $c_val->country_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Zip Code<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([0-9]+)$" min="0" name="user_postal_code" id="user_postal_code" class="form-control" type="text" value="<?php echo set_value('user_postal_code'); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select data-validation="required" name="user_status" id="user_status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>City<span class="text-danger">*</span></label>
                                                <input required data-validation="custom" data-validation-regexp="^([a-zA-z -]+)$" data-validation-allowing="- _" name="user_city" id="user_city" class="form-control" type="text" value="<?php echo set_value('user_city'); ?>" />
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="input text">
                                                <label>Address line 1<span class="text-danger">*</span></label>
                                                <input data-validation="required" autocomplete="off" id="autocomplete" placeholder="Enter your address line 1" name="user_address" onFocus="geolocate()" class="form-control has-border" type="text" value="<?php echo set_value('user_address'); ?>"/>
                                            </div>
                                        </div>
                                        <input type="hidden" name="txtLat" id="txtLat" value="" >
                                        <input type="hidden" name="txtLng" id="txtLng" value="" >
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="input text">
                                                <label>Address line 2</label>
                                                <input autocomplete="off" id="autocomplete" placeholder="Enter your address line 2" name="user_address2" class="form-control has-border" type="text" value="<?php echo set_value('user_address2'); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Email Reminder</label>
                                                <br>
                                                <label><input checked name="email_reminder" id="email_reminder"type="radio" value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  
                                                <label><input name="email_reminder" id="email_reminder"type="radio" value="OFF" /> <b>OFF</b></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Sms Reminder</label>
                                                <br>
                                                <label><input checked name="text_reminder" id="text_reminder"type="radio" value="ON" /> <b>ON</b></label>&nbsp;&nbsp;&nbsp;&nbsp;  
                                                <label><input name="text_reminder" id="text_reminder"type="radio" value="OFF" /> <b>OFF</b></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="input text">
                                                <label>Profile Image</label>
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
                                </div>
                                <div class="box-footer">
                                    <button class="btn btn-success btn-sm" type="submit" name="Submit" value="Add" >Submit</button>
                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url().MODULE_NAME;?>doctor/docpatientView/<?php echo $doctor_id; ?>">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<script type="text/javascript">
     function check_user_email_address(emailId){

    var action_check_emailId = 'check_email';

    var check_dataString = 'action_check_emailId=' + action_check_emailId + '&user_email=' + emailId;   

    var check_PAGE = '<?php echo base_url();?>user/checkEmailId'; 

        $.ajax({

        type: "POST",

        url: check_PAGE,

        data: check_dataString,

        cache: false,           

        success: function(check_data){

        //alert(check_data); return false;               

           if(check_data == parseInt(1)){



            $('#error_user_Rmail').html('This email id allready ragistered!.');

            $('#submit_btn').hide();

            $("#user_email").focus();

            document.getElementById('user_email').style.border='1px solid red';

            return false;

           }else{  



              $('#error_user_Rmail').html('');

              $('#submit_btn').show();

              document.getElementById('user_email').style.border='1px solid green';

                

           }    

         }

      });



     }

     function checkMobileNo(mobileNo){

        var action_check_mobile = 'check_mobile';

        var check_dataString = 'action_check_mobile=' + action_check_mobile + '&user_mobile_no=' + mobileNo;    

        var check_PAGE = '<?php echo base_url();?>user/checkMobileNo'; 

            $.ajax({

            type: "POST",

            url: check_PAGE,

            data: check_dataString,

            cache: false,           

            success: function(check_data){

            //alert(check_data); return false;               

               if(check_data == parseInt(1)){



                $('#error_user_Rmob').html('This Mobile Number id allready ragistered!.');

                $('#submit_btn').hide();

                $("#user_mobile_no").focus();

                document.getElementById('user_mobile_no').style.border='1px solid red';

                return false;

               }else{  



                  $('#error_user_Rmob').html('');

                  $('#submit_btn').show();

                  document.getElementById('user_mobile_no').style.border='1px solid green';

                    

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
        /*var user_password = $('[name=user_password]').val();
        if(user_password){
            $('[name=user_password]').val(sha256(user_password));
        }
        var user_cpassword = $('[name=user_cpassword]').val();
        if(user_cpassword){
            $('[name=user_cpassword]').val(sha256(user_cpassword));
        }*/
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
  var myCenter = new google.maps.LatLng(33.883991, -84.514374);
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