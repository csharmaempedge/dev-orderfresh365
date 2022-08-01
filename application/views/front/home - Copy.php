<style type="text/css">
	.person-info h5 {
    margin-bottom: 64px;
    color: #fb3d3d;
    font-size: 24px;
	}
	.dot{width: 200px;}
</style>
<?php
$global_setting_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');
 $order_status = (!empty($global_setting_res->order_status)) ? $global_setting_res->order_status : '';
 $deadline_date = (!empty($global_setting_res->deadline_date)) ? $global_setting_res->deadline_date : '';
?>
<section class="contact-us section-space">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-12">
				<div class="section-title style2 ">
					<div class="section-top">
						<h1><span>menu</span><b>Current Menu</b></h1>
						<h4>Lorem ipsum dolor sit amet, consectetursed do ei</h4>
					</div>
				</div>
			</div>
		</div>
		

		<div class="row">
			<div class="col-9">
				<div class="data-table p-4 bg-white">
					<table id="job_tbl" class="display responsive nowrap table table-hover table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">S.No</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Protien Serving</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Carb Serving</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Veg Serving</th>
								<th style="background-color: <?PHP echo THEME_COLOR; ?>; color: #22255a;">Price</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$standard_meal_res = $this->common_model->getData('tbl_standard_meal', array('meal_status !='=>2), 'multi', NULL,'meal_id ASC');
							if(!empty($standard_meal_res))
							{
								$i = 1;
								foreach ($standard_meal_res as $res) 
								{
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $res->protien_serving; ?></td>
										<td><?php echo $res->carb_serving; ?></td>
										<td><?php echo $res->veg_serving; ?></td>
										<td><?php echo $res->price; ?></td>
									</tr>
									<?php
									 $i++;
								}
							}
							?>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-3">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="section-title style2 ">
								<div class="section-top">
									<h1><span>Countdown Timer</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-12 col-lg-12 col-md-6 mb-30">
							<div class="card border-0 has-shadow h-100 dot">
								<div class="card-header border-0 text-center" style="border-radius: 111%;background-color: <?PHP echo THEME_COLOR; ?>;">
									
									<div class="person-info">
										<h5><p style="text-align: center;font-size: 20px;margin-top: 69px;" id="demo"></p></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
	</div>
</section>
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