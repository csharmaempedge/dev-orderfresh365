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



	.btn-success {

		background-color: #8bd040;

		border-color: #8bd040;

	}

	.btn {

		border-radius: 3px;

		-webkit-box-shadow: none;

		box-shadow: none;

		border: 1px solid transparent;

	}

	.btn-sm {

		padding: 5px 10px;

		font-size: 12px;

		line-height: 1.5;

		border-radius: 3px;

	}

	.btn-success {

		color: #22255a;

		background-color: #8bd040;

		border-color: #8bd040;

	}

	.btn {

		display: inline-block;

		padding: 6px 12px;

		margin-bottom: 0;

		font-size: 14px;

		font-weight: 400;

		line-height: 1.42857143;

		text-align: center;

		white-space: nowrap;

		vertical-align: middle;

		-ms-touch-action: manipulation;

		touch-action: manipulation;

		cursor: pointer;

		-webkit-user-select: none;

		-moz-user-select: none;

		-ms-user-select: none;

		user-select: none;

		background-image: none;

		border: 1px solid transparent;

		border-radius: 4px;

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

<aside class="right-side">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Label Print</h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo base_url().MODULE_NAME;?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo base_url().MODULE_NAME;?>orderList">Order </a></li>

            <li class="active">Label Print</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">       

        <div class="box box-success">

            <div class="box-header">

                <div class="pull-left">

                    <h3 class="box-title">Label Print</h3>

                </div>

                <div class="pull-right">

                   <a href="<?php echo base_url().MODULE_NAME;?>order" class="btn btn-info btn-sm">Back</a> 

               </div>

            </div>

            <div class="layout roll" style="text-align: center;" >

		<br>

		<br><br>

		<br><span class="btn btn-sm btn-success" onclick="printInvoice();">Print Sheet</span>

		<br>

		<br>

		<div id="print_table" style="margin: auto;">

			<?php

				if(!empty($order_list))

	            { 

	            	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$order_res->patient_id), 'single');

            		$row_count = 1;

            		foreach ($order_list as $p_val) {

            			for ($i=0; $i<$p_val->qty; $i++)

						{

            			if($row_count == 1){

            				?>

            				<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 0px solid lightgrey; page-break-inside: avoid;vertical-align:top;width: 100%; width: 384px;padding:0px;background-color: #f2f2f2; height: 576px; border-spacing: 0px;">

								<tbody style="display: table-footer-group;">

									<tr <?php echo $row_count.'--A'; ?>>

            				<?php

            			}

            			?>

	            			<td align="center" style="padding: 0px;">

								<div style="width: 384px; border:1px solid #ddd;border-radius: 16px;margin:auto 0;background-color:#ffffff;text-align:left;padding:6px;font-family: verdana; height: 96px;">

									<div style="margin-top:0px;margin-left: 0px;line-height: 1;margin-right: 100px;height: 40px;">

										<font style="font-size: 10px"><p style="margin: 0 0px 3px ;"><b>Client&nbsp;&nbsp;-&nbsp;<?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></b></p></font>

										<font style="font-size: 10px;"><p style="margin: 0 0px 5px ;"><b>



											<?php 

											if($order_res->label_type == 'Pickup')

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

									<div style="width: 62px;margin-top: -48px;height: 30px;margin-left: 290px;line-height: 1;text-align: right; position: relative;  top: 8px;">

										<img src="<?php echo base_url(); ?>webroot/login/logo.jpg" width="100%">

									</div>

									<!-- <div style="margin-top:5px;">

										<br>

									</div> -->

									<div style="margin-top: 0px; margin-left: -3px;">

										<table style="font-size: 10px; width: 100%;">

											<tr>

												<th style="padding: 0px; width: 100px; text-align: left;" >Serving</th>

												<?php

												$label_res = $this->common_model->getData('tbl_label', NULL, 'multi');

												if(!empty($label_res))

												{

													foreach ($label_res as $l_res) 

													{

														?>

														<th style="padding: 0px; width: 60px; text-align: left;" ><?php echo $l_res->label_name; ?></th>

														<?php

													}

												}

												?>

											</tr>

											<tbody>

												<?php

												if(!empty($label_res))

												{

														$order_p_res = $this->common_model->getData('tbl_order_product', array('patient_id'=>$order_res->patient_id,'unique_no'=>$p_val->unique_no), 'multi');

														foreach ($order_p_res as $res) 

														{

															$product_res = $this->common_model->getData('tbl_product', array('product_id'=>$res->product_id), 'single');

															$label_product_res = $this->common_model->getData('tbl_product_label_price', array('product_id'=>$res->product_id), 'multi');

															?>



															<tr>

																<td style="padding: 0px; width: 100px;"><?php echo (!empty($product_res->product_name)) ? $product_res->product_name : ''; ?></td><!-- .' '.$res->macro_value_id .'oz' -->

																<?php

																if(!empty($label_product_res))

																{

																	foreach ($label_product_res as $l_res) 

																	{

																		$label_amount 	= $l_res->label_amount;

																		$macro_value_id = $res->macro_value_id;

																		$label_price = $label_amount * $macro_value_id;

																		?>

																		<td style="padding: 0px; width: 60px;"><?php echo $label_price; ?></td>

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

								<hr style="margin-top: 0px; margin-bottom: 0px; border: none;"> 

							</td>

            			<?php

            			/*if($row_count%2 == 0){*/

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

            			if($row_count%5 == 0){

            				?>

            				</tr>

            				</tbody>				

							</table>

	            			<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 0px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 384px;padding:0px;background-color: #f2f2f2;height: 576px; margin-top: 20px; border-spacing: 0;">

							<tbody style="display: table-footer-group;">

								<tr <?php echo $row_count.'--X'; ?>>	            					

        				<?php

            			}

            			$row_count++;

            			}

            		}

	            }

			?>

		</div>

	</div>

        </div>



        <!-- /.box -->

    </section>

    <!-- /.content -->

</aside>

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