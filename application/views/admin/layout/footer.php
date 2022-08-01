        </div>
        <script src="<?php echo base_url(); ?>webroot/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/js/bootbox.min.js"></script>      
        <script src="<?php echo base_url(); ?>webroot/js/app.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/js/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>webroot/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/plugins/fullcalendar/fullcalendar.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>webroot/js/dataencrypt.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>webroot/js/bootstrap-select.min.js"></script>
        <script src="<?php echo base_url(); ?>webroot/js/summernote-bs4.js"></script>
        <script src="<?php echo base_url(); ?>webroot/js/nestable/jquery.nestable.js"></script>
        <script src="<?php echo base_url();?>webroot/js/toster.min.js"></script>
        <script type="text/javascript">
            $("#msg_div").fadeOut(10000);  
            $(function(){            
                $( ".current_date_val" ).datepicker({
                    dateFormat : 'yy-mm-dd',
                    changeMonth : true,
                    changeYear : true,  
                    minDate:new Date(),      
                });
                $( ".date_val" ).datepicker({
                    dateFormat : 'yy-mm-dd',
                    changeMonth : true,
                    changeYear : true,  
                });
                $(".timepicker").timepicker({
                    showInputs: false,
                    minuteStep: 5,
                    showMeridian: false,
                });
                $.fn.dataTable.ext.errMode = 'none';
                $('#example').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
                $('#example_new').DataTable({
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false
                });
                $('#example_scroll').DataTable({
                   "paging": false,
                   "lengthChange": false,
                   "searching": false,
                   "ordering": false,
                   "info": false,
                   "autoWidth": false,
                   "scrollX": true
                });
            });
            $(document).ready(function(){
                $('.summernote').summernote({
                    height: '200px',
                    placeholder: 'text here....',
                    fontNames: ['Arial', 'Arial Black', 'Khmer OS'],
                });
                $("#content").summernote();
                $('.dropdown-toggle').dropdown();

            });
            $.validate({
                modules : 'date, security, file',
                onModulesLoaded : function() {}
            });
            var table = $('.box-body').find('table');
            if(!table.parent('div').hasClass('table-responsive')){
                table.wrap('<div class="table-responsive"></div>');
            }
            if($('table thead tr').hasClass('label-primary'));{
                $('table thead tr').removeClass('label-primary')
            }
        </script>
        <script type="text/javascript" src="<?php echo base_url();?>webroot/plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
            selector: "textarea.tiny_textarea",
            plugins :"advlist autolink link image lists charmap print preview code fullscreen textcolor table media",
            tools: "inserttable", 
            relative_urls: false,
            toolbar: [ "undo redo | styleselect | bold italic | link image | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify  forecolor backcolor | fontsizeselect | sizeselect | fontselect", ]
            });
            tinymce.init({
                // fontsize_formats: "1pt 2pt 3pt 4pt 5pt 6pt 7pt",
                selector: "textarea.tiny_textarea_disabled",
                relative_urls: false,            
                readonly : 1
            });     
            var table = $('.box-body').find('table');
            if(!table.parent('div').hasClass('table-responsive')) 
            {
                table.wrap('<div class="table-responsive"></div>');
            }
            if($('table thead tr').hasClass('label-primary'));
            {
                $('table thead tr').removeClass('label-primary')
            }
        </script>
        


    </body>
</html>