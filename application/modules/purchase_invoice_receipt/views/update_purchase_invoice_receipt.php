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
                        <h4>Update Purchase Payable</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
           <?php 
		  // echo "<pre>";
		  //print_r($receipt_details);exit;
		  ?> 
            <div class="contentpanel">
          
            <table style="width:70%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
              
               <tr>
                    
                    <td width="5%">Receipt No</td>
                     <td width="10%"><b><?=$receipt_details[0]['receipt_no']?></b></td>
                      <td width="5%">Supplier Name</td>
                    <td width="10%">
                    	<?=$receipt_details[0]['store_name']?>
                    </td>
                  
               </tr>
               
               </table>
               <?php
				//$this->load->model('customer/customer_model');
				//$customer_info=$this->customer_model->get_customer1($receipt_details[0]['customer_id']);
					$this->load->model('admin/admin_model');

					$data['company_details']=$this->admin_model->get_company_details();
			   ?>
            
               <div style="width:100%">
               <div style="width:56%;float:left;margin-right: 10px;" >
               <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               			<thead>
                        	<th colspan="6">Payment History</th>
                            
                        </thead>  	
                        <thead>
                        	<th width="1%">S&nbsp;No</th>
                            <th width="5%">Payment&nbsp;Terms</th>
                            <th width="5%">Bank&nbsp;Details</th>
                            <th>Paid&nbsp;Date</th>
                            <th>Paid&nbsp;Amount</th>
                           
                            
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
                                            <td>
												<?php
                                            		if($val['terms']==1)
														echo "Cash";
													elseif($val['terms']==2)
														echo "DD";
													elseif($val['terms']==3)
														echo "Cheque";	
													elseif($val['terms']==4)
														echo "NEFD";	
													elseif($val['terms']==5)
														echo "RTGS";					
												?>
                                            </td>
                                            <td>
												<?php
                                            		if($val['terms']!=1 && $val['terms']!=4 && $val['terms']!=5)
													{
														echo "<b>A/C&nbsp;NO</b>    :<br>".$val['ac_no'].'<br>';
														echo "<b>Branch</b>    :<br>".$val['branch'].'<br>';
														echo "<b>DD&nbsp;/&nbsp;Cheque&nbsp;NO</b>:<br>".$val['dd_no'].'<br>';
													}
													else
														echo "-";			
												?>
                                            </td>
                                            <td><?=date('d-M-Y',strtotime($val['created_date']))?></td>
                                            <td><?=$val['bill_amount']?></td>
                                    
                                        </tr>
                                    <?php
									$i++;
								}
								?>
                                <tfoot>
                                	<td></td>
                                    <td></td>
                                    <td></td>
                                   
                                    <td><?=$paid?></td>
                                    <td><?=$dis?></td>
                                </tfoot>
                                <?php
							}
							else
								echo "<tr>
                            	<td colspan='5'>No Data Found</td>
                            </tr>";
						    ?>
                        </tbody>
                    </table>
               		
                </div>    
                <div style="width:41%;float:left;" >
                <form method="post">
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    	<thead>
                        	<th colspan="6">Invoice Details</th>
                            
                        </thead>  	
               			<thead>
                        	<th>S No</th>
                           	<th>Purchase Invoice NO</th>
                            <th>Bill NO</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                        </thead>
                        <tbody id='receipt_info'>
                        	<?php
							//echo "<pre>";
							//print_r($receipt_details);
							
                        	if(isset($receipt_details[0]['inv_details']) && !empty($receipt_details[0]['inv_details']))
							{
								$i=1;$inv_amt=0;$org_amt=0;
								foreach($receipt_details[0]['inv_details'] as $val)
								{
									$inv_amt=$inv_amt+$val['total_amount'];
									//$org_amt=$org_amt+$val['org_value'];
									?>
                                    	<tr>
                                        	<td><?=$i?></td>
                                            <td><?=$val['receipt_no']?></td>
                                            <td><?=$val['inv_no']?></td>
                                            <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                             <td><?=date('d-M-Y',strtotime($val['due_date']))?></td>
                                            <td><?=$val['total_amount']?></td>
                                        </tr>
                                    <?php
									$i++;
								}
								?>
                                <input type="hidden" value="<?=($inv_amt-$dis)-$paid?>" id="inv_amount" />
                                
                                	<tr><td colspan="5" style="text-align:right;">Invoice Amount</td><td><?=$inv_amt?></td></tr>
                                   
                                    <tr><td colspan="5" style="text-align:right;">Total Paid Amount</td><td><?=$paid?></td></tr>
                                    <tr style="display:none;">
                                    	<td colspan="5" style="text-align:right;">Discount<input type='text' id='dis_per'  style=' width:70px ;' name='receipt_bill[discount_per]'>%</td>
                                    	<td>
                                        	<input id='discount' readonly="readonly"  class='form-control int_val' style=' width:100px ;float:left;' type='text'  name='receipt_bill[discount]' />
                                        </td>
                                    </tr>
                                   <tr>
                                   		<td colspan='5' style='text-align: right;'>Payment Terms</td><td  style='align: right;'>
                                        <select class='form-control' id='terms' style="width:100px;" name='receipt_bill[terms]'>
                                            <option value='1'>Cash</option>
                                            <option value='2'>DD</option>
                                            <option value='3'>Cheque</option>
                                            <option value='4'>NEFD</option>
                                            <option value='5'>RDGS</option>
                                        </select>
							  			</td>
						   		  </tr> 
                                   <tr class='show_tr' style='display:none'>
                                   		<td colspan='5' style='text-align: right;'>A / C NO</td>
                                        <td  style='align: right;'>
                                        	<input id='ac_no'  class='form-control' readonly="readonly" value="<?=$data['company_details'][0]['ac_no']?>" style=' width:100px ;float:left;' type='text'  name='receipt_bill[ac_no]' />
                                            <span id="receiptuperror" style="color:#F00;" ></span>
                                        </td>
                                   </tr>
								   <tr class='show_tr' style='display:none'>
                                   		<td colspan='5' style='text-align: right;'>Branch</td>
                                        <td  style='align: right;'>
                                        	<input id='branch'  class='form-control' readonly="readonly"  value="<?=$data['company_details'][0]['branch']?>" style=' width:100px ;float:left;' type='text'  name='receipt_bill[branch]' />
                                            <span id="receiptuperror1" style="color:#F00;" ></span>
                                        </td>
                                   </tr>
								   <tr  class='show_tr' style='display:none'>
                                   		<td colspan='5' style='text-align: right;'>DD / Cheque NO</td>
                                        <td  style='align: right;'>
                                        	<input id='dd_no'  class='form-control dduplication' style=' width:100px ;float:left;' type='text'  name='receipt_bill[dd_no]' />
                                            <span id="receiptuperror2" style="color:#F00;" ></span><span id="duperror" style="color:#F00;" ></span></td></tr>
                                    <tr>
                                    	<td colspan="5" style="text-align:right;">Paid Amount</td>
                                    	<td>
                                        	<input id='paid'  class='form-control dot_val' type='text'  style=' width:100px ;float:left;'  name='receipt_bill[bill_amount]'  />
                                       <span id="receiptuperror3" style="color:#F00;" ></span> </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="5" style="text-align:right;">Balance</td>
                                    	<td>
                                        	<input id='balance'  class='form-control' type='text'  style=' width:100px ;float:left;'  name='balance'   value='<?php echo ($inv_amt-$dis)-$paid; ?>'  readonly='readonly' />
                                        </td>
                                    </tr>
                                <?php
							}
							else
								echo "<tr>
                            	<td colspan='6'>No Data Found</td>
                            </tr>";
						    ?>
                        	<tr><td  colspan="6"> <input  style="float: right;"  type="submit" class="btn btn-default" value="Pay" id="pay"/> </td></tr>
                            
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
		$('#dis_per').live('keyup',function(){
		total=0;
		var d_val=Number($('#inv_amount').val())*(Number($(this).val())/100);
		$('#discount').val(d_val.toFixed(2));
		total=(Number($('#inv_amount').val())-Number($('#discount').val()))-Number($('#paid').val());
			$('#balance').val(total.toFixed(2));
		});
		$('#paid').live('keyup',function(){
		total=0;
		total=(Number($('#inv_amount').val())-Number($('#discount').val()))-Number($(this).val());
			$('#balance').val(total.toFixed(2));
		});
		
		</script>
        <script type="text/javascript">
		$("#paid").live('blur',function()
		{
			 var paid =$('#paid').val();
			 if(paid== "")
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
			 if(paid=="")
			 { 
				 $("#receiptuperror3").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#receiptuperror3").html("");
			 }
		     var terms=$("#terms").val();
			 if(terms==1 || terms==5 || terms==4)
			 {
			 }
			 else
			 {
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
		
		
		$(".dduplication").live('blur',function()
		{
			 var checkno=$(".dduplication").val(); 
			 if(checkno=="")
			 {
			 }
			 else
			 {
		$.ajax(
	   {
		url:BASE_URL+"purchase_invoice_receipt/update_checking_invoice_checkno",
		type:'POST',
		data:{ value1 : checkno},
		success:function(result)
		{
		   $("#duperror").html(result);
	   
		}      
		}); 
			 }
		});
		</script>