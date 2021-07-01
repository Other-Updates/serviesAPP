<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<?php if($from==1){?>
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
                        <h4>Goods Receive Note Using Scanner</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
          
            <div class="contentpanel">
            <table style="margin:0 auto;width:50%">
                	<tr>
                    	<td id='error'></td>
                    </tr>
                </table>
                <form method="post" action="<?php echo $this->config->item('base_url').'gen/';?>">
<?php }?>           
           
           <input type="hidden" name="po_no" value='<?=$gen_info[0]['grn_no']?>'  />
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            	<tr>
                	<td class="first_td1">PO NO</td>
                    <td >
                   		<b><?=$gen_info[0]['grn_no']?></b>
                        <input type="hidden" value="<?=$gen_info[0]['grn_no']?>"  name="po_no">
                    </td>
                    <td class="first_td1">Supplier</td>
                   <td id='customer_td'>
                    	<?=$gen_info[0]['store_name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
                </tr>
               <tr>
               		<td class="first_td1">GRN NO</td>
                    <td><!--<input type="text" name="inv_no"  />--><b><?=$last_no?></b></td>
                    <td class="first_td1">Date</td>
                    <td >
                    	<?=date('d-M-Y',strtotime($gen_info[0]['inv_date']))?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
              
               </tr>
              
               </table>
      
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td width="10%" class="first_td1">Style</td>
                        <td width="10%" class="first_td1">Color</td>
                        <td width="10%" class="first_td1">Lot No</td>
						  <td  class="first_td1">Size</td>
                         <td  width="8%" class="first_td1">QTY</td>
                         <td  width="8%" class="first_td1">Location</td>
                        <td  width="5%" class="first_td1">LANDED COST</td>
                        <td  width="5%" class="first_td1">Net Value</td>
                        <!--<td width="5%"><input type="button" value="+" title="Add row" id='add_group' class="btn btn-primary" /></td>-->
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
                            <?=$info['style_name'];?>
                            
                            	<input type="hidden" value="<?=$info['style_id'];?>" class='style_id'  name="style_all[]">
                                   
                            </td>
                          
                            <td>
                            	<?=$info['colour'];?>
                            	<input type="hidden" value="<?=$info['color_id'];?>"  class="color_class" name="color[]">
                                    
                            </td>
                            <td>
                            	<?=$info['lot_no'];?>
                            	<input type="hidden" value="<?=$info['lot_no'];?>"  name="style_lot_no[]">
                                    
                            </td>
                             
                            <td class="size_html">
                           		 <?php 
								 	$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												$full_total=$full_total+$val['qty'];
												$cl_name=$info['style_id'].'-'.$info['color_id'].'-'.$val['id'].'-'.$val['size_id'];
                                                ?>
                                                    <div style="text-align:center;float:left;" >
                                                    	<p  style="margin: 0 0 0px;"  ><?=$val['size']?></p>
                                                        <p   style="margin: 0 0 0px;">
                                                        	<input type="text"  tabindex="-1" readonly="readonly" class="avail_qty avail_<?=$cl_name;?>" id="<?=$val['size_id']?>"  value="<?=$val['qty']?>" style="width:50px;" />
                                                        </p>
                                                        <p>
                                                        	<input type="text" autocomplete="off" class="s_size cum_qty int_val po_empty <?=$cl_name;?>" id="<?=$val['size_id']?>"   style="width:50px;" />
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
                            	<input type="text" value=""  tabindex="-1" readonly="readonly"  name="qty_total[]" style="width:70px;margin-top: 44px;" class="total_qty" />
                            </td>
                            <td>
                            	<input type="text"    name="location[]" style="width:70px;margin-top: 44px;"  />
                            </td>
                            <td  class="mrp_html">
                            	<input type="text"  tabindex="-1" readonly="readonly" style="width:70px;margin-top: 44px;" value="<?=$info['landed'];?>" class="total_mrp1" />
                            </td>
                             <td>
                            	<input type="text"  tabindex="-1" readonly="readonly"  style="width:70px;margin-top: 44px;" value="" class="total_value" />
                            </td>
                           <!-- <td>
                            	
                            </td>-->
                            
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"  tabindex="-1" readonly="readonly" name="full_total[]" value="" class="full_total" style="width:70px;" /></td>
                             <td></td> <td></td>
                            <td><input type="text"  tabindex="-1" readonly="readonly"  name="net_total" name="net_total" class="final_total" value="" style="width:70px;" /></td>
                           <!-- <td></td>-->
                        </tr>
                    </tfoot>
                </table>
                <input type="submit" class="btn btn-default" id='add_gen' value="Update" style="float:right;"/>
                </form>
            <script>
			
		 $(".po_no_dup").live('blur',function()
  	   {
		   
         po_no=$(".po_no_dup").val();
		 //alert(po_no);
		 $.ajax(
		 {
		  url:BASE_URL+"gen/po_duplication",
		  type:'post',
		   data:{ value1:po_no},
		  success:function(result)
		  {
			 
		     $("#duplica").html(result);	
		  }    		
		});
      }); 
		
		
		
		$('#view_po').live('click',function(){
			var i=0;
			var po=$("#po_no").val();
			if(po=='')
			{
				$("#poerror").html("Enter PO NO");
				i=1;
				
			}
			else
			{
				$("#poerror").html("");
			}
			var m=$('#duplica').html();
			if((m.trim()).length>0)
			{
				i=1;
			}
			if(i==1)
			{
				return false;
			}
			else
			{
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"gen/view_po",
					  type:'GET',
					  data:{
						  po:$('#po_no').val()
						   },
					  success:function(result){
						   for_response(); 
						$('#grn_html').html(result);
					  }    
				});
			}
		});
	
		$('.cum_qty').live('keyup',function(){
			
				var round_val=Number($(this).parent().parent().find('.avail_qty').val());
				//alert(round_val);
				var five_val=Number($(this).parent().parent().find('.avail_qty').val());
				//alert(five_val);
				//alert($(this).val());
				if(Number(five_val) < Number($(this).val()))
				{
					
					$(this).css('border-color','red');
					
				}
				else
				{
					//alert('enter1');
					/*if(Number($(this).parent().parent().find('.avail_qty').val())==0 && Number($(this).parent().parent().find('.avail_qty').val())!=Number($(this).val()))
						$(this).css('border-color','red');
					else*/
						$(this).css('border-color','');
				}
		
		}); 
			$('#add_gen').live('click',function(){
				var i=0;
				$('.cum_qty').each(function(){
						
						var round_val=Number($(this).parent().parent().find('.avail_qty').val());
						
						var five_val=Number($(this).parent().parent().find('.avail_qty').val());
						if(Number(five_val) < Number($(this).val()))
						{
							i=1;
							$(this).css('border-color','red');
						}
						else
						{
							/*if(Number($(this).parent().parent().find('.avail_qty').val())==0 && Number($(this).parent().parent().find('.avail_qty').val())!=Number($(this).val()))
							{
								$(this).css('border-color','red');
							
								i=1;
							}
							else*/
								$(this).css('border-color','');
							}
				
				});
				if(i==1)
				{
					return false;
				}
				else
				{
					$('.color_class').each(function(){
						var color_id=$(this).val();
						var s_html=$(this).closest('tr').find('.s_size');		
						var style_id=$(this).closest('tr').find('.style_id').val();	
						$(s_html).each(function(){
							$(this).attr('name','size['+style_id+']['+color_id+']['+$(this).attr('id')+']');
						});		
					});
					return true;
				}
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
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"gen/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						 $('#customer_td').html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.style_html');	
			for_loading(); 	 
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						 s_html.html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.size_html');	
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
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.mrp_html');		
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
			$('.final_total').val(total_value);
			
			
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
            <script>


// only init when the page has loaded
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
			$('.final_total').val(total_value);
			
			
		});

