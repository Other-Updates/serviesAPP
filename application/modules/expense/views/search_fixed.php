<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <td width="4%">S NO</td>
                                    <td>Date</td>
                                     <?php 
                                       if(isset($expense) && !empty($expense))
                                       {
                                           foreach($expense as $val)
                                           {
                                               ?>
                                                    <td><?=$val['expense']?></td>
                                               <?php
                                           }
                                       }
                                       ?>
                                    <td>Total</td>
                                    <td  class="hide_class">Action</td>
                                </tr>
                            </thead>
                            <tbody >
                                <?php 
								$full_total=0;$dd=array();
                                    if(isset($all_expense) && !empty($all_expense))
                                    {
                                        $i=1;
                                        foreach($all_expense as $val)
                                        {
											
                                            ?>
                                                <tr>
                                                    <td class='first_td'><?=$i?></td>
                                                    <td><?=date('d-m-Y',strtotime($val['exp_date']))?></td>
                                                    <?php 
                                                    if(isset($val['expense_info']) && !empty($val['expense_info']))
                                                    {
														$each=0;$g=0;
                                                        foreach($val['expense_info'] as $val1)
                                                        {
															
                                                            ?>
                                                            <td style="text-align:right;">
                                                                <?php 
																	$full_total=$full_total+$val1[0]['exp_value'];
                                                                    if(isset($val1[0]['exp_value']) && !empty($val1[0]['exp_value']))
																	{
																		$dd[$g][]=$val1[0]['exp_value'];
																		$each=$each+$val1[0]['exp_value'];
                                                                        echo number_format($val1[0]['exp_value'], 2, '.', ',');
																	}
																	else
																	{
																		$dd[$g][]=0;
																		$each=$each+0;
                                                                        echo 0;		
																	}
                                                                ?>
                                                            </td>
                                                            <?php
															$g++;
                                                        }
                                                    }
                                                    ?>
                                                    <td  style="text-align:right;"><?=number_format($each, 2, '.', ',')?></td>
                                                    <td  class="hide_class">
                                                        <a href="#edit_<?=$i?>" data-toggle="modal" name="edit" class="fa fa-edit tooltips" title="" data-original-title="Edit">&nbsp;</a>
                                                        <a href="#delete_<?=$i?>" data-toggle="modal" name="delete" class="red fa fa-ban tooltips" title="In-Active">&nbsp;</a>
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
                                     <?php 
									 $h=0;
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