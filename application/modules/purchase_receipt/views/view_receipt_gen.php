<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>View Purchase Invoice</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <div class="contentpanel">
          <?php 
		 // echo "<pre>";
		  //print_r($receipt_details);
		  //exit;
		  ?>
          <div class="tabwid70">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               <tr>
               	<td colspan="5" style="text-align:center;">
                	<b><?=$receipt_details[0]['receipt_no']?></b>
                </td>
               </tr>
               <tr>
                    
                    <td width="5%" class="first_td1">Due Date</td>
                     <td width="10%"><?=date('d-M-Y',strtotime($receipt_details[0]['due_date']))?></td>
                      <td width="5%" class="first_td1">Supplier Name</td>
                    <td width="10%">
                    	<?=$receipt_details[0]['store_name']?>
                    </td>
                  
               </tr>
          
               <tr>
                    <td width="5%" class="first_td1">Bill No</td>
                     <td width="10%"><?=$receipt_details[0]['inv_no']?></td>
                      <td width="5%" class="first_td1">
                      IInvoice Date
                      </td>
                    <td width="10%">
                    	<?=date('d-M-Y',strtotime($receipt_details[0]['inv_date']))?>
                    </td>
                  
               </tr>
               </table>
               </div>
            
               <div class="tabwid70">
              
               <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               				
                        <thead>
                        	<th width="1%">S&nbsp;No</th>
                            <th width="5%">PO No</th>
                            <th width="5%">GRN No</th>
                            <th width="5%">GRN QTY</th>
                            <th  width="5%">GRN Date</th>
                            <th width="5%">Amount</th>
                            
                        </thead>
                        <tbody id='receipt_info'>
                        	<?php
                        	if(isset($receipt_details[0]['inv_details']) && !empty($receipt_details[0]['inv_details']))
							{
								$i=1;$dis=0;$paid=0;$full_amt=0;
								foreach($receipt_details[0]['inv_details'] as $val)
								{
									$full_amt=$full_amt+$val['total_value'];
									?>
                                    	<tr>
                                        	<td><?=$i?></td>
                                            <td><?=$val['po_no']?></td>
                                            <td><?=$val['grn_no']?></td>
                                            <td class="text_right"><?=$val['total_qty']?></td>
                                            <td><?=date('d-M-Y',strtotime($val['due_date']))?></td>
                                            <td class="text_right"><?=number_format($val['total_value'], 2, '.', ',')?></td>
                                        </tr>
                                    <?php
									$i++;
								}
								?>
                                
                                	<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>GRN Value</td>
                                    <td class="text_right"><?=number_format($full_amt, 2, '.', ',')?></td>
                                    </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>Tax <?=' ( '.$receipt_details[0]['tax_per'].' % ) '?></td>
                                    <td class="text_right"><?=number_format($receipt_details[0]['tax_value'], 2, '.', ',')?></td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>NET Value</td>
                                    <td class="text_right"><?=number_format($receipt_details[0]['net_value'], 2, '.', ',')?></td>
                                </tr>   
                                 
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>Invoice&nbsp;Amount</td>
                                    <td class="text_right"><?=number_format($receipt_details[0]['inv_value'], 2, '.', ',')?></td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>Debit Note
                                    <?php 
										if(!empty($receipt_details[0]['remark']))
										{
											echo "<br><b>Remarks:</b>".$receipt_details[0]['remark'].'<br>';
											echo '<span id="hide_print" style="display:none;">'.$receipt_details[0]['debit_file'].'</span>';
											echo "<a id='hide_print1' target='_blank' href=".$this->config->item('base_url')."debit_note/".$receipt_details[0]['debit_file'].">".$receipt_details[0]['debit_file'].'</a>';
										}
									?>
                                    </td>
                                    <td class="text_right">
										<?=number_format($receipt_details[0]['debit_note'], 2, '.', ',')?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>Discount <?=' ( '.$receipt_details[0]['debit_per'].' % ) '?></td>
                                    <td class="text_right">
									<?=number_format($receipt_details[0]['debit'], 2, '.', ',')?>
                                    
                                    </td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td><td></td>
                                    <td>Payable Value</td>
                                    <td class="text_right"><?=$receipt_details[0]['total_amount']?></td>
                                </tr>
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
                 <div class="action-btn-align">
                 <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                 </div>
                
				  <script>
                    $('.print_btn').click(function(){
                        window.print();
                    });
                  </script>
                 
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        