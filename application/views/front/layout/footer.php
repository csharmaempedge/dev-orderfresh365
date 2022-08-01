<footer class="footer">

        <!-- <div class="waveWrapper">

            <div class="footer-wave waveTop"></div>

        </div> -->

        <!-- Footer Top -->

        <div class="footer-top">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-6 col-12">

                        <!-- Footer About -->

                        <div class="single-widget footer-about widget">

                            <!-- <h3 class="widget-title">About&nbsp;</h3>

                            <div class="footer-widget-about-description">

                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing. </p>

                            </div> -->

                        </div>

                        <!--/ End Footer About -->

                    </div>

                    <div class="col-lg-4 col-md-6 col-12">

                        <!-- Footer Links -->

                        <!-- <div class="single-widget f-link widget">

                            <h3 class="widget-title">Useful Links</h3>

                            <ul class="list-unstyled">

                                <li><a href="<?php echo base_url(); ?>">Home</a></li>

                                <li><a href="<?php echo base_url();?>home/commonFullView/privacyPolicy/1">Privacy Policy</a></li>

                                <li><a href="<?php echo base_url();?>home/commonFullView/termsCondition/1">Terms & Conditions</a></li>



                            </ul>

                        </div> -->

                        <!--/ End Footer Links -->

                    </div>

                    <div class="col-lg-4 col-md-6 col-12">

                        <!-- Footer Contact -->

                        <div class="single-widget footer_contact widget">

                            <h3 class="widget-title">Contact Us</h3>

                            <ul class="address-widget-list mb-5">

                                <li class=""><span><i class="fa fa-phone"></i></span>704-507-3099</li>

                                <li class=""><span><i class="fa fa-envelope"></i></span>orders@circadianfood365.com </li>

                            </ul>

                        </div>

                        <!--/ End Footer Contact -->

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

                    <div class="col-12">

                        <div class="text-center">

                            <div class="social">

                                <ul class="social-icons">

                                    <li><a class="facebook" href="#" target="_blank"><i class="fab fa-facebook"></i></a></li>

                                    <li><a class="twitter" href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>

                                    <li><a class="linkedin" href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>

                                    <!-- <li><a class="pinterest" href="#" target="_blank"><i class="fab fa-pinterest-p"></i></a></li> -->

                                    <li><a class="instagram" href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

        <!-- Copyright -->

        <div class="copyright">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <div class="copyright-content">

                            <!-- Copyright Text -->

                            <p class="csi-heading text-success" style="line-height: 2.8rem; color: #3c763d;">&copy; Powerd By  &nbsp;<a target="_blank" href="https://orderfresh365.com"><span style="box-sizing: border-box; color: #f48123;">Circadian Food &nbsp;</a>  <script>document.write(new Date().getFullYear());</script>&nbsp; All Right Reserved</span></p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!--/ End Copyright -->

    </footer>

    <script src="<?php echo base_url();?>webroot/front/assets/js/jquery-3.3.1.slim.min.js"></script>

    <script src="<?php echo base_url();?>webroot/front/assets/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo base_url();?>webroot/front/assets/js/jquery-3.4.1.min.js"></script>

    <script src="<?php echo base_url();?>webroot/front/assets/js/light-box.js"></script>

    <script src="<?php echo base_url();?>webroot/front/assets/js/owl.carousel.min.js"></script>

    <script src="<?php echo base_url();?>webroot/front/assets/js/wow.min.js"></script>

    <script src="<?= base_url();?>webroot/front/assets/DataTables/datatables.min.js"></script>

    <script src="<?= base_url();?>webroot/front/assets/DataTables/Responsive-2.2.3/js/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url();?>webroot/front/assets/DataTables/FixedHeader-3.1.6/js/fixedHeader.bootstrap4.js"></script>

    <script src="<?= base_url();?>webroot/front/assets/js/bootstrap.min.js"></script>



    <script>

        new WOW().init();

    </script>

        <script type="text/javascript">

            $("#msg_div").fadeOut(10000);

                $(document).ready(function() {

                    $('#job_tbl').DataTable({

                        fixedHeader: true,

                        searching: false,

                        ordering: false,

                        paging: false,

                        bInfo: false,

                        

                        

                        

                    });

                });

            </script>



    <script>

        $(function(){



        $(document).on('change', '#chat_message', function()

        {         

            $chat_message = $('#chat_message').val();

            addChat($chat_message);

        });





    });

    function  addChat(chat_message)

    {

        var reciver_id      = $('#reciver_id').val();

        var str = 'reciver_id='+reciver_id+'&chat_message='+chat_message+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        var PAGE = '<?php echo base_url(); ?>chat/addChat';



        jQuery.ajax({



            type :"POST",



            url  :PAGE,



            data : str,



            success:function(data)

            {        

                $('#chat_message').val('');

                $('#chat_message').focus();

                console.log(data);

            } 



        });



    }

        $(document).on("click", '[data-toggle="lightbox"]', function(event) {

            event.preventDefault();

            $(this).ekkoLightbox();

        });

        $(".chatbox-close").click(function(){

            $(this).parent(".fixed-chat-box").toggleClass("hide-box");

            $(this).toggleClass("closechat");

        });



        $(".team-arrow").click(function(){

            $(this).parents(".single-team").toggleClass('active');

        });

        $('.search_open').click(function(){

                    $('body').find('.search_abso').addClass('translateY');

                    $( "#search_input" ).focus();

                });

        $('.close_bar').click(function(){

            $('body').find('.search_abso').removeClass('translateY');

            $("#search_page_keyword").val('');

            $("#search_page_list_dynamic li").text('');

        });



        function search_menu(keyword){

        var limit=10;

        var PAGE = '<?php echo base_url('home/search_menu')?>';

        jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data :{'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',limit:limit,keyword:keyword}, 

            success:function(response)

            {   

                if(response != '')

                {

                    $('#search_page_list_dynamic').html(response);

                }

            } 

        });

    }



    $("#search_page_keyword" ).keyup(function(){

        var keyword = $('#search_page_keyword').val();

        if(keyword.length > 1){

            search_menu(keyword);

        }

        else{

            $('#search_page_list_dynamic').html('');



        }

    });

    $(".input_holder input#search_page_keyword").keyup(function(){

        var keyword = $('#search_page_keyword').val();

        if(keyword.length > 2){

            $(".search_page_list_frame").addClass("visible");   

        }

        else{

            $(".search_page_list_frame").removeClass("visible");

        }

    });

        $(window).scroll(function(){

            scroll = $(window).scrollTop();



            if ($(window).width() > 280) {

                if (scroll >= 50) {

                    $(".sec-nav ").addClass("bg-white navbar-boxshadow");

                }

                else

                {

                    $(".sec-nav ").removeClass("bg-white navbar-boxshadow");

                }

            };

        });



        getShowMember('nation');

        function getShowMember(str) 

        {

            if(str == 'nation')

            {

                $('.nation_member').show();

                $('.state_member').hide();

            }

            else

            {

                $('.nation_member').hide();

                $('.state_member').show();

            }

        }



    </script>



    <script>



        $('.clients').owlCarousel({

            loop: true,

            nav: false,

            dots:false,

            smartSpeed:1500,

            autoplay:true,

            autoplayTimeout:2000,

            autoplayHoverPause:true,

            lazyLoad: true,

            margin: 24,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    loop: true,

                    margin: 10,

                },

                375: {

                    items: 2,

                    margin: 10,

                },

                560: {

                    items: 4,

                },



                1200: {

                    items: 5,

                }

            }

        });







        $('.team-carousel').owlCarousel({

            loop: true,

            nav: false,

            dots:true,

            smartSpeed:1200,

            autoplay:true,

            autoplayTimeout:3000,

            autoplayHoverPause:true,

            center:false,

            navText: [

            '<i class="fa fa-angle-left" aria-hidden="true"></i>',

            '<i class="fa fa-angle-right" aria-hidden="true"></i>'

            ],

            lazyLoad: true,

            margin: 0,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    dots:false,

                },

                768: {

                    items: 2,

                },



                992: {

                    items: 3,

                },

                1200: {

                    items: 6,

                }

            }

        });





        $('.team-carousel-1').owlCarousel({

            loop: true,

            nav: false,

            dots:true,

            smartSpeed:1200,

            autoplay:true,

            autoplayTimeout:4000,

            autoplayHoverPause:true,

            center:false,

            navText: [

            '<i class="fa fa-angle-left" aria-hidden="true"></i>',

            '<i class="fa fa-angle-right" aria-hidden="true"></i>'

            ],

            lazyLoad: true,

            margin: 0,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    dots:false,

                },

                768: {

                    items: 2,

                },



                992: {

                    items: 3,

                },

                1200: {

                    items: 6,

                }

            }

        });







        $('.team-carousel-2').owlCarousel({

            loop: true,

            nav: false,

            dots:true,

            smartSpeed:1200,

            autoplay:false,

            autoplayTimeout:3500,

            autoplayHoverPause:true,

            center:true,

            navText: [

            '<i class="fa fa-angle-left" aria-hidden="true"></i>',

            '<i class="fa fa-angle-right" aria-hidden="true"></i>'

            ],

            lazyLoad: true,

            margin: 0,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    dots:false,

                },

                768: {

                    items: 2,

                },



                992: {

                    items: 3,

                },

                1200: {

                    items: 4,

                },

                1400: {

                    items: 5,

                }

            }

        });







        $('.blog-latest-slider').owlCarousel({

            loop: true,

            nav: true,

            dots:false,

            smartSpeed:1200,

            autoplay:true,

            autoplayTimeout:2000,

            autoplayHoverPause:true,

            

            navText: [

            '<i class="fa fa-angle-left" aria-hidden="true"></i>',

            '<i class="fa fa-angle-right" aria-hidden="true"></i>'

            ],

            lazyLoad: true,

            margin: 24,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    loop: false,

                    margin: 10,

                    nav: false,

                    dots:false,

                },

                768: {

                    items: 1,

                },

                

                992: {

                    items: 2,

                }

            }

        });



        $('.home').owlCarousel({

            loop: true,

            nav: false,

            dots:true,

            smartSpeed:1200,

            autoplay:true,

            autoplayTimeout:2000,

            autoplayHoverPause:true,

            

            navText: [

            '<i class="fa fa-angle-left" aria-hidden="true"></i>',

            '<i class="fa fa-angle-right" aria-hidden="true"></i>'

            ],

            lazyLoad: true,

            margin: 24,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    dots:false,

                },

                768: {

                    items: 1,

                },



                992: {

                    items: 1,

                },

                1200: {

                    items: 1,

                },

                1400: {

                    items: 1,

                }

            }

        });

    </script>

    </script>

    <script type="text/javascript">

        function  getStateListByCountryID(country_id){

        var str = 'country_id='+country_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';

        var PAGE = '<?php echo base_url(); ?>admin/common/getStateListByCountryID';

        jQuery.ajax({

            type :"POST",

            url  :PAGE,

            data : str,

            success:function(data){        

                $('#state_id').html(data);

            } 

        });

    } 

    </script>

</body>

</html>