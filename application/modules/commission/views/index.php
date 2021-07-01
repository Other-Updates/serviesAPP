<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Add Commission Payable</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel" style="padding:4px;">
            <form method="post">
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
           
                    
                
                     <input type="hidden" id="today" class="today" value="<?php echo $i=date("d-m-y");  ?>" />
                     <span id="recipterror" style="color:#F00;"></span></td>
                      <td width="5%" class="first_td1">Agent Name</td>
                    <td width="10%">
                    	<select id='customer' name="commission[agent_id]" class="form-control">
                            <option value="">Select</option>
                            <?php 
                                if(isset($all_agent) && !empty($all_agent))
                                {
                                    foreach($all_agent as $val)
                                    {
                                        ?>
                                            <option value='<?=$val['id']?>'><?=$val['name']?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select><span id="recipterror1" style="color:#F00;"></span>
                    </td>
                    <td width="15%" rowspan="6" id='s_div'></td>
               </tr>
               </table>
               <br />
               <form method="post">
               		<table style="width:42%;margin:0 auto;margin-bottom:0px;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               			<thead>
                        	<th>S No</th>
                            <th>Invoice NO</th>
                            <th>Invoice Date</th>
                            <th>Invoice Amount</th>
                        </thead>
                        <tbody id='receipt_info'>
                        	<tr>
                            	<td colspan="4">No Data Found</td>
                            </tr>
                        </tbody>
                    </table>
                      
               </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		$(".ddduplication").live('blur',function()
		{
			 //alert("hi");
			 var checkno=$(".ddduplication").val(); 
			 if(checkno=="")
			 {
			 }
			 else
			 {
		$.ajax(
	   {
		url:BASE_URL+"receipt/checking_payment_checkno",
		type:'POST',
		data:{ value1 : checkno},
		success:function(result)
		{
		   $("#duperror").html(result);
	   
		}      
		}); 
			 }
		});
		
		
		$("#from_date1").live('change',function()
		{
			 var dateString =$('#from_date1').val();
			 var today = $('#today').val();
			 if(dateString== "")
			 { 
				 $("#recipterror").html("Required Field");
		
			 }
			 else if(dateString<today)
			 { 
				$("#recipterror").html("You cannot select past date!");
			 }
			 else
			 {
				  $("#recipterror").html("");
			 }
		}); 
		$("#customer").live('change',function()
		{
			 var customer =$('#customer').val();
			 if(customer== "")
			 { 
				 $("#recipterror1").html("Required Field");
		
			 }
			 else
			 {
				  $("#recipterror1").html("");
			 }
		}); 
		$("#agent").live('change',function()
		{
			 var agent =$('#agent').val();
			 if(agent== "")
			 { 
				 $("#recipterror2").html("Required Field");
		
			 }
			 else
			 {
				  $("#recipterror2").html("");
			 }
		});
		$('#percentage').live('blur',function()
		{
			var percentage=$('#percentage').val();
			var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(percentage=="" || percentage==null || percentage.trim().length==0)
			{
				$('#recipterror3').html("Required Field");
			}
			else if(!pefilter.test(percentage))
			{
				$("#recipterror3").html("Enter Valid Percentage");
			}
			else
			{
				$('#recipterror3').html("");
			}
		});
		$("#paid").live('blur',function()
		{
			 var paid =$('#paid').val();
			 if(paid== "" || paid==0)
			 { 
				 $("#recipterror4").html("Required Field");
		
			 }
			 else
			 {
				  $("#recipterror4").html("");
			 }
		}); 
		$("#ac_no").live('blur',function()
		{
			var ac_no=$("#ac_no").val();
			if(ac_no=="" || ac_no==null || ac_no.trim().length==0)
			{
				$("#recipterror5").html("Required Field");
			}
			else
			{
				$("#recipterror5").html("");
			}
		});
		$("#branch").live('blur',function()
		{
			var branch=$("#branch").val();
			if(branch=="" || branch==null || branch.trim().length==0)
			{
				$("#recipterror6").html("Required Field");
			}
			else
			{
				$("#recipterror6").html("");
			}
		});
		$("#dd_no").live('blur',function()
		{
			var dd_no=$("#dd_no").val();
			if(dd_no=="" || dd_no==null || dd_no.trim().length==0)
			{
				$("#recipterror7").html("Required Field");
			}
			else
			{
				$("#recipterror7").html("");
			}
		});
		$('.submit').live('click',function()
		{
			i=0;
			 var paid =$('#paid').val();
			 if(paid=="" || paid==0)
			 { 
				 $("#recipterror4").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#recipterror4").html("");
			 }
		     var terms=$(".terms").val();
			 if(terms==1)
			 {
			 }
			 else
			 {
			 var dd_no=$("#dd_no").val();
			 if(dd_no=="" || dd_no==null || dd_no.trim().length==0)
			 {
				$("#recipterror7").html("Required Field");
				i=1;
			 }
			 else
			 {
				$("#recipterror7").html("");
			 }
			    var m=$('#duperror').html();
				if((m.trim()).length>0)
				{
					i=1;
				}
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
		</script>
         <script type="text/javascript">
                  $('#terms').live('change',function(){
				  		if($(this).val()==2 || $(this).val()==3)
							$('.show_tr').show();
						else
							$('.show_tr').hide();
				  });
                  </script>
        <script type="text/javascript">
		 // Date Picker
		 $('#add_package').live('click',function(){
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
				});	
			 
		 $(document).ready(function(){

	        jQuery('#from_date1').datepicker(); 
		});	
		$('#cor_no').live('keyup',function(){
			var select_op='';
			if(Number($(this).val()))
			{
				select_op=select_op+'<select class="cort_class"  name="corton[]"><option>Select</option>';
				for(i=1;i<=Number($(this).val());i++)
				{
					select_op=select_op+'<option value='+i+'>'+i+'</option>';	
				}
				select_op=select_op+'</select>';
				$('.cor_class').html(select_op);
			}
		});
	   	$('#customer').live('change',function(){
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"commission/get_all_pending_receipt",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
						$('#s_div').html(result);
						 for_response(); 
				  }    
			});
			
		});
		$('#receipt_list').live('change',function(){
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"commission/get_receipt_details",
				  type:'GET',
				  data:{
					  r_id:$(this).val(),
					  a_id:$('#customer').val()
					   },
				  success:function(result){
						$('#receipt_info').html(result);
						 for_response(); 
				  }    
			});
			
		});
		$('.so_id').live('click',function(){
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
				  url:BASE_URL+"receipt/get_inv",
				  type:'GET',
				  data:{
					  	inv_id:s_arr,
					  	c_id:$('#customer').val()
					   },
				  success:function(result){
					     for_response(); 
						$('#receipt_info').html(result);
				  }    
			});
		});
		$('#discount').live('keyup',function(){
		total=0;
		total=(Number($('#inv_amount').val())-Number($(this).val()))-Number($('#paid').val());
			$('#balance').val(total.toFixed(2));
			
			var tt=($(this).val()/$('#inv_amount').val())*100;
			$('#discount_per').val(tt.toFixed(2));
			
			
		});
		$('#paid').live('keyup',function(){
		total=0;
		total=(Number($('#inv_amount').val())-Number($('#discount').val()))-Number($(this).val());
			$('#balance').val(total.toFixed(2));
		});
		
		$('#comm_val').live('keyup',function(){
			var tt=($(this).val()/$('#net_val').val())*100;
			$('#comm_per').val(tt.toFixed(2));
			
			var tt1=Number($('#comm_val').val())-Number($('#paid').val());
			$('#balance').val(tt1.toFixed(2));
		});
		$('#comm_per').live('keyup', function(){
			var tt=$('#net_val').val()*($(this).val()/100);
			$('#comm_val').val(tt.toFixed(2));
			
			var tt1=Number($('#comm_val').val())-Number($('#paid').val());
			$('#balance').val(tt1.toFixed(2));
			
		});
		$('#paid').live('keyup', function(){
			var tt=Number($('#comm_val').val())-Number($(this).val());
			$('#balance').val(tt.toFixed(2));
		});
		
		
		
		</script>