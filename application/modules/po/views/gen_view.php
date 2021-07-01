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
                        <h4>View PO</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <div class="contentpanel">
          
           <table style="width:100%;margin:0 auto;"  class="">
           		<tr>
                	<td><span  style="font-weight: 700;"> <h4><?=$gen_info[0]['name']?></h4></span></td>
                    <td></td>
                    <td></td>
                    <td><b><?=$gen_info[0]['grn_no']?></b></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['store_name']?></td>
                    <td></td>
                    <td></td>
                    <td><b></b></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['address1']?>,<?=$gen_info[0]['address2']?>,<?=$gen_info[0]['city']?></td>
                    <td></td>
                    <td></td>
                    <td><?=date('d-M-Y',strtotime($gen_info[0]['inv_date']))?></td>
                </tr>
                <tr>
                	<td><?=$gen_info[0]['city']?>,<?=$gen_info[0]['state']?>-<?=$gen_info[0]['pincode']?></td>
                    <td></td>
                    <td></td>
                  
                </tr>
                 <tr>
                	<td><b>Tin / Vat No</b>:<?=$gen_info[0]['tin']?></td>
                    <td></td>
                    <td></td>
                </tr>
           </table>
           <br/>
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
<table style="width:50%;margin:0 auto; display:none;" class="table table-striped responsive dataTable no-footer dtr-inline">
       <tr>
               		<td>State</td>
                    <td>
                    	<?=$gen_info[0]['state']?>
                    	<!--<select id='state' name="state" style="width: 170px;">
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
                        </select>-->
                    </td>
                    <td>Supplier</td>
                    <td id='customer_td'>
                    	<?=$gen_info[0]['name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
              
               </tr>
               <tr>
               		<td>PO NO</td>
                    <td><!--<input type="text" name="inv_no"  />--><?=$gen_info[0]['grn_no']?></td>
                    <td>Date</td>
                    <td>
                    	<?=$gen_info[0]['inv_date']?>
                    	 <!-- <div class="input-group">
                            <input type="text" class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="datepicker">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>-->
                    </td>
               </tr>
               <tr>
               	<td colspan="2" style="text-align:right;margin-top:10px;vertical-align: middle;">LOT NO</td>
				<td colspan="2"><b><?=$gen_info[0]['lot_no']?></b></td>
              
               </tr>
               </table>
                <form action="<?php echo $this->config->item('base_url').'po/get_baroode'?>" method="post">
                 <input type="hidden" name="desc" value="<?=$gen_info[0]['style_size'][0]['style_desc']?>" style="width:46px;" />          
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr style="font-weight:bold;">
                    	<td class="hide_class">
                        	<input type="checkbox" class='check_all' />
                        </td>
                    	<td width="10%" class="first_td1">Style Code</td>
                        <td width="8%" class="first_td1">Color</td>
                        <td width="14%" class="first_td1">Lot No</td>
                        <td class="first_td1">Size / QTY</td>
                        <td  width="5%" class="first_td1">QTY</td>
                        <td  width="5%" class="first_td1">Landed&nbsp;Cost</td>
                        <td  width="10%" class="first_td1">Net&nbsp;Value</td>
                    </tr>
                    <tbody id='app_table'>
                    <?php 
					//echo '<pre>';
					//print_r($gen_info[0]['style_size'][0]['style_desc']);
					$net_val=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
					?>
                    	<tr>
                        	<td  class="hide_class">
                        		<input type="checkbox"  value="<?=$info['lot_no']?>" class='check_single' />
                        	</td>
                        	<td>
                            	<?=$info['style_name']?>
                            </td>
                          
                            <td>
                            	<?=$info['colour'];?>
                            </td>
                            <td>
                            	<?=$info['lot_no'];?>
                            </td>
                            <td class="size_html">
                           		 <?php 
								 	$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												$full_total=$full_total+$val['qty'];
                                                ?>
                                                    <div style="border: 1px solid rgb(181, 181, 181);text-align: center;float: left;width: 62px;">
                                                    	<p style="margin: 0 0 0px;"  ><?=$val['size_id']?></p>
                                                        <p style="margin: 0 0 0px;border-top: 1px solid rgb(181, 181, 181);">
                                                        	<?=$val['qty']?>
                                                        </p>
                                                        <p style="margin: 0 0 0px;border-top: 1px solid rgb(181, 181, 181);">
                                                        	<input type="text" name="lot[<?=$info['style_name']?>][<?=$info['colour']?>][<?=$info['lot_no']?>][<?=$val['size_id']?>]" value="<?=$val['qty']?>"  style="width:46px;" class="<?=$info['lot_no']?> hide_class" />
                                                            <input type="hidden" name="landed[<?=$info['style_name']?>][<?=$info['colour']?>][<?=$info['lot_no']?>][<?=$val['size_id']?>]" value="<?=$info['landed'];?>" style="width:46px;" />
                                                        </p>
                                                    </div>
                                                <?php
                                            }
                                        }
										
										$net_val=$net_val+($full_total*$info['landed']);
                                    ?>
                            
                            </td>
                            <td>
                            	<?=$full_total;?>
                            </td>
                            <td  class="text_right"><?=$info['landed']?></td>
                             <td  class="text_right"><?=number_format($full_total*$info['landed'], 2, '.', ',')?></td>
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="5" style="width:70px; text-align:right;">Total</td>
                            <td><?=$gen_info[0]['full_total'];?></td>
                          	<td></td>
                            <td class="text_right"><?=number_format($net_val, 2, '.', ',')?></td>
                        </tr>
                        <?php
						$st=$net_val*($gen_info[0]['st']/100);
						$cst=$net_val*($gen_info[0]['cst']/100);
						$vat=$net_val*($gen_info[0]['vat']/100);	
						if($st!=0)
						{
                        ?>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;"></td>
                            <td colspan="2" style="text-align:right;font-weight:bold;">ST ( <span class="st"><?=($gen_info[0]['st']=='0.00'?0:$gen_info[0]['st'])?></span> % )</td>
                            <td class="text_right"><?=number_format($st, 2, '.', ',')?></td>
                           
                        </tr>
                         <?php 
						}
						if($cst!=0)
						{
						?>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;"></td>
                            <td colspan="2" style="text-align:right;font-weight:bold;">CST ( <span class="cst"><?=($gen_info[0]['cst']=='0.00'?0:$gen_info[0]['cst'])?></span> % )</td>
                            <td class="text_right"><?=number_format($cst, 2, '.', ',')?></td>
                         
                        </tr>
                        <?php 
						}
						if($vat!=0)
						{
						?>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;"></td>
                            <td colspan="2"style="text-align:right;font-weight:bold;">VAT ( <span class="vat"><?=($gen_info[0]['vat']=='0.00'?0:$gen_info[0]['vat'])?></span> % )</td>
                            <td  class="text_right"><?=number_format($vat, 2, '.', ',')?></td>
                           
                        </tr>
                        <?php }?>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;">
                       
                            </td>
                            <td colspan="2"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td  class="text_right"><?=number_format($gen_info[0]['net_total'], 2, '.', ',');?></td>
                       
                        </tr>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;">
                           <b> Rupees in Words:</b>
                             <?php
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
							?>
                            
                            
                            </td>
                            <td colspan="2"style="text-align:right;font-weight:bold;">Grand Total</td>
                            <td  class="text_right"><?=round($gen_info[0]['net_total']);?></td>
                       
                        </tr>
                    </tfoot>
                </table>
                
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
                <br />
                <table style="width:100%;border:1 solid #CCC;">
                	<tr>
                    	<td  style="width:49%;">
                        	<table style="width:100%;">
                            	
                                <tr>
                                	<td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                                    
                                </tr>
                                <tr>
                                	<td width="5%">1.</td>
                                    <td  width="40%">Delivery Schedule</td>
                                    <td  width="5%">:</td>
                                    <td width="49%"><b><?=$gen_info[0]['delivery_schedule'];?></b></td>
                                </tr>
                                <tr>
                                	<td>2.</td>
                                    <td>Delivery at</td>
                                    <td>:</td>
                                    <td><b><?=$gen_info[0]['delivery_at'];?></b></td>
                                </tr>
                                <tr>
                                	<td>3.</td>
                                    <td>Mode of Payment</td>
                                    <td>:</td>
                                    <td><b><?=$gen_info[0]['mode_of_payment'];?></b></td>
                                </tr>
                                
                            </table>
                        </td>
                        <td style="width:49%;">
                        	<table style="width:100%;">
                            	<tr>
                                	<td style="text-align: center;">Thanking you ,</td>
                                    <td style="text-align: center;">For <b style="font-size:15px;"><?=strtoupper($company_details[0]['company_name'])?></b></td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td style="text-align: center;"></td>
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
                <br />
                 <div class="action-btn-align">
                 <button class="btn btn-defaultexport7"  id='send_mail'><span class="glyphicon glyphicon-barcode"></span> View Barcode</button>
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                   <button class="btn btn-default1"  id='send_mail'><span class="glyphicon glyphicon-send"></span> Send Email</button>
                    
                    </div>
               
                </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		 // Date Picker
		 $(document).ready(function(){
			$('#send_mail').click(function(){
				var s_html=$('.size_html');
				for_loading(); 	
					$.ajax({
						  url:BASE_URL+"po/send_email",
						  type:'GET',
						  data:{
							  po_id:<?=$gen_info[0]['id']?>
							   },
						  success:function(result){
							   for_response(); 
						  }    
					});
			});	
		 });
		 $('.check_all').click(function(){
			if($(this).attr('checked')=='checked')
			{
				$('.check_single').attr('checked','checked');
			}
			else
			{
				$('.check_single').removeAttr('checked');
			}
		});
		 </script>
      <script>
      	$('.print_btn').click(function(){
			window.print();
		});
      </script>