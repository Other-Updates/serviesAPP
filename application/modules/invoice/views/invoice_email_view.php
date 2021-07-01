<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
      
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" rowspan="3">
                <b>Billing Address:</b><br />
                &nbsp;&nbsp;<?=$package_details[0]['name']?><br />
                &nbsp;&nbsp;<?=$package_details[0]['store_name']?>,<br />
                &nbsp;&nbsp;<?=$package_details[0]['address1']?>,<?=$package_details[0]['address1']?>,<br />
                &nbsp;&nbsp;<?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                &nbsp;&nbsp;<b>PIN:</b><?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
                 &nbsp;&nbsp;<b>Tin / Vat No:</b><?=$package_details[0]['tin']?>
                </td>
               
                <td width="25%">&nbsp;&nbsp;<b>Invoice No</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['inv_no']?></td>
                <td width="25%">
                
                 <div style="float:left;padding-right: 50px;">
                &nbsp;&nbsp;Invoice Date<br />&nbsp;&nbsp;<?=date('d-M-Y', strtotime($invoice_details[0]['inv_date']))?>
                </div>
                <div  style="float:left;">
               &nbsp;&nbsp; Due Date<br />&nbsp;&nbsp;<?=date('d-M-Y', strtotime($invoice_details[0]['due_date']))?>
                </div>	
                </td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;<b>Delivery Challan No</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['challen_no']?></td>
                <td>&nbsp;&nbsp;<b>Purchase Order No</b><br />&nbsp;&nbsp;<b><?=$invoice_details[0]['po_no']?></b></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;<b>Work Order No</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['work_order_no']?></td>
                <td>&nbsp;&nbsp;<b>Mode / Terms of payment</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['terms_of_payment']?></td>
              </tr>
              <tr>
                <td rowspan="2">
                 <b>Delivery Address:</b><br />
                &nbsp;&nbsp;<?=$package_details[0]['name']?><br />
                &nbsp;&nbsp;<?=$package_details[0]['store_name']?>,<br />
                &nbsp;&nbsp;<?=$package_details[0]['address1']?>,<?=$package_details[0]['address1']?>,<br />
                &nbsp;&nbsp;<?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                &nbsp;&nbsp;<b>PIN:</b><?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
                 &nbsp;&nbsp;<b>Tin / Vat No:</b><?=$package_details[0]['tin']?>
                </td>
                <td>&nbsp;&nbsp;<b>No of Cartons</b><br /><b>&nbsp;&nbsp;<?=$package_details[0]['no_corton']?></b></td>
                <td>&nbsp;&nbsp;<b>LR No/Docket No</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['docket_no']?></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;&nbsp;<b>Despatch Throught</b><br />&nbsp;&nbsp;<?=$invoice_details[0]['despatch_throught']?></td>
                </tr>
            </table>

                <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>&nbsp;&nbsp;<b>S No</b></th>
                            <th>&nbsp;&nbsp;<b>Particulars</b></th>
                            <th>&nbsp;&nbsp;<b>Color</b></th>
                            <th>&nbsp;&nbsp;<b>Total Qty</b></th>
                            <th>&nbsp;&nbsp;<b>Unit Price</b></th>
                            <th>&nbsp;&nbsp;<b>Amount</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
						$full_total=$full_qty=0;
						$this->load->model('package/package_model');
						 $this->load->model('sales_order/sales_order_model');
                        if(isset($package_info) && !empty($package_info))
                        {
                            $full_total=0;
                            foreach($package_info as $val)
                            {
                            	$single=0;
                                foreach($val['style_color'] as $val1)
                                {
									$total_p=0;
									foreach($val1['size'] as $val2)
									{
										$total_p=$total_p+$val2['total_qty'];
									}
									if($total_p==0)continue;
									?>
                                    <tr>
                                    	<td>&nbsp;&nbsp;<?=$i?></td>
                            			<td>&nbsp;&nbsp;<?=$val['style_name'];?></td>            
                                        <td>
                                            &nbsp;&nbsp;<?=$val1['colour']?>
                                        </td>
        
                                            <?php
                                            $total=0;
                                                foreach($val1['size'] as $val2)
                                                {
                                                    $total=$total+$val2['total_qty'];
                                                   
                                                }
                                                $full_qty=$full_qty+$total;
												
												$c_mrp=$this->package_model->get_p_mrp($package_details[0]['id'],$val['style_id']);
												
												$val['mrp']=$c_mrp[0]['p_c_mrp'];
                                            ?>
                         
                                        <td  style="text-align:right;"><?=$total?>&nbsp;&nbsp;</td>
                                        <td  style="text-align:right;"><?=$c_mrp[0]['p_c_mrp'];?>&nbsp;&nbsp;</td>
                                        <td  style="text-align:right;">
										<?php 
											$single=$total*$c_mrp[0]['p_c_mrp'];
											
											echo number_format(round($single,2), 2, '.', ',');
											$full_total=$full_total+$single;
										?>&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <?php
									$i++;
                                }
                            }
							?>
                            
                            <tr>
                            	<td></td><td></td>
                            	 <td  style="text-align:right;"><b>Total QTY</b>&nbsp;&nbsp;</td>
                                <td  style="text-align:right;"><?=$full_qty?>&nbsp;&nbsp;<input type='hidden' name='invoice[total_qty]' value=<?=$full_qty?> />
                                </td>
                            	
                                <td  style="text-align:right;"><b>Sub Total</b>&nbsp;&nbsp;</td>
                                <td  style="text-align:right;"><?=number_format(round($full_total,2), 2, '.', ',')?>&nbsp;&nbsp;</td>		                            </tr>
                            <?php 
							
								$st=0;$cst=0;$vat=0;
								if($package_details[0]['st']!='' && $package_details[0]['st']!='0')
								{
							?>     
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">ST ( <?=($package_details[0]['st']=='0.00')?0:$package_details[0]['st']?>  %)&nbsp;&nbsp;</td>
                                <td  style="text-align:right;">
                                	<?php 
										$st=$full_total*($package_details[0]['st']/100);
										echo number_format(round($st,2), 2, '.', ','); 
									?>&nbsp;&nbsp;
                                </td>
                            </tr>
                             <?php 
								}if($package_details[0]['cst']!='' && $package_details[0]['cst']!='0')
								{
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">CST ( <?=($package_details[0]['cst']=='0.00')?0:$package_details[0]['cst']?>  %)&nbsp;&nbsp;</td>
                                <td style="text-align:right;">
                                	<?php 
										$cst=$full_total*($package_details[0]['cst']/100);
										echo number_format(round($cst,2), 2, '.', ','); 
									?>&nbsp;&nbsp;
                                </td>
                            </tr>
                             <?php 
								}if($package_details[0]['vat']!='' && $package_details[0]['vat']!='0')
								{
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">VAT ( <?=($package_details[0]['vat']=='0.00')?0:$package_details[0]['vat']?>  %)&nbsp;&nbsp;</td>
                                <td  style="text-align:right;">
                                	<?php 
										$vat=$full_total*($package_details[0]['vat']/100);
										echo number_format(round($vat,2), 2, '.', ','); 
									?>&nbsp;&nbsp;
                                </td>
                            </tr>
                             <?php 
								}
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">Net Total&nbsp;&nbsp;</td>
                                <td  style="text-align:right;font-weight:bold;">
                                	<?php 
										echo  number_format(round($full_total+$st+$cst+$vat,2), 2, '.', ','); 
									?>
                                   &nbsp;
                                </td>
                            </tr>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">Grand Total&nbsp;&nbsp;</td>
                                <td  style="text-align:right;font-weight:bold;">
                                	<?php 
										echo round($full_total+$st+$cst+$vat); 
									?>
                                 &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" >
                                    <span style="float:left;margin-top:6px;">Value in Words&nbsp;:
                                    <?php 
										 $money=round($full_total+$st+$cst+$vat);
										  $number = $money;
										   $no = round($number);
										   $point = round($number - $no, 2) * 100;
										   $hundred = null;
										   $digits_1 = strlen($no);
										   $i = 0;
										   $str = array();
										   $words = array('0' => '', '1' => 'one', '2' => 'two',
											'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
											'7' => 'seven', '8' => 'eight', '9' => 'nine',
											'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
											'13' => 'thirteen', '14' => 'fourteen',
											'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
											'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
											'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
											'60' => 'sixty', '70' => 'seventy',
											'80' => 'eighty', '90' => 'ninety');
										   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
										   while ($i < $digits_1) {
											 $divider = ($i == 2) ? 10 : 100;
											 $number = floor($no % $divider);
											 $no = floor($no / $divider);
											 $i += ($divider == 10) ? 1 : 2;
											 if ($number) {
												$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
												$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
												$str [] = ($number < 21) ? $words[$number] .
													" " . $digits[$counter] . $plural . " " . $hundred
													:
													$words[floor($number / 10) * 10]
													. " " . $words[$number % 10] . " "
													. $digits[$counter] . $plural . " " . $hundred;
											 } else $str[] = null;
										  }
										  $str = array_reverse($str);
										  $result = implode('', $str);
										  $points = ($point) ?
											" . " . $words[$point / 10] . " " . 
												  $words[$point = $point % 10] : '';
									
										  echo '<b>'. $result . "rupees ".'</b>';
										
									?></span>
                                </td>
                       		</tr>  
                             <tr>
                                <td colspan="6" style="">
                                    <span style="float:left;margin-top:6px;">Remarks :&nbsp; <b><?=$invoice_details[0]['remarks']?></b></span>
                                </td>
                       		</tr>    
                    <?php
                        }
                        else
                        {
                            echo "<tr><td colspan='5'>Sales Order Not Created Yet....</td></tr>";
                        }
                    ?>
                   </tbody>
                </table> 
                