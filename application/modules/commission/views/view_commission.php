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
                        <h4>View Commission Payable</h4>
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
                                            <td  class="text_right"><?=number_format($val['bill_amount'], 2, '.', ',')?></td>
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
                                            <td class="text_right"><?=number_format($val['org_value'], 2, '.', ',')?></td>
                                        </tr>
                                    <?php
									$i++;
								}
								?>
								<tr><td colspan="3" class="text_right">Total Invoice Value</td><td class="text_right"><?=number_format($receipt_details[0]['total_inv_value'], 2, '.', ',')?></td></tr>
									
									<tr><td colspan="3" class="text_right">Total Discount Value</td><td class="text_right"><?=number_format($receipt_details[0]['total_dis_value'], 2, '.', ',')?></td></tr>
									
									<tr><td colspan="3" class="text_right">Net Receipt Value</td><td class="text_right"><?=number_format($receipt_details[0]['net_receipt_val'], 2, '.', ',')?></td></tr>
									
									<tr>
										<td colspan="3" class="text_right">
										Agent Commission
										(<?=$receipt_details[0]['agent_comm']?>%)
										</td>
										<td  class="text_right">
										<?=number_format($receipt_details[0]['agent_comm_value'], 2, '.', ',')?>
										</td>
									</tr>
									
									<tr><td  colspan="3" class="text_right">Total Paid Value</td><td class="text_right"><?=number_format($paid, 2, '.', ',')?></td>
                                    </tr>									
									<tr><td  colspan="3" class="text_right">Balance</td><td class="text_right"><?=number_format($receipt_details[0]['agent_comm_value']-$paid, 2, '.', ',')?></td></tr>
									
									
									
									<tr><td colspan="3"></td><td><input type="button" class="btn btn-default print_btn" style="float:right;"  value="Print"/>
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script> </td></tr>
								<?php }?>
                        </tbody>
                    </table>
                    </form>
                 </div> 
                 </div>    
               
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
     