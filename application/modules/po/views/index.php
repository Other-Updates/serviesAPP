<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
 <style type="text/css">
 	.text_right
	{
		text-align:right;
	}
 </style>
<div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Add PO</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <?php 
			//echo "<pre>";
			//	echo "<pre>";
			//	print_r($all_state);
			//	print_r($all_style);
			//	print_r($all_color);
			?>
            <div class="contentpanel">
            <form method="post">
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            	
               <tr>
               		<td class="first_td1">State</td>
                    <td>
                    	<select id='state' name="state" style="width: 170px;" class="form-control class_req">
                        	<option>Select</option>
                            <?php 
								if(isset($all_state) && !empty($all_state))
								{
									foreach($all_state as $val)
									{
										?>
                                        	<option value='<?=$val['id']?>'><?=$val['state']?></option>
                                        <?php
									}
								}
							?>
                        </select>
                    </td>
                    <td class="first_td1">Supplier</td>
                    <td id='customer_td'>
                    	<select  name="customer"  style="width: 170px;" class="form-control class_req">
                        	<option>Select</option>
                        </select>
                    </td>
              
               </tr>
               <tr>
               		<td class="first_td1">PO NO</td>
                    <td> <input type="text"  tabindex="-1" name="grn_no" style="width:170px;" class="code form-control colournamedup" readonly="readonly" value="<?=$last_no?>" id="grn_no"></td>
                    <td ></td>
                    <td>
                     <input type="hidden"   name="lot_no" id='tin' readonly="readonly" style="width:170px;" class="code form-control colournamedup"  />
                    	  <input type="hidden"  tabindex="-1"   style="width:170px;" class="code form-control colournamedup" readonly="readonly" />
                         <!--/* <span style="font-weight:bold;" id='lot_no_span'  style="display:none;">
                          	
                          </span>*/-->
                    </td>
               </tr>
               </table>
               <br />
               <input type="hidden" value="select" name='style_code[]'  class="form-control"/>
               <table style="display:none;">
                <tr id="last_row">
                    <td>
                            	<input type="hidden"   class='style_id dynamic_style form-control'  name="style_all[]">
                                    
                            </td>
                            <td  class="color_div">
                            	<select  name="color[]" class="color_class color_cmp check_cream">
                                    <option value="">Select</option>
                                    
                                   
                                </select>
                                <input type="hidden" name='style[]' class="sty_class" value="<?=$val['size_id']?>" />
                            <input type="hidden" name='color[]' class="col_class"value="<?=$val['qty']?>" />
                            </td>
                            <td class="lot_td">
                            	<input type="text" name='style_lot_no[]' tabindex="-1" readonly="readonly" style="width:130px;" class="lot_clas" />
                            </td> 
                            <td  class="size_html"></td>
                            <td>
                            	<input type="text"  readonly="readonly"  tabindex="-1" name="qty_total[]" style="width:70px;" class="total_qty " />
                            </td>
                             <td  class="mrp_html">
                         
                            </td>
                            <td>
                            	<input type="text"  readonly="readonly"  tabindex="-1" style="width:70px;" class="total_value text_right text_right" />
                            </td>
                            <td>
                            	<input type="button"   tabindex="-1" value="-" class='remove_comments btn btn-danger form-control'/>
                            </td>
                            
                        </tr>
                </table>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td width="10%" class="first_td1">Style</td>
                        <td width="10%" class="first_td1">Color</td>   
                        <td width="10%" class="first_td1">Lot No</td>                        
                        <td class="first_td1">Size</td>
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="5%" class="first_td1">LANDED&nbsp;COST</td>
                        <td  width="5%" class="first_td1">Net Value</td>
                        <td width="5%"><input type="button" value="+" style="display:none;"  tabindex="-1" title="Add row" id='add_group' class="btn btn-primary form-control" /></td>
                    </tr>
                    <tbody id='app_table'>
                    	<tr>
                        	<td>
                            	<select id='single_style' class='style_id static_style class_req' name="style_all[]">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_style) && !empty($all_style))
                                        {
                                            foreach($all_style as $val)
                                            {
                                                ?>
                                                    <option value='<?=$val['id']?>'><?=$val['style_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td class="color_div">
                            	<select  name="color[]"   class="color_class static_color">
                                    <option value="">select</option>
                                   
                                </select>
                            </td>
                            <td class="lot_td">
                            	<input type="text" name="style_lot_no[]"  tabindex="-1" readonly="readonly" style="width:130px;" class="lot_clas" />
                            </td> 
                            <td class="size_html int_val"></td>
                            <td>
                            	<input type="text"   tabindex="-1" readonly="readonly" name="qty_total[]" style="width:70px;" class="total_qty " />
                            </td>
                            <td  class="mrp_html">
                            	
                            </td>
                            <td>
                            	<input type="text"   tabindex="-1" style="width:70px;" readonly="readonly" class="total_value text_right" />
                            </td>
                            <td>
                            	
                            </td>
                            
                        </tr>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"  name="full_total[]"  tabindex="-1" readonly="readonly" class="full_total" style="width:70px;" /></td>
                            <td style="text-align:right;">Sub Total</td>
                            <td><input type="text" name='org_total'  tabindex="-1" readonly="readonly"  class="final_total text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3" style="text-align:right;font-weight:bold;">ST ( <span class="st"></span> % )</td>
                            <td>
                            	<input type="hidden" name="st" class='st'  tabindex="-1" readonly="readonly"  style="width:70px;" />
                            	<input type="text"  class='st_val text_right'  tabindex="-1" readonly="readonly"   style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3" style="text-align:right;font-weight:bold;">CST ( <span class="cst"></span> % )</td>
                            <td>
                            	<input type="hidden"  name="cst" class='cst'  tabindex="-1" readonly="readonly"   style="width:70px;" />
                                <input type="text"   class='cst_val text_right'  tabindex="-1" readonly="readonly"  style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3"style="text-align:right;font-weight:bold;">VAT ( <span class="vat"></span> % )</td>
                            <td>
                            	<input type="hidden"  name="vat" class='vat'  tabindex="-1" readonly="readonly"  style="width:70px;" />
                                <input type="text"   class='vat_val text_right'  tabindex="-1" readonly="readonly"   style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text" name='net_total' readonly="readonly"  tabindex="-1" class="final_net text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                         <tr>
                            <td colspan="8" style="">
                            	<span style="float:left; position:relative; top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> <input  style="float:left;width:90%;" type="text" class="form-control" name="remarks" />
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
                                        <input type="text"  id='datepicker' class="form-control datepicker class_req" name="delivery_schedule" placeholder="dd-mm-yyyy" >
                                        <input type="hidden" id="today" name="inv_date" value="<?php echo $i=date("d-m-y");  ?>" />
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                         </div>
                                    </td>
                                </tr>
                                <tr>
                                	<td>2.</td>
                                    <td>Delivery at</td>
                                    <td></td>
                                    <td><input type="text" style="width:261px;" class="form-control class_req" name="delivery_at" /></td>
                                </tr>
                                <tr>
                                	<td>3.</td>
                                    <td>Mode of Payment</td>
                                    <td></td>
                                    <td><input type="text" style="width:261px;" class="form-control class_req" name="mode_of_payment" /></td>
                                </tr>
                               
                            </table>
                        </td>
                        <td style="width:49%;">
                        	
                        </td>
                    </tr>
                </table>
               <div class="action-btn-align">
                <input type="submit" class="btn btn-primary btn-rounded"  value="Create"/>
               </div>
                <br />
                </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		 // Date Picker
		  
		 $(document).ready(function(){
			 var today = new Date();
			   var dd = today.getDate();
			   var mm = today.getMonth()+1; //January is 0!
			  
			   var yyyy = today.getFullYear();
			   if(dd<10){
				dd='0'+dd
			   } 
			   if(mm<10){
				mm='0'+mm
			   } 
			  // var today = yyyy+'-'+mm+'-'+dd;
			  var today = dd+'-'+mm+'-'+yyyy;
			   $('#today').val(today);
	        jQuery('#datepicker').datepicker(); 
			$('#add_gen').click(function(){
				
				$('.color_class').each(function(){
					var color_id=$(this).val();
					var s_html=$(this).closest('tr').find('.s_size');	
					var s_id=$(this).closest('tr').find('.style_id');	
					var style_id=$(this).closest('tr').find('.style_id').val();	
					$(s_html).each(function(){
						$(this).attr('name','size['+style_id+']['+color_id+']['+$(this).attr('id')+']');
					});		
				});
			//	return false;
				var i=0;
					$('.class_req').each(function(){
				
						if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select' ||  $(this).val()==0)
						{
							
							$(this).css('border-color','red');
							i=1;
							
						}
						else
						{
							$(this).css('border-color','');
						}
						
					});
					$('.color_cmp').each(function(){
						
						var arr=$(this).attr('class').split(' '); 
						//var arr=$(this).val();
						console.log(arr);
						
						
						$('.'+arr[1]).each(function(){
							var my=$(this).val();
							var count=0;
							$('.'+arr[1]).each(function(){
								
								if($(this).val()!='Select' || $(this).val()!='')
								{
									if(my==$(this).val())
									{
										count++;
									}
								}
							});
							if( count >= 2)
							{
								i=1;
								$('.'+arr[1]).each(function(){
									$(this).css('border-color','red');
								});
							}
							else
							{
								$(this).css('border-color','');
							}
							
						});
						
					});
					  var dateString =$('#datepicker').val();
			 var today = $('#today').val();
			 if(dateString=="")
			 { 
			 }
			 else if(dateString<today)
			 { 
				$("#colorpoerror").html("You cannot select past date!");
				i=1;
			 }
			 else
			 {
				  $("#colorpoerror").html("");
				   $(this).css('border-color',''); 
			 }
	
					if(i==1)
					{
						return false;
					}
					else
					{
						return true;
					}
					});
		 });
 
		document.onkeyup = KeyCheck;
 
		function KeyCheck(e)
		{
		   var KeyID = (window.event) ? event.keyCode : e.keyCode;
		   if(KeyID == 113)
		   {
				$('#last_row').clone().appendTo('#app_table');  	
		   }
		}
        $('#add_group').click(function(){
		 	$('#last_row').clone().appendTo('#app_table');  	
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
	   	$('#state').live('change',function(){
				for_loading(); // loading notification
				$.ajax({
					  url:BASE_URL+"gen/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					 	 success:function(result){
						   for_response(); // resutl notification
						 $('#customer_td').html(result);
						 var tax=$('.customer').attr('class').split(" ");
						 console.log(tax);
						 if(tax[1]=='0')
						 {
						 	$('.st').html(0);
							$('.st').val(0);
							$('.st').closest('tr').hide();
						 }
						 else
						 {
						 	$('.st').html(tax[1]);
							$('.st').val(tax[1]);
						 }
						 if(tax[2]=='0')
						 {
						 	$('.cst').html(0);
							$('.cst').val(0);
							$('.cst').closest('tr').hide();
						 }
						 else
						 {
						 	$('.cst').html(tax[2]);
							$('.cst').val(tax[2]);
						 }
						if(tax[3]=='0')
						{
							$('.vat').html(0);
							$('.vat').val(0);
							$('.vat').closest('tr').hide();
						}
						else
						{	
						 	$('.vat').html(tax[3]);
							$('.vat').val(tax[3]);
						}
						
					  }    
				});
		});
		$('.style_id').live('change',function(){
			$('#add_group').show();
			var s_html=$('.color_div');
			$('.dynamic_style').val($(this).val());	
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						 s_html.html(result);
					  }    
				});
			}
		});
		$('.customer').live('change',function(){
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/get_tin",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 for_response(); 
						 $('#tin').val(result);
					  }    
				});
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
				var s_html=$('.size_html');
				for_loading(); 	
					$.ajax({
						  url:BASE_URL+"gen/get_all_style_details_by_id1",
						  type:'GET',
						  data:{
							  s_id:$(this).val()
							   },
						  success:function(result){
							   for_response(); 
							s_html.html(result);
						  }    
					});
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
				var s_html=$('.mrp_html');		
				for_loading();  
					$.ajax({
						  url:BASE_URL+"gen/get_all_style_details_by_id2",
						  type:'GET',
						  data:{
							  s_id:$(this).val()
							   },
						  success:function(result){
							   for_response(); 
							 s_html.html(result);
						  }    
					});
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/get_lot_no",
					  type:'GET',
					  data:{
						  s_id:$(this).val(),
						  s_name:$(this).find('option:selected').text()
						   },
					  success:function(result){
						  for_response(); 
						  $('#lot_no_span').html($.trim(result));
						  $('#lot_no').val($('#lot_no_span').html());
					  }    
				});
			}
		});
		
		$('.s_size').live('keyup',function(){
			
			var total=0;
			var full_total=0;
			
			var s_list=$(this).closest('tr').find('.s_size');	
			var s_total=$(this).closest('tr').find('.total_qty');
			var s_mrp=$(this).closest('tr').find('.total_mrp1').val();
			var s_net=$(this).closest('tr').find('.total_value');
			$(s_list).each(function(){
				total=total+Number($(this).val());
			});		
			console.log(Number(s_mrp) * total);
			s_total.val(total);
			s_net.val(Number(s_mrp) * total);
			$('.total_qty').each(function(){
				full_total=full_total+Number($(this).val());
			});	
			$('.full_total').val(full_total);
			total_value=0;
			$('.total_value').each(function(){
				total_value=total_value+Number($(this).val());
			});	
			$('.final_total').val(total_value.toFixed(2));
			st_val=total_value*( Number($('.st').html()) / 100 );
			$('.st_val').val(st_val.toFixed(2));
			cst_val=total_value*( Number($('.cst').html()) / 100 );
			$('.cst_val').val(cst_val.toFixed(2));
			vat_val=total_value*( Number($('.vat').html()) / 100 );
			$('.vat_val').val(vat_val.toFixed(2));
			$('.final_net').val(Number(st_val) + Number(cst_val) + Number(vat_val) + Number(total_value.toFixed(2)));
		});
			/*$(document).ready(function(){
				 $.ajax({
					  url:BASE_URL+"stock/stock_details",
					  type:'GET',
					  data:{
						    },
					  success:function(result){
						  $('#stock_details').html(result);
					  }    
				});
		    });	
			$('.edit_btn').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','block');
				$('#remove_'+data[1]).css('display','block');
				$('.size_'+data[1]).removeAttr('readonly');
				$(this).hide();
			});
			$('.size_remove').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.size_'+data[1]).attr('readonly','readonly');
			});
			$('.size_ok').live('click',function(){
				data=$(this).attr('id').split("_");
				$('#remove_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.size_'+data[1]).attr('readonly','readonly');
				var c_array=arry_list='';
				$('.size_'+data[1]).each(function(){
					stock_id=arry_list[1];
					arry_list=$(this).attr('id').split("_");
					c_array=c_array+arry_list[2]+'_'+$(this).val()+',';
				});
				$.ajax({
					  url:BASE_URL+"stock/update_stock_details",
					  type:'GET',
					  data:{
						  s_id:stock_id,
						  s_list:c_array
						   },
					  success:function(result){
						  $('#stock_details').html(result);
					  }    
				});
			});
			$('.ccolor').live('keyup',function(){
		    	if($(this).val()<=0)
					$(this).css('background-color','#F4D5D5');
				else
					$(this).css('background-color','');	
				data=$(this).attr('id').split("_");	
				
				total=0;
				$('.size_'+data[1]).each(function(){
					total=total+Number($(this).val());
				});
				$('.total_'+data[1]).val(total);
				
				f_total=0;
				$('.ctotal').each(function(){
					f_total=f_total+Number($(this).val());
				});
				$('#f_total').val(f_total);
				
			});
			$('.m_style').live('change',function(){
				$.ajax({
					  url:BASE_URL+"stock/get_color_by_style_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  
						 $('#color_td').html(result);
					  }    
				});
			});*/
			$('.color_class').live('change',function(){
				var lot_c=$(this).closest('tr').find('.lot_clas');
				$.ajax({
					  url:BASE_URL+"po/get_lot_no_by_color",
					  type:'GET',
					  data:{
						  s_id:$(this).closest('tr').find('.style_id').val(),
						  s_name:$('#single_style').find('option:selected').text(),
						  c_name:$(this).find('option:selected').text(),
						  c_id:$(this).val()
						   },
					  success:function(result){
						
						lot_c.val(result);
					  }    
				});
			});
        </script>
        <script type="text/javascript">
		$(".int_val").live('keypress',function(event){
  	var characterCode = (event.charCode) ? event.charCode : event.which ;
		var browser;
		if($.browser.mozilla)
		{
      		if((characterCode > 47 && characterCode < 58) || characterCode==8 || event.keyCode==39  || event.keyCode==37 || characterCode==97 || characterCode==118) 
		  {
		   
			return true;
		  }
		  return false;
		}
		if($.browser.chrome)
		{
     		if (event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57)) {
        //display error message
        
               return false;
   			 }
		}
			 
	
 });
 			$('.class_req').live('blur',function(){
			if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select')
			{
				i=1;
				$(this).css('border-color','red');
			}
			else
			{
				$(this).css('border-color','');
			}
		});
		
		$('.color_cmp').live('change',function(){
			/*var i=0;
			var checked = [];
			$(".color_cmp").each(function()
			{
				checked[i]=$(this).val();
				i++;
			
			});
			arr = $.unique(checked);*/
			$('.color_cmp').each(function(){
						
						var arr=$(this).attr('class').split(' '); 
						//var arr=$(this).val();
						console.log(arr);
						
						
						$('.'+arr[1]).each(function(){
							var my=$(this).val();
							var count=0;
							$('.'+arr[1]).each(function(){
								
								if($(this).val()!='Select' || $(this).val()!='')
								{
									if(my==$(this).val())
									{
										count++;
									}
								}
							});
							if( count >= 2)
							{
								k=1;
								$('.'+arr[1]).each(function(){
									$(this).css('border-color','red');
								});
							}
							else
							{
								$(this).css('border-color','');
							}
							
						});
						
					});
		
			
		});
		$("#datepicker").live('change',function()
		{
			 var dateString =$('#datepicker').val();
			 var today = $('#today').val();
			 if(dateString=="")
			 { 
			 }
			 else if(dateString<today)
			 { 
				$("#colorpoerror").html("You cannot select past date!");
			 }
			 else
			 {
				  $("#colorpoerror").html("");
				   $(this).css('border-color',''); 
			 }
		}); 
		
		
		
		/*$("#datepicker").live('change',function()
		{
		 var dateString = $('#datepicker').val().split("-");

    //var today = $('#today').val();
    dateString=dateString[2]+'-'+dateString[1]+'-'+dateString[0];
     
    var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
     
      var yyyy = today.getFullYear();
      if(dd<10){
    dd='0'+dd
      } 
      if(mm<10){
    mm='0'+mm
      } 
       var today = yyyy+'-'+mm+'-'+dd;
      
      var d= new Date(today);
    var a= new Date(dateString);
    var diff=(a-d) /(1000*24*60*60);0
   if(diff>0)
   {
        //alert('after');
	   $("#colorpoerror").html("You cannot select Future date!");
   }
   else
   {
	   $("#colorpoerror").html("");
	   $(this).css('border-color','');      
       // alert('before');
   }
	
		});*/
	
		</script>