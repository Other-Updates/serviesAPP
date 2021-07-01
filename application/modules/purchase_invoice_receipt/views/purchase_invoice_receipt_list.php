<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
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
                        <h4>Purchase Payable</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
                    <a href="<?php echo $this->config->item('base_url').'purchase_invoice_receipt/'?>" class="btn btn-default  right"><span>Add Purchase Payable</span></a>
                    <br /><br />
                  <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide" style="display:none;">
                  		<tr>
                        	
                           
                            <td>Supplier
                            <input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>
                            	<select id='state' style="width: 170px;">
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
                            <td>
                            	<select id='supplier'  class="form-control" style="width: 170px;">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_supplier) && !empty($all_supplier))
                                        {
                                            foreach($all_supplier as $val)
                                            {
                                                ?>
                                                    <option value='<?=$val['id']?>'><?=$val['store_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>From Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td>To Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>
                        </tr>
                  </table>
                  <div id='result_div'>
                  <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>RP #</td>
                            <td>Supplier</td>
                            <td width="300">Inv No</td>
                            <td>Invoice Amount</td>
                            
                            <td>Paid Amount</td>
                            <td>Balance</td>
                            <td>Payment Status</td>
                            <td class="hide_class">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
							$this->load->model('purchase_invoice_receipt/purchase_invoice_receipt_model');
							$r=0;$inv=0;$p=0;
                        	if(isset($all_receipt) && !empty($all_receipt))
							{
								$i=1;
								foreach($all_receipt as $val)
								{
									$inv_list='';
									foreach(explode('-',$val['inv_list']) as $inv_id)
									{
										$inv_no=$this->purchase_invoice_receipt_model->get_inv_no($inv_id);
										
										$inv_list=$inv_list.$inv_no[0]['receipt_no'].', ';
									}
									$r=$r+$val['total_amount'];
									$inv=$inv+$val['receipt_bill'][0]['receipt_paid'];
									$p=$p+($val['total_amount']-$val['receipt_bill'][0]['receipt_balance'])-$val['receipt_bill'][0]['receipt_paid'];
									?>
                                    <tr>
                                    <td class='first_td'><?=$i?></td>
                                    <td><?=$val['receipt_no']?></td>	
                                    <td><?=$val['store_name']?></td>
                              		<td><?=$inv_list?></td>
                                    <td  class="text_right"><?=number_format($val['total_amount'], 2, '.', ',')?></td>
                                    
                                    <td  class="text_right"><?=number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',')?></td>
                                    <td  class="text_right"><?=number_format(($val['total_amount']-$val['receipt_bill'][0]['receipt_balance'])-$val['receipt_bill'][0]['receipt_paid'], 2, '.', ',')?></td>
                                    <td>
										<?php 
										if($val['complete_status']==0)
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
										}
										else
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
										}
										
										?>
                                   </td>
									
									<td  class="hide_class">
                                      <a href="<?php echo $this->config->item('base_url').'purchase_invoice_receipt/view_receipt/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                    <?php 
									if($val['complete_status']==0)
									{
									?>
                                    	<a href="<?php echo $this->config->item('base_url').'purchase_invoice_receipt/update_receipt/'.$val['id']?>" data-toggle="tooltip" class="fa fa-edit tooltips" title="" data-original-title="Edit">&nbsp;</a>
                                        <?php }?>
                                      
                                    </td>
                                    </tr>
                                    <?php
									$i++;
								}
								?>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td width="300"></td>
                                        <td class="text_right"><?=number_format($r, 2, '.', ',')?></td>
                                        <td class="text_right"><?=number_format($inv, 2, '.', ',')?></td>
                                        <td class="text_right"><?=number_format($p, 2, '.', ',')?></td>
                                        <td></td>
                                        <td class="hide_class"></td>
                                    </tr>
                                </tbody>
                                <?php
							}
							else
							{
								?>
                                <tr><td colspan="8">No data found...</td></tr>
                                <?php
							}
						?>
                    </tbody>
                  </table>
                      
                  </div>
                  <input type="button" class="btn btn-defaultprint6 print_btn" style="float:right;"  value="Print"/>
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
        
        <?php
			if(isset($all_gen) && !empty($all_gen))
			{
				foreach($all_gen as $val)
				{
					?>
                    <form method="post" action="<?=$this->config->item('base_url').'po/force_to_complete/1'?>">
                            <div id="com_<?=$val['id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                    <h4 style="color:#06F">Force to Complete</h4>
                                                    <h3 id="myModalLabel">
                                       </div>
                                       <div class="modal-body">
                                             
                                             <strong>
                                               Are You Sure You Want to Complete This PO ?  
                                             </strong>
                                           	<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                            	<tr>
                                                	<td width="40%" style="text-align:right;" class="first_td1">Remarks&nbsp;</td>
                                                    <td>
                                                    	<input type="text" style="width:220px;" class="form-control" name='complete_remarks' />
                                                    </td>
                                                </tr>
                                            </table>	
                                             <input type="hidden" name="update_id" value="<?=$val['id']?>"  />
                                    
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
				}
			}
		
		?>             
  		<script type="text/javascript">
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#po_no").autocomplete(BASE_URL+"gen/get_po_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/search_result",
					  type:'GET',
					  data:{
						  	po       :$('#po_no').val(),
						 	state    :$('#state').val(),
							supplier :$('#supplier').val(),
							supplier_name:$('#supplier').find('option:selected').text(),
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