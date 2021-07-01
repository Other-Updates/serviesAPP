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
                        <h4>Update Commission Payable</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
           <?php 
		  // echo "<pre>";
		  //print_r($receipt_details);exit;
		  ?> 
            <div class="contentpanel">
          
            <table style="width:70%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
            
                    
                    <td width="5%">Agent Name</td>
                     <td width="10%"><?=$receipt_details[0]['agent_name']?></td>
                      <td width="5%">Receipt No</td>
                    <td width="10%">
                    	<?=$receipt_details[0]['receipt_no']?>
                    </td>
                  
               </tr>
          
               </table>
               <?php
				$this->load->model('commission/commission_model');
				$data['pending_inv']=$this->commission_model->get_invoice_for_receipt($receipt_details[0]['receipt_list']);
				//echo "<pre>";
				//print_r($data['pending_inv'][0]['inv_details']);
			   ?>
            
               <div style="width:100%">
               <div style="width:56%;float:left;margin-right: 10px;" >
               <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               			<thead>
                        	<th colspan="6">Payment History</th>
                            
                        </thead>  	
                        <thead>
                        	<th width="1%">S&nbsp;No</th>
                            <th>Paid&nbsp;Amount</th>
                            <th>Paid Date</th>
                            
                        </thead>
                        <tbody id='receipt_info'>
                        	<?php
                        	if(isset($receipt_details[0]['receipt_history']) && !empty($receipt_details[0]['receipt_history']))
							{
								$i=1;$dis=0;$paid=0;
								foreach($receipt_details[0]['receipt_history'] as $val)
								{
									$paid=$paid+$val['bill_amount'];
									$dis=$dis+$val['discount'];
									?>
                                    	<tr>
                                        	<td><?=$i?></td>
                                            <td class="text_right"><?=number_format($val['bill_amount'], 2, '.', ',')?></td>
                                             <td><?=date('d-M-Y',strtotime($val['created_date']))?></td>
                                        </tr>
                                    <?php
									$i++;
								}
								?>
                                <tfoot>
                                    <td></td>
                                    <td  class="text_right"><?=number_format($paid, 2, '.', ',')?></td>
                                    <td></td>
                                </tfoot>
                                <?php
							}
							else
								echo "<tr>
                            	<td colspan='3'>No Data Found</td>
                            </tr>";
						    ?>
                        </tbody>
                    </table>
               		
                </div>    
                <div style="width:41%;float:left;" >
                <form method="post">
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    	<thead>
                        	<th colspan="4">Invoice Details</th>
                            
                        </thead>  	
               			<thead>
                        	<th>S No</th>
                            <th>Invoice NO</th>
                            <th>Invoice Date</th>
                            <th>Invoice Amount</th>
                        </thead>
                        <tbody id='receipt_info'>
                        	<?php
                            $table='';$total=0;
                        	if(isset($data['pending_inv'][0]['inv_details']) && !empty($data['pending_inv'][0]['inv_details']))
							{
								$i=1;$inv_amt=0;$org_amt=0;
								foreach($data['pending_inv'][0]['inv_details'] as $val)
								{
									$org_amt=$org_amt+$val['org_value'];
									?>
                                    	<tr>
                                        	<td><?=$i?></td>
                                            <td><?=$val['inv_no']?></td>
                                            <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                            <td><?=$val['org_value']?></td>
                                        </tr>
                                    <?php
									$i++;
								}
								?>
								<tr><td colspan="3" class="text_right">Total Invoice Value</td><td><input  type="text" readonly class="form-control" value="<?=$receipt_details[0]['total_inv_value']?>" /></td></tr>
									
									<tr><td colspan="3" class="text_right">Total Discount Value</td><td><input   type="text" readonly class="form-control" value="<?=$receipt_details[0]['total_dis_value']?>" /></td></tr>
									
									<tr><td colspan="3" class="text_right">Net Receipt Value</td><td><input    type="text" readonly class="form-control"  id="net_val" value="<?=$receipt_details[0]['net_receipt_val']?>" /></td></tr>
									
									<tr>
										<td colspan="3" class="text_right">
										Agent Commission
										<input type="text" id="comm_per" class="dot_val"  readonly value="<?=$receipt_details[0]['agent_comm']?>"  autocomplete="off"    style="width:70px;" >
										</td>
										<td>
										<input type="text" id="comm_val" readonly   class="form-control dot_val" value="<?=$receipt_details[0]['agent_comm_value']?>" autocomplete="off"/>
										</td>
									</tr>
									
									<tr><td  colspan="3" class="text_right">Toatl Paid Value</td><td><input id='t_paid' readonly class="form-control dot_val"  value="<?=$paid?>" type="text" autocomplete="off"/></td>
                                    </tr>
                                    <tr><td  colspan="3" class="text_right">Paid Amount</td><td><input id="paid" class="form-control dot_val"   name="commission_bill[bill_amount]"  type="text" autocomplete="off"/>
                                    <input type="hidden"  name="commission_bill[comm_id]"  value="<?=$receipt_details[0]['id']?>"  autocomplete="off"/>
                                    </td>
                                    </tr>
									
									<tr><td  colspan="3" class="text_right">Balance</td><td><input class="form-control dot_val" name="balance"  id="balance" type="text" value="<?=$receipt_details[0]['agent_comm_value']-$paid?>" autocomplete="off"/></td></tr>
									
									
									
									<tr><td colspan="3"></td><td><input type="submit" class="btn btn-success submit" value="Pay"> </td></tr>
								<?php }?>
                        </tbody>
                    </table>
                    </form>
                 </div> 
                 </div>    
               
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		   $('#terms').live('change',function(){
				if($(this).val()==2 || $(this).val()==3)
					$('.show_tr').show();
				else
					$('.show_tr').hide();
			});
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
				  url:BASE_URL+"receipt/get_all_pending_invoice",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
						$('#s_div').html(result);
				  }    
			});
			$.ajax({
				  url:BASE_URL+"receipt/get_invoice_view",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
					    for_response(); 
						$('#receipt_info').html(result);
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
		$('#discount_per').live('keyup', function(){
			var tt=$('#inv_amount').val()*($(this).val()/100);
			$('#discount').val(tt.toFixed(2));
			
			total=0;
			total=(Number($('#inv_amount').val())-Number($('#discount').val()))-Number($('#paid').val());
			$('#balance').val(total.toFixed(2));
		});
		</script>
        <script type="text/javascript">
		
		$(".dduplication").live('blur',function()
		{
			 //alert("hi");
			 var checkno=$(".dduplication").val(); 
			 if(checkno=="")
			 {
			 }
			 else
			 {
		$.ajax(
	   {
		url:BASE_URL+"receipt/update_checking_payment_checkno",
		type:'POST',
		data:{ value1 : checkno},
		success:function(result)
		{
		   $("#dupperror").html(result);
	   
		}      
		}); 
			 }
		});
		$("#paid").live('blur',function()
		{
			 var paid =$('#paid').val();
			 if(paid== "" || paid==0)
			 { 
				 $("#receiptuperror3").html("Required Field");
		
			 }
			 else
			 {
				  $("#receiptuperror3").html("");
			 }
		}); 
		$("#ac_no").live('blur',function()
		{
			var ac_no=$("#ac_no").val();
			if(ac_no=="" || ac_no==null || ac_no.trim().length==0)
			{
				$("#receiptuperror").html("Required Field");
			}
			else
			{
				$("#receiptuperror").html("");
			}
		});
		$("#branch").live('blur',function()
		{
			var branch=$("#branch").val();
			if(branch=="" || branch==null || branch.trim().length==0)
			{
				$("#receiptuperror1").html("Required Field");
			}
			else
			{
				$("#receiptuperror1").html("");
			}
		});
		$("#dd_no").live('blur',function()
		{
			var dd_no=$("#dd_no").val();
			if(dd_no=="" || dd_no==null || dd_no.trim().length==0)
			{
				$("#receiptuperror2").html("Required Field");
			}
			else
			{
				$("#receiptuperror2").html("");
			}
		});
		$('#pay').live('click',function()
		{
			i=0;
			var paid =$('#paid').val();
			 if(paid=="" || paid==0)
			 { 
				 $("#receiptuperror3").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#receiptuperror3").html("");
			 }
		     var terms=$("#terms").val();
			 if(terms==1)
			 {
			 }
			 else
			 {
			 var ac_no=$("#ac_no").val();
			 if(ac_no=="" || ac_no==null || ac_no.trim().length==0)
			 {
				$("#receiptuperror").html("Required Field");
				i=1;
			 }
			 else
			 {
				$("#receiptuperror").html("");
			 }
			 var branch=$("#branch").val();
			 if(branch=="" || branch==null || branch.trim().length==0)
			 {
				$("#receiptuperror1").html("Required Field");
				i=1;
			 }
			 else
			 {
				$("#receiptuperror1").html("");
			 }
			 var dd_no=$("#dd_no").val();
			 if(dd_no=="" || dd_no==null || dd_no.trim().length==0)
			 {
				$("#receiptuperror2").html("Required Field");
				i=1;
			 }
			 else
			 {
				$("#receiptuperror2").html("");
			 }
			 var m=$('#dupperror').html();
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
		$('#paid').live('keyup', function(){
			var tt=Number($('#comm_val').val()-$('#t_paid').val())-Number($(this).val());
			$('#balance').val(tt.toFixed(2));
		});
		</script>