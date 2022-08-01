<script src="<?php echo base_url(); ?>webroot/plugins/jQuery/jquery-2.2.3.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<section class="breadcrumbs overlay" style="background-image: url(<?php echo base_url();?>webroot/front/assets/images/breadcrumb.jpg);">

		<div class="container">

			<div class="row">

				<div class="col-12">

					<div class="bread-inner">

						<!-- Bread Menu -->

						<div class="bread-menu">

							<ul>

								<li><a href="<?php echo base_url(); ?>">Home</a></li>

								<li><a href="<?php echo base_url(); ?>user">User</a></li>

							</ul>

						</div>

						<!-- Bread Title -->

						<!-- <div class="bread-title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">&nbsp;<span style="box-sizing: border-box; color: #efefef;">User</span></h2></div> -->

					</div>

				</div>

			</div>

		</div>

	</section>

	<div id="msg_div">

        <?php echo $this->session->flashdata('message'); ?>

    </div>

<section class="section-bg sec-profile sec-gap">

	<div class="container">

		<div class="row">

			<div class="col-12">

				<div class=" my-5">

					<div class="section-title default text-center">

						<!-- <div class="section-top">

							<h1><span>Latest</span></h1>

						</div>

						<div class="text-center">

							<b>Lorem Ipsum Dolor Sit Amet, Conse Ctetur Adipiscing Elit, Sed Do Eiusmod Tempor Ares Incididunt Utlabore. Dolore Magna Ones Baliqua</b>

						</div> -->

				</div>

				</div>

			</div>

			<form action="" class="form d-content" method="post" accept-charset="utf-8" enctype="multipart/form-data">

				<?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>

            	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

				<div class="col-lg-4 col-md-6 col-12">

					<div class="profile-left bg-white p-3">

						<div class="user-image">

							<img id="img_show" src="<?php echo base_url();?>webroot/placeholder.png">

						</div>

						<div class="text-center">

							<div class="upload">

								<input onchange="Upload(this);" data-validation="mime size" data-validation-allowing="jpg, png, gif, jpeg, jpe" data-validation-max-size="2M" type="file" name="user_profile_img" type="file" id="user_profile_img">

								<button class="btn btn-success"><span><i class="fas fa-cloud-upload-alt"></i></span> Upload</button><br>

								<small>Max upload size is 2MB (Width 512 * Height 512)</small>

							</div>

						</div>

					</div>

				</div>

				<div class="col-lg-8 col-md-6 col-12">

					<div>

				        <div id="msg_div_new">

				            <?php echo $this->session->flashdata('message_new');?>

				        </div>

				     </div>

					<div class="profile-right bg-white p-3">

						

						<div class="section">

							<h4 class="title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">User&nbsp;<span style="box-sizing: border-box; color: #f48123;"></span></h2></h4>

							<div class="forms-elements">

								<div class="row">

									<div class="col-lg-6">

										<div class="form-group">

											<label> First Name<span class="text-danger">*</span></label>

											<input type="text" required name="user_fname" class="form-control" placeholder=" First Name" value="<?php echo set_value('user_fname'); ?>">

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label>Last Name</label>

											<input type="text" name="user_lname" class="form-control" placeholder="Last Name" value="<?php echo set_value('user_lname'); ?>">

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label class="required">User Name (Small letters only)<span class="text-danger">*</span></label>

											<input required data-validation="custom" data-validation-regexp="^([a-z]+)$" data-validation-allowing="- _" onchange="check_user_name(this.value)" type="text" name="user_name" id="user_name" class="form-control has-border" value="">

											<span id="error_user_name" style="color:red;"></span>		

										</div>

									</div>
									<div class="col-lg-6">

										<div class="form-group">

											<label> Password<span class="text-danger">*</span></label>

											<input type="password" required="required" name="user_password" class="form-control" placeholder=" Password" value="<?php echo set_value('user_password'); ?>">

										</div>

									</div>
									<div class="col-lg-6">

										<div class="form-group">

											<label class="required">Email<span class="text-danger">*</span></label>

											<input required onchange="check_user_email_address(this.value)" type="text" name="user_email" id="user_email" class="form-control has-border" value="">

											<span id="error_user_Rmail" style="color:red;"></span>		

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label>Mobile Numbe<span class="text-danger">*</span></label>

											<input required onchange="checkMobileNo(this.value)" required name="user_mobile_no" id="user_mobile_no" placeholder="Enter Mobile" class="form-control has-border" value="">

											<span id="error_user_Rmob" style="color:red;"></span>

										</div>

									</div>

								</div>

								<div class="row">

									<!-- <div class="col-lg-6">

										<div class="form-group">

											<label class="required">Country<span class="text-danger">*</span></label>

											<select required id="country_id" name="country_id" class="form-control has-border" onchange="getStateListByCountryID(this.value)">

												<?php

			                                        $country_res = $this->common_model->getData('tbl_country', array('country_status'=>'1'), 'multi');

			                                        if(!empty($country_res)){

			                                            foreach($country_res as $c_val){

			                                                ?>

			                                                <option value="<?php echo $c_val->country_id; ?>"><?php echo $c_val->country_name; ?></option>

			                                                <?php

			                                            }

			                                        }

			                                    ?>

											</select>

											<?php echo form_error('country_id','<span class="text-danger">','</span>'); ?>

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label class="required">State Province<span class="text-danger">*</span></label>

											<select required id="state_id" name="state_id" class="form-control has-border">

												<option value="" >Select Your State </option>

												<?php

                                                    $state_list = $this->common_model->getData('tbl_state', NULL, 'multi');

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

									<div class="col-12 col-lg-6">

										<div class="form-group">

											<label class="required">Village<span class="text-danger">*</span></label>

											<input  required type="text" name="member_village" id="member_village" placeholder="Enter Village" class="form-control has-border" value="">

										</div>

									</div>

									<div class="col-12 col-lg-6">

										<div class="form-group">

											<label class="required">Postal Code<span class="text-danger">*</span></label>

											<input  required type="text" name="user_postal_code" id="user_postal_code" placeholder="Enter Postal Code" class="form-control has-border" value="">

										</div>

									</div>

									<div class="col-12 col-lg-6">

										<div class="form-group">

											<label class="required">City<span class="text-danger">*</span></label>

											<input required type="text" name="user_city" id="user_city" placeholder="Enter City" class="form-control has-border" value="">

										</div>

									</div> -->

									<div class="col-lg-6">

										<div class="form-group">

											<label>Email Reminder</label><br>

											<label><input checked name="email_reminder" id="email_reminder"type="radio" value="ON" /> &nbsp;ON</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                                            <label><input name="email_reminder" id="email_reminder"type="radio" value="OFF" /> &nbsp;OFF</label>

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label>Sms Reminder</label><br>

											<label><input checked name="text_reminder" id="text_reminder"type="radio" value="ON" /> &nbsp;ON</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                                            <label><input name="text_reminder" id="text_reminder"type="radio" value="OFF" /> &nbsp;OFF</label>

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label>Date of Birth</label>

											<input type="date" name="user_dob" class="form-control" placeholder="Date of Birth" value="<?php echo set_value('user_dob'); ?>">

										</div>

									</div>

									<div class="col-lg-6">

										<div class="form-group">

											<label class="required">State Province<span class="text-danger">*</span></label>

											<select required id="state_id" name="state_id" class="form-control has-border">

												<option value="" >Select Your State </option>

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

									<div class="col-12 col-lg-12">
										<div class="form-group">
											<label>Address line 1<span class="text-danger">*</span></label><br>
											<input autocomplete="off" required id="autocomplete" placeholder="Enter your address" name="user_address1" onFocus="geolocate()" class="form-control has-border" type="text" value="<?php echo set_value('user_address1'); ?>"/>
										</div>
									</div>

									<div class="col-12 col-lg-12">

										<div class="form-group">

											<label>Address line 2</label><br>

											<input type="text" name="user_address2" id="user_address2" class="form-control has-border" placeholder="Enter Address line 2" value="<?php echo set_value('user_address2'); ?>">

										</div>

									</div>

									<div class="col-12 col-lg-6">

										<div class="form-group">

											<label class="required">City<span class="text-danger">*</span></label>

											<input required type="text" name="user_city" id="user_city" placeholder="Enter City" class="form-control has-border" value="">

										</div>

									</div>

									<div class="col-12 col-lg-6">

										<div class="form-group">

											<label class="required">ZIP Code<span class="text-danger">*</span></label>

											<input  required type="text" name="user_postal_code" id="user_postal_code" placeholder="Enter ZIP Code" class="form-control has-border" value="">

										</div>

									</div>
									<input type="hidden" name="txtLat" id="txtLat" value="" >
								  	<input type="hidden" name="txtLng" id="txtLng" value="" >
									<div class="col-12 col-lg-12">
										<div id="map"></div>
										    <div id="infowindow-content">
										      <span id="place-name" class="title"></span><br />
										      <span id="place-address"></span>
										    </div>
									</div>
									
								</div>

							</div>

						</div>					

					</div>

					<div class="bg-white p-2 text-center">

						<button id="submit_btn"  type="submit" name="Submit" value="Add" class="ss-btn theme-2">Submit</button>

						<div class="text-center mt-5">

							<h6>Already have an account? <a href="<?php echo base_url(); ?>login">Login Now</a></h6>

						</div>

					</div>

				</div>

			</form>

			

		</div>

	</div>

