<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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
                        <h4>Add Package Order</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            <form method="post">
            <table style="width:70%;margin:0 auto;" class="table table-striped table-bordered dataTable ">  	
               <tr>
               	<td colspan="5" style="text-align:center;">
                	<b><?=$last_no?></b>
                </td>
               </tr>
               <tr>
               		
                    
                    <td width="15%" class="first_td1">Customer Name</td>
                    <td width="25%">
                    	<select id='customer' name="package[customer]" class="form-control class_req">
                            <option>Select</option>
                            <?php 
                                if(isset($all_customer) && !empty($all_customer))
                                {
                                    foreach($all_customer as $val)
                                    {
                                        ?>
                                            <option value='<?=$val['id']?>'><?=$val['store_name']?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td width="15%" class="first_td1">No&nbsp;of&nbsp;Cottons</td>
                    <td  width="25%"><input type="text" id='cor_no'  name="package[no_corton]" class="form-control class_req" /></td>
                    <td width="21%" rowspan="5" id='s_div'></td>
                    
               </tr>
               <tr>
               		<td class="first_td1">Ship Mode</td>
                    <td><input type="text" class="form-control class_req"  name="package[ship_mode]" /></td>
                    <td class="first_td1">Ship Date</td>
                    <td>
                    	<div class="input-group" >
                                    <input type="text" id='from_date1'  class="form-control datepicker class_req"  name="package[ship_date]" placeholder="dd-mm-yyyy" >
                                   
                                </div>
                    </td>
               </tr>
               <tr>
               		<td class="first_td1">Country of Origin</td>
                    <td><input type="text" class="form-control class_req"  name="package[origin]"/></td>
                    <td class="first_td1">Destination</td>
                    <td><input type="text" class="form-control class_req"  name="package[destination]"/></td>
               </tr>
                <tr>
               		<td class="first_td1">LR NO</td>
                    <td><input type="text" class="form-control class_req"  name="package[lr_no]"/></td>
                    <td class="first_td1">Transport</td>
                    <td>
                        <select  class="form-control class_req"  name="package[llr_no]">
                            <option>Select</option>
                        
                        <?php 
                            if(isset($all_transport) && !empty($all_transport))
                            {
                                foreach($all_transport as $trans) 
                                {
									?>
                                    	<option value="<?=$trans['transport_name']?>"><?=$trans['transport_name']?></option>
                                    <?php
								}
							}
                        ?>
                        </select>
                    </td>
               </tr>
               </table>
               	<table style="margin:0 auto;width:50%">
                	<tr>
                    	<td id='error'></td>
                    </tr>
                </table>
                   <div id='package_info'>
                    
                   </div>
               </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
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
		 $('.size_val').live('keyup',function(){
			var arr=$(this).attr('class').split(' '); 
			var total=0;
			$('.'+arr[2]).each(function(){
				total=total+Number($(this).val());
			});
			
			if( Number(total) > Number($('.c'+arr[2]).val()) || Number(total) < Number($('.c'+arr[2]).val()) )
			{
				$('.'+arr[2]).each(function(){
					$(this).css('border-color','red');
				});
			}
			else
			{
				$('.'+arr[2]).each(function(){
					$(this).css('border-color','');
				});
			}
		});
		 // Date Picker
		 $('#add_package').live('click',function(){
			 
			 		var i=0;var j=0;k=0;
					
					$('.class_req').each(function(){
						if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select' ||  $(this).val()==0)
						{
							i=1;
							$(this).css('border-color','red');
						}
						else
						{
							$(this).css('border-color','');
						}
					});
					$('.size_val').each(function(){
						var arr=$(this).attr('class').split(' '); 
						var total=0;
						$('.'+arr[2]).each(function(){
							total=total+Number($(this).val());
						});
						
						if( Number(total) > Number($('.c'+arr[2]).val()) || Number(total) < Number($('.c'+arr[2]).val()) )
						{
							j=1;
							$('.'+arr[2]).each(function(){
								$(this).css('border-color','red');
							});
						}
						else
						{
							$('.'+arr[2]).each(function(){
								$(this).css('border-color','');
							});
						}
					});
					$('.cort_class').each(function(){
						
						var arr=$(this).attr('class').split(' '); 
						console.log(arr);
						
						$('.'+arr[2]).each(function(){
							var my=$(this).val();
							var count=0;
							$('.'+arr[2]).each(function(){
								
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
								$('.'+arr[2]).each(function(){
									$(this).css('border-color','red');
								});
							}
						
							
						});
						
					});
					
					
			 		if(i==0 && j==0 && k==0)
					{
						$('.sty_class').each(function(){
							var s_html=$(this).closest('tr').find('.size_val');	
							var size_name=$(this).closest('tr').find('.size_name');	
							var cort_class=$(this).closest('tr').find('.cort_class').val();	
							var sty_class=$(this).closest('tr').find('.sty_class').val();
							var col_class=$(this).closest('tr').find('.col_class').val();	
							
							$(s_html).each(function(){
								$(this).attr('name','size['+sty_class+col_class+cort_class+'][]');
							});	
							$(size_name).each(function(){
								$(this).attr('name','size_name['+sty_class+col_class+cort_class+'][]');
							});		
						});
						return true;
					}
					else
						return false;
				});	
			 
		 $(document).ready(function(){

	        jQuery('#from_date1').datepicker(); 
		});	
		$('#cor_no').live('keyup',function(){
			var select_op='';
			if(Number($(this).val()))
			{
				select_op='<option>Select</option>';
				for(i=1;i<=Number($(this).val());i++)
				{
					select_op=select_op+'<option value='+i+'>'+i+'</option>';	
				}
				$('.cort_class').find('option').remove();
				$('.cort_class').append(select_op);
			}
		});
	   	$('#customer').live('change',function(){
			for_loading(); 
			/*$.ajax({
				  url:BASE_URL+"package/get_package_by_customer_id",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
					    for_response(); 
						$('#package_info').html(result);
						var select_op='';
						if(Number($('#cor_no').val()))
						{
							select_op='<option>Select</option>';
							for(i=1;i<=Number($('#cor_no').val());i++)
							{
								select_op=select_op+'<option value='+i+'>'+i+'</option>';	
							}
							$('.cort_class').find('option').remove();
							$('.cort_class').append(select_op);
						}
				  }    
			});*/
			$.ajax({
				  url:BASE_URL+"package/get_package_by_customer_id1",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
					    for_response(); 
						$('#s_div').html(result);
				  }    
			});
			
		});
		$('.so_id').live('click',function(){
			var cc=$(this);
			var s_arr=[];
			var i=0;
			
			$('.so_id').each(function(){
				if($(this).attr('checked')=='checked')
				{
					s_arr[i]=$(this).val();
					i++;
				}
			});
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"package/get_package_by_so",
				  type:'GET',
				  data:{
					  	so_id:s_arr,
					  	c_id:$('#customer').val()
					   },
				  success:function(result){
					    for_response();
						console.log(result);
						if(result.length=='277')
						{ 
							alert("You can't select this sales order for same MRP...");
							cc.removeAttr('checked');	
						}
						else
						{
							$('#package_info').html(result);
							if(Number($('#cor_no').val()))
							{
								var select_op='<option>Select</option>';
								for(i=1;i<=Number($('#cor_no').val());i++)
								{
									if(i==1)
									select_op=select_op+'<option selected value='+i+'>'+i+'</option>';	
								}
								$('.cort_class').find('option').remove();
								$('.cort_class').append(select_op);
							}
						}
				  }    
			});
		});
		$('.add_group').live('click',function(){
			var c_val=$(this).closest('tr').clone();
			c_val.find('.single_val').html('');
			c_val.find('.size_val').val('');
			c_val.find('.add_group').remove();
			c_val.find('.hide_remove').show();
			c_val.find('.hide_val').html('');
			var after_clone=$(this).closest('tr').after(c_val);
			 $(this).trigger('blur');
			
		});
		  $(".remove_group").live('click',function(){
			$(this).closest("tr").remove();
	   });
		</script>
        <script>


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
					//alert(bc);
					//alert("Barcode Scanned: " + bc);
					var avail_qty=Number($('.avail-'+bc).val());
					if(isNaN(avail_qty))
					{
						$('#error').css('color','red');	
						$('#error').html('Enter Valid Barcode for this Package');
					}
					else
					{
						$('#error').html('');
						$('#error').css('color','');
						var i=1
						$('.'+bc).each(function(){
							if(i==$('.'+bc).length)
							{
								var scan_qty=Number($(this).val())+1;
								if(Number($(this).closest('tr').find('.avail-'+bc).val())<Number($(this).val()))
									$('.'+bc).css('border-color','red');
								else
								{
									$('.'+bc).css('border-color','');
									$(this).val(scan_qty);
								}
							}
							i++;
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