// only init when the page has loaded
$(document).ready(function() {
    var pressed = false; 
    var chars = []; 
    // trigger an event on any keypress on this webpage
	var bc='';
    $(window).keypress(function(e) {
        // check the keys pressed are numbers
        if (e.which <= 150) {
            // if a number is pressed we add it to the chars array
            chars.push(String.fromCharCode(e.which));
        }
        if (pressed == false) {
            setTimeout(function(){
                // check we have a long length e.g. it is a barcode
                if (chars.length >= 10) {
                    // join the chars array to make a string of the barcode scanned
                    var barcode = chars.join("");
                    // debug barcode to console (e.g. for use in Firebug)
                   
					bc=barcode.replace("*", "");
					//alert("Barcode Scanned: " + bc);
					var avail_qty=Number($('.avail_'+bc).val());
					var scan_qty=Number($('.'+bc).val())+1;
					
					if(Number($('.avail_'+bc).val())<Number(scan_qty))
						$('.'+bc).css('border-color','red');
					else
					{
						$('.'+bc).val(scan_qty);
						$('.'+bc).css('border-color','');
						
					$('.s_size').each(function(){
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
						$('.final_total').val(total_value);
						
						
					});		
					}
						
                }
                chars = [];
                pressed = false;
            },500);
        }
    });
	
});
</script>
<?php if($from==1){?>
 </div><!-- contentpanel -->
</div><!-- mainpanel -->
</form>
<?php }?>