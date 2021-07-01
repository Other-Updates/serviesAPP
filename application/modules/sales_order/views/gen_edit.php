 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
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
                        <h4>Edit Sales Order</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <?php 
			//echo "<pre>";
			//	echo "<pre>";
			//	print_r($gen_info[0]);
			//	print_r($all_style);
			//	print_r($all_color);
			?>
            <div class="contentpanel">
            <form method="post">
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            	
               <tr>
               		<td>State</td>
                    <td>
                    	<?=$gen_info[0]['state']?>
                    	<!--<select id='state' name="state" style="width: 170px;">
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
                        </select>-->
                    </td>
                    <td>Customer</td>
                    <td id='customer_td'>
                    	<?=$gen_info[0]['name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
              <?php
            //  echo "<pre>";
			//  print_r($gen_info);
			  ?>
               </tr>
               <tr>
               		<td>Sales Order No</td>
                    <td><?=$gen_info[0]['grn_no']?></td>
                    <td>Date</td>
                    <td>
                    	<?=$gen_info[0]['inv_date']?>
                    	 <!-- <div class="input-group">
                            <input type="text" class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="datepicker">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>-->
                    </td>
               </tr>
               </table>
               <br />
               <table style="display:none;">
                <tr id="last_row">
                    <td>
                            	<select  class='style_id'  name="style_code[]">
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
                            <td  class="style_html"></td>
                            <td>
                            	<select  name="color[]" class="color_class">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_color) && !empty($all_color))
                                        {
                                            foreach($all_color as $val)
                                            {
                                                ?>
                                                    <option value='<?=$val['id']?>'><?=$val['colour']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td  class="size_html"></td>
                            <td>
                            	<input type="text"  name="qty_total[]" style="width:70px;" class="total_qty" />
                            </td>
                             <td class="mrp_html"></td>
                           <td><input type="text"                     class="total_value" style="width:60px;" /></td>
                            <td><input type="text"  name="st_total[]" class="st_val" style="width:60px;" /></td>
                            <td><input type="text"  name="cst_total[]" class="cst_val" style="width:60px;" /></td>
                            <td><input type="text"  name="vat_total[]" class="vat_val" style="width:60px;" /></td>
                            <td><input type="text"  name="net_total[]" class="net_val" style="width:60px;" /></td>
                            <td>
                            	<input type="button" value="-" class='remove_comments btn btn-danger'/>
                            </td>
                            
                        </tr>
                </table>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td width="5%">Style Code</td>
                 
                    	<td width="5%">Color</td>
                        <td>Size</td>
                        <td  width="5%">Qty</td>
                        <td  width="5%">MRP</td>
                        <td  width="5%">Order Value</td>
                        <td  width="5%">ST<input type="text" id='st' value="<?=$gen_info[0]['st']?>" name="st" style="width:50px;"/></td>
                        <td  width="5%">CST<input type="text" id='cst' value="<?=$gen_info[0]['cst']?>" name='cst' style="width:50px;"/></td>
                        <td  width="5%">VAT<input type="text" id='vat' value="<?=$gen_info[0]['vat']?>" name='vat' style="width:50px;"/></td>
                        <td  width="5%">Net Value</td>
                        <td width="5%"><input type="button" value="+" title="Add row" id='add_group' class="btn btn-primary" /></td>
                    </tr>
                    <tbody id='app_table'>
                    <?php 
					$net_o_val=0;
					$net_final_val=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
						//	echo "<pre>";
						//	print_r($info);
					?>
                    	<tr>
                        	<td>
                            	<select class='style_id'  name="style_code[]">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_style) && !empty($all_style))
                                        {
                                            foreach($all_style as $val)
                                            {
                                                ?>
                                                    <option <?=($info['style_id']==$val['id']?'selected':'')?> value='<?=$val['id']?>'><?=$val['style_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                           
                            <td>
                            	<select  name="color[]"  class="color_class">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_color) && !empty($all_color))
                                        {
                                            foreach($all_color as $val)
                                            {
                                                ?>
                                                    <option  <?=($info['color_id']==$val['id']?'selected':'')?> value='<?=$val['id']?>'><?=$val['colour']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td class="size_html">
                           		 <?php 
								 	$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												$full_total=$full_total+$val['qty'];
                                                ?>
                                                    <div style="text-align:center;float:left;" >
                                                    	<p  style="margin: 0 0 0px;"  ><?=$val['size']?></p>
                                                        <p   style="margin: 0 0 0px;">
                                                        	<input type="text" class="s_size int_val" id="<?=$val['size_id']?>"  value="<?=$val['qty']?>" style="width:50px;" />
                                                        </p>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                            
                            </td>
                            <td>
                            	<input type="text" value="<?=$full_total;?>"  name="qty_total[]" style="width:70px;" class="total_qty" />
                            </td>
                            
                           
                             <td class="mrp_html">
                             <input type="text" style="width:70px;" value="<?=$info['mrp']?>" class="total_mrp1" />
                             </td>
                             <?php 
							 	$o_val=$full_total*$info['mrp'];
								$net_o_val=$net_o_val+$o_val;
								$st_val=($o_val*($gen_info[0]['st']/100));
								$cst_val=($o_val*($gen_info[0]['cst']/100));
								$vat_val=($o_val*($gen_info[0]['vat']/100));
								$final_total=$o_val+$st_val+$cst_val+$vat_val;
								$net_final_val=$net_final_val+$final_total;
							 ?>
                            <td><input type="text"   value='<?=round($o_val,2);?>'                  class="total_value" style="width:60px;" /></td>
                            <td><input type="text"   value='<?=round($st_val,2);?>' name="st_total[]" class="st_val" style="width:60px;" /></td>
                            <td><input type="text"  value='<?=round($cst_val,2);?>' name="cst_total[]" class="cst_val" style="width:60px;" /></td>
                            <td><input type="text"  value='<?=round($vat_val,2);?>' name="vat_total[]" class="vat_val" style="width:60px;" /></td>
                            <td><input type="text"  value='<?=round($final_total,2);?>' name="net_total[]" class="net_val" style="width:60px;" /></td>
                            <td></td>
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="3" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"  name="full_total[]" value="<?=$gen_info[0]['full_total'];?>" class="full_total" style="width:70px;" /></td>
                            <td></td>
                            <td><input type="text" value="<?=round($net_o_val,2);?>" name="net_value"  class="final_total" style="width:60px;" /></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text"  value="<?=round($net_final_val,2);?>" name="net_final_total"  class="net_final_total" style="width:60px;" /></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <input type="submit" class="btn btn-primary btn-rounded" id='add_gen' value="Update" style="float:right;"/>
                </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		 // Date Picker
		 $(document).ready(function(){
			$('#add_gen').click(function(){
				$('.color_class').each(function(){
					var color_id=$(this).val();
					var s_html=$(this).closest('tr').find('.s_size');	
					var s_id=$(this).closest('tr').find('.style_id');	
					$(s_html).each(function(){
						$(this).attr('name','size['+s_id.val()+']['+color_id+']['+$(this).attr('id')+']');
					});		
				});
			});	
		 });
 
		
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
			
				$.ajax({
					  url:BASE_URL+"sales_order/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  
						 $('#customer_td').html(result);
					  }    
				});
				
		});
		$('#state').live('change',function(){
			
				$.ajax({
					  url:BASE_URL+"sales_order/get_tax",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  data=result.split("-");
						$('#st').val(data[1]);
						$('#cst').val(data[2]);
						$('#vat').val(data[3]);
					  }    
				});
				
		});
		
		
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.style_html');		 
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 s_html.html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.size_html');	
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id1",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						s_html.html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.mrp_html');		 
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id2",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 s_html.html(result);
					  }    
				});
		});
		$('.s_size').live('keyup',function(){
			
			var total=0;
			var full_total=0;
			var last=0;
			var s_list=$(this).closest('tr').find('.s_size');	
			var s_total=$(this).closest('tr').find('.total_qty');
			var s_mrp=$(this).closest('tr').find('.total_mrp1').val();
			var s_net=$(this).closest('tr').find('.total_value');
			
			var st_val=$(this).closest('tr').find('.st_val');
			var cst_val=$(this).closest('tr').find('.cst_val');
			var vat_val=$(this).closest('tr').find('.vat_val');
			var net_val=$(this).closest('tr').find('.net_val');
			
			$(s_list).each(function(){
				total=total+Number($(this).val());
			});		
			console.log(Number(s_mrp) * total);
			s_total.val(total);
			org_val=Number(s_mrp) * total;
			s_net.val(org_val.toFixed(2));
			p1=org_val*($('#st').val()/100);
			p2=org_val*($('#cst').val()/100);
			p3=org_val*($('#vat').val()/100);
			st_val.val(p1.toFixed(2));
			cst_val.val(p2.toFixed(2));
		    vat_val.val(p3.toFixed(2));
			last=org_val+p1+p2+p3;
			net_val.val(last.toFixed(2));
			
			
			
			$('.total_qty').each(function(){
				full_total=full_total+Number($(this).val());
			});	
			$('.full_total').val(full_total);
			total_value=0;
			$('.total_value').each(function(){
				total_value=total_value+Number($(this).val());
			});	
			$('.final_total').val(total_value);
			
			net_final_total=0;
			$('.net_val').each(function(){
				net_final_total=net_final_total+Number($(this).val());
			});	
			$('.net_final_total').val(net_final_total.toFixed(2));
			
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
		</script>