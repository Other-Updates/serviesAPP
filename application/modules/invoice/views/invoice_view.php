<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
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
                        <h4>View Invoice</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">        
            <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
              <tr>
                <td width="50%" style="line-height: 20px;font-size: 15px;" rowspan="3">
                <b>Billing Address:</b><br />
                
                
                 <?=$package_details[0]['name']?><br />
                 <?=$package_details[0]['store_name']?>,<br />
                  <?=$package_details[0]['address1']?>,<?=$package_details[0]['address1']?>,<br />
                  <?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                  <b>PIN:</b>&nbsp;<?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
				  <b>Tin / Vat No:</b><?=$package_details[0]['tin']?><br />
                </td>
               
                <td width="25%">Invoice No<br /><?=$invoice_details[0]['inv_no']?></td>
                <td width="25%">
                <div style="float:left;padding-right: 50px;">
                Invoice Date<br /><?=date('d-M-Y', strtotime($invoice_details[0]['inv_date']))?>
                </div>
                <div  style="float:left;">
                Due Date<br /><?=date('d-M-Y', strtotime($invoice_details[0]['due_date']))?>
                </div>	
                </td>
              </tr>
              <tr>
                <td>Delivery Challan No<br /><?=$invoice_details[0]['challen_no']?></td>
                <td>Purchase Order No<br /><b><?=$invoice_details[0]['po_no']?></b></td>
              </tr>
              <tr>
                <td>Work Order No<br /><?=$invoice_details[0]['work_order_no']?></td>
                <td>Mode / Terms of payment<br /><?=$invoice_details[0]['terms_of_payment']?></td>
              </tr>
              <tr>
                <td  style="line-height: 20px;font-size: 15px;" rowspan="2">
                 <b>Delivery Address:</b><br />
                <?=$package_details[0]['name']?><br />
                 <?=$package_details[0]['store_name']?>,<br />
                  <?=$package_details[0]['address1']?>,<?=$package_details[0]['address1']?>,<br />
                  <?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                   <b>PIN:</b>&nbsp;<?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
                   <b>Tin / Vat No:</b><?=$package_details[0]['tin']?><br />
                </td>
                <td>No of Cartons<br /><b><?=$package_details[0]['no_corton']?></b></td>
                <td>LR No/Docket No<br /><?=$invoice_details[0]['docket_no']?></td>
              </tr>
              <tr>
                <td colspan="2">Despatch Throught<br /><?=$invoice_details[0]['despatch_throught']?></td>
                </tr>
            </table>

                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Particulars</th>
                            <th>Color</th>
                            <th>Total Qty</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						$full_total=$full_qty=0;
						$this->load->model('package/package_model');
						 $this->load->model('sales_order/sales_order_model');$i=1;
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
                                    	<td><?=$i?></td>
                            			<td><?=$val['style_name'];?></td>            
                                        <td>
                                            <?=$val1['colour']?>
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
                         
                                        <td  class='right_td'><?=$total?></td>
                                        <td  class='right_td'><?=number_format($c_mrp[0]['p_c_mrp'], 2, '.', ',');?></td>
                                        <td  class='right_td'>
										<?php 
											$single=$total*$c_mrp[0]['p_c_mrp'];
											echo number_format(round($single,2), 2, '.', ',');
											$full_total=$full_total+$single;
										?>
                                        </td>
                                    </tr>
                                    <?php
									$i++;
                                }
                            }
							?>
                            
                            <tr>
                            	<td  style='text-align:right;font-weight:bold;' colspan='3'>Total Qty</td>
                                <td style='text-align:right;font-weight:bold;'><?=$full_qty?></td>
                            	<input type='hidden' name='invoice[total_qty]' value=<?=$full_qty?> />
                                <td  class='right_td'>Sub Total</td><td class='right_td'><?=number_format(round($full_total,2), 2, '.', ',')?></td>		                            </tr>
                               <?php 
							
								$st=0;$cst=0;$vat=0;
								if($package_details[0]['st']!='' && $package_details[0]['st']!='0')
								{
							?> 
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">ST ( <?=($package_details[0]['st']=='0.00')?0:$package_details[0]['st']?>  %)</td>
                                <td class='right_td'>
                                	<?php 
										$st=$full_total*($package_details[0]['st']/100);
										echo number_format(round($st,2), 2, '.', ','); 
									?>
                                </td>
                            </tr>
                            <?php 
								}if($package_details[0]['cst']!='' && $package_details[0]['cst']!='0')
								{
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">CST ( <?=($package_details[0]['cst']=='0.00')?0:$package_details[0]['cst']?>  %)</td>
                                <td class='right_td'>
                                	<?php 
										$cst=$full_total*($package_details[0]['cst']/100);
										echo number_format(round($cst,2), 2, '.', ','); 
									?>
                                </td>
                            </tr>
                             <?php 
								}if($package_details[0]['vat']!='' && $package_details[0]['vat']!='0')
								{
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">VAT ( <?=($package_details[0]['vat']=='0.00')?0:$package_details[0]['vat']?>  %)</td>
                                <td class='right_td'>
                                	<?php 
										$vat=$full_total*($package_details[0]['vat']/100);
										echo number_format(round($vat,2), 2, '.', ','); 
									?>
                                </td>
                            </tr>
                            <?php 
								}
							?>
                            <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">Net Total</td>
                                <td class='right_td' style="font-weight:bold;">
                                	<?php 
										echo  number_format(round($full_total+$st+$cst+$vat,2), 2, '.', ','); 
									?>
                                    <input type="hidden" name='invoice[total_value]' value="<?=number_format(round($full_total+$st+$cst+$vat,2), 2, '.', ',')?>" />
                                </td>
                            </tr>
                             <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">Grand Total</td>
                                <td class='right_td' style="font-weight:bold;">
                                	<?php 
										echo  round($full_total+$st+$cst+$vat); 
									?>
                                
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" >
                                    <span style="float:left;margin-top:6px;">Rupees in Words&nbsp;
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
									
										  echo '<b>'. $result . "rupees  " . $points . " paise".'</b>';
										
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
                <div class="action-btn-align">
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                   <button class="btn btn-default1"  id='send_mail'><span class="glyphicon glyphicon-send"></span> Send Email</button>
                    </div>
                <br />
             <script>
				$('.print_btn').click(function(){
					window.print();
				});
			  </script>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
		<style type="text/css">
      	.right_td
		{
			text-align:right;
		}
      </style>
 		<script type="text/javascript">
			 $(document).ready(function(){
				$('#send_mail').click(function(){
					var s_html=$('.size_html');
					for_loading(); 	
						$.ajax({
							  url:BASE_URL+"invoice/send_email",
							  type:'GET',
							  data:{
								  inv_id:<?=$invoice_details[0]['id']?>
								   },
							  success:function(result){
								   for_response(); 
							  }    
						});
				});	
			 });
		 </script>