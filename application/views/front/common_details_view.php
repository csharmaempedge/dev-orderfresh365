	<?php
	if($type == 'mission')
	{
		?>
		<div class="breadcrumbs bread-blog">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<!-- Bread Menu -->
							<div class="bread-menu">
								<ul>
									<!-- <li><a href="<?php echo base_url();?>home">Home</a></li>
									<li><a href="<?php echo base_url();?>home">Mission</a></li>
									<li><a href="<?php echo base_url();?>home"><?php echo !empty($mission_res->mission_title) ? $mission_res->mission_title : ''; ?></a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="blog-single section-space">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="blog-single-main">
							<div class="main-image">
								<img src="<?php echo base_url().$mission_res->mission_img; ?>" alt="#">
							</div>
							<div class="blog-detail">
								<!-- News meta -->
								<ul class="news-meta">
									<li><span><i class="fas fa-pencil-alt"></i> </span><?php echo date('d M Y', strtotime($mission_res->mission_created_date)) ?></li>
								</ul>
								<?php echo !empty($mission_res->mission_long_description) ? $mission_res->mission_long_description : ''; ?>
								
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</section>
		<?php
	}
	if($type == 'home_page')
	{
		?>
		<div class="breadcrumbs bread-blog">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<!-- Bread Menu -->
							<div class="bread-menu">
								<ul>
									<!-- <li><a href="<?php echo base_url();?>home">Home</a></li>
									<li><a href="<?php echo base_url();?>home"><?php echo !empty($home_pages_res->home_page_title) ? $home_pages_res->home_page_title : ''; ?></a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="blog-single section-space">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="blog-single-main">
							<div class="main-image">
								<img src="<?php echo base_url().$home_pages_res->home_page_img; ?>" alt="#">
							</div>
							<div class="blog-detail">
								<!-- News meta -->
								<ul class="news-meta">
									<li><span><i class="fas fa-pencil-alt"></i> </span><?php echo date('d M Y', strtotime($home_pages_res->home_page_created_date)) ?></li>
								</ul>
								<?php echo !empty($home_pages_res->home_page_long_description) ? $home_pages_res->home_page_long_description : ''; ?>
								
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</section>

		
		<?php
	}
	if($type == 'privacyPolicy')
	{
		?>
		<div class="breadcrumbs bread-blog">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<!-- Bread Menu -->
							<div class="bread-menu">
								<ul>
									<!-- <li><a href="<?php echo base_url();?>home">Home</a></li>
									<li><a href="<?php echo base_url();?>home">Privacy Policy</a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="blog-single section-space">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="blog-single-main">
							<div class="blog-detail">
								<!-- News meta -->
								<ul class="news-meta">
									<li><span><i class="fas fa-pencil-alt"></i> </span><?php echo date('d M Y', strtotime($privacy_res->gs_updated_date)) ?></li>
								</ul>
								<?php echo !empty($privacy_res->privacy_policy) ? $privacy_res->privacy_policy : ''; ?>
								
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</section>

		
		<?php
	}
	if($type == 'termsCondition')
	{
		?>
		<div class="breadcrumbs bread-blog">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<!-- Bread Menu -->
							<div class="bread-menu">
								<ul>
									<!-- <li><a href="<?php echo base_url();?>home">Home</a></li>
									<li><a href="<?php echo base_url();?>home">Terms & Conditions</a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="blog-single section-space">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="blog-single-main">
							<div class="blog-detail">
								<!-- News meta -->
								<ul class="news-meta">
									<li><span><i class="fas fa-pencil-alt"></i> </span><?php echo date('d M Y', strtotime($privacy_res->gs_updated_date)) ?></li>
								</ul>
								<?php echo !empty($privacy_res->term_n_condition) ? $privacy_res->term_n_condition : ''; ?>
								
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</section>

		
		<?php
	}
	if($type == 'vision')
	{
		?>
		<div class="breadcrumbs bread-blog">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<!-- Bread Menu -->
							<div class="bread-menu">
								<ul>
									<!-- <li><a href="<?php echo base_url();?>home">Home</a></li>
									<li><a href="<?php echo base_url();?>home">Vision</a></li>
									<li><a href="<?php echo base_url();?>home"><?php echo !empty($vision_res->vision_title) ? $vision_res->vision_title : ''; ?></a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<section class="blog-single section-space">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="blog-single-main">
							<div class="main-image">
								<img src="<?php echo base_url().$vision_res->vision_img; ?>" alt="#">
							</div>
							<div class="blog-detail">
								<!-- News meta -->
								<ul class="news-meta">
									<li><span><i class="fas fa-pencil-alt"></i> </span><?php echo date('d M Y', strtotime($vision_res->vision_created_date)) ?></li>
								</ul>
								<?php echo !empty($vision_res->vision_long_description) ? $vision_res->vision_long_description : ''; ?>
								
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</section>
		<?php
	}
	?>
	