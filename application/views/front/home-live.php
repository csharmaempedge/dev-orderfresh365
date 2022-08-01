<?php
$home_banner_res = $this->common_model->getData('cm_home_banner', array('home_banner_status'=>'1'), 'multi');
$mission_res = $this->common_model->getData('cm_mission', array('mission_status'=>'1'), 'multi');
$vision_res = $this->common_model->getData('cm_vision', array('vision_status'=>'1'), 'multi');
$community_res = $this->common_model->getData('cm_community', array('community_status'=>'1','community_id'=>'1'), 'single');
$home_pages_res = $this->common_model->getData('cm_home_page', NULL, 'single');
?>
<!-- SLIDER SECTION -->
	<section class="sec-banner">
		<div class="container" style="max-width: 1283px;">
			<div id="carouselExampleIndicators" class="blog-latest home owl-carousel owl-theme" data-ride="carousel">
				<?php
					if(!empty($home_banner_res))
					{
						$i=1;
						foreach($home_banner_res as $hb_val)
						{
							?>
							<div class="carousel-inner">
								<div class="carousel-item active bg-overlay">
									<img class="d-block w-100" src="<?php echo base_url().$hb_val->home_banner_img_name; ?>" alt="First slide">
									<div class="carousel-caption">
										<div>
											<h4 style="color: #f3a712;"><?php echo !empty($hb_val->home_banner_heading) ? $hb_val->home_banner_heading : ''; ?></h4>
											<h2><?php echo !empty($hb_val->banner_description) ? $hb_val->banner_description : ''; ?></h2>
										</div>
									</div>
								</div>
							</div>
							<?php
							$i++;
						}
					}
				?>
			</div>
		</div>
	</section>
	<!-- NEWS SECTION -->
	<!-- <section class="sec_notification">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="notification">
						<marquee scrollamount="4" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
							<ul class="list-inline">
								<li><span class="new">
								<?php 
								if(!empty($news_res)){
									$count =0;
									foreach($news_res as $n_res){
										?> 
										<img src="<?php echo base_url();?>webroot/front/assets/images/new.gif"></span>
											<a href="#">
												<?php echo !empty($n_res->news_small_description) ? $n_res->news_small_description : ''; ?>
											</a>
										<?php
										$count++;
									}
								}
								?>
								</li>&nbsp;
							</ul>
						</marquee>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- OUR MISSION SECTION -->
	<section class="latest-blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
					<div class="section-title default text-center">
						<div class="section-top">
							<h1><span>Latest</span><b> Our Mission</b></h1>
						</div>
						<div class="section-bottom">
							<div class="text">
								<p>Provide innovative, timely, and quality medical services & SK Health services provide a quality work environment that fosters unity, respect for diversity, teamwork and professional growth. We are committed to serve</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="blog-latest blog-latest-slider owl-carousel owl-theme">

						<?php
							if(!empty($mission_res))
							{
								$i=1;
								foreach($mission_res as $m_res)
								{
									?>

									<div class="single-news ">
										<div class="news-head overlay">
											<span class="news-img" style="background-image:url('<?php echo base_url().$m_res->mission_img; ?>')"></span>
											<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'mission'.'/'.$m_res->mission_id; ?>" class="ss-btn theme-2">Read more</a>
										</div>
										<div class="news-body">
											<div class="news-content">
												<h3 class="news-title"><a href="<?php echo base_url();?>home/commonFullView/<?php echo 'mission'.'/'.$m_res->mission_id; ?>"><?php echo !empty($m_res->mission_title) ? $m_res->mission_title : ''; ?></a></h3>
												<div class="news-text"><p><?php echo !empty($m_res->mission_small_description) ? $m_res->mission_small_description : ''; ?></p></div>
												<ul class="news-meta">
													<li class="date"><span><i class="fa fa-calendar"></i></span><?php echo date('d M', strtotime($m_res->mission_created_date)) ?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php
									$i++;
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- JANTA PARTY SECTION -->

	<section class="sec-about side overlay">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="pr-4">
						<img src="<?php echo (!empty($home_pages_res->home_page_img)) ? base_url().$home_pages_res->home_page_img : ''; ?>" class="w-100">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="about-main">
						<div class="title">
							<h2><?php echo (!empty($home_pages_res->home_page_title)) ? $home_pages_res->home_page_title : ''; ?> </h2>
							<?php echo (!empty($home_pages_res->home_page_small_description)) ? $home_pages_res->home_page_small_description : ''; ?>
							<div class="my-4">
								<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'home_page'.'/'.$home_pages_res->home_page_id; ?>" class="ss-btn theme-2">Know More</a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- OUR AGENDA -->
	<!-- <section class="sec-challenge section-space" >
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title text-center">
						<div class="section-top">
							<h1><span>M & V</span></h1>
							<h2>Mission and&nbsp;<span>Vision</span></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="challenge-frame">
						<?php
						if(!empty($mission_res))
						{
							$i=1;
							foreach($mission_res as $ag_res)
							{
								?>
								<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'mission'.'/'.$ag_res->mission_id; ?>" class="challenge-box">
									<div class="challenge-box-img" style="background-image: url('<?php echo base_url().$ag_res->mission_img; ?>');"></div>

									<div class="challenge-details">
										<h2><?php echo !empty($ag_res->mission_title) ? $ag_res->mission_title : ''; ?></h2>
									</div>
								</a>
								<?php
								$i++;
							}
						}
						if(!empty($vision_res))
						{
							$i=1;
							foreach($vision_res as $ag_res)
							{
								?>
								<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'vision'.'/'.$ag_res->vision_id; ?>" class="challenge-box">
									<div class="challenge-box-img" style="background-image: url('<?php echo base_url().$ag_res->vision_img; ?>');"></div>

									<div class="challenge-details">
										<h2><?php echo !empty($ag_res->vision_title) ? $ag_res->vision_title : ''; ?></h2>
									</div>
								</a>
								<?php
								$i++;
							}
						}
						?>
					</div>

					<!-- <div class="text-center">
						<a href="#" class="ss-btn theme-2">Connect your startup</a>
					</div> -->
				</div>
			</div>
		</div>
	</section> -->

	<!-- JANTA PARTY HD IMAGES -->
	<!-- <section class="sec-adv-banner">
		<div class="sec-adv-banner-img">
			<img src="<?php echo (!empty($home_pages_res->janta_party_img)) ? base_url().$home_pages_res->janta_party_img : ''; ?>" class="img-fluid">
		</div>
	</section> -->

	<!-- EVENT SECTION -->
	<!-- <section class="latest-blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
					<div class="section-title default text-center">
						<div class="section-top">
							<h1><span>Latest</span></h1>
							<h2 class="csi-heading text-success" style="box-sizing: border-box; font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d; margin-top: 0px; margin-bottom: 6.8rem; font-size: 3.2rem; text-align: center; background-color: #f1f1f1;">Latest&nbsp;<span style="box-sizing: border-box; color: #f48123;">EVENT</span></h2>
						</div>
						<div class="section-bottom">
							<div class="text">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="blog-latest blog-latest-slider owl-carousel owl-theme">

						<?php
							if(!empty($event_res))
							{
								$i=1;
								foreach($event_res as $m_res)
								{
									?>

									<div class="single-news ">
										<div class="news-head overlay">
											<span class="news-img" style="background-image:url('<?php echo base_url().$m_res->event_img; ?>')"></span>
											<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'event'.'/'.$m_res->event_id; ?>" class="ss-btn theme-2">Read more</a>
										</div>
										<div class="news-body">
											<div class="news-content">
												<h3 class="news-title"><a href="<?php echo base_url();?>home/commonFullView/<?php echo 'event'.'/'.$m_res->event_id; ?>"><?php echo !empty($m_res->event_title) ? $m_res->event_title : ''; ?></a></h3>
												<div class="news-text"><p><?php echo !empty($m_res->event_small_description) ? $m_res->event_small_description : ''; ?></p></div>
												<ul class="news-meta">
													<li class="date"><span><i class="fa fa-calendar"></i></span><?php echo date('d M', strtotime($m_res->event_created_date)) ?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php
									$i++;
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section> -->

	<!-- COMMUNITY MEMBER -->
	<!-- <section class="team  section-bg section-space">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title  text-center">
						<div class="section-top">
							<h1><span>Professional</span></h1>
							<h2 class="csi-heading text-success" style="box-sizing: border-box; font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d; margin-top: 0px; margin-bottom: 3.8rem; font-size: 3.2rem; text-align: center; background-color: #f1f1f1;">&nbsp;<span style="box-sizing: border-box; color: #f48123;">Teams</span></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<section class="sec-adv-banner">
			<div class="sec-adv-banner-img" style="text-align: center;">
				<div class="team-head">
					<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'community'.'/'.$community_res->community_id; ?>"><img class="mentor-img" src="<?php echo base_url().$community_res->community_img; ?>" alt="dharmesh-barodiya" /></a>
				</div>
				<div class="t-content">
					<div class="team-arrow">
						<a><i class="fa fa-angle-up"></i></a>
					</div>
					<div class="content-inner">
						<h4 class="name"><a href="<?php echo base_url();?>home/commonFullView/<?php echo 'community'.'/'.$community_res->community_id; ?>"><?php echo !empty($community_res->community_title) ? $community_res->community_title : ''; ?></a></h4>
						<span class="designation"><?php echo !empty($community_res->community_small_description) ? $community_res->community_small_description : ''; ?></span>
					</div>

				</div>
			</div>
		</section>
	</section> -->
	<!-- OUR MISSION SECTION -->
	<section class="latest-blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
					<div class="section-title default text-center">
						<div class="section-top">
							<h1><span>Latest</span><b> Our Vision</b></h1>
						</div>
						<div class="section-bottom">
							<div class="text">
								<p>The trusted health partners — empowering health, impacting lives.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="blog-latest blog-latest-slider owl-carousel owl-theme">

						<?php
							if(!empty($vision_res))
							{
								$i=1;
								foreach($vision_res as $m_res)
								{
									?>

									<div class="single-news ">
										<div class="news-head overlay">
											<span class="news-img" style="background-image:url('<?php echo base_url().$m_res->vision_img; ?>')"></span>
											<a href="<?php echo base_url();?>home/commonFullView/<?php echo 'vision'.'/'.$m_res->vision_id; ?>" class="ss-btn theme-2">Read more</a>
										</div>
										<div class="news-body">
											<div class="news-content">
												<h3 class="news-title"><a href="<?php echo base_url();?>home/commonFullView/<?php echo 'vision'.'/'.$m_res->vision_id; ?>"><?php echo !empty($m_res->vision_title) ? $m_res->vision_title : ''; ?></a></h3>
												<div class="news-text"><p><?php echo !empty($m_res->vision_small_description) ? $m_res->vision_small_description : ''; ?></p></div>
												<ul class="news-meta">
													<li class="date"><span><i class="fa fa-calendar"></i></span><?php echo date('d M', strtotime($m_res->vision_created_date)) ?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php
									$i++;
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--JANTA PARTY HD IMAGES -->
	<section class="sec-adv-banner">
		<div class="sec-adv-banner-img">
			<img src="<?php echo (!empty($home_pages_res->janta_party_img)) ? base_url().$home_pages_res->janta_party_img : ''; ?>" class="img-fluid">
		</div>
	</section>
	