</section>

<div id="uploadimageModal" class="modal" role="dialog">

 <div class="modal-dialog">

  <div class="modal-content" style="width: 120%;">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" style="text-align: center;">Upload & Crop Image</h4>

        </div>

        <div class="modal-body">

          <div class="row">

       <div class="col-md-8 text-center">

        <div id="image_demo" style="width:350px; margin-top:30px"></div>

       </div>

       <div class="col-md-4" style="padding-top:30px;">

        <br />

        <br />

        <br/>

        <button class="btn btn-success crop_image" style="margin: -57px">Crop & Upload Image</button>

     </div>

    </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>

     </div>

    </div>

</div>

    <script type="text/javascript">

        $("#msg_div_new").fadeOut(10000);

        function Upload() {

	   //alert(img_no);

	    var membership_height = '<?php echo membership_height; ?>';

	    var membership_width = '<?php echo membership_width; ?>';

	    //Get reference of FileUpload.

	    var fileUpload = document.getElementById("user_profile_img");

	    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");

	    if (regex.test(fileUpload.value.toLowerCase())) {

	        //Check whether HTML5 is supported.

	        if (typeof (fileUpload.files) != "undefined") {

	            var reader = new FileReader();

	            reader.readAsDataURL(fileUpload.files[0]);

	            reader.onload = function (e) {

	                var image = new Image();

	                image.src = e.target.result;

	                image.onload = function () {

	                    var height = this.height;

	                    var width = this.width;

	                    if (height == membership_height && width == membership_width) {

	                      $('#img_show')

	                      .attr('src', e.target.result);

	                      alert('Uploaded image has valid Height and Width.!');

	                      return true;

	                    }

	                    else

	                    {

	                      $('#img_show').attr('src', '');

	                      alert('Height and Width must not exceed.');

	                      $('#user_profile_img').val('');

	                      return false; 

	                    }

	                    

	                };

	 

	            }

	        } else {

	            $('#img_show').attr('src', '');

	            $('#user_profile_img').val('');

	            alert('This browser does not support HTML5.');

	            return false;

	        }

	    } else {

	        $('#img_show').attr('src', '');

	        $('#user_profile_img').val('');

	        alert('Please select a valid Image file.');

	        return false;

	    }

	    }



	    $.validate({

	        modules : 'date, security, file',

	        onModulesLoaded : function() {}

	    });



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

	 function check_user_name(user_name){

    var action_check_user_name = 'check_name';

	var check_dataString = 'action_check_user_name=' + action_check_user_name + '&user_name=' + user_name;	

	var check_PAGE = '<?php echo base_url();?>user/check_user_name'; 

		$.ajax({

		type: "POST",

		url: check_PAGE,

		data: check_dataString,

		cache: false,	        

		success: function(check_data){

		//alert(check_data); return false;			     

	       if(check_data == parseInt(1)){



		    $('#error_user_name').html('This User Name allready ragistered!.');

		    $('#submit_btn').hide();

		    $("#user_name").focus();

		    document.getElementById('user_name').style.border='1px solid red';

		    return false;

		   }else{  



	      	  $('#error_user_name').html('');

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