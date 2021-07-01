
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
                        <h4>View Sales Order</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <div class="contentpanel">
            <form method="post">
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
               
               <tr>
               		<td class="first_td1">State</td>
                    <td>
                    <?php
                    	//echo "<pre>";
						//print_r($gen_info);
					?>
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
                    <td class="first_td1">Customer</td>
                    <td id='customer_td'>
                    	<?=$gen_info[0]['store_name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
              
               </tr>
               <tr>
               		<td class="first_td1">Sales Order No</td>
                    <td><!--<input type="text" name="inv_no"  />--><b><?=$gen_info[0]['grn_no']?></b></td>
                    <td class="first_td1">Date</td>
                    <td>
                    	<?=date('d-M-Y',strtotime($gen_info[0]['inv_date']))?>
                    	 <!-- <div class="input-group">
                            <input type="text" class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="datepicker">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>-->
                    </td>
               </tr>
               <tr>
               		<td class="first_td1" colspan="1">Tin / Vat No</td>
                    <td  colspan="3"><b><?=$gen_info[0]['inv_no']?></b></td>
                 
               </tr>
               </table>
               <br />
              <?php $this->load->model('sales_order_model');?>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td class="hide_class">
                        	<input type="checkbox" class='check_all' />
                        </td>
                    	<td width="5%" class="first_td1">Style</td>
                    	<td width="11%" class="first_td1">Lot No</td>
                        <td width="5%" class="first_td1">Color</td>
                        <td class="first_td1">Size</td>
                        <td  width="5%" class="first_td1">Qty</td>
                        <td  width="5%" class="first_td1">MRP</td>
                        <td width="5%" class="first_td1 hide_warehouse">Selling<br /> (<?=$gen_info[0]['sp']?>%)</td>
                        <td  width="5%" class="first_td1 hide_warehouse">Order Value</td>
                        <?php if($gen_info[0]['st']!=0){?>
                        <td  width="5%" class="first_td1 hide_warehouse">ST <br />(<?=$gen_info[0]['st']?>%)</td>
                        <?php }if($gen_info[0]['cst']!=0){?>
                        <td  width="5%" class="first_td1 hide_warehouse">CST <br />(<?=$gen_info[0]['cst']?>%)</td>
                        <?php }if($gen_info[0]['vat']!=0){?>
                        <td  width="5%" class="first_td1 hide_warehouse">VAT <br />(<?=$gen_info[0]['vat']?>%)</td>
                        <?php }?>
                        <td  width="5%" class="first_td1 hide_warehouse">Net Value</td>
                      
                    </tr>
                    <tbody id='app_table'>
                    <form method="post">
                    <?php 
					$net_o_val=0;
					$net_final_val=0;
					//echo "<pre>";
					//print_r($gen_info[0]['style_size']);
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
					?>
                    	<tr>
                        	<td  class="hide_class">
                        		<input type="checkbox" name="lot_no[]" value="<?=$info['lot_no']?>" class='check_single' />
                        	</td>
                        	<td>
                            <?=$info['style_name']?>
                            </td>
                      		<td>
                            <?=(strlen($info['lot_no'])>5)?$info['lot_no']:'-';?>
                            </td>
                            <td>
                            	<?=$info['colour']?>
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
                                                    <div  style="border: 1px solid rgb(181, 181, 181);text-align: center;float: left;width: 47px;" >
                                                    	<p  style="margin: 0 0 0px; border-bottom: 1px solid rgb(181, 181, 181);"  ><?=$val['size']?></p>
                                                        <p   style="margin: 0 0 0px;">
                                                        	<?=$val['qty']?>
                                                        </p>
                                                         <p   style="margin: 0 0 0px;"  class="hide_class">
                                                        	<input type="text" name="lot[<?=$info['lot_no']?>][<?=$val['size_id']?>]" value="<?=$val['qty']?>" style="width:46px;" class="<?=$info['lot_no']?>" />
                                                        </p>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                            
                            </td>
                            <td  class="right_td">
                            	<?=$full_total;?>
                            </td>
                          
                             <td class="mrp_html right_td">
                            <?php 
							
							//$c_mrp=$this->sales_order_model->get_customer_mrp($gen_info[0]['customer'],$info['style_id']);
							//echo $gen_info[0]['id'];
							$c_mrp=$this->sales_order_model->get_sales_details1($gen_info[0]['id'],$info['style_id']);
							//print_r($c_mrp);
							//exit;
							$info['mrp']=$c_mrp[0]['c_mrp'];
							echo $info['mrp'];
							?>
                             </td>
                             <?php 
							 	$o_val=$full_total*($info['mrp']-round($info['mrp']*(($gen_info[0]['sp'])/100),2));
								$net_o_val=$net_o_val+$o_val;
								$st_val=($o_val*($gen_info[0]['st']/100));
								$cst_val=($o_val*($gen_info[0]['cst']/100));
								$vat_val=($o_val*($gen_info[0]['vat']/100));
								$final_total=$o_val+$st_val+$cst_val+$vat_val;
								$net_final_val=$net_final_val+$final_total;
							 ?>
                            <td class="right_td hide_warehouse"><?= number_format($info['mrp']-round($info['mrp']*(($gen_info[0]['sp'])/100),2), 2, '.', ',')?></td>
                            <td class="right_td hide_warehouse"><?= number_format(round($o_val,2), 2, '.', ',');?></td>
                            <?php if($gen_info[0]['st']!=0){?>
                            <td class="right_td hide_warehouse"><?= number_format(round($st_val,2), 2, '.', ',');?></td>
                            <?php }if($gen_info[0]['cst']!=0){?>
                            <td class="right_td hide_warehouse"><?= number_format(round($cst_val,2), 2, '.', ',');?></td>
                            <?php }if($gen_info[0]['vat']!=0){?>
                            <td class="right_td hide_warehouse"><?= number_format(round($vat_val,2), 2, '.', ',');?></td>
                            <?php }?>
                            <td class="right_td hide_warehouse"><?= number_format(round($final_total,2), 2, '.', ',');?></td>
                            
                         
                        </tr>
                        <?php 
							}
						}
						?>
                        
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<td  class="hide_class"></td>
                            <td colspan="4" style="width:70px; text-align:right;"><strong>Total</strong></td>
                            <td class="right_td"><strong><?=$gen_info[0]['full_total'];?></strong></td>
                            <td class="hide_warehouse"></td> <td class="hide_warehouse"></td>
                            <td class="right_td hide_warehouse"><strong><?= number_format(round($net_o_val,2), 2, '.', ',');?></strong></td>
    						<?php if($gen_info[0]['st']!=0){?>                       
                            <td class="hide_warehouse"></td>
                            <?php }if($gen_info[0]['cst']!=0){?>
                            <td class="hide_warehouse"></td>
                            <?php }if($gen_info[0]['vat']!=0){?>
                            <td class="hide_warehouse"></td>
                            <?php }?>
                            <td class="right_td hide_warehouse"><strong><?= number_format(round($net_final_val,2), 2, '.', ',');?></strong></td>
                           
                        </tr>
                    </tfoot>
                </table>
                <div class="action-btn-align">
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                  <button class="btn btn-default1 print_warehouse"  id='send_mail'><span class="glyphicon glyphicon-print"></span> Print Warehouse Copy</button>
                 <button class="btn btn-defaultexport7"  id='send_mail'><span class="glyphicon glyphicon-barcode"></span> View Barcode</button>
                 
               </div>
           
           </form>
             <script>
      	$('.print_btn').click(function(){
			window.print();
		});
		$('.print_warehouse').click(function(){
			$('.hide_warehouse').hide();
			window.print();
			$('.hide_warehouse').show();
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
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
      <style type="text/css">
      	.right_td
		{
			text-align:right;
		}
      </style>