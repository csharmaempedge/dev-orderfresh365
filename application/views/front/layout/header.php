<!doctype html>

<html lang="en">

<head>

    <?php

    $seo_res = $this->common_model->getData('cm_seo', NULL, 'single');

    $home_pages_res = $this->common_model->getData('cm_home_page', NULL, 'single');

    if(!empty($seo_res))

    {

        ?>

        <meta charset="utf-8">

        <meta name="robots" content="noindex" />

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="<?php echo $seo_res->seo_description; ?>">

        <meta name="keywords" content="<?php echo $seo_res->seo_keyword; ?>">

        <meta name = "format-detection" content = "telephone=no">

        

        <title><?php echo $seo_res->seo_title; ?></title>

        <?php

    }

    ?>

    <!-- <link rel="icon" href="demo_icon.gif" type="image/gif" sizes="16x16"> -->

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/light-box.css">

    <!-- Owl Carousel -->

    <link  href="<?php echo base_url();?>webroot/front/assets/css/owl.carousel.min.css" rel="stylesheet">

    <link  href="<?php echo base_url();?>webroot/front/assets/css/owl.theme.default.min.css" rel="stylesheet">



    <!-- Wow -->

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/animate.css">

    



    <!-- Font Awesome 5 -->

    <script defer src="<?php echo base_url();?>webroot/front/assets/js/all.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/all.min.css">

    <link href="<?php echo base_url();?>webroot/front/assets/DataTables/datatables.min.css" rel="stylesheet">

    <link href="<?php echo base_url();?>webroot/front/assets/DataTables/Responsive-2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet">

    <link href="<?php echo base_url();?>webroot/front/assets/DataTables/FixedHeader-3.1.6/css/fixedHeader.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/ss-custom.css">

    <link rel="stylesheet" href="<?php echo base_url();?>webroot/front/assets/css/ss-responsive.css">

    <!-- Google Fonts -->

    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700|Poppins:400,500,600,700&display=swap" rel="stylesheet"> -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,500i,700,900&display=swap" rel="stylesheet">


    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRzUFxKZlyVppkwsQEYqo3wPLqQw5W1SY&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
    <title><?php echo $seo_res->seo_title; ?></title>

</head>
<style type="text/css">
    #map {
      height: 400px;
      width: 100%;
    }
</style>
<body>

    <form style="position: relative;">

        <div class="search_abso">

            <div class="text-center">

                <input autocomplete="off" type="text" name="" id="search_page_keyword" placeholder="Search - Keyword, Phrase & Hit Enter" autofocus id="search_input" >

            </div>

            <div class="search_page_list_frame">



                <ul id="search_page_list_dynamic">

                

                </ul>

            </div>

            <span class="close_bar">

                <img src="<?php echo base_url();?>webroot/front/assets/images/icons/close.svg" alt="Close Button" />

            </span>   

        </div>

        </form>

    <div class="sec-nav  <?= (($this->uri->segment(1) == 'home') || ($this->uri->segment(1) == '')) ? 'fixed-top' : ''; ?>">

        <nav class="navbar navbar-expand-lg navbar-light">

            <div class="container">

                <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo (!empty($home_pages_res->logo)) ? base_url().$home_pages_res->logo : ''; ?>" alt=""></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item <?= (($this->uri->segment(1) == 'home') || ($this->uri->segment(1) == '')) ? 'active' : ''; ?>">

                            <a class="nav-link" href="<?php echo base_url();?>">Home</a>

                        </li>



                        <!-- <li class="nav-item <?= (($this->uri->segment(1) == 'about')) ? 'active' : ''; ?>">

                            <a class="nav-link" href="<?php echo base_url();?>about">About</a>

                        </li>

                        <li class="nav-item <?= (($this->uri->segment(1) == 'contactUs')) ? 'active' : ''; ?>">

                            <a class="nav-link" href="<?php echo base_url();?>contactUs">Contact Us </a>

                        </li> -->

                        <li class="nav-item <?= (($this->uri->segment(1) == 'user')) ? 'active' : ''; ?>">

                            <a class="nav-link" href="<?php echo base_url();?>user">Register </a>

                        </li>

                        <li class="nav-item <?= (($this->uri->segment(1) == 'login')) ? 'active' : ''; ?>">

                            <a class="nav-link" href="<?php echo base_url();?>login">Login </a>

                        </li>

                        

                    </ul>

                </div>

            </div>

        </nav>

    </div>



