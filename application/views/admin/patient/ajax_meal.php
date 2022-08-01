
<tr>
  <td>
      <input min="0" type="number" name="qty[]" value="" placeholder="#" class="form-control mx-120">
  </td>
  <?php
  $patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$patient_id), 'multi');
     if(!empty($patient_macro_res))
     {
       foreach ($patient_macro_res as $p_res) 
       {
           $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');
           $product_res = $this->common_model->getData('tbl_product', array('category_id'=>$p_res->macro_id), 'multi');
           ?><td>
  
                  <div class="input-group">
                    <input type="text" name="macro_value_id[]" value="<?php echo $p_res->macro_value_id; ?>" class="form-control" placeholder="#">
                    <div class="input-group-addon">
                        
                        <select required style="height: 31px;" name="product_id[]">
                            <option value=""><?php echo $macro_res->macro_name; ?></option>
                            <?php
                            if(!empty($product_res)){
                                  foreach($product_res as $res){
                                      ?>
                                      <option value="<?php echo $res->product_id; ?>"><?php echo $res->product_name; ?></option>
                                      <?php
                                  }
                              }
                            ?>
                         </select>
                    </div>
                </div>
              </td>
           <?php
       }
     }
    ?>
</tr>
