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

		padding-left: 18.354330709px !important;

    padding-right: 18.354330709px !important;

    padding-top: 24px !important;

    padding-bottom: 18px !important;



		}

	.sectionPageBreak {

 /* width: 100% !important;

		padding:42px !important;*/

		padding-left: 18.354330709px !important;

    padding-right: 18.354330709px !important;

    padding-top: 42px !important;

    padding-bottom: 18px !important;

	page-break-before:always;

		}

		tr, td {

    font-size: 19px !important;

}

h6 {

    font-size: 18px !important;

    margin: 0 0 0 0 !important;

}

  }

body {

   /* width: 384px;*/

    /*height: auto;

    padding-left: 49.133858268px;

    padding-right: 45.354330709px;

    padding-top: 37.795275591px;

    padding-bottom: 18.897637795px;

    overflow: hidden;*/

 }	

 .section {

 		width: 100%;

 	    margin: 0 auto;

 	    left: 0;

 	    right: 0;

 	    text-align: left;

 	    /*border: 1px solid #000;*/

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

 		font-size: 13px;  

 		margin: 0 0 0 0;

 	}

 	.headerRight{

 		text-align: right;

 	}

 	.logo{

 		max-width: 170px;

 	}

 	table{

 		width: 100%;

 	}

 	tr, td{

 		font-size: 12px;

 	}

	table, td, th {

  border: 1px solid;

}



table {

  border-collapse: collapse;

}

.claimedRight{

float: left;

    display: inline-block;

    width: 200px;

	}

</style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>




<br>
		<div class="col-md-12" style="text-align: center;">
			<span class="btn btn-sm btn-success" style="border-radius: 21px;" onclick="printInvoice();">Print Sheet</span>
		</div>
		<br>
		<br>
		<br>
<body >



	<div id="print_table">
		<script>

$(document).ready(function(){

  

  $('.claimedRight').each(function (f) {



      var newstr = $(this).text().substring(0,50);

      $(this).text(newstr);



    });

})

</script>
	<?php 

	if(!empty($breakfast_order_res)){
				$itemCount = 0;
				foreach ($breakfast_order_res as $p_val) {
					$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$p_val->patient_id), 'single');

				for( $i = 0; $i<$p_val->qty; $i++ ){ 

				$itemCount++;

			  if ($itemCount % 5 == 1 && $itemCount >= 6) {

				          



			?>

			<div class="sectionPageBreak sectionFLexVerticle">



	  <?php }else{ ?>

	  		<div class="section sectionFLexVerticle">



	  <?php } ?>

			<div class="sectionHeader" >

				<div class="headerLeft" style=" width: 70%;">

					<h6><?php echo !empty($patient_res) ? substr($patient_res->user_fname.' '.$patient_res->user_lname, 0, 35) : '';?></h6>

					<h6>

						<?php 

						if($p_val->label_type == 'Pickup')

						{

							$user_address = 'Pickup';

							$expire_date =  (!empty($p_val)) ? date("m-d-y", strtotime($p_val->expire_date)): '';

						}

						else

						{

							$user_address =  (!empty($patient_res)) ? substr($patient_res->user_address, 0, 30) : '';

							$expire_date =  (!empty($p_val)) ? date("m-d-y", strtotime($p_val->expire_date)): '';

						}

						?>

						<span class="claimedRight"><?php echo $user_address; ?></span>  (Exp <?php echo $expire_date; ?>)</h6>

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
						$product1_res = $this->common_model->getData('tbl_product', array('product_id'=>$p_val->breakfast_product_id_1), 'single');
						$label_product1_res = $this->common_model->getData('tbl_product_label_price', array('product_id'=>$p_val->breakfast_product_id_1), 'multi');
						?>

						<tr>
							<td ><?php echo (!empty($product1_res->product_name)) ? $product1_res->product_name : ''; ?></td><!-- .' '.$p_val->macro_value_id .'oz' -->
							<?php
							if(!empty($label_product1_res))
							{
								foreach ($label_product1_res as $l_res) 
								{
									$label_amount 	= $l_res->label_amount;
									$breakfast_qty_1 = $p_val->breakfast_qty_1;
									$label_price = $label_amount * $breakfast_qty_1;
									?>
									<td><?php echo round($label_price,1); ?></td>
									<?php
								}
							}
							?>
						</tr>
						<?php
							$product2_res = $this->common_model->getData('tbl_product', array('product_id'=>$p_val->breakfast_product_id_2), 'single');
							$label_product2_res = $this->common_model->getData('tbl_product_label_price', array('product_id'=>$p_val->breakfast_product_id_2), 'multi');
							?>
							<tr>
								<td ><?php echo (!empty($product2_res->product_name)) ? $product2_res->product_name : ''; ?></td><!-- .' '.$p_val->macro_value_id .'oz' -->
								<?php
								if(!empty($label_product2_res))
								{
									foreach ($label_product2_res as $l_res) 
									{
										$label_amount 	= $l_res->label_amount;
										$breakfast_qty_2 = $p_val->breakfast_qty_2;
										$label_price = $label_amount * $breakfast_qty_2;
										?>
										<td ><?php echo round($label_price,1); ?></td>
										<?php
									}
								}
								?>
							</tr>
							<tr style="opacity: 0; visibility: hidden;">
								<td>Dummy</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								</tr>
							<?php
							
					}
					?>

					</tbody>

				</table>

			</div>

		</div>

	<?php }}} ?>

	

	

	</div>

</div>

</body>

</html>   



<script type="text/javascript">

   function printInvoice()
		{
			var divToPrint=document.getElementById('print_table');
			var newWin=window.open('','Print-Window');
			newWin.document.open();
			newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
			newWin.document.write('<style>@media print{body{width: 75% !important; height: auto !important; padding-left: 97.5px !important; padding-right: 0px !important; padding-top: 11.5px !important; padding-bottom: 0px !important; overflow: hidden !important; display: table;}.section{/* width: 100% !important;padding:42px !important;*/padding-left: 18.354330709px !important; padding-right: 18.354330709px !important; padding-top: 24px !important; padding-bottom: 18px !important;}.sectionPageBreak{/* width: 100% !important;padding:42px !important;*/padding-left: 18.354330709px !important; padding-right: 18.354330709px !important; padding-top: 42px !important; padding-bottom: 18px !important;page-break-before:always;}tr, td{font-size: 19px !important;}h6{font-size: 18px !important; margin: 0 0 0 0 !important;}}body{width: 384px; height: auto; padding-left: 49.133858268px; padding-right: 45.354330709px; padding-top: 37.795275591px; padding-bottom: 18.897637795px; overflow: hidden;}.section{width: 100%; margin: 0 auto; left: 0; right: 0; text-align: left; /*border: 1px solid #000;*/ padding: 4px 15px; box-sizing: border-box; border-radius: 12px;}.sectionHeader{display: flex; flex-direction: row; align-items: center; justify-content: space-between;}h6{font-size: 13px; margin: 0 0 0 0;}.headerRight{text-align: right;}.logo{max-width: 170px;}table{width: 100%;}tr, td{font-size: 12px;}table, td, th{border: 1px solid;}table{border-collapse: collapse;}.claimedRight{float: left; display: inline-block; width: 200px;}</style>');
			newWin.document.close();
    	}

</script>