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
            <li><a href="<?php echo base_url().MODULE_NAME;?>order/setBageLable/<?php echo $order_id.'/'.$patient_id; ?>">Bags </a></li>
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
                   <a href="<?php echo base_url().MODULE_NAME;?>order/setBageLable/<?php echo $order_id.'/'.$patient_id; ?>" class="btn btn-info btn-sm">Back</a> 
               </div>
            </div>
            <div class="layout roll" style="text-align: center;" >
		<br>
		<br><br>
		<br><span class="btn btn-sm btn-success" onclick="printInvoice();">Print Sheet</span>
		<br>
		<br>
		<div id="print_table" style="max-width: 793px;margin: auto;border: 1px solid #ddd;text-align:center;min-height: 1122px;">
			<?php
            	$patient_res = $this->common_model->getData('tbl_user',array('user_id'=>$patient_id), 'single');
        		$row_count = 1;
        			for ($i=0; $i<$bags_count; $i++)
					{
        			if($row_count == 1){
        				?>
        				<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 0px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 100%;max-width: 793px;padding:45px 11px 45px 19px ;background-color: #f2f2f2;height: 1122px;">
							<tbody style="display: block;">
								<tr <?php echo $row_count.'--A'; ?>>
        				<?php
        			}
        			?>
            			<td align="center" style="height:128px">
							<div style="width: 374px;height: 128px;border:1px solid #ddd;border-radius: 6px;margin:auto 0;background-color:#ffffff;text-align:left;padding:6px;font-family: verdana;margin-right: 8px;">
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
											<th style="padding-right: 60px;" >Name</th>
											<td ><?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></td>
										</tr>
										<tr>
											<th style="padding-right: 60px;" >Address</th>
											<td ><?php echo (!empty($patient_res)) ? $patient_res->user_address : ''; ?></td>
										</tr>
										<tr>
											<th style="padding-right: 60px;" ></th>
											<td ><?php echo $row_count.'/'.$bags_count; ?></td>
										</tr>
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
            			<table cellpadding="0" cellspacing="0" align="center" valign="top" style="border: 1px solid lightgrey;page-break-inside: avoid;vertical-align:top;width: 100%;max-width: 793px;padding:45px 11px 45px 19px;background-color: #f2f2f2;height: 1122px;">
						<tbody>
							<tr <?php echo $row_count.'--X'; ?>>	            					
    				<?php
        			}
        			$row_count++;
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