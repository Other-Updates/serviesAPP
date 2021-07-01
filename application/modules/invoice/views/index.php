<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
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
                        <h4>Create Invoice</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
           
            <form method="post">          
            <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
              <tr>
                <td width="50%" style="line-height: 20px;" rowspan="3">
                <b>Billing Address:</b><br />
               
                <input type="hidden" value="<?=$package_details[0]['customer']?>" name="c_ids" />
                 <?=$package_details[0]['name']?><br />
                 <?=$package_details[0]['store_name']?>,<br />
                  <?=$package_details[0]['address1']?>,<?=$package_details[0]['address2']?>,<br />
                  <?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                  <b>PIN:</b>&nbsp;<?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
                </td>
                
                <input type="hidden" name="invoice[package_id]" value="<?=$package_details[0]['id']?>" />
                <td width="25%">Invoice No<br /><input type="text" name="invoice[inv_no]" value="<?=$last_no?>" readonly="readonly" class="code form-control colournamedup" /></td>
                <td width="25%">Invoice Date <span  style="margin-left: 50px;" >Due Date</span><br />
                	<div class="input-group" >
                        <input type="text"  readonly="readonly" style="width:100px;float:left;" value=""  id='today' class="form-control datepicker"  name="invoice[inv_date]" placeholder="dd-mm-yyyy" >
                    	
                        <input type="text"  id='due_date' readonly="readonly" style="width:100px;float:left;margin-left: 22px;"  class="form-control datepicker"  name="invoice[due_date]" placeholder="dd-mm-yyyy" >
                  
                    </div>
                </td>
              </tr>
              <tr>
                <td>Delivery Challan No<br /><input type="text"  name="invoice[challen_no]" readonly="readonly" value="DC<?=substr($last_no,3)?>" id="in_challenno" class="form-control" /><span id="invoive_error" style="color:#F00;s"></span></td>
                <td>
                PO NO<br /><input type="text" id='po_no'  name="invoice[po_no]"  class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Work Order No / Sales Order No<br /><input type="text"  name="invoice[work_order_no]" id="in_wrkorder" class="form-control" /><span id="invoive_error2" style="color:#F00;s"></span></td>
                <td>Mode / Terms of payment<br /><input type="text"   name="invoice[terms_of_payment]" value="<?=$package_details[0]['payment_terms']?>" readonly="readonly" id="in_tofpay" class="form-control" /><span id="invoive_error3" style="color:#F00;s"></span></td>
              </tr>
              <tr>
                <td  style="line-height: 20px;" rowspan="2">
                 <b>Delivery Address:</b><br />
                <?=$package_details[0]['name']?><br />
                 <?=$package_details[0]['store_name']?>,<br />
                  <?=$package_details[0]['address1']?>,<?=$package_details[0]['address2']?>,<br />
                  <?=$package_details[0]['city']?>,<?=$package_details[0]['state']?>,<br />
                   <b>PIN:</b>&nbsp;<?=$package_details[0]['pincode']?>, <b>PH NO:</b><?=$package_details[0]['mobil_number']?>,<br />
                </td>
                <td>No of Cartons<br /><b><?=$package_details[0]['no_corton']?></b></td>
                <td>Despatch Throught<br /><input type="text" readonly="readonly" value="<?=$package_details[0]['llr_no']?>"  name="invoice[despatch_throught]" id="in_despatch" class="form-control" /><span id="invoive_error1" style="color:#F00;s"></span>LR No / Docket No<br /><input type="text"  value="<?=$package_details[0]['lr_no']?>" readonly="readonly" name="invoice[docket_no]" id="in_docketno" class="form-control" /><span id="invoive_error4" style="color:#F00;s"></span></td>
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
					//echo "<pre>";
					
					//print_r($package_info);
                    $i=1;
						$full_total=$full_qty=0;
						$this->load->model('sales_order/sales_order_model');
						$this->load->model('package/package_model');
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
											$mm=0;
                                                foreach($val1['size'] as $val2)
                                                {
                                                    $total=$total+$val2['total_qty'];
                                                  	$mm=$val2['c_mrp']; 
                                                }
                                                $full_qty=$full_qty+$total;
                                            ?>
                                               <td>
                         				<?php 
										$c_mrp=0;
										//echo "<pre>";
										foreach($val['sales_order'] as $ss)
										{
											$where=array('style_id'=>$val['style_id'],'color_id'=>$val1['color_id'],'sales_order'=>$ss);
											//print_r($where);
											$xx=$this->sales_order_model->get_customer_mrp2($where);
											//print_r($xx);
											if(!empty($xx[0]['c_mrp']))
											$c_mrp=$xx[0]['c_mrp'];
											//echo $c_mrp;
										}
										
										//echo $c_mrp;
										
										
										//$c_mrp=$this->sales_order_model->get_customer_mrp($package_details[0]['customer'],$val['style_id']);
										//echo "<pre>";
									//	print_r($c_mrp);
										$val['mrp']=$c_mrp-round($c_mrp*(($package_details[0]['selling_percent'])/100),2);
										//print_r($val['mrp']);
										
										?>
                                        
                                     <?=$total?>
                                        <input type="hidden" name="mrp_rate[<?=$package_details[0]['id']?>][<?=$val['style_id']?>]" value="<?=$c_mrp-round($c_mrp*(($package_details[0]['selling_percent'])/100),2);?>" />
                                        </td>
                                        <td  class='right_td'><?=$c_mrp-round($c_mrp*(($package_details[0]['selling_percent'])/100),2);?></td>
                                        <td  class='right_td'>
										<?php 
											//$single=$total*$val['mrp']; 
											$single=$total*($c_mrp-round($c_mrp*(($package_details[0]['selling_percent'])/100),2));
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
                                <input type='hidden' name='invoice[org_value]' value=<?=round($full_total,2)?> />
                                <td  class='right_td'>Sub Total</td><td class='right_td'><?=number_format(round($full_total,2), 2, '.', ',')?>
                            	    
                                </td>
                            </tr>
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
                                    <input type="hidden" name='invoice[total_value]' value="<?=round($full_total+$st+$cst+$vat,2)?>" />
                                </td>
                            </tr>
                             <tr>
                            	<td style="text-align:right;font-weight:bold;" colspan="5">Grand Total</td>
                                <td class='right_td' style="font-weight:bold;">
                                	<?php 
										echo round($full_total+$st+$cst+$vat); 
									?>
                                
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" >
                                    <span style="float:left;margin-top:6px;">Value in Words&nbsp;
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
												  
										
										if(!empty($points))
										  echo '<b>'. $result . "rupees  " . $points . " paise".'</b>';
										else
											 echo '<b>'. $result . "rupees  ".'</b>';
									?>
									</span>
                                </td>
                       		</tr>  
                             <tr>
                                <td colspan="6" style="">
                                    <span style="float:left;margin-top:6px;">Remarks&nbsp;</span> <input style="float:left;width:90%;" type="text" class="form-control" name="invoice[remarks]" />
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
                 <input type="submit" class="btn btn-default" id="submit" style="float:right;" value="Create" /><br />
              </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
      <script type="text/javascript">
		 // Date Picker
		 
		 $(document).ready(function(){
			var today = new Date();
			   var dd = today.getDate();
			   var mm = today.getMonth()+1; //January is 0!
			  
			   var yyyy = today.getFullYear();
			   if(dd<10){
				dd='0'+dd
			   } 
			   if(mm<10){
				mm='0'+mm
			   } 
			   var today = dd+'-'+mm+'-'+yyyy;
			   var today1 = mm+'/'+dd+'/'+yyyy;
			   $('#today').val(today);
			   
			   var someDate = new Date(today1);
				var numberOfDaysToAdd = Number($('#in_tofpay').val());
				console.log(someDate.setDate(someDate.getDate() + numberOfDaysToAdd)); 
				var dd = someDate.getDate();
				var mm = someDate.getMonth() + 1;
				var y = someDate.getFullYear();
				
				var someFormattedDate = dd + '-'+ mm + '-'+ y;
				console.log(someFormattedDate); 
			   $('#due_date').val(someFormattedDate);
	       		 jQuery('#from_date1').datepicker(); 
		 });
		 
		 
		 
		
		</script>
		<style type="text/css">
      	.right_td
		{
			text-align:right;
		}
      </style>
      
      <script type="text/javascript">
	    $("#in_challenno").live('blur',function()
		{
		var inchallen=$("#in_challenno").val();
		if(inchallen=="" || inchallen==null || inchallen.trim().length==0)
		{
			$("#invoive_error").html("Required Field");
		}
		else
		{
			$("#invoive_error").html("");
		}
		});
		$("#in_despatch").live('blur',function()
		{
		var indespatch=$("#in_despatch").val();
		if(indespatch=="" || indespatch==null || indespatch.trim().length==0)
		{
			$("#invoive_error1").html("Required Field");
		}
		else
		{
			$("#invoive_error1").html("");
		}
		});
		$("#in_wrkorder").live('blur',function()
		{
		var in_wrkorder=$("#in_wrkorder").val();
		if(in_wrkorder=="" || in_wrkorder==null || in_wrkorder.trim().length==0)
		{
			$("#invoive_error2").html("Required Field");
		}
		else
		{
			$("#invoive_error2").html("");
		}
		});
		$("#in_tofpay").live('blur',function()
		{
		var in_tofpay=$("#in_tofpay").val();
		if(in_tofpay=="" || in_tofpay==null || in_tofpay.trim().length==0)
		{
			$("#invoive_error3").html("Required Field");
		}
		else
		{
			$("#invoive_error3").html("");
		}
		});
		 $("#in_docketno").live('blur',function()
		{
		var in_docketno=$("#in_docketno").val();
		if(in_docketno=="" || in_docketno==null || in_docketno.trim().length==0)
		{
			$("#invoive_error4").html("Required Field");
		}
		else
		{
			$("#invoive_error4").html("");
		}
		});
		
		
		$('#submit').live('click',function()
		{
			var i=0;
			var inchallen=$("#in_challenno").val();
			if(inchallen=="" || inchallen==null || inchallen.trim().length==0)
			{
				$("#invoive_error").html("Required Field");
				i=1;
			}
			else
			{
				$("#invoive_error").html("");
			}
			var indespatch=$("#in_despatch").val();
			if(indespatch=="" || indespatch==null || indespatch.trim().length==0)
			{
				$("#invoive_error1").html("Required Field");
				i=1;
			}
			else
			{
				$("#invoive_error1").html("");
			}
			var in_wrkorder=$("#in_wrkorder").val();
			if(in_wrkorder=="" || in_wrkorder==null || in_wrkorder.trim().length==0)
			{
				$("#invoive_error2").html("Required Field");
				i=1;
			}
			else
			{
				$("#invoive_error2").html("");
			}
			var in_tofpay=$("#in_tofpay").val();
			if(in_tofpay=="" || in_tofpay==null || in_tofpay.trim().length==0)
			{
				$("#invoive_error3").html("Required Field");
				i=1;
			}
			else
			{
				$("#invoive_error3").html("");
			}
			var in_docketno=$("#in_docketno").val();
			if(in_docketno=="" || in_docketno==null || in_docketno.trim().length==0)
			{
				$("#invoive_error4").html("Required Field");
				i=1;
			}
			else
			{
				$("#invoive_error4").html("");
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
		$().ready(function() {
				$("#po_no").autocomplete(BASE_URL+"gen/get_po_list_inv", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
	  </script>