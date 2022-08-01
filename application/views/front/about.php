<?php
$about_res = $this->common_model->getData('cm_about', NULL, 'single');
?>
<section class="breadcrumbs overlay" style="background-image: url(<?php echo base_url();?>webroot/front/assets/images/breadcrumb.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<!-- Bread Menu -->
						<div class="bread-menu">
							<ul>
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<li><a href="<?php echo base_url(); ?>about">About Us</a></li>
							</ul>
						</div>
						<!-- Bread Title -->
						<div class="bread-title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">&nbsp;<span style="box-sizing: border-box; color: #efefef;">ABOUT US</span></h2></div>
					</div>
				</div>
			</div>
		</div>
</section>

<section class="features-area section-bg">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title style2 text-center">
					<div class="section-top">
						<h1><span>About</span><b>ABOUT US</b></h1><h4>Explore all the Events & Activities</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-12 mb-4">
				<!-- Single Feature -->
				<div class="single-feature">
					<div class="icon-head"><span><i class="fa fa-podcast"></i></span></div>
					<h4><a href="#"><?php echo (!empty($about_res->about_fbox_title)) ? $about_res->about_fbox_title : ''; ?></a></h4>
					<p><?php echo (!empty($about_res->about_fbox_description)) ? $about_res->about_fbox_description : ''; ?></p>

				</div>
				<!--/ End Single Feature -->
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-4">
				<!-- Single Feature -->
				<div class="single-feature">
					<div class="icon-head"><span><i class="fa fa-podcast"></i></span></div>
					<h4><a href="#"><?php echo (!empty($about_res->about_sbox_title)) ? $about_res->about_sbox_title : ''; ?></a></h4>
					<p><?php echo (!empty($about_res->about_sbox_description)) ? $about_res->about_sbox_description : ''; ?></p>

				</div>
				<!--/ End Single Feature -->
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-4">
				<!-- Single Feature -->
				<div class="single-feature">
					<div class="icon-head"><span><i class="fa fa-podcast"></i></span></div>
					<h4><a href="#"><?php echo (!empty($about_res->about_tbox_title)) ? $about_res->about_tbox_title : ''; ?></a></h4>
					<p><?php echo (!empty($about_res->about_tbox_description)) ? $about_res->about_tbox_description : ''; ?></p>

				</div>
				<!--/ End Single Feature -->
			</div>
		</div>
	</div>
</section>

<section class="blog-single section-space">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-12">
				<div class="blog-single-main">
					<div class="main-image">
						<img src="<?php echo (!empty($about_res->about_img)) ? base_url().$about_res->about_img : ''; ?>" alt="#">
					</div>
					<div class="blog-detail">
						<?php echo (!empty($about_res->about_long_description)) ? $about_res->about_long_description : ''; ?>
					</div>
				</div>
				
			</div>

		</div>
	</div>
</section>