<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

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
                        <h4>Add Goods Receive Note</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
          
            <div class="contentpanel">
            <form method="post">
            <table  style="width:40%;margin:0 auto;" class="table table-striped table-bordered no-footer dtr-inline">
            	<tr>
                	<td class="first_td1" width="100">PO NO</td>
                    <td><input type="text"  id="po_no" autocomplete="off" class="form-control po_no_dup"/></td>
                    <td><input type="button" class="btn btn-default " id='view_po' value='View'/><span id="poerror" style="color:#F00;"></span><span id="duplica" style="color:#F00;"></span></td>
                    
                </tr>
            </table>
            <br />
            <div  id='grn_html'>
            
            </div>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->

        <script type="text/javascript">
		$().ready(function() {
			$("#po_no").autocomplete("gen/get_po_list", {
				width: 260,
				autoFocus: true,
				matchContains: true,
				selectFirst: false
			});
		});
		
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
			
        </script>         <script>


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

					bc=barcode;
					alert("Barcode Scanned: " + bc);
					var avail_qty=Number($('.avail_'+bc).val());
					var scan_qty=Number($('.'+bc).val())+1;
					$('.'+bc).val(scan_qty);
					if(Number($('.avail_'+bc).val())<Number($('.'+bc).val()))
						$('.'+bc).css('border-color','red');
					else
						$('.'+bc).css('border-color','');
                }
                chars = [];
                pressed = false;
            },500);
        }
    });
	
});

</script>