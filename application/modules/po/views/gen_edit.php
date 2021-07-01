<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
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
                        <h4>Edit PO</h4>
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
                    <td>Supplier</td>
                    <td id='customer_td'>
                    	<?=$gen_info[0]['name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
              
               </tr>
               <tr>
               		<td>PO NO</td>
                    <td><!--<input type="text" name="inv_no"  />--><b><?=$gen_info[0]['grn_no']?></b></td>
                    <td>Date</td>
                    <td>
                    	<?=date('d-M-Y',strtotime($gen_info[0]['inv_date']))?>
                    	 <!-- <div class="input-group">
                            <input type="text" class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="datepicker">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>-->
                    </td>
               </tr>
               <tr>
               		<td colspan="2">Tin / Vat No</td>
                    <td colspan="2"><?=$gen_info[0]['lot_no']?></td>
               </tr>
               </table>
               <br />
               
               <?php 
			   $s_landed=$this->master_model->get_landed_cost1($gen_info[0]['id']);	
		
			   ?>
                 <input type="hidden" value="select" name='style_code[]' />
                 <table style="display:none;">
                <tr id="last_row">
                    <td>
                            	
                                    <input type="hidden" value="<?=$gen_info[0]['style_size'][0]['style_id']?>" id="<?=$gen_info[0]['style_size'][0]['style_name']?>" class='style_id '  name="style_all[]">
                            </td>
                             <td  class="color_div">
                             <?php
                             	$this->load->model('po/gen_model');
                                $this->load->model('master_state/master_state_model');
                                $this->load->model('master_style/master_model');
                                $this->load->model('stock/stock_model');
                                $update_data=$this->input->get();
                                $data['color']=$this->gen_model->get_all_color_details_by_id($gen_info[0]['style_size'][0]['style_id']);
                                if(isset($data['color']) && !empty($data['color']))
                                {
                                    $select='<select name="color[]"  class="color_class colour_editcomp color_editcomp"><option>Select</option>';
                                    foreach($data['color'] as $val)
                                    {
                                         $select=$select."<option value=".$val['id'].">".$val['colour']."</option>";
                                    }
                                    $select=$select.'</select>';
                                }
                                echo $select;
                                ?>
                       
                            </td>
                            <td class="lot_td">
                            	<input type="text" name="style_lot_no[]"  tabindex="-1" readonly="readonly" style="width:130px;" class="lot_clas" />
                            </td>  
                            <td  class="size_html">
                            
                            <?php 
								if(isset($gen_info[0]['style_size'][0]['list']) && !empty($gen_info[0]['style_size'][0]['list']))
								{
									foreach($gen_info[0]['style_size'][0]['list'] as $val)
									{
										?>
											<div style="text-align:center;float:left;" >
												<p  style="margin: 0 0 0px;"  ><?=$val['size']?></p>
												<p   style="margin: 0 0 0px;">
													<input type="text"  autocomplete="off"  tabindex="1" class="s_size" id="<?=$val['size_id']?>"  style="width:50px;" />
												</p>
											</div>
										<?php
									}
								}
							?>
                            
                            </td>
                            <td>
                            	<input type="text"  name="qty_total[]" style="width:70px;" class="total_qty" />
                            </td>
                           
                             <td  class="mrp_html">
                         <input type="text"  tabindex="-1" readonly="readonly" style="width:70px;" value="<?=$s_landed[0]['landed'];?>" class="total_mrp1" />
                            </td>
                            <td>
                            	<input type="text"  style="width:70px;" class="total_value text_right text_right" />
                            </td>
                            <td>
                            	<input type="button" value="-" class='remove_comments btn btn-danger'/>
                            </td>
                            
                        </tr>
                </table>
                <?php 
					///echo "<pre>";
					//print_r($gen_info[0]['style_size']);
				?>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td width="10%">Style</td>
                        <td width="15%">Color</td>
                       	<td width="15%">Lot No</td>
						  <td >Size</td>
                         <td  width="8%">QTY</td>
                        <td  width="5%">Landed Cost</td>
                        <td  width="5%">Net Value</td>
                       <td width="5%"><input type="button" value="+" title="Add row" id='add_group' class="btn btn-primary" /></td>
                    </tr>
                    <tbody id='app_table'>
                    <?php
					$net_val=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{	  
					?>
                    	<tr>
                        	<td>
                            	<input type="hidden" value="<?=$info['style_id']?>" id="<?=$info['style_name']?>" name="style_all[]" class="style_id"/>
                                <input type="hidden" value="<?=$info['color_id']?>"  name="color[]" class="color_class colour_editcomp color_editcomp"/>
                                <input type="hidden" value="<?=$info['lot_no']?>" name="style_lot_no[]"/>
                            	<?=$info['style_name']?>
                            </td>
                          
                            <td>
                            	<?=$info['colour']?>
                            </td>
                            <td>
                            	<?=$info['lot_no']?>
                            </td>
                            <td class="size_html int_val">
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
                                                        	<input type="text"   tabindex="1" class="s_size" id="<?=$val['size_id']?>"  value="<?=$val['qty']?>" style="width:50px;" />
                                                        </p>
                                                    </div>
                                                <?php
                                            }
                                        }
										
										$last_val=$full_total*$info['landed'];
										$net_val=$net_val+$last_val;
                                    ?>
                            
                            </td>
                            <td>
                            	<input type="text"  tabindex="-1" readonly="readonly" value="<?=$full_total;?>"  name="qty_total[]" style="width:70px;" class="total_qty" />
                            </td>
                            <td  class="mrp_html">
                            	<input type="text"  tabindex="-1" readonly="readonly" style="width:70px;" value="<?=$info['landed'];?>" class="total_mrp1" />
                            </td>
                             <td>
                            	<input type="text"   tabindex="-1" readonly="readonly" style="width:70px;" value="<?=$last_val;?>" class="total_value text_right" />
                            </td>
                            <td>
                            	
                            </td>
                            
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly"  name="full_total[]" value="<?=$gen_info[0]['full_total'];?>" class="full_total" style="width:70px;" /></td>
                            <td style="text-align:right;">Sub Total</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly" name='net_total'  class="final_total text_right" value="<?=$net_val?>" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        <?php
						$st=$net_val*($gen_info[0]['st']/100);
						$cst=$net_val*($gen_info[0]['cst']/100);
						$vat=$net_val*($gen_info[0]['vat']/100);
						
                        ?>
                        <tr style="display:<?=($st==0)?'none':''?>">
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3" style="text-align:right;font-weight:bold;">ST ( <span class="st"><?=($gen_info[0]['st']=='0.00'?0:$gen_info[0]['st'])?></span> % )</td>
                            <td>
                            <input type="text"  tabindex="-1" readonly="readonly" class='st_val text_right' value="<?=$st?>"  style="width:70px;" /></td>
                            <td></td>
                        </tr>
                       
                        <tr  style="display:<?=($cst==0)?'none':''?>">
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3" style="text-align:right;font-weight:bold;">CST ( <span class="cst"><?=($gen_info[0]['cst']=='0.00'?0:$gen_info[0]['cst'])?></span> % )</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly" class='cst_val text_right'  value="<?=$cst?>"  style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        
                        <tr  style="display:<?=($vat==0)?'none':''?>">
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3"style="text-align:right;font-weight:bold;">VAT ( <span class="vat"><?=($gen_info[0]['vat']=='0.00'?0:$gen_info[0]['vat'])?></span> % )</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly" class='vat_val text_right'  value="<?=$vat?>"   style="width:70px;" /></td>
                            <td></td>
                        </tr>
                       
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="3"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly" name='net_total' value="<?=$gen_info[0]['net_total'];?>"  class="final_net text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                         <tr>
                            <td colspan="8" style="">
                            	Remarks <input type="text" value="<?=$gen_info[0]['remarks'];?>" class="form-control" name="remarks" />
                            </td>
                            
                        </tr>
                    </tfoot>
                </table>
                <table style="width:100%;border:1 solid #CCC;">
                	<tr>
                    	<td  style="width:49%;">
                        	<table style="width:100%;">
                            	
                                <tr>
                                	<td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                                    
                                </tr>
                                <tr>
                                	<td>1.</td>
                                    <td>Delivery Schedule</td>
                                    <td>:</td>
                                    <td>
                                     <div class="input-group" style="width:70%;">
                                        <input type="text"  id='datepicker' value="<?=$gen_info[0]['delivery_schedule'];?>" class="form-control datepicker class_req" name="delivery_schedule" placeholder="dd-mm-yyyy" id="">
                                        <input type="hidden" id="today" value="<?php echo $i=date("d-m-y");  ?>" />
                                        <span id="colorpoeerror" style="color:#F00;" ></span>
                                         </div>
                                    </td>
                                </tr>
                                <tr>
                                	<td>2.</td>
                                    <td>Delivery at</td>
                                    <td>:</td>
                                    <td><input type="text"  style="width:261px;"  class="form-control class_req" value="<?=$gen_info[0]['delivery_at'];?>" name="delivery_at" /></td>
                                </tr>
                                <tr>
                                	<td>3.</td>
                                    <td>Mode of Payment</td>
                                    <td>:</td>
                                    <td><input type="text"  style="width:261px;"  class="form-control class_req" value="<?=$gen_info[0]['mode_of_payment'];?>" name="mode_of_payment" /></td>
                                </tr>
                               
                            </table>
                        </td>
                        <td style="width:49%;">
                        	
                        </td>
                    </tr>
                </table>
                <input type="submit" class="btn btn-primary btn-rounded" id='add_gen' value="Update" style="float:right;"/>
                </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
   <script type="text/javascript">
		 // Date Picker
		$(document).ready(function(){
	      jQuery('#datepicker').datepicker(); 
			$('#add_gen').click(function(){
				$('.color_class').each(function(){
					var color_id=$(this).val();
					var s_html=$(this).closest('tr').find('.s_size');	
					var style_id=$(this).closest('tr').find('.style_id').val();	
					$(s_html).each(function(){
						$(this).attr('name','size['+style_id+']['+color_id+']['+$(this).attr('id')+']');
					});			
				});
				var k=0;
				$('.colour_editcomp').each(function(){
					
					
					
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
					
					var dateString =$('#datepicker').val();
				 var today = $('#today').val();
				 if(dateString=="")
				 { 
				 }
				 else if(dateString<today)
				 { 
					$("#colorpoeerror").html("You cannot select past date!");
					k=1;
				 }
				 else
				 {
					  $("#colorpoeerror").html("");
				 }
				 $('.class_req').each(function(){
				
						if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select' ||  $(this).val()==0)
						{
							
							$(this).css('border-color','red');
							k=1;
							
						}
						else
						{
							$(this).css('border-color','');
						}
						
					});
					if(k==1)
					{
						return false;
					}
					else
					{
						return true;
					}
					
				
					
			});	
		 });
 
		
        </script>
          <script type="text/javascript">
		 
 
		
        $('#add_group').click(function(){
		 	$('#last_row').clone().appendTo('#app_table');  	
		 });
		  $(".remove_comments").live('click',function(){
			$(this).closest("tr").remove();
			var total_value=0;
			$('.total_qty').each(function(){
				total_value=full_total+Number($(this).val());
			});	
			$('.full_total').val(total_value);
			
			st_val=total_value*( Number($('.st').html()) / 100 );
			$('.st_val').val(st_val.toFixed(2));
			cst_val=total_value*( Number($('.cst').html()) / 100 );
			$('.cst_val').val(cst_val.toFixed(2));
			vat_val=total_value*( Number($('.vat').html()) / 100 );
			$('.vat_val').val(vat_val.toFixed(2));
			$('.final_net').val(Number(st_val) + Number(cst_val) + Number(vat_val) + Number(total_value.toFixed(2)));
	   });
	   	$('#state').live('change',function(){
				$.ajax({
					  url:BASE_URL+"gen/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 $('#customer_td').html(result);
						 var tax=$('.customer').attr('class').split(" ");
						 if(tax[1]=='0.00')
						 	$('.st').html(0);
						 else
						 	$('.st').html(tax[1]);
						 if(tax[2]=='0.00')
						 	$('.cst').html(0);
						 else
						 	$('.cst').html(tax[2]);
						if(tax[3]=='0.00')
							$('.vat').html(0);
						else	
						 	$('.vat').html(tax[3]);
						 
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.color_div');	
			if($(this).val()!='Select')	 
			{
				$.ajax({
					  url:BASE_URL+"po/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 s_html.html(result);
					  }    
				});
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
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
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
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
			}
		});
		$('.style_id').live('change',function(){
			if($(this).val()!='Select')	 
			{
				$.ajax({
					  url:BASE_URL+"po/get_lot_no",
					  type:'GET',
					  data:{
						  s_id:$(this).val(),
						  s_name:$(this).find('option:selected').text()
						   },
					  success:function(result){
						 $('#lot_no').val($.trim(result));
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
 
 $('.colour_editcomp').live('change',function(){
	 
			$('.colour_editcomp').each(function(){
						
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
		$('.color_class').live('change',function(){
				var lot_c=$(this).closest('tr').find('.lot_clas');
				$.ajax({
					  url:BASE_URL+"po/get_lot_no_by_color",
					  type:'GET',
					  data:{
						  s_id:$(this).closest('tr').find('.style_id').val(),
						  s_name:$(this).closest('tr').find('.style_id').attr('id'),
						  c_name:$(this).find('option:selected').text(),
						  c_id:$(this).val()
						   },
					  success:function(result){
						
						lot_c.val(result);
					  }    
				});
			});
		</script>
        