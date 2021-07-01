<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<div class="mainpanel">
<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-rupee" style="margin:9px;"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Variable Expense</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            
            <div class="col-md-15">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-info">
                    <li class="active"><a href="#home6" data-toggle="tab"><strong>List</strong></a></li>
                    <li><a href="#profile6" data-toggle="tab"><strong>Add</strong></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content tab-content-info mb30">
                    <div class="tab-pane active" id="home6">
                
                   <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide">
                  		<tr>
                        	
                            <td>From Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker"  placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td>To Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>
                        </tr>
                  </table>
                   <div id="result_div">  
                       <table id='basicTable' class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <td width="4%">S NO</td>
                                    <td width="10%">&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td width="20%">Expense Type</td>
                                    <td  width="7%">Expense Against</td>
                                    <td  width="15%">Invoice Details</td>
                                     <?php 
									   if(isset($expense) && !empty($expense))
									   {
										   foreach($expense as $val)
										   {
											   ?>
                                                <td>
                                                    <?=$val['expense']?>
                                                </td>
											   <?php
										   }
									   }
									 ?>
                                    <td>Total</td>
                                    <td class="hide_class">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$full_total=0;$dd=array();
								if(isset($all_expense) && !empty($all_expense))
								{
									$i=1;
									foreach($all_expense as $val)
									{
										?>
                                        <tr>
                                            <td  class='first_td'><?=$val['id']?></td>
                                            <td><?=date('d-m-Y',strtotime($val['date']));?></td>
                                            <td>
                                            	<?php
                                                if($val['exp_against']=='sale_order')
													echo 'RECEIPT';
												else
												{ 
													if($val['exp_against']!='transport')	
													{
														foreach($val['expense_info'] as $ex)
														{
															if($ex[0]['exp_desc']!='')
															{
																echo $ex[0]['exp_desc'];
															}
														}
													}
													else
														echo $val['exp_against'];			
												}
												?>
                                            </td>
                                            <td><?=$val['exp_for_details'][0]['exp_for_name'];?></td>
                                            <td>
                                            	 <?php 
													if(isset($val['inv_for_details']) && !empty($val['inv_for_details']))
													{
														$i=1;
														foreach($val['inv_for_details'] as $va)
														{
															echo $va['inv_no'].', ';
														}
													}
												?>
                                            </td>
                                           	<?php 
											   $g=0;
											   if(isset($val['expense_info']) && !empty($val['expense_info']))
											   {
												   $each=0;
												  
												   foreach($val['expense_info'] as $val1)
												   {
													   $full_total=$full_total+$val1[0]['exp_amount'];
													   $each=$each+$val1[0]['exp_amount'];
													   $dd[$g][]=$val1[0]['exp_amount'];
													   ?>
														<td style="text-align:right;">
															<?=number_format($val1[0]['exp_amount'], 2, '.', ',')?>
														</td>
													   <?php
													   $g++;
												   }
											   }
											 ?>
                                             <td style="text-align:right;">
                                             	<?=number_format($each, 2, '.', ',')?>
                                             </td>
                                            <td class="hide_class">
                                                <a href="#edit_<?=$val['id']?>" data-toggle="modal" name="edit" class="fa fa-edit tooltips" title="" data-original-title="Edit">&nbsp;</a>
                                                <a href="#delete_<?=$val['id']?>" data-toggle="modal" name="delete" class="red fa fa-ban tooltips" title="In-Active">&nbsp;</a>
                                            </td>
                                        </tr>
                                        <?php
										$i++;
									}
								}
								
							?>
                                
                            </tbody>
                            <tfoot>
                             <tr>
                                    <td width="4%"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <?php  $h=0;
                                       if(isset($expense) && !empty($expense))
                                       {
                                           foreach($expense as $val)
                                           {
                                               ?>
                                                    <td  style="text-align:right;"><?=number_format(array_sum($dd[$h]), 2, '.', ','); ?></td>
                                               <?php
											    $h++;
                                           }
                                       }
                                       ?>
                                    <td  style="text-align:right;"><?=number_format($full_total, 2, '.', ',');?></td>
                                    <td  class="hide_class"></td>
                                </tr>
                            </tfoot>
                       </table>
                    </div>
                       <input type="button" class="btn btn-default print_btn" style="float:right;"  value="Print"/> <input type="button" id="export_excel" class="btn btn-default" style="float:right;margin-right:10px;" value="Export excel"><br />
                   
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
                    </div><!-- tab-pane -->
                  
                    <div class="tab-pane" id="profile6">
                        <form method="post">
                        <div class="row">
                        	<div class="col-md-1"></div>
                        	<div class="col-md-8">
                            	<div>     
                                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                   <tr>
                                        <td width="20%" class="first_td1">
                                            Date
                                        </td>
                                        <td width="20%">
                                            <input type="text" id='from_date1' style="width:100px;"  class="form-control datepicker"  name="exp[date]" placeholder="dd-mm-yyyy" >
                                            <input type="hidden" id="today" class="today" value="<?php echo $i=date("d-m-y");  ?>" />
                                            <span id="varerror" style="color:#F00;" ></span>
                                        </td>
                                        <td  width="30%">
                                            <select class="form-control" name="exp[exp_against]"  id='expense_ag' style="width:140px;float:left;">
                                                <option value="">Select</option>
                                                <option value="1">Supplier</option>
                                               <!-- <option value="2">Customer</option>
                                                <option value="3">Style</option>
                                                <option value="4">Receipt</option> -->
                                                <option value="5">Transport</option>  
                                                <!--<option value="6">Agent Commission</option>  -->
                                                <option value="7">Others</option>  
                                            </select><br /><span id="varerror1" style="color:#F00;"></span>
                                            
                                        </td>
                                        <td  width="30%">
                                        	<div id='change_div'>
                                                <select  class="form-control expensecmp"  name="exp[exp_for]"  style="width:150px;float:left;">
                                                   <option value="">Select</option>
                                                </select><span id="varerror2" style="color:#F00;" ></span>
                                            </div>
                                        </td>
                                   </tr>
                                   <?php 
                                   if(isset($expense) && !empty($expense))
                                   {
                                       foreach($expense as $val)
                                       {
                                           ?>
                                           <tr>
                                                <td class="first_td1"><?=$val['expense']?>
                                                	<input type="hidden" name="exp_info[exp_type][]" value="<?=$val['id']?>" /></td>
                                                <td><input class="<?=($val['expense']=='Agency Commission')?'ag_name':'';?> form-control dot_val" type="text" name="exp_info[exp_amount][]" placeholder="amount" style="width:100px;" /></td>
                                                <td colspan="2"><input class="<?=($val['expense']=='Agency Commission')?'ag_remark':'';?> form-control" type="text" name="exp_info[exp_desc][]" placeholder="Remarks"/></td>
                                           </tr>
                                           <?php
                                       }
                                   }
								   else
								   {
									   ?>
                                       <tr><td colspan="4">Kindly add master expense...</td></tr>
                                       <?php
								   }
                                   ?>
                               </table>
                               <?php 
							  	   if(isset($expense) && !empty($expense))
                                   {
									   ?>
                                       <input type="submit" class="btn btn-default" style="float:right;" value="Save" id="submit" />
                                       <?php
								   }
								 
							   ?>
                          
                               <br />
                           </div>
                            </div>
                            <div class="col-md-3">
                            	<div id='inv_details'></div>
                            </div>
                        </div>
                            
                           
                       </form>
                    </div><!-- tab-pane -->
                  
                   
                </div><!-- tab-content -->
                
            </div>
            <?php 
            if(isset($all_expense) && !empty($all_expense))
            {
                $i=1;
                foreach($all_expense as $val)
                {
                    ?>
                     <form method="post" action="<?=$this->config->item('base_url').'expense/update_variable_fixed'?>">
              			<div id="edit_<?=$val['id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                    <h4 style="color:#06F">Update Expense</h4>
                                                    
                                      </div>
                                      <div class="modal-body">
                             				
                                                <div  style="margin:0 auto; width:100%" >     
                                                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                                       <tr style="display:none;">
                                                            <td width="25%" class="first_td1">
                                                                Date
                                                            </td>
                                                            <td width="20%">
                                                                <input type="text"  style="width:100px;"  class="form-control datepicker from_date1"  name="exp[date]" placeholder="dd-mm-yyyy" value="<?=date('d-m-Y',strtotime($val['date']));?>">
                                                            	<input type="hidden" id="today" class="today" value="<?php echo $aa=date("d-m-y");  ?>" />
                                                                <span class="varerrorup" style="color:#F00;"></span>
                                                            </td>
                                                            <td  width="30%">
                                                                <select class="form-control expensecmp_up" name="exp[exp_against]"  id='expense_ag' style="width:150px;float:left;">
                                                                    <option value="">Select</option>
                                                                    <option <?=($val['exp_against']=='suplier')?'selected':''?> value="1">Supplier</option>
                                                                    <!--<option <?=($val['exp_against']=='customer')?'selected':''?> value="2">Customer</option>
                                                                    <option <?=($val['exp_against']=='style')?'selected':''?> value="3">Style</option>
                                                                    <option <?=($val['exp_against']=='sale_order')?'selected':''?> value="4">Sales Order</option>  -->
                                                                     <option <?=($val['exp_against']=='transport')?'selected':''?> value="5">Transport</option>  
                                                                     <!-- <option <?=($val['exp_against']=='agent')?'selected':''?> value="6">Agent Commission</option>  -->
                                                                </select><span class="varerrorup1" style="color:#F00;"></span>
                                                                </td>
                                                                <td width="30%">
                                                                <div id='change_div'>
                                                                	<select  
                                                                    class="form-control expensecmpup" <?=($val['exp_against']=='agent')?'multiple':''?> 
                                                                    id="<?=($val['exp_against']=='agent')?'agent_list_receipt':''?>"
                                                                    name="exp[exp_for]<?=($val['exp_against']=='agent')?'[]':''?>"
                                                                      
                                                                    style="width:150px;float:left;">
                                                                    
                                                                    <option value="">Select</option>
                                                                <?php 
																if($val['exp_against']=='suplier')
																{
																
																	if(isset($all_supplier) && !empty($all_supplier))
																	{
																		foreach($all_supplier as $list)
																		{
																			?>
																				<option <?=($list['id']==$val['exp_for'])?'selected':''?> value="<?=$list['id']?>"><?=$list['store_name']?></option>
																			<?php
																		}
																	}  
																}
																elseif($val['exp_against']=='customer')
																{
																	if(isset($all_customer) && !empty($all_customer))
																	{
																		foreach($all_customer as $list)
																		{
																			?>
																				<option <?=($list['id']==$val['exp_for'])?'selected':''?> value="<?=$list['id']?>">
																					<?php echo $list['store_name'].' ( '.$list['selling_percent'].' % ) '?>
                                                                                </option>
																			<?php
																		}
																	}
																}
																elseif($val['exp_against']=='style')
																{
																	if(isset($po_no) && !empty($po_no))
																	{
																		foreach($po_no as $list)
																		{
																			?>
																				<option <?=($list['id']==$val['exp_for'])?'selected':''?> value="<?=$list['id']?>"><?=$list['grn_no']?></option>
																			<?php
																		}
																	}
																}
																elseif($val['exp_against']=='sale_order')
																{
																	if(isset($so_no) && !empty($so_no))
																	{
																		foreach($so_no as $list)
																		{
																			?>
																				<option <?=($list['id']==$val['exp_for'])?'selected':''?> value="<?=$list['id']?>"><?=$list['receipt_no']?></option>
																			<?php
																		}
																	}
																}
																elseif($val['exp_against']=='transport')
																{
																	if(isset($lr_no) && !empty($lr_no))
																	{
																		foreach($lr_no as $list)
																		{
																			$arr=explode(',',$val['exp_for']);
																			?>
																				<option <?=(in_array($list['id'],$arr))?'selected':''?> value="<?=$list['id']?>"><?=$list['lr_no']?></option>
																			<?php
																		}
																	}
																}
																elseif($val['exp_against']=='agent')
																{
																	if(isset($so_no) && !empty($so_no))
																	{
																		foreach($so_no as $list)
																		{
																			
																			
																			$arr=explode(',',$val['exp_for']);
																			
																			?>
																				<option <?=(in_array($list['id'],$arr))?'selected':''?> value="<?=$list['id']?>"><?=$list['receipt_no']?></option>
																			<?php
																		}
																	}
																}
																?>
                                                                
                                                                  </select><span class="varerrorup2" style="color:#F00;"></span>
                                                                </div>
                                                                
                                                            </td>
                                                       </tr>
                                                       <?php 
                                                       if(isset($val['expense_info']) && !empty($val['expense_info']))
                                                       {
                                                           foreach($val['expense_info'] as $val1)
                                                           {
                                                               ?>
                                                               <tr>
                                                                    <td class="first_td1"><?=$val1[0]['expense']?>
                                                                        <input type="hidden" name="exp_info[exp_type][]" value="<?=$val1[0]['exp_type']?>" /></td>
                                                                    <td><input type="text"  class="<?=($val1[0]['expense']=='Agency Commission')?'ag_name':'';?> form-control int_val"  name="exp_info[exp_amount][]" value="<?=$val1[0]['exp_amount']?>"  placeholder="amount" style="width:100px;"/></td>
                                                                    <td><input type="text"  class="<?=($val1[0]['expense']=='Agency Commission')?'ag_remark':'';?> form-control" name="exp_info[exp_desc][]" value="<?=$val1[0]['exp_desc']?>" placeholder="
                                                                    " /></td>
                                                               </tr>
                                                               <?php
                                                           }
                                                       }
                                                       ?>
                                                   </table>
                                               <div id='inv_details1'></div>
                                               </div>
                     
                                      </div>
                                      <input type="hidden" name="update_id" value="<?=$val['id']?>" />
                                      <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary delete_yes yesin update" id="yesin" value="Update">
                                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> Discard</button>
                                      </div>
                            	</div>
                          </div>  
                     </div>
                     </form>
                    <?php
                    $i++;
                }
            }
        ?>
            <?php 
            if(isset($all_expense) && !empty($all_expense))
            {
                $i=1;
                foreach($all_expense as $val)
                {
                    ?>
                    <form method="post" action="<?=$this->config->item('base_url').'expense/delete_variable_fixed'?>">
              			<div id="delete_<?=$val['id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                   <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                <h4 style="color:#06F">In-Active Expense</h4>
                                               
                                   </div>
                                   <div class="modal-body">
                                         
                                         <strong>
                                           Do you want In-Active? &nbsp; 
                                         </strong>
                                       
                                         <input type="hidden" name="delete_id" value="<?=$val['id']?>"  />
                                     
                                       </div>
                                       <div class="modal-footer">
                                        <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                                  </div>
                            </div>
                          </div>  
                     </div>
                     </form>
                    <?php
                    $i++;
                }
            }
        ?>
         
            
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
      <script type="text/javascript">
		 // Date Picker
		 $(document).ready(function(){
	        jQuery('#from_date1,.from_date1,#from_date,#to_date').datepicker(); 
		 });
		$('#expense_ag').live('change',function(){
			var c_div=$(this).closest('tr').find('#change_div');
			if($(this).val()!='Select')
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"expense/get_expense_type_details",
					  type:'GET',
					  data:{
						  ex_type:$(this).val()
						   },
					  success:function(result){
						c_div.html(result);
						  for_response(); 
					  }    
				});
			}
		});
		/*$('#receipt').live('change',function(){
			var ag_name=$(this).closest('table').find('.ag_name');
			var ag_remark=$(this).closest('table').find('.ag_remark');
			if($(this).val()!='Select')
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"expense/get_receipt_info",	
					  type:'GET',
					  data:{
						  r_id:$(this).val()
						   },
					  success:function(result){
						 var arr=result.split(' / ');
						ag_name.val(arr[0]);
						ag_remark.val(arr[1]);
						  for_response(); 
					  }    
				});
			}
		});*/
		$('#agent_list_receipt').live('change',function(){
			var ag_name=$(this).closest('table').find('.ag_name');
			var ag_remark=$(this).closest('table').find('.ag_remark');
			if($(this).val()!='Select')
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"expense/get_receipt_info",
					  type:'GET',
					  data:{
						  r_id:$(this).val()
						   },
					  success:function(result){
						 var arr=result.split(' / ');
						ag_name.val(arr[0]);
						ag_remark.val(arr[1]);
						  for_response(); 
					  }    
				});
			}
		});
		
		</script>
         <script type="text/javascript">
	  $("#from_date1").live('change',function()
		{
			 var dateString =$('#from_date1').val();
			 var today = $('#today').val();
			 if(dateString== "")
			 { 
				 $("#varerror").html("Required Field");
		
			 }
			 else
			 {
				  $("#varerror").html("");
			 }
		}); 
		 $("#expense_ag").live('change',function()
		{
			 var expense_ag =$('#expense_ag').val();
			 if(expense_ag=="")
			 { 
				 $("#varerror1").html("Required Field");
		
			 }
			 else
			 {
				  $("#varerror1").html("");
			 }
		}); 
		 $(".expensecmp").live('change',function()
		{
			 var expensecmp =$('.expensecmp').val();
			 if(expensecmp=="")
			 { 
				 $("#varerror2").html("Required Field");
		
			 }
			 else
			 {
				    for_loading(); 
					$.ajax({
						  url:BASE_URL+"expense/get_inv_info",
						  type:'GET',
						  data:{
							 	 st_id:$('#expense_ag').val(),
								 expense_ag:$(this).val(),
								 expense_text:$(this).find(":selected").text()
							   },
						  success:function(result){
							 $('#inv_details').html(result);
							  for_response(); 
						  }    
					});
				  $("#varerror2").html("");
			 }
		}); 
		
		$('#submit').live('click',function()
		{
			 i=0;
			 var dateString =$('#from_date1').val();
			 var today = $('#today').val();
			 if(dateString== "")
			 { 
				 $("#varerror").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#varerror").html("");
			 }
			  var expense_ag =$('#expense_ag').val();
			 if(expense_ag=="")
			 { 
				 $("#varerror1").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#varerror1").html("");
			 }
			  var expensecmp =$('.expensecmp').val();
			 if(expensecmp=="")
			 { 
				 $("#varerror2").html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  $("#varerror2").html("");
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
		$('.from_date1').live('change',function()
		{
			var date=$(this).parent().parent().find(".from_date1").val();
			var today=$(this).parent().parent().find(".today").val();
			var m=$(this).offsetParent().find('.varerrorup');
			if(date=='')
			{
				m.html("Required Field");
			}
			else
			{
				m.html("");
			}
		});
		 $(".expensecmp_up").live('change',function()
		{
			 //var expensecmpup =$('.expensecmpup').val();
			 var expensecmpup=$(this).parent().parent().find(".expensecmp_up").val();
			 var o=$(this).offsetParent().find('.varerrorup1');
			 if(expensecmpup=="")
			 { 
				 o.html("Required Field");
		
			 }
			 else
			 {
				  o.html("");
			 }
		}); 
		 $(".expensecmpup").live('change',function()
		{
			 var expensecmpup =$('.expensecmpup').val();
			 var expensecmpup=$(this).parent().parent().find(".expensecmpup").val();
			 var n=$(this).offsetParent().find('.varerrorup2');
			 if(expensecmpup=="")
			 { 
				 n.html("Required Field");
		
			 }
			 else
			 {
				
				 n.html("");
			 }
		}); 
		
		$('.update').live('click',function()
		{
			i=0;
			var date=$(this).parent().parent().find(".from_date1").val();
			var today=$(this).parent().parent().find(".today").val();
			var m=$(this).offsetParent().find('.varerrorup');
			if(date=='')
			{
				m.html("Required Field");
				i=1;
			}
			else
			{
				m.html("");
			}
			var expensecmpup=$(this).parent().parent().find(".expensecmp_up").val();
			 var o=$(this).offsetParent().find('.varerrorup1');
			 if(expensecmpup=="")
			 { 
				 o.html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				  o.html("");
			 }
			 var expensecmpup =$('.expensecmpup').val();
			 var expensecmpup=$(this).parent().parent().find(".expensecmpup").val();
			 var n=$(this).offsetParent().find('.varerrorup2');
			 if(expensecmpup=="")
			 { 
				 n.html("Required Field");
				 i=1;
		
			 }
			 else
			 {
				 n.html("");
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
		$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"expense/search_variable",
					  type:'GET',
					  data:{
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
		<style type="text/css">
      	.right_td
		{
			text-align:right;
		}
      </style>
      <script>
			function fnExcelReport()
			{
				var tab_text="<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
				var textRange; var j=0;
				tab = document.getElementById('basicTable'); // id of table
				for(j = 0 ; j < tab.rows.length ; j++) 
				{     
					tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
					//tab_text=tab_text+"</tr>";
				}
				tab_text=tab_text+"</table>";
				tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
				tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
				tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE "); 
				if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
				{
					txtArea1.document.open("txt/html","replace");
					txtArea1.document.write(tab_text);
					txtArea1.document.close();
					txtArea1.focus(); 
					sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
				}  
				else                 //other browser not tested on IE 11
					sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
				return (sa);
			}
   </script>
   <script>
           
	$('#export_excel').live('click',function(){
		
		fnExcelReport();
		//window.location.href=BASE_URL+'report/pl_excel_file1';
	});
  </script>