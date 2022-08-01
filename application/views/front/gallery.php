	
		<section class="breadcrumbs overlay" style="background-image: url(<?php echo base_url();?>webroot/front/assets/images/breadcrumb.jpg);">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<!-- Bread Menu -->
						<div class="bread-menu">
							<ul>
								<li><a href="<?php echo base_url();?>home">Home</a></li>
								<li><a href="<?php echo base_url();?>gallery">Gallery</a></li>
							</ul>
						</div>
						<!-- Bread Title -->
						<div class="bread-title"><h2 class="csi-heading text-success" style="font-family: 'Playfair Display', serif; line-height: 2.8rem; color: #3c763d;">Gall<span style="box-sizing: border-box; color: #f48123;">ery</span></h2></div>
					</div>
				</div>
			</div>
		</div>
	</section>
		<section class="team  section-bg section-space">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="section-title  style2 text-center">
								<div class="section-top">
									<h1><span>photos</span><b>PHOTOS</b></h1><h4>Our experts leaders are waiting for you.</h4>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="gallery-box">
								<?php
									if(!empty($portfolio_img_res))
									{
										foreach($portfolio_img_res as $po_res)
										{
											?>
											<div class="gallery-item">
											<a href="<?php echo base_url().$po_res->portfolio_images; ?>" data-toggle="lightbox" data-gallery="gallery">
												<img src="<?php echo base_url().$po_res->portfolio_images; ?>" class="img-fluid">
											</a>
										</div>
											<?php
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
	