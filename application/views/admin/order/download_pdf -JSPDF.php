<!DOCTYPE html>
<html id="content">
<head>
    <title>CIRCADIAN FOOD</title>
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
            text-align: center;
        }
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
    </style>
</head>
<body>
 <div >
    <table>
        <thead>
            <tr>
                <th>Name </th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Address</th>
                <th>Order</th>
                <th>#Order</th>
                <th>Bags</th>
                <th>Delivery Route</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $patient_macro_res = $this->common_model->getData('tbl_macro', NULL, 'multi');
            if(!empty($order_res))
            {
                foreach ($order_res as $res) 
                {
                    $address_res = $this->common_model->getData('tbl_address', array('user_id'=>$res->patient_id,'user_address'=>$res->user_address), 'single');
                    $bags_count = $this->common_model->getData('tbl_print_bags', array('patient_id'=>$res->patient_id,'order_id'=>$res->order_id), 'count');
                    $patient_res = $this->common_model->getData('tbl_user', array('user_id'=>$res->patient_id), 'single');
                    $order_list = $this->common_model->getData('tbl_order_product', array('patient_id'=>$res->patient_id,'order_id'=>$res->order_id, 'qty !='=>0), 'multi',NULL,NULL,NULL, 'unique_no');
                    $breakfast_order_res = $this->common_model->getData('tbl_breakfast_order', array('patient_id'=>$res->patient_id, 'order_id'=>$res->order_id), 'multi');
                    $totalQty = $this->order_model->gettotalOrderQty('', $res->order_id);
                    $totalBreakfastQty = $this->order_model->gettotalBreakfastOrderQty('', $res->order_id);
                    $toTalQTY = $totalQty->qty + $totalBreakfastQty->qty;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo (!empty($patient_res)) ? $patient_res->user_fname.' '.$patient_res->user_lname : ''; ?></td>
                        <td><?php echo (!empty($patient_res)) ? $patient_res->user_mobile_no : ''; ?></td>
                        <td><?php echo (!empty($patient_res)) ? $patient_res->user_email : ''; ?></td>
                        <td><?php echo $res->user_address; ?></td>
                        <td>
                        <?php
                        foreach($order_list as $crt_res)
                        {
                            foreach ($patient_macro_res as $p_res)
                            {
                                $cart_res = $this->common_model->getData('tbl_order_product', array('patient_id'=>$res->patient_id,'macro_id'=>$p_res->macro_id,'unique_no'=>$crt_res->unique_no), 'multi');
                                if(!empty($cart_res))
                                {
                                    foreach ($cart_res as $c_res) 
                                    {
                                        $product_res = $this->common_model->getData('tbl_product', array('product_id'=>$c_res->product_id), 'single');
                                        echo $c_res->macro_value_id.' - '.$product_res->product_name;
                                        echo "<br>";
                                    }
                                }
                            }
                        }
                        if(!empty($breakfast_order_res))
                        {
                            foreach($breakfast_order_res as $b_res)
                            {
                                $product_res1 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_1), 'single');
                                $product_res2 = $this->common_model->getData('tbl_product', array('product_id'=>$b_res->breakfast_product_id_2), 'single');
                                $product_name1 = (!empty($product_res1)) ? $product_res1->product_name : '';
                                $p1 = $b_res->breakfast_qty_1.' '.$product_name1;
                                $product_name2 = (!empty($product_res2)) ? $product_res2->product_name : '';
                                $p2 = $b_res->breakfast_qty_2.' '.$product_name2;
                                echo $p1.'<br>'.$p2.'<br>';
                          }
                        }
                        ?>
                        </td>
                        <td><?php echo $toTalQTY; ?></td>
                        <td><?php echo (!empty($bags_count)) ? $bags_count : '0'; ?></td>
                        <td><?php echo (!empty($address_res->address_route)) ? $address_res->address_route : ''; ?></td>
                        <td><?php echo (!empty($order_list[0]->note)) ? $order_list[0]->note : ''; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<button id="cmd">generate PDF</button>

<br>
<br>




</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js" type="text/javascript"></script>


<script type="text/javascript">
 var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});

</script>
