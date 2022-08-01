<!DOCTYPE html>
<html>
<head>
    <title>CIRCADIAN FOOD</title>
    <style type="text/css">
        
        table{
            border-collapse: collapse;
            margin: 0px auto;
        }
        td,th{
            border: 1px solid lightgrey;
            text-align: center;
            width: 1in;
            height: 0.375in;
        }
        table.table-bordered th, table.table-bordered tbody td {
		    border: 1px solid #ddd !important;
		}
		table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after{
			content: none;
		}
		table.dataTable thead > tr > th {
		    padding: 15px 10px;
		}
		.deleivery_print_head ul {
		    
		}
		.deleivery_print_data ul {
		    list-style: none;
		    display: flex;
		        padding: 0;
		}
    </style>
</head>
<body>
 <div>
    <br>
        <div class="col-md-12" style="text-align: center;">
            <span class="btn btn-sm btn-success" style="border-radius: 21px;" onclick="printInvoice();">Print Sheet</span>
        </div>
        <br>
        <br>
        <br>
    <h2 style="text-align: center;">CIRCADIAN FOOD</h2>
    <div id="print_table">

    	<div class="delievery_print_sheet" style="width: 816px;  margin: 0 auto;">
    		<div class="deleivery_print_head">
    			<ul style="display: table; list-style: none; padding: 0; margin:0; font-size: 14px;">
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 120px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;">Name</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 120px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Phone No.</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 150px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Email</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 95px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Address</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 106px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Number Of Meals</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 106px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Number Of Bags</li>
    				<li style="padding: 10px 15px; border: 1px solid #ccc; width: 95px; font-weight: 700; font-size: 14px; display: table-cell; word-break: break-word; vertical-align: middle;     border-left: none;">Delivery Route</li>
    			</ul>
    		</div>
    		<div class="deleivery_print_data">
                <?php
                if(!empty($delivery_person_res))
                {
                    foreach ($delivery_person_res as $dp_res) 
                    {
                        $order_list = $this->common_model->getData('tbl_order', array('address_route'=>$dp_res->address_route,'delivery_status'=>'Pending'), 'multi');
                        if(!empty($order_list))
                        {   
                            foreach ($order_list as $o_res) 
                            {
                                $bags_count = $this->common_model->getData('tbl_print_bags', array('order_id'=>$o_res->order_id), 'count');
                                $totalQty = $this->order_model->gettotalOrderQty('', $o_res->order_id);
                                $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty('', $o_res->order_id);
                                $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

                                $patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$o_res->patient_id), 'single');
                                /*$address_res = $this->common_model->getData('tbl_address', array('user_id'=>$o_res->patient_id,'address_id'=>$o_res->address_id), 'single');*/
                                $address_res = $this->common_model->getData('tbl_address', array('user_id'=>$o_res->patient_id,'address_id'=>$o_res->address_id), 'single');
                                ?>

                                <div>
                                    <ul style="display: table; list-style: none; padding: 0; margin:0;">
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 120px; display: table-cell; word-break: break-word; vertical-align: middle;"><?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 120px; display: table-cell; word-break: break-word; vertical-align: middle; border-left: none;"><?php echo (!empty($patient_res->user_mobile_no)) ? $patient_res->user_mobile_no : ''; ?></li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 150px; display: table-cell;  word-break: break-word; vertical-align: middle; border-left: none;"><?php echo (!empty($patient_res->user_email)) ? $patient_res->user_email : ''; ?> </li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 95px; display: table-cell;  word-break: break-word; vertical-align: middle; border-left: none;"><?php 
                                        if($o_res->label_type == 'Pickup')
                                        {
                                            echo "Pickup";
                                        }
                                        else
                                        {
                                            echo (!empty($o_res->user_address)) ? $o_res->user_address : ''; 
                                        }
                                        ?></li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 106px; display: table-cell; word-break: break-word; vertical-align: middle; border-left: none;"><?php echo $toTalQTY; ?></li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 106px; display: table-cell; word-break: break-word; vertical-align: middle; border-left: none;"><?php echo $bags_count; ?></li>
                                        <li style="padding: 10px 15px; border: 1px solid #ccc; width: 95px; display: table-cell; word-break: break-word; vertical-align: middle; border-left: none;"><?php echo (!empty($o_res->address_route)) ? $o_res->address_route : ''; ?></li>
                                    </ul>
                                    <div class="notes_div" style="text-align: left; border: 1px solid #ccc; padding: 10px 15px; border-top: none;">
                                        <strong>Notes:</strong> 
                                        <p style="margin: 0;"><?php echo (!empty($o_res->note)) ? $o_res->note : ''; ?></p>
                                    </div>         
                                </div>
                                <?php

                            }
                        }

                    }
                }
                ?>



    		</div>
    	</div>
	</div>
</div>

<br>
<br>
</body>
</html>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        function printInvoice()
        {
            var divToPrint=document.getElementById('print_table');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            /*newWin.document.write('<style type="text/css">html, body, tbody, tfoot, thead, tr, th, td,body{margin:0px !important;margin-bottom:0px !important;}*{box-sizing:border-box;}@font-face {font-family: verdanab;src: url("fonts/verdanab.ttf");}@font-face {font-family: verdana;src: url("fonts/verdana.ttf");}p{font-family:verdana;}tbody{display: block;}</style>');*/
            newWin.document.close();
        }
    </script>
