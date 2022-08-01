<style type="text/css">



	.person-info h5 {



    margin-bottom: 64px;



    color: #fb3d3d;



    font-size: 24px;



	}



	.dot{width: 200px;}



</style>



<style type="text/css">



.job_top_headBox {



    position: relative;



    padding: 15px;



    border: 1px solid #666;



}



.job_top_headBox h2 {



    font-size: 38px;



    margin-bottom: 20px;



    font-weight: bold;



    line-height: 38px;



}



.job_top_headBox h2 a {



    word-break: break-all;



}



.form_application_detail_vs {



    position: relative;



    border: 1px solid #666;



    margin-top: -1px;



}







.form_application_detail_vs .col-md-3 {



    border-left: 1px solid #666;



}



.form_application_detail_vs .col-md-3 {



    padding: 20px 50px;



}



.form_application_detail_vs .row {



    margin: 0;



}



.form_application_detail_vs h3 {



    color: #007e00;



    font-size: 28px;



    margin-bottom: 20px;



    font-weight: bold;



}



ul.form_application_detail_vs_uline {



    margin: 0;



    font-size: 20px;



    line-height: 22px;



}



ul.form_application_detail_vs_uline li {



    margin-bottom: 5px;



}



@media (max-width: 767px){



	.job_top_headBox h2 {



	    font-size: 26px;



	    margin-bottom: 18px;



	    line-height: 26px;



	}



	.form_application_detail_vs .col-md-3 {



	    padding: 30px 40px;



	}



	.form_application_detail_vs .col-md-3:last-child {



	    border-left: none;



	}



}



</style>



<?php



$global_setting_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');



$order_status = (!empty($global_setting_res->order_status)) ? $global_setting_res->order_status : '';

if(!empty($global_setting_res))

{

	if($global_setting_res->order_status == 'Open')

	{

		$deadline_date = (!empty($global_setting_res->deadline_date)) ? $global_setting_res->deadline_date : '';

	}	

	else

	{

		$deadline_date = '1';

	}

}



$front_delivery_date = (!empty($global_setting_res->front_delivery_date)) ? $global_setting_res->front_delivery_date : '';



$delivery_day_name = date('l', strtotime($front_delivery_date))



?>







<section class="sec-challenge section-space home_content_wrap" style="background-image: url(<?php echo base_url();?>webroot/login_bg.jpg);">



	<div class="container">



		<div class="row">







			







			<div class="col-lg-8 col-md-6">



				<div class="section-title style2 menu_header_vs">



					<div class="section-top">



						<h1><span>menu</span><b>Current Menu</b></h1>



						<h4>Delivery Date : <?php echo $delivery_day_name.' '.date("m/d/Y", strtotime($front_delivery_date))?></h4>



					</div>



				</div>



			</div>



			<div class="col-lg-4 col-md-6">



				<div class="countdown_timer_header">



					<div class="section-title style2 ">



						<div class="section-top">



							<h1><span>Countdown Timer</span>



						</div>



					</div>



					<div class="">



						<div class="card-header border-0 text-center" style="background-color: <?PHP echo THEME_COLOR; ?>; border-radius: 30px;">



							



							<div class="person-info">



								<h5><p style="text-align: center;font-size: 20px;margin-top: 69px;" id="demo"></p></h5>



							</div>



						</div>



					</div>



				</div>



			</div>



		</div>



		







		<div class="row">



			<div class="col-12">



				<div class="job_detail_content_vs">



					<div class="text-center job_top_headBox">



						<h2 style="color: #f0080f">Current Menu</h2>



						<div style="margin-left: 25px;display: inline-block;color: #fff;position: relative;border-radius: 50px;padding: 5px 15px;line-height: initial;">



							<div class="section-top">



								<h1><span data-target="#MySecondmodal" data-toggle="modal" style="cursor: pointer;font-size: 15px; text-decoration: underline;">Standard Prices</span>



							</div>



						</div>



					</div>



					<div class="form_application_detail_vs">



						<div class="row">



							<div class="col-md-3" style="padding: 12px 25px;">



								<?php



								$category_res = $this->common_model->getData('tbl_category', array('category_status '=>1), 'multi');



								if(!empty($category_res))



								{



									foreach ($category_res as  $c_res) 



									{



										if($c_res->category_id == '1')



										{



											?>



											<h3 ><?php echo $c_res->category_name; ?></h3>



											<?php



											$product_res = $this->common_model->getData('tbl_product', array('product_status '=>1, 'category_id'=>1), 'multi');



											if(!empty($product_res))



											{



												foreach ($product_res as $p_res) 



												{



													?>



													<ul class="form_application_detail_vs_uline">



														<li style="font-size: 15px;font-weight: 400;color: #2e2751;"><?php echo $p_res->product_name; ?></li>



													</ul>



													<?php







												}



											}



										}











									}



								}



								?>



							</div>



							<div class="col-md-3" style="padding: 12px 25px;">



								<?php



								$category_res = $this->common_model->getData('tbl_category', array('category_status '=>1), 'multi');



								if(!empty($category_res))



								{



									foreach ($category_res as  $c_res) 



									{



										if($c_res->category_id == '2')



										{



											?>



											<h3 ><?php echo $c_res->category_name; ?></h3>



											<?php



											$product_res = $this->common_model->getData('tbl_product', array('product_status '=>1, 'category_id'=>2), 'multi');



											if(!empty($product_res))



											{



												foreach ($product_res as $p_res) 



												{



													?>



													<ul class="form_application_detail_vs_uline">



														<li style="font-size: 15px;font-weight: 400;color: #2e2751;"><?php echo $p_res->product_name; ?></li>



													</ul>



													<?php







												}



											}



										}











									}



								}



								?>



							</div>



							<div class="col-md-3" style="padding: 12px 25px;">



								<?php



								$category_res = $this->common_model->getData('tbl_category', array('category_status '=>1), 'multi');



								if(!empty($category_res))



								{



									foreach ($category_res as  $c_res) 



									{



										if($c_res->category_id == '3')



										{



											?>



											<h3 ><?php echo $c_res->category_name; ?></h3>



											<?php



											$product_res = $this->common_model->getData('tbl_product', array('product_status '=>1, 'category_id'=>3), 'multi');



											if(!empty($product_res))



											{



												foreach ($product_res as $p_res) 



												{



													?>



													<ul class="form_application_detail_vs_uline">



														<li style="font-size: 15px;font-weight: 400;color: #2e2751;"><?php echo $p_res->product_name; ?></li>



													</ul>



													<?php







												}



											}



										}











									}



								}



								?>



							</div>



							<div class="col-md-3" style="padding: 12px 25px;">



								<?php



								$category_res = $this->common_model->getData('tbl_category', array('category_status '=>1), 'multi');



								if(!empty($category_res))



								{



									foreach ($category_res as  $c_res) 



									{



										if($c_res->category_id == '4')



										{



											?>



											<h3 ><?php echo $c_res->category_name; ?></h3>



											<?php



											$product_res = $this->common_model->getData('tbl_product', array('product_status '=>1, 'category_id'=>4), 'multi');



											if(!empty($product_res))



											{



												foreach ($product_res as $p_res) 



												{



													?>



													<ul class="form_application_detail_vs_uline">



														<li style="font-size: 15px;font-weight: 400;color: #2e2751;"><?php echo $p_res->product_name; ?></li>



													</ul>



													<?php







												}



											}



										}











									}



								}



								?>



							</div>







						</div>



					</div>



				</div>



			</div>



			



		



	</div>



