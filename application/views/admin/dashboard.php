<?php



  $global_res = $this->common_model->getData('tbl_global_setting', NULL, 'single');



  if(!empty($global_res))



  {



    if($global_res->order_status == 'Open')



    {



      ?>



          <style type="text/css">



           .mx-60 {



                    max-width: 60px;



                }







                .mx-120 {



                    max-width: 120px;



                }







                .my-16{



                    margin-top: 16px;



                    margin-bottom: 16px;



                }







                .multiple-input{



                    display: flex;



                }



                .multiple-input .form-control{



                    max-width: 60px;



                }



          </style>



          <aside class="right-side">



           <section class="content-header">



              <?php



              if(!empty($role_id))



              {



                if($role_id == '4' && $patient_doctor_id !='0')



                {



                    ?>



                    <h1>Build Your Meals</h1>



                       <ol class="breadcrumb">



                          <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>



                          <li class="active">Build Your Meals</li>



                       </ol>



                    <?php



                }



                else



                {



                 ?>



                 <h1>Dashboard</h1>



                    <ol class="breadcrumb">



                       <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>



                       <li class="active">dashboard</li>



                    </ol>



                 <?php



                }



              }



              ?>



              <?php



              if(!empty($role_id))



              {



                if($role_id == '4' && $patient_doctor_id !='0')



                {



                    ?>



                    <section class="content">



                      <div class="box box-success">



                         <div>



                           <div id="msg_div">



                               <?php echo $this->session->flashdata('message');?>



                           </div>



                       </div><br><br><br>



                         <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">



                            <?php $csrf = array( 'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash() );?>



                            <!-- <input type="text" name="latitude" id="latitude">



                            <input type="text" name="longitude" id="longitude"> -->



                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" /> 



                            <!-- <body style="padding: 50px 0;"> -->



                            <body>



                              <?php



                                if(!empty($role_id))



                                {



                                    if($role_id == '4' && $patient_doctor_id !='0')



                                    {



                                        $doctor_res = $this->common_model->getData('tbl_user', array('user_id'=>$patient_doctor_id), 'single');



                                        ?>



                                        <div class="container">



                                          <div class="row">



                                              <div class="col-md-12 col-lg-10">







                                                  <div class="form-group">



                                                      <label for="">Build Your Meals (or set by <?php echo !empty($doctor_res)? $doctor_res->user_fname.' ' .$doctor_res->user_lname : ''; ?>)</label>



                                                      <div class="input-group multiple-input">



                                                        <?php



                                                            $patient_macro_res = $this->common_model->getData('tbl_patient_macro', array('patient_id'=>$user_id), 'multi');



                                                            if(!empty($patient_macro_res))



                                                            {



                                                                $macro = array();



                                                                foreach ($patient_macro_res as $p_res) 



                                                                {



                                                                   $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');



                                                                   ?>



                                                                    <input readonly type="text" class="form-control" placeholder="4" value="<?php echo (!empty($macro_res)) ? $p_res->macro_value_id : ''; ?>">



                                                                   <?php



                                                                }



                                                            }



                                                        ?>







                                                          



                                                      </div>



                                                  </div>



                                                  <div class="table-responsive meal_vs_table">



                                                      <table class="table table-bordered">



                                                          <thead>



                                                              <tr>



                                                                  <th>Quantity Of Current Meal</th>



                                                                  <?php



                                                                     if(!empty($patient_macro_res))



                                                                     {



                                                                       foreach ($patient_macro_res as $p_res) 



                                                                       {



                                                                           $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');



                                                                           ?><th><?php echo $macro_res->macro_name.' (oz)'; ?></th><?php



                                                                       }



                                                                     }



                                                                     ?>



                                                              </tr>



                                                          </thead>







                                                          <tbody id="add_emp_dep_box_div">



                                                              <tr>



                                                                  



                                                                  <?php



                                                                     if(!empty($patient_macro_res))



                                                                     {



                                                                       foreach ($patient_macro_res as $p_res) 



                                                                       {



                                                                           $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');



                                                                           $product_res = $this->common_model->getData('tbl_product', array('category_id'=>$p_res->macro_id,'product_status'=>1), 'multi');



                                                                           ?>



                                                                           <?php



                                                                           if($p_res->macro_id == '1')



                                                                           {



                                                                            ?>



                                                                             <td data-label="Quantity">

                                                                              <div>

                                                                                <input required min="0" type="number" name="qty[]" id="qty_1" value="" placeholder="#" class="form-control mx-120">



                                                                                <input min="0" type="hidden" name="qty[]" value="0" placeholder="#" class="form-control mx-120">



                                                                                <input min="0" type="hidden" name="qty[]" value="0" placeholder="#" class="form-control mx-120">

                                                                                </div>

                                                                            </td>



                                                                            <?php



                                                                           }



                                                                           ?>

                                                                           <?php

                                                                           if($p_res->macro_id == '1')

                                                                           {

                                                                              $datalLabelName = 'Protien (oz)';

                                                                           }

                                                                           elseif($p_res->macro_id == '2')

                                                                           {

                                                                              $datalLabelName = 'Carb (oz)';

                                                                           }

                                                                           else

                                                                           {

                                                                              $datalLabelName = 'Veggies (oz)';

                                                                           }

                                                                           ?>

                                                                           <td data-label="<?php echo $datalLabelName; ?>">



                                                                  



                                                                                  <div class="input-group">



                                                                                    <input type="hidden" name="macro_id[]" value="<?php echo $p_res->macro_id; ?>" class="form-control" placeholder="#">



                                                                                    <!-- <input type="text" name="macro_value_id[]" value="<?php echo $p_res->macro_value_id; ?>" class="form-control" placeholder="#"> -->



                                                                                    <select required name="macro_value_id[]" class="form-control">



                                                                                  



                                                                                      <?php



                                                                                          $macro_list = $this->common_model->getData('tbl_macro', array('macro_status'=>'1', 'macro_id'=>$p_res->macro_id), 'single');



                                                                                          



                                                                                          if(!empty($macro_list))



                                                                                          {



                                                                                            $macro_value_id_arr = explode(',',$macro_list->macro_value_id);



                                                                                                foreach($macro_value_id_arr as $macro_value_id){



                                                                                                ?>



                                                                                                <option <?php if($p_res->macro_value_id == $macro_value_id){ echo "selected"; } ?> value="<?php echo $macro_value_id; ?>"><?php echo $macro_value_id; ?></option>



                                                                                                <?php



                                                                                            }



                                                                                          }



                                                                                      ?>



                                                                                    </select>



                                                                                    <div class="input-group-addon">



                                                                                        <?php



                                                                                        if($p_res->macro_id == '1')



                                                                                        {



                                                                                          ?>



                                                                                            <select onchange="productWiseVeggies(this.value, <?php echo $p_res->macro_id; ?>, '1');" required style="height: 26px;" name="product_id[]" id="protien_1" >



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



                                                                                          <?php



                                                                                        }



                                                                                        if($p_res->macro_id == '2')



                                                                                        {



                                                                                          ?>



                                                                                            <select required style="height: 26px;" name="product_id[]" id="carb_id_1" >



                                                                                              <option value=""><?php echo $macro_res->macro_name; ?></option>



                                                                                              



                                                                                            </select>



                                                                                          <?php



                                                                                        }



                                                                                        if($p_res->macro_id == '3')



                                                                                        {



                                                                                          ?>



                                                                                            <select required style="height: 26px;" name="product_id[]" id="veggies_id_1" >



                                                                                              <option value=""><?php echo $macro_res->macro_name; ?></option>



                                                                                              



                                                                                            </select>



                                                                                          <?php



                                                                                        }



                                                                                        ?>



                                                                                    </div>



                                                                                </div>



                                                                              </td>



                                                                           <?php



                                                                       }



                                                                     }



                                                                    ?>



                                                              </tr>



                                                          </tbody>



                                                      </table>



                                                  </div>



                                                  <div id="show_breakfast_div" style="display: none;">



                                                    <div class="form-group">



                                                      <label for="">Select Meal Breakfast (or set by <?php echo !empty($doctor_res)? $doctor_res->user_fname.' ' .$doctor_res->user_lname : ''; ?>)</label>



                                                      <div class="input-group multiple-input">



                                                        <?php



                                                            $patient_breakfast_res = $this->common_model->getData('tbl_patient_breakfast', array('patient_id'=>$user_id), 'multi');



                                                            if(!empty($patient_breakfast_res))



                                                            {



                                                                $breakfast = array();



                                                                foreach ($patient_breakfast_res as $b_res) 



                                                                {



                                                                   ?>



                                                                    <input readonly type="text" class="form-control" placeholder="4" value="<?php echo (!empty($b_res)) ? $b_res->qty : ''; ?>">



                                                                   <?php



                                                                }



                                                            }



                                                        ?>







                                                          



                                                      </div>



                                                    </div>



                                                    <div class="table-responsive">



                                                        <table class="table table-bordered">



                                                            <thead>



                                                                <tr>



                                                                    <th>Quantity</th>



                                                                    <?php



                                                                      $breakfast_res = $this->common_model->getData('tbl_breakfast', NULL, 'multi');



                                                                       if(!empty($breakfast_res))



                                                                       {



                                                                         foreach ($breakfast_res as $b_res) 



                                                                         {



                                                                             $patient_breakfast_res = $this->common_model->getData('tbl_patient_breakfast', array('breakfast_id'=>$b_res->breakfast_id, 'patient_id'=>$user_id), 'single');



                                                                             ?><th><?php echo $b_res->breakfast_name; ?></th><?php



                                                                         }



                                                                       }



                                                                       ?>



                                                                </tr>



                                                            </thead>







                                                            <tbody>



                                                                <tr>



                                                                   <td>



                                                                        <input min="0" type="number" name="break_fast_qty" id="break_fast_qty" value="" placeholder="#" class="form-control mx-120">



                                                                    </td>



                                                                    



                                                                    <?php



                                                                       if(!empty($breakfast_res))



                                                                       {



                                                                         foreach ($breakfast_res as $b_res) 



                                                                         {



                                                                             $patient_breakfast_res = $this->common_model->getData('tbl_patient_breakfast', array('breakfast_id'=>$b_res->breakfast_id, 'patient_id'=>$user_id), 'single');



                                                                             ?>



                                                                             <td>



                                                                                    <div class="input-group">



                                                                                      <input type="hidden" name="breakfast_id_<?php echo $b_res->breakfast_id; ?>" value="<?php echo $b_res->breakfast_id; ?>" class="form-control" placeholder="#">



                                                                                      <input type="text" name="breakfast_value_<?php echo $b_res->breakfast_id; ?>" value="<?php echo $patient_breakfast_res->qty; ?>" class="form-control" placeholder="#">



                                                                                      <div class="input-group-addon">



                                                                                          



                                                                                          <select style="height: 26px;" name="breakfast_product_id_<?php echo $b_res->breakfast_id; ?>">



                                                                                             <!--  <option value=""><?php echo $b_res->breakfast_name; ?></option> -->



                                                                                              <?php



                                                                                              if($b_res->breakfast_id == '1')



                                                                                              {



                                                                                                $product_res = $this->common_model->getData('tbl_product', array('category_id'=>'4','breakfast_type'=>'Protien','product_status'=>1), 'multi');



                                                                                              }



                                                                                              else



                                                                                              {



                                                                                                $product_res = $this->common_model->getData('tbl_product', array('breakfast_type'=>'Other','category_id'=>'4','product_status'=>1), 'multi');



                                                                                              }



                                                                                                  if(!empty($product_res)){



                                                                                                      foreach($product_res as $p_res){



                                                                                                          ?>



                                                                                                          <option <?php echo (!empty($patient_breakfast_res) && $patient_breakfast_res->product_id == $p_res->product_id) ? 'selected' : '' ;?> value="<?php echo $p_res->product_id; ?>"><?php echo $p_res->product_name; ?></option>



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



                                                            </tbody>



                                                        </table>



                                                    </div>



                                                  </div>



                                                  <div class="row">



                                                    <div class="form-group col-md-12">



                                                        <div class="input text">



                                                            <label>Note</label>



                                                            <textarea name="note" id="note" class="form-control"></textarea>



                                                        </div>



                                                    </div>



                                                  </div> 



                                                  <div class="my-16">



                                                    <input type="hidden" name="no_of_emp_dep_box" id="no_of_emp_dep_box" value="1">



                                                      <button type="button" id="add_emp_dep_box"  class="btn btn-default">Add Meal</button>



                                                     <!--  <button type="button" id="remove_emp_dep_box" style="display: none;" class="btn btn-danger">Remove Meal</button> -->



                                                      <button type="button" id="add_breakfast" style="background-color: #bad59c;" class="btn btn-default" onclick="showBreakfastDiv('open')" >Add Breakfast</button>



                                                      <button type="button" id="remove_breakfast"  style="display: none;" class="btn btn-danger" onclick="showBreakfastDiv('hide')">Remove Breakfast</button>



                                                      <button type="submit" name="Submit" value="Add" class="btn btn-primary">Checkout</button>



                                                  </div>



                                              </div>



                                          </div>



                                        </div>



                                        <?php



                                    }



                                }



                              ?>



                              







                          </body> 



                         </form>  



                         </div>  



                   </section>



                    <?php



                }



              }



              ?>



           </section>



           <!-- <script type="text/javascript">



            getLocation();



             function getLocation() {



              if (navigator.geolocation) {



                navigator.geolocation.getCurrentPosition(showPosition);



              } else { 



                alert("Geolocation is not supported by this browser.");



              }



            }



            function showPosition(position) {



              $('#latitude').val(position.coords.latitude);



              $('#longitude').val(position.coords.longitude);



            }



           </script> -->



          </aside>



          <script type="text/javascript">



          var order_Data = [];



          $(document).on('click' , '.remove-sub-heading' , function(){

              var id = $(this).data('id');

              $('#rm_langing_box_div'+id).remove();

          });

           $(document).ready(function(){



                var langind_box = '1';



                var langind_box_n = parseInt(langind_box) + 1;



                var validation_box = parseInt(langind_box) - 1;



                $("#add_emp_dep_box").click(function (){



                  var qty = $('#qty_1').val();



                   if (qty ==  '' || parseInt(qty) ==  0) {



                    alert('please enter quantity');



                     return false; 



                   }



                   var protien_1 = $('#protien_1').val();



                   if (protien_1 ==  '') {



                    alert('please select protien');



                     return false; 



                   }
                   var carb_id_1 = $('#carb_id_1').val();



                   if (carb_id_1 ==  '') {



                    alert('please select carb');



                     return false; 



                   }
                   var veggies_id_1 = $('#veggies_id_1').val();



                   if (veggies_id_1 ==  '') {



                    alert('please select veggies');



                     return false; 



                   }



                  qty_valid = parseInt(langind_box_n)-1; 



                  var qty_dynamic = $('#qty_'+qty_valid).val();



                   if (qty_dynamic ==  '' || parseInt(qty_dynamic) ==  0) {



                    alert('please enter quantity');



                     return false; 



                   } 



                  var protien_dynamic = $('#protien_'+qty_valid).val();



                   if (protien_dynamic ==  '' || parseInt(protien_dynamic) ==  0) {



                    alert('please select protien');



                     return false; 



                   }
                   var carb_dynamic = $('#carb_id_'+qty_valid).val();



                   if (carb_dynamic ==  '' || parseInt(carb_dynamic) ==  0) {



                    alert('please select carb');



                     return false; 



                   }
                   var veggies_dynamic = $('#veggies_id_'+qty_valid).val();



                   if (veggies_dynamic ==  '' || parseInt(veggies_dynamic) ==  0) {



                    alert('please select veggies');



                     return false; 



                   }



                  $('#remove_emp_dep_box').show();



                    var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'rm_langing_box_div' + langind_box);



                    newTextBoxDiv.after().html(`



                        <?php



                        if(!empty($patient_macro_res))



                        {



                        foreach ($patient_macro_res as $p_res) 



                        {



                           $macro_res = $this->common_model->getData('tbl_macro', array('macro_id'=>$p_res->macro_id), 'single');



                           $product_res = $this->common_model->getData('tbl_product', array('category_id'=>$p_res->macro_id,'product_status'=>1), 'multi');



                           ?>



                           <?php



                           if($p_res->macro_id == '1')



                           {



                            ?>



                             <td>



                                <input required min="0" type="number" name="qty[]" id="qty_`+langind_box_n+`" value="" placeholder="#" class="form-control mx-120">



                                <input min="0" type="hidden" name="qty[]" value="0" placeholder="#" class="form-control mx-120">



                                <input min="0" type="hidden" name="qty[]" value="0" placeholder="#" class="form-control mx-120">



                            </td>



                            <?php



                           }



                           ?>



                           <td>







                                  <div class="input-group">



                                    <input type="hidden" name="macro_id[]" value="<?php echo $p_res->macro_id; ?>" class="form-control" placeholder="#">



                                    <select required name="macro_value_id[]" class="form-control">



                                                                                  



                                      <?php



                                          $macro_list = $this->common_model->getData('tbl_macro', array('macro_status'=>'1', 'macro_id'=>$p_res->macro_id), 'single');



                                          



                                          if(!empty($macro_list))



                                          {



                                            $macro_value_id_arr = explode(',',$macro_list->macro_value_id);



                                                foreach($macro_value_id_arr as $macro_value_id){



                                                ?>



                                                <option <?php if($p_res->macro_value_id == $macro_value_id){ echo "selected"; } ?> value="<?php echo $macro_value_id; ?>"><?php echo $macro_value_id; ?></option>



                                                <?php



                                            }



                                          }



                                      ?>



                                    </select>



                                    <div class="input-group-addon">



                                        



                                        <?php



                                        if($p_res->macro_id == '1')



                                        {



                                          ?>



                                            <select onchange="productWiseVeggies(this.value, <?php echo $p_res->macro_id; ?>, `+langind_box_n+`);" required style="height: 26px;" name="product_id[]" id="protien_`+langind_box_n+`" >



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



                                          <?php



                                        }



                                        if($p_res->macro_id == '2')



                                        {



                                          ?>



                                            <select required style="height: 26px;" name="product_id[]" id="carb_id_`+langind_box_n+`" >



                                              <option value=""><?php echo $macro_res->macro_name; ?></option>



                                              



                                            </select>



                                          <?php



                                        }



                                        if($p_res->macro_id == '3')



                                        {



                                          ?>



                                            <select required style="height: 26px;" name="product_id[]" id="veggies_id_`+langind_box_n+`" >



                                              <option value=""><?php echo $macro_res->macro_name; ?></option>



                                              



                                            </select>



                                          <?php



                                        }



                                        ?>



                                    </div>



                                </div>



                              </td>



                           <?php



                        }



                        }



                        ?>

                         <td>

                             <div class="form-group col-md-2">

                                     <button data-id="`+langind_box+`" class="btn btn-danger btn-sm remove-sub-heading" title="remove meal" type="button" style="margin-left: 20px; margin-top: 25px"><i class="fa fa-remove"></i></button>

                                </div>

                            </div> 

                          </td>

                        `);          



                    newTextBoxDiv.appendTo("#add_emp_dep_box_div");   



                    $('#no_of_emp_dep_box').val(langind_box_n);



                    langind_box++;



                    langind_box_n++;



                });



                $("#remove_emp_dep_box").click(function (){



                    langind_box--;



                    langind_box_n--;



                    langind_box_val = parseInt(langind_box_n)-1; 



                    $('#no_of_emp_dep_box').val(langind_box_val);



                    $("#rm_langing_box_div" + langind_box).remove();         



                    if(langind_box == 1){



                        $('#remove_emp_dep_box').hide();



                    }



                });



            }); 







           $(document).on('change' , '.selectedDepartment' , function(){







                if(jQuery.inArray($(this).val(), order_Data) !== -1){



                    alert('This Engery Resources already selected.please select other Macro');



                    $(this).prop("selectedIndex", 0);



                    order_Data = $.map($(document).find('select.selectedDepartment'), function(option) {



                        return option.value;



                    });



                    return false;



                }







                order_Data = $.map($(document).find('select.selectedDepartment'), function(option) {



                    return option.value;



                });







            });



          </script>



          <script type="text/javascript">



          function showBreakfastDiv(str) 



          {



            if(str == 'open')



            {



              $('#break_fast_qty').attr('required', 'required');



              $('#show_breakfast_div').show();



              $('#add_breakfast').hide();



              $('#remove_breakfast').show();



            }



            if(str == 'hide')



            {



              $('#show_breakfast_div').hide();



              $('#break_fast_qty').removeAttr('required');



              $('#add_breakfast').show();



              $('#remove_breakfast').hide();



            }



          }



          function productWiseVeggies(product_id, macro_id, count) 



          {



            productWiseCarb(product_id, macro_id, count);



            if(macro_id == '1')



            {



              var str = 'product_id='+product_id+'&macro_id='+macro_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';



              var PAGE = '<?php echo base_url().MODULE_NAME; ?>dashboard/productWiseVeggies';



              jQuery.ajax({



                  type :"POST",



                  url  :PAGE,



                  data : str,



                  success:function(data){        



                      $('#veggies_id_'+count).html(data);



                  } 



              });



            }



          }



          function productWiseCarb(product_id, macro_id, count) 



          {



            if(macro_id == '1')



            {



              var str = 'product_id='+product_id+'&macro_id='+macro_id+'&<?php echo $this->security->get_csrf_token_name(); ?>='+'<?php echo $this->security->get_csrf_hash(); ?>';



              var PAGE = '<?php echo base_url().MODULE_NAME; ?>dashboard/productWiseCarb';



              jQuery.ajax({



                  type :"POST",



                  url  :PAGE,



                  data : str,



                  success:function(data){        



                      $('#carb_id_'+count).html(data);



                  } 



              });



            }



          }



          </script>



      <?php



    }



    else



    {



      ?>



      <aside class="right-side">



         <!-- Content Header (Page header) -->



         <section class="content-header">



            <h1>Dashboard</h1>



            <ol class="breadcrumb">



               <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>



               <li class="active">Dashboard</li>



            </ol>



         </section>



         <!-- Main content -->



         <section class="content">



            <div class="box box-success">



               <div class="box-body">



                  <div class="row">



                    <div class="col-md-12">



                      <h3 class="box-title"></h3>



                    </div>



                  </div>



                  <div class="row" style="text-align: center;">



                     <div class="col-md-6" style="width: 100%;">



                        <div class="small-box bg-green">



                           <div class="inner">



                              <h4>Menu is Currently "Off"  Please Check Later.</h4>



                           </div>



                           <div class="icon">



                              <i class="ion ion-ios-book"></i>



                           </div>



                        </div>



                     </div>



                  </div>



               </div>



            </div>    



         </section>



         <!-- /.content -->



      </aside>



      <?php



    }



  }



?>











