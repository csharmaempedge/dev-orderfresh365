<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Label Print</title>
</head>
<style>
@media print {
  body{
 width: 75% !important;
    height: auto !important;
    padding-left: 97.5px !important;
    padding-right: 0px !important;
    padding-top: 11.5px !important;
    padding-bottom: 0px !important;
    overflow: hidden !important;
    display: table;
  }
  .section {
 /* width: 100% !important;
		padding:42px !important;*/
		padding-left: 45.354330709px !important;
    padding-right: 45.354330709px !important;
    padding-top: 40.804330709px !important;
    padding-bottom: 45.354330709px !important;
		}
		tr, td {
    /*font-size: 14px !important;*/
    font-size: 16px !important;
}
h6 {
    /*font-size: 15px !important;*/
    font-size: 17px !important;
    margin: 0 0 0 0 !important;
}
  }
body {
    width: 384px;
    height: 576px;
    padding-left: 49.133858268px;
    padding-right: 45.354330709px;
    padding-top: 37.795275591px;
    padding-bottom: 18.897637795px;
    overflow: hidden;
 }	
 .section {
 		width: 100%;
 	    margin: 0 auto;
 	    left: 0;
 	    right: 0;
 	    text-align: left;
 	    border: 1px solid #000;
 	    padding: 4px 15px;
 	    box-sizing: border-box;
 	    border-radius: 12px;

 	}
 	.sectionHeader{
 		display: flex;
	    flex-direction: row;
	    align-items: center;
	    justify-content: space-between;
 	}
 	h6{
 		/*font-size: 13px;*/  
 		font-size: 15px;  
 		margin: 0 0 0 0;
 	}
 	.headerRight{
 		text-align: right;
 	}
 	.logo{
 		max-width: 85px;
 	}
 	table{
 		width: 100%;
 	}
 	tr, td{
 		/*font-size: 12px;*/
 		font-size: 14px;
 	}
</style>
<body>
	<div class="sheetArea">
		<?php
				if(!empty($order_list))
	            { 
	            	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$order_res->patient_id), 'single');
            		$row_count = 1;
            		foreach ($order_list as $p_val) {
            			for ($i=0; $i<$p_val->qty; $i++)
						{
            			?>
            			<div class="section sectionFLexVerticle">
							<div class="sectionHeader" >
								<div class="headerLeft" style=" width: 70%;">
									<h6><?php 
										echo !empty($patient_res) ? substr($patient_res->user_fname.' '.$patient_res->user_lname, 0, 35) : '';
									 ?></h6>
									<h6>
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
											<?php echo (!empty($patient_res)) ? substr($patient_res->user_address, 0, 30) : ''; ?> ( <?php echo (!empty($p_val)) ? date("m-d-y", strtotime($p_val->expire_date)): ''; ?>)
											<?php
										}
										?>
										</h6>
								</div>
								<div class="headerRight">
									<img class="logo" src="<?php echo base_url(); ?>webroot/login/logo.jpg">
								</div>
							</div>
							<div class="sectionDetailTable">
								<table>
									<thead>
										<tr>
											<th style="">Serving</th>
											<?php

												$label_res = $this->common_model->getData('tbl_label', NULL, 'multi');

												if(!empty($label_res))

												{

													foreach ($label_res as $l_res) 

													{

														?>

														<th><?php echo $l_res->label_name; ?></th>

														<?php

													}

												}

												?>
										</tr>
									</thead>
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
													<td><?php echo (!empty($product_res->product_name)) ? $product_res->product_name : ''; ?></td>
													<!-- <td><?php echo (!empty($product_res->product_label_print_name)) ? $product_res->product_label_print_name : ''; ?></td> -->
													<?php
													if(!empty($label_product_res))
													{
														foreach ($label_product_res as $l_res) 
														{
															$label_amount 	= $l_res->label_amount;
															$macro_value_id = $res->macro_value_id;

															$label_price = $label_amount * $macro_value_id;

															?>

															<td><?php echo $label_price; ?></td>

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
            			<?php
            			}
            		}
	            }
			?>
	</div>
</body>
</html>   
<script type="text/javascript">
   window.print();
    onafterprint = function () {
        window.location.href = "<?php echo base_url().MODULE_NAME;?>order";
    }
</script>