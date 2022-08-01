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
			if(!empty($order_res))
			{
				foreach ($order_res as $op_res) 
				{
					$order_list = $this->common_model->getData('tbl_order_product', array('patient_id'=>$op_res->patient_id,'order_id'=>$op_res->order_id), 'multi');
					if(!empty($order_list))
		            { 
		            	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$op_res->patient_id), 'single');
	            		$row_count = 1;
	            		foreach ($order_list as $p_val) {
	            			for ($i=0; $i<$p_val->qty; $i++)
							{
	            			if($row_count == 1){
	            				?>
	            				<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 0px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 100%;max-width: 793px;padding:45px 11px 45px 19px ;background-color: #f2f2f2;">
									<tbody style="display: block;">
										<tr <?php echo $row_count.'--A'; ?>>
	            				<?php
	            			}
	            			?>
		            			<td align="center" style="height:128px">
									<div style="width: 374px;height: 128px;border:1px solid #ddd;border-radius: 6px;margin:auto 0;background-color:#ffffff;text-align:left;padding:6px;font-family: verdana;margin-right: 8px;">
										<div style="margin-top:0px;margin-left: 0px;line-height: 1;margin-right: 100px;height: 48px;">
											<font style="font-size: 11px"><p style="margin: 0 0px 3px ;"><b>Client&nbsp;&nbsp;-&nbsp;<?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></b></p></font>
											<font style="font-size: 11px;"><p style="margin: 0 0px 5px ;"><b>
											<?php 
											if($op_res->label_type == 'Pickup')
											{
												?>
												<?php echo 'Pickup'; ?> ( <?php echo (!empty($p_val)) ? date("m-d-y", strtotime($p_val->expire_date)): ''; ?>)
												<?php
											}
											else
											{
												?>
												<?php echo (!empty($patient_res)) ? $patient_res->user_address : ''; ?> ( <?php echo (!empty($p_val)) ? date("m-d-y", strtotime($p_val->expire_date)): ''; ?>)
												<?php


											}
											?>

											</b></p></font>
										</div>
										<div style="width: 95px;margin-top: -48px;height: 48px;margin-left: 265px;line-height: 1;text-align: right;">
											<img src="<?php echo base_url(); ?>webroot/login/logo.jpg" width="100%">
										</div>
										<div style="margin-top:5px;">
											<br>
										</div>
										<div style="margin-top: -40px;">
											<table style="font-size: 12px;">
												<tr>
													<th style="padding-right: 60px;" >Serving</th>
													<?php
													$label_res = $this->common_model->getData('tbl_label', NULL, 'multi');
													if(!empty($label_res))
													{
														foreach ($label_res as $l_res) 
														{
															?>
															<th style="padding-right: 30px;" ><?php echo $l_res->label_name; ?></th>
															<?php
														}
													}
													?>
												</tr>
												<tbody>
													<?php
													if(!empty($label_res))
													{
															$order_p_res = $this->common_model->getData('tbl_order_product', array('patient_id'=>$op_res->patient_id,'unique_no'=>$p_val->unique_no), 'multi');
															foreach ($order_p_res as $res) 
															{
																$product_res = $this->common_model->getData('tbl_product', array('product_id'=>$res->product_id), 'single');
																$label_product_res = $this->common_model->getData('tbl_product_label_price', array('product_id'=>$res->product_id), 'multi');
																?>

																<tr>
																	<td style="padding-right: 50px;"><?php echo (!empty($product_res->product_name)) ? $product_res->product_name : ''; ?></td><!-- .' '.$res->macro_value_id .'oz' -->
																	<?php
																	if(!empty($label_product_res))
																	{
																		foreach ($label_product_res as $l_res) 
																		{
																			$label_amount 	= $l_res->label_amount;
																			$macro_value_id = $res->macro_value_id;
																			$label_price = $label_amount * $macro_value_id;
																			?>
																			<td style="padding-right: 39px;"><?php echo $label_price; ?></td>
																			<?php
																		}
																	}
																	?>
																</tr>
																<?php
															}
															
													}
													?>
												</tbody>
											</table>

										</div>
									</div>
									<hr> 
								</td>
	            			<?php
	            			if($row_count%1 == 0){
	            				?>
	            				</tr>
	            				<tr <?php echo $row_count.'--B'; ?>>	            					
	            				<?php
	            				/*if('1' == $row_count)
	            				{
	            					?>
	            					</tr>
	            					</tbody>				
								</table>
	            					<?php
	            				}*/
	            			}
	            			if($row_count%16 == 0){
	            				?>
	            				</tr>
	            				</tbody>				
								</table>
		            			<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 1px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 100%;max-width: 793px;padding:45px 11px 45px 19px;background-color: #f2f2f2;">
								<tbody>
									<tr <?php echo $row_count.'--X'; ?>>	            					
	        				<?php
	            			}
	            			$row_count++;
	            			}
	            		}
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