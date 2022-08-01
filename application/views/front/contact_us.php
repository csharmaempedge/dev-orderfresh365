<section class="breadcrumbs overlay" style="background-image: url(<?php echo base_url();?>webroot/front/assets/images/breadcrumb.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<!-- Bread Menu -->
						<div class="bread-menu">
							<ul>
								<li><a href="<?php echo base_url();?>home">Home</a></li>
								<li><a href="<?php echo base_url();?>contactUs">Contact</a></li>
							</ul>
						</div>
						<!-- Bread Title -->
						<div class="bread-title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">&nbsp;<span style="box-sizing: border-box; color: #efefef;">Contact US</span></h2></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-us section-space">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-7 col-12">
					<div id="msg_div_new">
					    <?php echo $this->session->flashdata('message_new'); ?>
					</div>
					<!-- Contact Form -->
					<div class="contact-form-area m-top-30">
						<h4>Get In Touch</h4>
						<form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
			                <?php  $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() ); ?>
			                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="icon"><i class="fa fa-user"></i></div>
										<input required type="text"name="contact_us_name" placeholder="Enter Your Name" value="<?php echo set_value('contact_us_name'); ?>">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="icon"><i class="fa fa-phone"></i></div>
										<input required type="text" name="contact_us_phone_no" placeholder="Contact Number" value="<?php echo set_value('contact_us_phone_no'); ?>">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="icon"><i class="fa fa-envelope"></i></div>
										<input required type="email" name="contact_us_email" placeholder="Email" value="<?php echo set_value('contact_us_email'); ?>">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<div class="icon"><i class="fa fa-tag"></i></div>
										<input required type="text" name="contact_us_subject" placeholder="Type Subjects" value="<?php echo set_value('contact_us_subject'); ?>">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group textarea">
										<div class="icon"><i class="fas fa-pencil-alt"></i></div>
										<textarea required type="textarea" name="contact_us_message" rows="5"><?php echo set_value('contact_us_message'); ?></textarea>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group button">
										<button  type="submit" name="Submit" value="Add" class="ss-btn theme-2">Send Now</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<!--/ End contact Form -->
				</div>
				<div class="col-lg-5 col-md-5 col-12">
					<div class="contact-box-main m-top-30">
						<div class="contact-title">
							<h2>Contact with us</h2>
							<p>Life Time achievement award conferred to Dr. Col V.K. Arora Professor & Head Community Medicine during IAPSM Conference.</p>
						</div>
						<!-- Single Contact -->
						<div class="single-contact-box">
							<div class="c-icon"><span><i class="far fa-clock"></i></span></div>
							<div class="c-text">
								<h4>Opening Hour</h4>
								<p>24 Hours Open</p>
							</div>
						</div>
						<div class="single-contact-box">
							<div class="c-icon"><span><i class="fa fa-phone"></i></span></div>
							<div class="c-text">
								<h4>Call Us Now</h4>
								<p>Mob.: +91-9090548569</p>
								<p>Mob.: +91-9090548569</p>
							</div>
						</div>
						<div class="single-contact-box">
							<div class="c-icon"><span><i class="fa fa-tag"></i></span></div>
							<div class="c-text">
								<h4>Address</h4>
								<p>Dummy Address <br>
								<p>India <br>
							</div>
						</div>
						<!--/ End Single Contact -->
						<!-- <div class="button">
							<a href="#" class="ss-btn theme-1">Our Works<i class="fa fa-angle-right"></i></a>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="contact-map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57654.79089093068!2d78.49652377910157!3d25.424070100000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3977715266b19b2f%3A0x196ebf0ff254985e!2sParaMedical!5e0!3m2!1sen!2sin!4v1631355125947!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	</div>


    <script src="<?php echo base_url(); ?>webroot/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        $("#msg_div_new").fadeOut(10000);
    </script>