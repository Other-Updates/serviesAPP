<?php
                        if(isset($quotation) && !empty($quotation))
                        {
                            $i=1;
                            foreach($quotation as $val)
                            {
                            ?>
                                <tr>
                                <td class='first_td'><?=$i?></td>                                  
                                <td><?=$val['job_id']?></td>	
                                <td><?=$val['name']?></td>
                                <td class="action-btn-align"><?=$val['total_qty']?></td>
                                <td class="text_right"><?=number_format($val['tax_details'][0]['tot_tax'],2)<0?0:number_format($val['tax_details'][0]['tot_tax'],2);?></td>
                                <td class="text_right"><?=number_format($val['subtotal_qty'],2);?></td>
                                <td class="text_right"><?=number_format($val['net_total'],2);?></td>
                                <td><?=($val['created_date']!='1970-01-01')?date('d-M-Y',strtotime($val['created_date'])):'';?></td>   
                                <td><?=$val['remarks']?></td>
                                
                            <?php 
                         $i++;
                        }
                    }
                          
                        else
                        {
                            echo '<tr><td colspan="8">Data not found...</td></tr>';
                        }
			
			?>