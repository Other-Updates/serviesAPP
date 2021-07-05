<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
.text_right
{
        text-align:right;
}
.box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
#top_heading_fix h3 {top: -57px;left: 6px;}
#TB_overlay { z-index:20000 !important; }
#TB_window { z-index:25000 !important; }
.dialog_black{ z-index:30000 !important; }
#boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;} 
.ui-datepicker td.ui-datepicker-today a {
     background:#999999;  
 }
.auto-asset-search ul#country-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
.auto-asset-search ul#product-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#service-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#country-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
.auto-asset-search ul#product-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
.auto-asset-search ul#service-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
ul li {
    list-style-type: none;
}
 </style>
<div class="mainpanel">
            <!--<div class="pageheader">
                <div class="media">    
                <div class="pageicon pull-left">
                        <i class="fa fa-quote-right pageheader_icon iconquo"></i>
                    </div>                
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                            <li>Update</li>
                        </ul>
                        <h4>Update Quotation</h4>                  
                   </div>
                </div>
            </div>-->
              <div id='empty_data'></div>
            <div class="contentpanel mb-25">
             <div class="media">
              <h4>Update Quotation</h4>
             </div>
                <table class="static" style="display: none;">
                <tr>
                            <td>
                            	<select id='' class='cat_id static_style class_req' name='categoty[]' tabindex="1" >
                                    <option>Select</option>
                                    <?php 
                                        if(isset($category) && !empty($category))
                                        {
                                            foreach($category as $val)
                                            {
                                                ?>
                                                    <option value='<?php echo $val['cat_id']?>'><?php echo $val['categoryName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td>
<!--                            <td class="sub_category">
                            	<select class=" static_color" name='sub_categoty[]' >
                                    <option value="">select</option>                                   
                                </select>
                            </td>-->
                            <td >
                            	<select name='brand[]' tabindex="1" >
                                    <option>Select</option>
                                    <?php 
                                        if(isset($brand) && !empty($brand))
                                        {
                                            foreach($brand as $val)
                                            {
                                                ?>
                                                    <option value='<?php echo $val['id']?>'><?php echo $val['brands']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td> 
                            <td >
                                <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1"  />
                                 <span class="error_msg"></span>
                                <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                            </td> 
                            <td>
                                <textarea  name="product_description[]" tabindex="1"  id="product_description" class='form-align auto_customer tabwid product_description' />  </textarea>                             
                            </td> 
                            <td>
                                <img id="blah" name="product_image[]" tabindex="1" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url").'attachement/product/no-img.gif' ?>"/> 
<!--                                <input type="file" name="product_image[]"  id="product_image" class='form-align auto_customer tabwid' style="display:none"/>                               -->
                            </td> 
                            <td>
                            	<input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                             <span class="error_msg"></span>
                            </td>
                            <td>
                            	<input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                             <span class="error_msg"></span>
                            </td>
                            <td>
                            	<input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                            </td>
                            <td>
                            	<input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                            </td>
                            <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                </table>
                <table class="static_ser" style="display: none;">
                <tr>
                            <td>
                            	<select id='' class='cat_id static_style class_req' name='categoty[]' tabindex="1" >
                                    <option>Select</option>
                                    <?php 
                                        if(isset($category) && !empty($category))
                                        {
                                            foreach($category as $val)
                                            {
                                                ?>
                                                    <option value='<?php echo $val['cat_id']?>'><?php echo $val['categoryName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td>
<!--                            <td class="sub_category">
                            	<select class=" static_color" name='sub_categoty[]'>
                                    <option value="">select</option>                                   
                                </select>
                            </td>-->
                            <td >
                            	<select name='brand[]' tabindex="1" >
                                    <option>Select</option>
                                    <?php 
                                        if(isset($brand) && !empty($brand))
                                        {
                                            foreach($brand as $val)
                                            {
                                                ?>
                                                    <option value='<?php echo $val['id']?>'><?php echo $val['brands']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td> 
                             <td >
                                <input type="text"  name="model_no[]" id="model_no_ser" class='form-align auto_customer tabwid model_no_ser' tabindex="1" />
                                 <span class="error_msg"></span>
                                <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                                <input type="hidden"  name="type[]" id="type_ser" class=' tabwid form-align type type_ser' />
                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                            </td> 
                            <td>
                                <textarea  name="product_description[]" id="product_description" tabindex="1" class='form-align auto_customer tabwid product_description' />  </textarea>                             
                            </td> 
                            <td>
                                <img id="blah" name="product_image[]" tabindex="1" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url").'attachement/product/no-img.gif' ?>"/> 
<!--                                <input type="file" name="product_image[]"  id="product_image" class='form-align auto_customer tabwid' style="display:none"/>                               -->
                            </td> 
                            <td>
                            	<input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                                 <span class="error_msg"></span>
                            </td>
                            <td>
                            	<input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                                 <span class="error_msg"></span>
                            </td>
                            <td>
                            	<input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                            </td>
                            <td>
                            	<input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                            </td>
                            <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                </table>
          
                 <?php       if(isset($quotation) && !empty($quotation))
			{
				foreach($quotation as $val)
				{
					?>
                <form  action="<?php echo $this->config->item('base_url'); ?>quotation/update_quotation/<?php echo $val['id'];?>" method="post" class=" panel-body">
                <table class="table table-striped responsive dataTable no-footer dtr-inline">
                    <tr>
                        <td class="first_td1">Reference Name</td>
                        <td><select id='' class='nick static_style class_req required' tabindex="1"  style="width:170px;" name='quotation[ref_name]'>
                                       <option value='<?php echo $val['ref_name']?>'><?php echo $val['nick_name']?></option>
                                    <?php 
                                        if(isset($nick_name) && !empty($nick_name))
                                        {
                                            foreach($nick_name as $vals)
                                            {
                                                ?>
                                                    <option value='<?php echo $vals['nick_name']?>'><?php echo $vals['nick_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select> <span class="error_msg"></span></td>
                        <td class="first_td1">Quotation NO</td>
                        <td> <input type="text"  tabindex="1" name="quotation[q_no]" class=" form-control colournamedup form-align tabwid" readonly="readonly" value="<?php echo $val['q_no'];?>"  id="grn_no"></td>
                        <td>Company Name</td>
                        <td>
                            <input type="text"  name="customer[store_name]" id="customer_name" tabindex="1" class='auto_customer form-align tabwid required' value="<?php echo $val['store_name'];?>"  />
                             <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer form-align tabwid' value="" />
                              <span class="error_msg"></span>
                             <div id="suggesstion-box" class="auto-asset-search"></div>
                        </td>
                   </tr>
                   <tr>
                        <td class="first_td1">Customer Mobile No</td>
                        <td>
                            <input type="text"  tabindex="1" name="customer[mobil_number]" class="form-align tabwid required" id="customer_no" value="<?php echo $val['mobil_number'];?>"/>
                         <span class="error_msg"></span>
                        </td>
                       <td class="first_td1"  >Customer Email ID</td>
                        <td id='customer_td'>
                            <input type="text" tabindex="1"  name="customer[email_id]" class="form-align tabwid required" id="email_id" value="<?php echo $val['email_id'];?>"/>
                         <span class="error_msg"></span>
                        </td> 
                         <td class="first_td">Tin No</td>
                        <td><input type="text" tabindex="1" name="company[tin_no]" value="<?=$company_details[0]['tin_no']?>" style="width:170px;"  />
                        </td>  
                   </tr>
                   <tr>
                        <td class="first_td1">Customer Address</td>
                        <td colspan="3">
                            <textarea name="customer[address1]" tabindex="1" class="form-align tabwid1 required" id="address1"><?php echo $val['address1'];?></textarea>
                            <span class="error_msg"></span>
                        </td>   
                        <td>Date</td>
                        <td> 
                            <input type="text" tabindex="1"  class="form-align datepicker tabwid required" name="quotation[created_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($val['created_date']));?>">
                            <span class="error_msg"></span>
                        </td>
                   </tr>               
                </table>
                  
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                	<thead>
                    <tr>
                    	<td width="10%" class="first_td1">Category</td>                                               
                        <td width="10%" class="first_td1">Brand</td>
                        <td width="10%" class="first_td1">Model Number</td>  
                        <td width="10%" class="first_td1">Product Description</td>  
                        <td width="10%" class="first_td1">Product Image</td>  
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="2%" class="first_td1">Cost/QTY</td>
                        <td  width="2%" class="first_td1">Tax</td>
                        <td  width="2%" class="first_td1">Net Value</td>
                        <td width="2%" class="action-btn-align">
                            <a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Product</a>
                            <a id='add_group_service' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Service</a>
                       </td>
                    </tr>
                    </thead>
                    <tbody id='app_table'>
                         <?php       if(isset($quotation_details) && !empty($quotation_details))
			{
				foreach($quotation_details as $vals)
				{
					?>
                        <tr>
                            <td>
                            	<select id='' class='cat_id static_style class_req required' name='categoty[]' tabindex="1" >
                                  <option value='<?php echo $vals['cat_id']?>'><?php echo $vals['categoryName']?></option>
                                    
                                    <?php 
                                        if(isset($category) && !empty($category))
                                        {
                                            foreach($category as $va)
                                            {
                                                ?>
                                                    <option value='<?php echo $va['cat_id']?>'><?php echo $va['categoryName']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td>

                            <td >
                                <select name='brand[]' class="brand_id required" tabindex="1" >
                                  <option value='<?php echo $vals['id']?>'> <?php echo $vals['brands']?> </option>
                                    <?php 
                                        if(isset($brand) && !empty($brand))
                                        {
                                            foreach($brand as $valss)
                                            {
                                                ?>
                                                    <option value='<?php echo $valss['id']?>'> <?php echo $valss['brands']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                 <span class="error_msg"></span>
                            </td> 
                             <td>                                 
                                <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no required' tabindex="1"  value="<?php echo $vals['model_no'];?>"/>
                                <span class="error_msg"></span>
                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id'];?>" />
                                <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type'];?>" />
                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                            </td> 
                            <td>
                                <textarea  name="product_description[]" tabindex="1" id="product_description" class='form-align auto_customer tabwid product_description' /><?php echo $vals['product_description']; ?></textarea>                             
                            </td> 
                            <td>
                                <img id="blah" name="product_image[]" tabindex="1" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url")?>attachement/product/<?php echo $vals['product_image'];?>"/> 
                            </td> 
                             <td> 
                            	<input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity']?>"/>
                                <span class="error_msg"></span>
                             </td>
                            <td>
                            	<input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost required " value="<?php echo $vals['per_cost']?>"/>
                                 <span class="error_msg"></span>
                            </td>
                            <td>
                            	<input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax']?>" />
                            </td>
                            <td>
                            	<input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total']?>"/>
                            </td>
                            <input type="hidden" value = "<?php  echo $vals['del_id']; ?>" class="del_id"/>
                            <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php  echo $vals['del_id']; ?>" class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                         <?php
                                            }
                                        }
                                    ?>
                    </tbody>
                        
                    <tfoot>
                    	<tr>
                            <td colspan="5" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"   name="quotation[total_qty]"  tabindex="1" readonly="readonly" value="<?php echo $val['total_qty'];?>" class="total_qty" style="width:70px;" id="total" /></td>
                            <td colspan="2" style="text-align:right;">Sub Total</td>
                            <td><input type="text" name="quotation[subtotal_qty]"  tabindex="1" readonly="readonly" value="<?php echo $val['subtotal_qty'];?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="1" name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label'];?>"/></td>
                            <td>
                            	<input type="text"  name="quotation[tax]" class='totaltax text_right' tabindex="1"  value="<?php echo $val['tax'];?>"  style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  tabindex="1" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total'];?>" /></td>
                            <td></td>
                        </tr>
                         <tr>

                            <td colspan="10" style="">
                            	<span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span> 
                              <input name="quotation[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks'];?>" tabindex="1"  />
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-striped" style="width:100%;border:1 solid #CCC;">
                	<tr>
                    	<td  style="width:49%;">
                        	<table style="width:100%;">
                                <tr>
                                	<td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>Delivery Schedule</td>
                                    <td></td>
                                    <td>
                                        <div class="input-group" style="width:70%;">
                                        <input type="text" class="form-control datepicker class_req borderra0 terms" tabindex="1" name="quotation[delivery_schedule]" value="<?php echo $val['delivery_schedule'];?>" placeholder="dd-mm-yyyy" >
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                         </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Notification Date</td>
                                    <td></td>
                                    <td> 
                                        <div class="input-group" style="width:70%;">
                                        <input type="text"  id='to_date' class="form-control datepicker borderra0 terms" tabindex="1"  name="quotation[notification_date]" value="<?php echo $val['notification_date'];?>" placeholder="dd-mm-yyyy" >                                  
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Mode of Payment</td>
                                    <td></td>
                                    <td>
                                    <div class="input-group" style="width:70%;">
                                    <input type="text" class="form-control class_req borderra0 terms" tabindex="1" value="<?php echo $val['mode_of_payment'];?>" name="quotation[mode_of_payment]"/>
                                    </div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>4.</td>
                                    <td>Validity</td>
                                    <td></td>
                                    <td>
                                    <div class="input-group" style="width:70%;">
                                    <input type="text" class="form-control class_req borderra0 terms" tabindex="1" value="<?php echo $val['validity'];?>" name="quotation[validity]"/>
                                    </div>
                                    </td>
                                </tr>
                                   <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['customer'];?>"/>
                              
                            </table>
                        </td>
                        <td style="width:49%;">
                        	
                        </td>
                    </tr>
                </table>
                <div class="action-btn-align">
               
                
                <?php if($val['estatus'] == 2) { ?>
                
                     <a href="<?php echo $this->config->item('base_url').'quotation/quotation_list/'?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                    <?php  }
                    else{
                 ?>
                      <button class="btn btn-info" id="save"> Update </button>
                <a href="<?php echo $this->config->item('base_url').'quotation/change_status/'.$quotation[0]['id'].'/2'?>" class="btn complete"><span class="glyphicon"></span> Complete </a>
                <a href="<?php echo $this->config->item('base_url').'quotation/quotation_list/'?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                </div>
                </form>
                <br />

                <?php }}}
                    ?>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
   
        <script type="text/javascript">
        $('#save').live('click',function(){  
        m=0;
        $('.required').each(function(){
        this_val = $.trim($(this).val()); 
        this_id = $(this).attr("id");
        if(this_val == "") {

            $(this).closest('tr').find('.error_msg').text('This field is required').css('display','inline-block');
            m++;
        }                       
        else {
            $(this).closest('tr').find('.error_msg').text('');
        }            
        });        
        if(m>0)
        return false;
       
        //$("#quotation").submit();
         
    });   
     $(document).ready(function() {
       // var $elem = $('#scroll');
      //  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function(){
            $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url');?>" + "quotation/get_customer",
            data:'q='+$(this).val(),
            success: function(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background","#FFF");
            }
            });
        });
        $('body').click(function(){
            $("#suggesstion-box").hide();  
        });
    }); 
    
    $('.cust_class').live('click',function(){
        $("#customer_id").val($(this).attr('cust_id'));
        $("#cust_id").val($(this).attr('cust_id'));
        $("#customer_name").val($(this).attr('cust_name'));
        $("#customer_no").val($(this).attr('cust_no'));
        $("#email_id").val($(this).attr('cust_email'));
        $("#address1").val($(this).attr('cust_address'));
    });  
   	
        $('#add_group').click(function(){
            var tableBody = $(".static").find('tr').clone();
            $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
            $('#app_table').append(tableBody);            
        });
        
        $('#add_group_service').click(function(){
            var tableBody = $(".static_ser").find('tr').clone();
            $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
            $('#app_table').append(tableBody);            
        });
        
        $('#delete_group').live('click',function(){         
            $(this).closest("tr").remove();
             calculate_function();
        });
         $('#delete_label').live('click',function(){         
            $(this).closest("tr").remove();
             calculate_function();
        });
         $('.del').live('click',function(){    
              
            var del_id =$(this).closest('tr').find('.del_id').val();
       
            $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url');?>" + "quotation/delete_id",
            data:{ del_id:del_id
                },
            success: function(datas){
              calculate_function();
               
            }
            });
            
        });
        
        $(".remove_comments").live('click',function(){
              $(this).closest("tr").remove();
              var full_total=0;
              $('.total_qty').each(function(){
                      full_total=full_total+Number($(this).val());
              });	
              $('.full_total').val(full_total);
              console.log(full_total);
        });
        

	   		
	$('.qty,.percost,.pertax,.totaltax').live('keyup',function(){
                 calculate_function();
            });
            function calculate_function()
                {
                    var final_qty=0;
                    var final_sub_total=0;
                    $('.qty').each(function(){
                        var qty=$(this);
                        var percost=$(this).closest('tr').find('.percost');
                        var pertax=$(this).closest('tr').find('.pertax');
                        var subtotal=$(this).closest('tr').find('.subtotal');
                       
                        if(Number(qty.val())!=0)
                        {
                            pertax1= Number(pertax.val()/100) * Number(percost.val());
                            sub_total=( Number(qty.val()) * Number(percost.val()) ) + ( pertax1 * Number(qty.val()) );
                            subtotal.val(sub_total.toFixed(2));
                            final_qty=final_qty+Number(qty.val());
                            final_sub_total=final_sub_total+sub_total;
                        }
                    });
                    $('.total_qty').val(final_qty);
                    $('.final_sub_total').val(final_sub_total.toFixed(2));
                    $('.final_amt').val((final_sub_total+Number($('.totaltax').val())).toFixed(2));
                }

   $(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#po_no").autocomplete(BASE_URL+"gen/get_po_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/search_result",
					  type:'GET',
					  data:{
						  	po       :$('#po_no').val(),
						 	style    :$('#style').val(),
							supplier :$('#supplier').val(),
							supplier_name:$('#supplier').find('option:selected').text(),
							from_date:$('#from_date').val(),
							to_date  :$('#to_date').val()
						   },
					  success:function(result){
						   for_response(); 
						$('#result_div').html(result);
					  }    
				});
			});
		
        </script>
        <script>
        $(".model_no").live('keyup',function(){  
              var this_ = $(this)
            $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url');?>" + "quotation/get_product",
            data:'q='+$(this).val(),
            success: function(datas){
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);
               
            }
            });
        });
        
        $("#model_no_ser").live('keyup',function(){  
              var this_ = $(this)
            $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url');?>" + "quotation/get_service",
            data:'s='+$(this).val(),
            success: function(datas){
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);
               
            }
            });
        });
        
     $(document).ready(function() {  
        $('body').click(function(){
           $(this).closest('tr').find(".suggesstion-box1").hide();  
        });
  
      });
    $('.pro_class').live('click',function(){         
        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell')); 
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id')); 
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));          
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name')+ "  " + $(this).attr('pro_description'));   
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url").'attachement/product/' ?>"+$(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();  
        calculate_function();
    });  
     $('.ser_class').live('click',function(){       
        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell')); 
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type')); 
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id')); 
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_no'));          
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name')+ "  " + $(this).attr('ser_description'));   
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url").'attachement/product/' ?>"+$(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide(); 
           calculate_function();
    }); 
            
</script>