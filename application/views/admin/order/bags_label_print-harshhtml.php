<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bags Label Print</title>
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
    padding-bottom: 12px !important;
		}
	.sectionPageBreak {
 /* width: 100% !important;
		padding:42px !important;*/
		padding-left: 18.354330709px !important;
    padding-right: 18.354330709px !important;
    padding-top: 42px !important;
    padding-bottom: 12px !important;
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
    width: 384px;
    height: auto;
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
    <script         src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  
  $('.claimedRight').each(function (f) {

      var newstr = $(this).text().substring(0,50);
      $(this).text(newstr);

    });
})
</script>
<body>

	<div class="sheetArea">
	<?php 
	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');
			$itemCount = 0;
			for( $i = 0; $i<$bags_count; $i++ ){ 
			$itemCount++;
			  if ($itemCount % 5 == 1 && $itemCount >= 6) {
				          

			?>
			<div class="sectionPageBreak sectionFLexVerticle">

	  <?php }else{ ?>
	  		<div class="section sectionFLexVerticle">

	  <?php } ?>
			<div class="sectionHeader" >
				<div class="headerLeft" style=" width: 70%;">
					<h6>Name <?php echo !empty($patient_res) ? substr($patient_res->user_fname.' '.$patient_res->user_lname, 0, 35) : '';?></h6>
					<h6>
						<?php 
						$user_address =  (!empty($patient_res)) ? substr($patient_res->user_address, 0, 30) : '';
						?>
						<span class="claimedRight">Address <?php echo $user_address; ?></span></h6>
					<h6>
						
						<?php echo $itemCount.'/'.$bags_count; ?></h6>
				</div>
				<div class="headerRight">
					<img class="logo" src="<?php echo base_url(); ?>webroot/login/logo.jpg">
				</div>
			</div>
			<div class="sectionDetailTable">
				
			</div>
		</div>
	<?php } ?>
	
	
	</div>

</body>
</html>   

<script type="text/javascript">
   window.print();
    onafterprint = function () {
        window.location.href = "<?php echo base_url().MODULE_NAME;?>order/setBageLable/<?php echo $order_id.'/'.$patient_id; ?>";
    }
</script>