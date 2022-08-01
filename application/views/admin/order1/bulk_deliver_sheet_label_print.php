<style type="text/css" media="all">
	*{
		box-sizing: border-box;
	}
	body{
		margin: 0px;
		padding: 0px;
		background-color: #fff;
	}
	ul{
		padding: 0px;
		list-style: none;
	}
	td{
		padding: 0;
		margin: 0;
	}
	button, input, select, textarea {
		font-family: inherit;
		font-size: inherit;
		line-height: inherit;
	}
	@font-face {
		font-family: verdanab;
		src: url("fonts/verdanab.ttf");
	}
	@font-face {
		font-family: verdana;
		src: url("fonts/verdana.ttf");
	}

	p{
		word-break: break-word;
	}



	table{
		border-spacing: 0;
	}

	tbody{
		/*display: block;*/
	}

	@media print{
		*{
			box-sizing: border-box;
		}

	}
</style>
		<br>
		<div class="col-md-12" style="text-align: center;">
			<span class="btn btn-sm btn-success" style="border-radius: 21px;" onclick="printInvoice();">Print Sheet</span>
		</div>
		<br>
		<br>
		<br>
		<div id="print_table" style="max-width: 793px;margin: auto;border: 1px solid #ddd;text-align:center;min-height: 1122px;">
			<?php
			if(!empty($delivery_person_res))
			{
				foreach ($delivery_person_res as $dp_res) 
				{
					$order_list = $this->common_model->getData('tbl_order', array('user_address'=>$dp_res->user_address,'delivery_status'=>'Pending'), 'single');
					if(!empty($order_list))
		            { 	
		            	$bags_count = $this->common_model->getData('tbl_print_bags', array('order_id'=>$order_list->order_id), 'count');
		            	$totalQty = $this->order_model->gettotalOrderQty('', $order_list->order_id);
	                    $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty('', $order_list->order_id);
	                    $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;

		            	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$order_list->patient_id), 'single');
	            		?>
	            		<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 0px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 100%;max-width: 793px;padding:45px 11px 45px 19px ;background-color: #f2f2f2;">
							<tbody style="display: block;">
								<tr>
									<td align="center" style="height:128px">
										<div style="width: 430px;height: 215px;border:1px solid #ddd;border-radius: 6px;margin:auto 0;background-color:#ffffff;text-align:left;padding:6px;font-family: verdana;margin-right: 8px;">
											<div style="margin-top:0px;margin-left: 0px;line-height: 1;margin-right: 100px;height: 48px;">
												
											</div>
											<div style="width: 95px;margin-top: -48px;height: 48px;margin-left: 265px;line-height: 1;text-align: right;">
												<img src="<?php echo base_url(); ?>webroot/login/logo.jpg" width="100%">
											</div>
											<div style="margin-top:5px;">
												<br>
											</div>
											<div style="margin-top: -40px;">
												<table style="font-size: 16px;">
													<tr>
														<th style="padding-right: 60px;" >Client Name</th>
														<td ><?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></td>
													</tr>
													<tr>
														<th style="padding-right: 60px;" >Phone Number</th>
														<td ><?php echo (!empty($patient_res->user_mobile_no)) ? $patient_res->user_mobile_no : ''; ?></td>
													</tr>
													<tr>
														<th style="padding-right: 60px;" >Address</th>
														<td><?php 
														if($order_list->label_type == 'Pickup')
														{
															echo "Pickup";
														}
														else
														{
															echo (!empty($dp_res->user_address)) ? $dp_res->user_address : ''; 
														}
														?></td>
													</tr>
													<tr>
														<th style="padding-right: 60px;" >Order Note</th>
														<td ><?php echo (!empty($order_list->note)) ? $order_list->note : ''; ?></td>
													</tr>
													<tr>
														<th style="padding-right: 60px;" >Number Of Meals</th>
														<td ><?php echo $toTalQTY; ?></td>
													</tr>
													<tr>
														<th style="padding-right: 60px;" >Number Of Bags</th>
														<td ><?php echo $bags_count; ?></td>
													</tr>
												</table>

											</div>
										</div>
										<hr> 
									</td>
								</tr>
        					</tbody>				
						</table>
	            		<?php
		            }

				}
			}
			?>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">
		function printInvoice()
		{
			var divToPrint=document.getElementById('print_table');
			var newWin=window.open('','Print-Window');
			newWin.document.open();
			newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
			newWin.document.write('<style type="text/css">html, body, tbody, tfoot, thead, tr, th, td,body{margin:0px !important;margin-bottom:0px !important;}*{box-sizing:border-box;}@font-face {font-family: verdanab;src: url("fonts/verdanab.ttf");}@font-face {font-family: verdana;src: url("fonts/verdana.ttf");}p{font-family:verdana;}tbody{display: block;}</style>');
			newWin.document.close();
    	}
	</script>