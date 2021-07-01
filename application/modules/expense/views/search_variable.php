<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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