</section>



<div class="modal fade" id="MySecondmodal">



	<div class="modal-dialog">



		<div class="modal-content" style="width: 109%;">



			<div class="modal-header" style="background-color: #5dd7ff;">                                                             



					<h4 class="modal-title" style="text-align: center;">Standard Meals</h4>



				<button type="button" class="close" data-dismiss="modal">×</button> 



			</div> 



			<div class="modal-body">



				<div class="row">



					<div class="col-md-12 col-lg-12">



                        <div class="table-responsive">



                            <table id="example_scroll" class="table table-condensed table-bordered">



                                <thead>



                                    <tr>



                                        <th>Protein Serving (oz)</th>



                                        <th>Carb Serving (oz)</th>



                                        <th>Veg Serving (oz)</th>



                                        <th>Price</th>



                                    </tr>



                                </thead>



                                <tbody>



                                    <?php



                                    $standard_meal_res = $this->common_model->getData(' tbl_standard_meal', array('meal_status'=>1,'show_meal_status'=>1), 'multi');



                                    if(!empty($standard_meal_res))



                                    {



                                        foreach ($standard_meal_res as $s_res) 



                                        {



                                            ?>



                                            <tr>



                                                <td><?php echo $s_res->protien_serving; ?></td>



                                                <td><?php echo $s_res->carb_serving; ?></td>



                                                <td><?php echo $s_res->veg_serving; ?></td>



                                                <td>$<?php echo number_format((float)$s_res->price,2,'.',''); ?></td>



                                            </tr>



                                            <?php



                                        }



                                    }



                                    ?>



                                </tbody>



                            </table>



                        </div>



                      </div>



				</div>



			</div>   



			<div class="modal-footer">



				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                               



			</div>



		</div>                                                                       



	</div>                                      



</div>



<script>



	/*var deadline_date = '2021-11-11 22:00:00';*/



	var deadline_date = '<?php echo $deadline_date; ?>';



// Set the date we're counting down to



var countDownDate = new Date(deadline_date).getTime();



// Update the count down every 1 second



var x = setInterval(function() {







  // Get today's date and time



  var now = new Date().getTime();



    



  // Find the distance between now and the count down date



  var distance = countDownDate - now;



    



  // Time calculations for days, hours, minutes and seconds



  var days = Math.floor(distance / (1000 * 60 * 60 * 24));



  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));



  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));



  var seconds = Math.floor((distance % (1000 * 60)) / 1000);



    



  // Output the result in an element with id="demo"



  document.getElementById("demo").innerHTML = days + "d " + hours + "h "



  + minutes + "m " + seconds + "s ";



    



  // If the count down is over, write some text 



  if (distance < 0) {



    clearInterval(x);



    document.getElementById("demo").innerHTML = "EXPIRED";



  }



}, 1000);



</script>