<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
 		<table width="100%" cellpadding="0" cellspacing="0">
        	<tbody>
           		<tr>
                	<td><b>To:</b> <?=$gen_info[0]['name']?></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center;"><b><?=$gen_info[0]['grn_no']?></b></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['store_name']?></td>
                    <td></td>
                    <td></td>
                    <td  style="text-align:center;"><b></b></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['address1']?>,<?=$gen_info[0]['address2']?>,<?=$gen_info[0]['city']?></td>
                    <td></td>
                    <td></td>
                    <td  style="text-align:center;"><?=date('d-M-Y',strtotime($gen_info[0]['inv_date']))?></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['city']?>,<?=$gen_info[0]['state']?>-<?=$gen_info[0]['pincode']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                 <tr>
                	<td><b>Tin / Lot NO:</b><?=$gen_info[0]['tin']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
             </tbody>
           </table>
           <br /><br />
           <table style="display:none;">
           		<tr><td><b>Dear Sir,</b></td></tr>
                <tr>
                	<td>
                    <b>
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We are pleased to place the purchase order for the following items :
                    </b>
                    </td>
                </tr>
           </table>                           
                <table width="100%" border="1" cellpadding="0" cellspacing="0">
                	<tr style="font-weight:bold;">
                    	<td>&nbsp;Style Code</td>
                        <td>&nbsp;Color</td>                        
                        <td>&nbsp;Size / QTY</td>
                        <td>&nbsp;QTY</td>
                        <td>&nbsp;Landed&nbsp;Cost</td>
                        <td>&nbsp;Net&nbsp;Value</td>
                    </tr>
                    <tbody id='app_table'>
                    <?php 
					$net_val=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
					?>
                    	<tr>
                        	<td>
                            	<?=$info['style_name']?>
                            </td>
                          
                            <td>
                            	<?=$info['colour'];?>
                            </td>
                            
                            <td class="size_html" align="center">
                           		 <?php 
								 	$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												$full_total=$full_total+$val['qty'];
                                                ?> 
												<table>
                                                	<tr>
                                                    	<td><?=$val['size']?> </td>
                                                        <td><?=$val['qty']?></td>
                                                    </tr>
                                                </table>
												
												
												
												<?php
                                            }
                                        }
										
										$net_val=$net_val+($full_total*$info['landed']);
                                    ?>
                            
                            </td>
                            <td  style="text-align:right;"><?=$full_total;?> &nbsp;</td>
                            <td   style="text-align:right;"><?=$info['landed']?> &nbsp;</td>
                             <td   style="text-align:right;"><?=number_format($full_total*$info['landed'], 2, '.', ',')?> &nbsp;</td>
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;">Total &nbsp;</td>
                            <td  style="text-align:right;"><?=$gen_info[0]['full_total'];?> &nbsp;</td>
                          	<td></td>
                            <td style="text-align:right;"><?=number_format($net_val, 2, '.', ',')?> &nbsp;</td>
                        </tr>
                        <?php
						$st=$net_val*($gen_info[0]['st']/100);
						$cst=$net_val*($gen_info[0]['cst']/100);
						$vat=$net_val*($gen_info[0]['vat']/100);	
                        ?>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                            <td></td>
                            <td style="text-align:right;font-weight:bold;">ST ( <span class="st"><?=($gen_info[0]['st']=='0.00'?0:$gen_info[0]['st'])?></span> % ) &nbsp;</td>
                            <td  style="text-align:right;"><?=number_format($st, 2, '.', ',')?> &nbsp;</td>
                           
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                            <td></td>
                            <td style="text-align:right;font-weight:bold;">CST ( <span class="cst"><?=($gen_info[0]['cst']=='0.00'?0:$gen_info[0]['cst'])?></span> % ) &nbsp;</td>
                            <td  style="text-align:right;"><?=number_format($cst, 2, '.', ',')?> &nbsp;</td>
                         
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                            <td></td>
                            <td style="text-align:right;font-weight:bold;">VAT ( <span class="vat"><?=($gen_info[0]['vat']=='0.00'?0:$gen_info[0]['vat'])?></span> % ) &nbsp;</td>
                            <td   style="text-align:right;"><?=number_format($vat, 2, '.', ',')?> &nbsp;</td>
                           
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                            <td></td>
                            <td style="text-align:right;font-weight:bold;">Net Total &nbsp;</td>
                            <td   style="text-align:right;"><?=number_format($gen_info[0]['net_total'], 2, '.', ',');?> &nbsp;</td>
                       
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                            <td></td>
                            <td style="text-align:right;font-weight:bold;">Grand Total &nbsp;</td>
                            <td style="text-align:right;"><?=round($gen_info[0]['net_total']);?> &nbsp;</td>
                       
                        </tr>
                    </tfoot>
                </table>
                Rupees in Words:
                             <b><?php
								  $money=round($gen_info[0]['net_total']);
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
										  
								
								if(!empty($points))
								  echo '<b>'. $result . "rupees  " . $points . " paise".'</b>';
								else
									 echo '<b>'. $result . "rupees  ".'</b>';
							?></b>
                <br /><br />
                <table>
                	<tr>
                    	<td><b>Remarks : </b><?=$gen_info[0]['remarks']?></td>
                    </tr>
                </table>
             	<table width="100%">
                	<tr style="display:none;">
                    	<td style="text-align:center;">
                        <b>
                        	We Hope the above said items will be supplied as per the specification and best of quality
                        </b>
                        </td>
                    </tr>
                </table>
                <br /><br />
                <table width="100%" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="50%" style="margin:0; padding:0;">
                        	<table width="100%">                            	
                                <tr>
                                	<td colspan="3"><b>TERMS AND CONDITIONS</b></td>                                    
                                </tr>
                                <tr>
                                    <td width="50%">Delivery&nbsp;Schedule</td>
                                    <td width="5">:</td>
                                    <td><b><?=$gen_info[0]['delivery_schedule'];?></b></td>
                                </tr>
                                <tr>
                                    <td>Delivery&nbsp;at</td>
                                    <td>:</td>
                                    <td><b><?=$gen_info[0]['delivery_at'];?></b></td>
                                </tr>
                                <tr>
                                    <td>Mode&nbsp;of&nbsp;Payment</td>
                                    <td>:</td>
                                    <td><b><?=$gen_info[0]['mode_of_payment'];?></b></td>
                                </tr>                                
                            </table>
                        </td>
                        <td width="50%">
                        	<table width="100%">
                            	<tr>
                                	<td style="text-align: center;" colspan="2">Thanking you, For <b><?=strtoupper($company_details[0]['company_name'])?></b></td>
                                </tr>
                                <tr>
                                	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                	<td style="text-align: center;">Receivers Signature</td>
                                    <td style="text-align: center;">Authorised Signature</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br /><br /><br />