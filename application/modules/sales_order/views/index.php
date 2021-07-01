<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

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
                        <h4>Add Sales Order</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <?php
			
			 	$tc=0;
            	if(isset($files) && !empty($files))
				{
					///echo "<pre>";
					$this->load->model('customer/customer_model');
					$c_data=$this->customer_model->get_customer1($c_id);
				
					$this->load->model('customer/customer_model');
					$all_customer=$this->customer_model->get_customer();
					
					$excel = new PhpExcelReader;
					$excel->read('so_excel_files/'.$files);
				
				}
			
			?>
            <div class="contentpanel">
            <form method="post">
            <table style="width:60%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            	
               <tr>
               		<td width="15%">State</td>
                    <td>
                    <?php
					if(isset($c_data) && !empty($c_data))
					{
						?>
                    	<select id='state' class="class_req" name="state" style="width: 170px;">
                        	<option>Select</option>
                            <?php 
								if(isset($all_state) && !empty($all_state))
								{
									foreach($all_state as $val)
									{
										?>
                                        	<option <?=($c_data[0]['m_s_id']==$val['id'])?'selected':''?> value='<?=$val['id']?>'><?=$val['state']?></option>
                                        <?php
									}
								}
							?>
                        </select>
                   		<?php
					}else
					{
						?>
                        <select id='state' class="class_req" name="state" style="width: 170px;">
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
                        </select>
                        <?php
					}
					?>    
                    </td>
                    <td>Customer</td>
                    <td id='customer_td'>
                    <?php
					if(isset($c_data) && !empty($c_data))
					{
					?>
                    	<select id='customer' name="customer" class="customer form-control class_req" style="width: 170px;">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_customer) && !empty($all_customer))
                                        {
                                            foreach($all_customer as $val)
                                            {
                                                ?>
                                                    <option  <?=($c_data[0]['id']==$val['id'])?'selected':''?>	 value='<?=$val['id']?>'><?=$val['store_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                        </select>	
                    <?php
					}else
					{
					?>
                    	<select  name="customer" class="customer" style="width: 170px;">
                        	<option>Select</option>
                        </select>
                    <?php
					}
					?>        
                    </td>
              
               </tr>
               <tr>
               		<td>Sales Order No</td>
                    <td>
                    	<input type="text" tabindex="-1" name="grn_no" style="width:170px;" class="code form-control colournamedup" readonly="readonly" value="<?=$last_no?>" id="grn_no">
                   
                    
                    </td>
                    <td style="display:none;">
                    	Tin / Vat No
                    </td>
                    
                    <td>
                     <?php
					if(isset($c_data) && !empty($c_data))
					{
					?>
                     <input type="text" readonly="readonly" id='tin' value="<?=$c_data[0]['tin']?>" class="form-control" style="width: 170px;display:none;" name="inv_no"   />
                     <?php }else
					 {?>
                     <input type="text" readonly="readonly" id='tin' class="form-control" style="width: 170px;display:none;" name="inv_no"   />
                     <?php }?>
                     <input type="hidden"  class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="sy_date">
                            
                    </td>
               </tr>
               </table>
               <br />
               <table style="display:none;">
                <tr id="last_row">
                    <td>
                            	<select  class='style_id'  name="style_code[]">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_style) && !empty($all_style))
                                        {
                                            foreach($all_style as $val)
                                            {
                                                ?>
                                                    <option value='<?=$val['id']?>'><?=$val['style_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            
                           <td class="color_div">
                            	<select  name="color[]"  class="color_class">
                                    <option>Select</option>
                                   
                                </select>
                                <input type="hidden" name="landed[]" />
                            </td>
                            <td class='lot_div'> </td>
                            <td  class="size_html"></td>
                            <td>
                            	<input type="text" tabindex="-1" readonly="readonly"  name="qty_total[]" style="width:45px;" class="total_qty" />
                            </td>
                          <td class="mrp_html"></td>
                          <td><input type="text" tabindex="-1" readonly="readonly"    class="sp_val" style="width:50px;"  /></td>
                           <td><input type="text"  tabindex="-1" readonly="readonly"  class="total_value" style="width:50px;" /></td>
                           
                            <td class="tr_st_val" style="display:none;"><input type="text" tabindex="-1"  name="st_total[]" class="st_val" style="width:50px;" /></td>
                            <td  class="tr_cst_val"><input type="text"  readonly="readonly" tabindex="-1"  name="cst_total[]" class="cst_val" style="width:50px;" /></td>
                            <td  class="tr_vat_val"><input type="text" readonly="readonly"  tabindex="-1" name="vat_total[]" class="vat_val" style="width:50px;" /></td>
                            <td><input type="text" tabindex="-1" readonly="readonly"  name="net_total[]" class="net_val" style="width:50px;" /></td>
                            <td>
                            	<input type="button" value="-" class='remove_comments btn btn-danger'/>
                            </td>
                            
                        </tr>
                </table>
                <input type="hidden" name="lot_no[]" />
                <div style="width:100%;overflow-x:auto;">
                <?php
					if(isset($c_data) && !empty($c_data))
					{
						echo "";
					}
					else
					{
				?>
                <div>
                <?php }?>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
                	<tr>
                    	<td  style="width:70px;">Style</td>
                        <td style="width:60px;">Color</td>
                        <td  style="width:85px;">Lot No</td>
                        <td>Size</td>
                        <td  style="width:45px;">Qty</td>
                        <td style="width:54px;"  width="">MRP</td>
                        <td  style="width:50px;" width="">SP <br /><span id='sp_div'>
                        	  <?php
								if(isset($c_data) && !empty($c_data))
								{
								//	echo "<pre>";
								//	print_r($c_data);
							  ?>
                        			<input type="text" tabindex="-1" value="<?=$c_data[0]['selling_percent']?>" readonly="readonly" id='sp' name="sp" style="width:50px;"/></span>
                              <?php 
								}else
								{
									?>
                                    <input type="text" tabindex="-1" readonly="readonly" id='sp' name="sp" style="width:50px;"/></span>
                                    <?php
								}
							  ?>      
                        </td>
                        <td   style="width:52px;">Order Value</td>
                      	 <?php
            			if(isset($files) && !empty($files))
						{
							
						?>
                        <input type="hidden" style="width:50px;" name="mrp[]" readonly="readonly" tabindex="-1" value="0" />
                        <input type="hidden" value="<?=$files?>"  id='files_id' name="file_name"/>
                        <td   style="width:59px;display:<?=(empty($c_data[0]['c_st']))?'none':''?>">ST<br /><input type="text" tabindex="-1" readonly="readonly" value="<?=$c_data[0]['c_st']?>" id='st' name="st" style="width:50px;"/></td>
                        <td   style="width:59px;display:<?=(empty($c_data[0]['c_cst']))?'none':''?>">CST<br /><input type="text" tabindex="-1" readonly="readonly"  value="<?=$c_data[0]['c_cst']?>" id='cst' name='cst' style="width:50px;"/></td>
                        <td   style="width:59px;display:<?=(empty($c_data[0]['c_vat']))?'none':''?>">VAT<br /><input type="text" tabindex="-1" readonly="readonly" value="<?=$c_data[0]['c_vat']?>"  id='vat' name='vat' style="width:50px;"/></td>
                        <?php }else{
							?>
                        <td  class="tr_st_val"  style="width:50px;display:none;">ST<br /><input type="text" tabindex="-1" readonly="readonly" id='st' name="st" style="width:50px;"/></td>
                        <td  class="tr_cst_val"  style="width:50px;">CST<br /><input type="text" tabindex="-1" readonly="readonly" id='cst' name='cst' style="width:50px;"/></td>
                        <td  class="tr_vat_val"  style="width:50px;">VAT<br /><input type="text" tabindex="-1" readonly="readonly" id='vat' name='vat' style="width:50px;"/></td>
							<?php
							}?>
                        <td   style="width:51px;">Net Value</td>
                        <td  style="width:15px;">
                        	<?php 
							if(empty($files))
							{
								?>
                                <input type="button"  tabindex="-1" value="+" title="Add row" id='add_group' class="btn btn-primary" style="padding:10px;" />
                               <?php
							}
							?>	
                            </td>
                    </tr>
                    <tbody id='app_table'>
                     <?php
					 $this->load->model('master_state/master_state_model');
					$this->load->model('master_style/master_model');
					$this->load->model('stock/stock_model');
					 $net_qty_vals=$net_final_val=$net_o_val=0;
					 
					
            			if(isset($files) && !empty($files))
						{
							
							
								 $tr='';
								 //echo "<pre>";
								 //print_r($excel->sheets);
								if(isset($excel->sheets[0]['cells']) && !empty($excel->sheets[0]['cells']))
								{
									$i=1;
										
									foreach($excel->sheets[0]['cells'] as $val)
									{
										if($i==1)
										{
											//echo "<pre>";
											//print_r(count($val));
										//	print_r($val);
											$first_row=$val;
										}
										else
										{
											$t_qty=0;
											//echo "<pre>";
											//print_r(count($val));
										    //print_r($first_row);
											//print_r($excel->sheets[0]['cells']);
											$tr=$tr.
											"
											<tr>
												<td>";
													
													if(isset($all_style) && !empty($all_style))
                                                	{
														$fff=0;
														foreach($all_style as $s_val)
														{
															if(strtolower($s_val['style_name'])==strtolower($val[1]))
															{
																$fff=1;
																$tr=$tr."<select class='style_id class_req' name='style_code[]'>"; 
																$sty_id=$s_val['id'];
																$tr=$tr."<option value=".$s_val['id'].">".$s_val['style_name']."</option>"; 
																$tr=$tr."</select>"; 
															}
															
														}
														if($fff==0)
														{
															$tr=$tr.$val[1].' not created in master,Kindly remove this Style in excel file';
															$tc=1;
														}
                                                	}	
												$tr=$tr."		
													
												</td>
												   
													<td class='color_div'>";
															//$this->load->model('po/gen_model');
														    $data['color']=$this->gen_model->get_all_color_details_by_id($sty_id);
															if(isset($data['color']) && !empty($data['color']))
															{
																$ff=0;
																foreach($data['color'] as $c_val)
																{
																	if(strtolower($c_val['colour'])==strtolower($val[2]))
																	{	
																		$ff=1;
																		$select='<select name="color[]"  class="color_class">';
																		$col_id=$c_val['id'];
																	 	$select=$select."<option value=".$c_val['id'].">".$c_val['colour']."</option>";
																		$select=$select.'</select>';
																		$tr=$tr.$select;
																	}
																}
																if($ff==0)
																{
																	$tr=$tr.$val[2].' not created for this Style,Kindly remove this color in excel file';
																	$tc=1;
																}
															}
															
													
													$tr=$tr."
													</td>
													<td class='lot_div'>";
												    $this->load->model('gen/gen_model');
													$ser=array('s_id'=>$sty_id,'c_id'=>$col_id);
													$p_data=$this->gen_model->get_lot_name($ser);
													$select='';
													$rr='';$rr1='';$rr2='';
													if(empty($p_data))
													{
														$rr=rand();
														$rr1='class_req6';$rr2='lot_repeat4';
													}
													else
													{
														$rr1='class_req';$rr2='lot_repeat';
													}
													$select=$select."<select  name='lot_no[]' class='".$rr1." upload_lot_no lotnoclass ".$rr1."' style='width: 50px;'>
													
													<option value='".$rr."'>Select</option>";
													if(isset($p_data) && !empty($p_data))
													{
														foreach($p_data as $val1)
														{		
																$select=$select."<option value='".$val1['lot_no']."'>".$val1['lot_no']."</option>";
														}
													}
													
													$select=$select."</select>";
													if(empty($p_data))
													{
														$select=$select."<span style='color:red;'>LOT not created yet...</span>";
													}
													$tr=$tr.$select;
												   $tr=$tr."</td>
													<td class='size_html' style='min-width:250px;'>";
													if(empty($p_data))
													{
														foreach($val as $f_key=>$f_val)
														{
															if($f_key!=1 && $f_key!=2)
															{
																$check_avail=$this->gen_model->check_available1($first_row[$f_key]);
																$tr=$tr.'<div style="text-align:center;float:left;" >
																		<p  style="margin: 0 0 0px;"  >'.$first_row[$f_key].'</p>
																		<p  style="margin: 0 0 0px;">
																			<input type="text" tabindex="-1"  class="avail_qty" readonly="readonly" value="0"  style="width:44px;background-color: rgb(192, 244, 199);"/></p>
																			<p  style="margin: 0 0 0px;">
																			<input type="text" tabindex="-1" class="cust_sales_qty" readonly="readonly" value="'.$f_val.'"   style="width:44px;background-color:rgb(255, 236, 161);"/></p>
																		<p  style="margin: 0 0 0px;">
																			<input type="text"  readonly="readonly"  id="'.$check_avail[0]['size_id'].'" value="0" class="s_size cust_qty int_val"  style="width:44px;"/></p>
																	   </div>&nbsp;';
																													   
															}
														}
													}
													$land=$this->gen_model->get_land1($sty_id,$col_id);
													$tr=$tr.'<input type="hidden" name="landed[]" value="'.$land[0]['sp'].'">';
													$tr=$tr."</td>
													<td>
														<input type='text' tabindex='-1' readonly='readonly'  name='qty_total[]' style='width:50px;' class='total_qty int_val'  />
													</td>
												   <td class='mrp_html'>";
												   //	$p_data=$this->gen_model->get_all_style_details_by_id($sty_id,$c_id);
													//if(isset($p_data[0]['customer_mrp']) && !empty($p_data[0]['customer_mrp']))
													//$values=$p_data[0]['customer_mrp'];
													//else
													$values=0;
													
													$o_val=$t_qty*round($values*(($c_data[0]['selling_percent'])/100),2);
													$net_o_val=round(($net_o_val+$o_val),2);
													$st_val=round(($o_val*($c_data[0]['st']/100)),2);
													$cst_val=round(($o_val*($c_data[0]['cst']/100)),2);
													$vat_val=round(($o_val*($c_data[0]['vat']/100)),2);
													$final_total=round(($o_val+$st_val+$cst_val+$vat_val),2);
													$net_final_val=round(($net_final_val+$final_total),2);
													$ch_st=$ch_cst=$ch_vat='';
													if(empty($c_data[0]['c_st']))
													$ch_st='none';
													if(empty($c_data[0]['c_cst']))
													$ch_cst='none';
													if(empty($c_data[0]['c_vat']))
													$ch_vat='none';
													
													$tr=$tr."<input type='text' style='width:50px;' name='mrp[]' readonly='readonly' tabindex='-1' value='".$values."' class='total_mrp1' /></td>
												    <td><input type='text'  tabindex='-1'   readonly='readonly'  class='sp_val' style='width:50px;'  /></td>
													<td><input type='text'  tabindex='-1'   readonly='readonly'  class='total_value' style='width:50px;' /></td>
													
													<td style='display:".$ch_st."'><input type='text'  tabindex='-1'   readonly='readonly'  name='st_total[]' class='st_val' style='width:50px;' /></td>
													<td style='display:".$ch_cst."'><input type='text'  tabindex='-1'   readonly='readonly'  name='cst_total[]' class='cst_val' style='width:50px;' /></td>
													<td style='display:".$ch_vat."'><input type='text'  tabindex='-1'   readonly='readonly'  name='vat_total[]' class='vat_val' style='width:50px;' /></td>
													<td><input type='text'  tabindex='-1'   readonly='readonly'  name='net_total[]' class='net_val' style='width:50px;' /></td>
													<td>
														<input type='button'  tabindex='-1' value='+' title='Add row'  class='upload_more_btn btn-primary'>
													</td>
													
											</tr>
											";
										}
										$i++;
									}
										
								}
								else
								{
									echo "File Upload Error.......";
								}	
								  echo $tr;    
							
						}else
						{
							?>
                            	<tr>
                                    <td>
                                        <select class='style_id class_req'  name="style_code[]">
                                            <option>Select</option>
                                            <?php 
                                                if(isset($all_style) && !empty($all_style))
                                                {
                                                    foreach($all_style as $val)
                                                    {
                                                        ?>
                                                            <option value='<?=$val['id']?>'><?=$val['style_name']?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                   
                                    <td class="color_div">
                                        <select  name="color[]"  class="color_class class_req">
                                            <option>Select</option>
                                           
                                        </select>
                                    </td>
                                    <td class='lot_div'> </td>
                                    <td class="size_html" style="min-width:212px"></td>
                                    <td>
                                        <input type="text" tabindex="-1" readonly="readonly"  name="qty_total[]" style="width:45px;" class="total_qty int_val" />
                                    </td>
                                   <td class="mrp_html"></td>
                                   <td><input type="text" tabindex="-1" readonly="readonly"  class="sp_val" style="width:50px;"  /></td>
                                    <td><input type="text"  tabindex="-1" readonly="readonly"                    class="total_value" style="width:50px;" /></td>
                                    
                                    <td  class="tr_st_val" style="display:none;"><input type="text"  tabindex="-1" readonly="readonly"  name="st_total[]" class="st_val" style="width:50px;" /></td>
                                    <td  class="tr_cst_val"><input type="text"  tabindex="-1" readonly="readonly"  name="cst_total[]" class="cst_val" style="width:50px;" /></td>
                                    <td  class="tr_vat_val"><input type="text"  tabindex="-1" readonly="readonly"  name="vat_total[]" class="vat_val" style="width:50px;" /></td>
                                    <td><input type="text"  tabindex="-1" readonly="readonly"  name="net_total[]" class="net_val" style="width:50px;" /></td>
                                    <td>
                                        
                                    </td>
                                    
                                </tr>
                            <?php
						}
					?>
                    		
                    	
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:50px; text-align:right;">Total</td>
                            <td><input type="text" tabindex="-1" value="<?=$net_qty_vals?>" readonly="readonly"  name="full_total[]" class="full_total" style="width:50px;" /></td>
                            <td></td>
                            <td></td>
                            <td><input type="text"  tabindex="-1" value="<?=$net_o_val?>" readonly="readonly"  name="net_value" class="final_total" style="width:50px;" /></td>
                            <?php
								$ch_st1=$ch_cst1=$ch_vat1='';
                            	if(isset($c_data[0]['c_st']) && empty($c_data[0]['c_st']))
								{
									$ch_st1='none';
								}
								if(isset($c_data[0]['c_cst']) && empty($c_data[0]['c_cst']))
								{
									$ch_cst1='none';
								}
								if(isset($c_data[0]['c_vat']) && empty($c_data[0]['c_vat']))
								{
									$ch_vat1='none';
								}
							?>
                            <td   style="width:50px;display:none;"class="tr_st_val"></td>
                            <td   style="width:50px;display:<?=$ch_cst1?>"class="tr_cst_val"></td>
                            <td   style="width:50px;display:<?=$ch_vat1?>"class="tr_vat_val"></td>
                            <td><input type="text" tabindex="-1" value="<?=$net_final_val?>" readonly="readonly" name="net_final_total"  class="net_final_total" style="width:50px;" /></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
               <?php
					if(isset($c_data) && !empty($c_data))
					{
						echo "";
					}
					else
					{
				?>
                </div>
                <?php }?>
                </div>
                <?php  
				if($tc==0)
				{
				?>
                <div class="action-btn-align">
                <input type="submit" class="btn btn-primary btn-rounded" id='add_gen2' value="Create"/>
                </div>
                <?php }?>
                </form>
                
                
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		$('.lot_repeat').live('change',function()
		{
		$('.lot_repeat').each(function(){
						
						var arr=$(this).attr('class').split(' '); 
						//var arr=$(this).val();
						console.log(arr);
						
						
						$('.'+arr[1]).each(function(){
							var my=$(this).val();
							var count=0;
							$('.'+arr[1]).each(function(){
								
								if($(this).val()!='Select' || $(this).val()!='')
								{
									if(my==$(this).val())
									{
										count++;
									}
								}
							});
							if( count >= 2)
							{
								i=1;
								$('.'+arr[1]).each(function(){
									$(this).css('border-color','red');
								});
							}
							else
							{
								$(this).css('border-color','');
							}
							
						});
						
					});
		
		});
		
		 // Date Picker
		$('.upload_more_btn').live('click',function(){
			var c_val=$(this).closest('tr').clone();
			c_val.find('.single_val').html('');
			c_val.find('.size_val').val('');
			c_val.find('.upload_more_btn').val('-');
			c_val.find('.upload_more_btn').addClass('remove_upload_btn');
			c_val.find('.upload_more_btn').addClass('btn-danger');
			c_val.find('.upload_more_btn').removeClass('upload_more_btn');
			c_val.find('.remove_upload_btn').removeClass('btn-primary');
			
			c_val.find('.hide_remove').show();
			c_val.find('.hide_val').html('');
			var after_clone=$(this).closest('tr').after(c_val);
		}); 
		$('.remove_upload_btn').live('click',function(){
			var c_val=$(this).closest('tr').remove();
		}); 
		$('.class_req').live('blur',function(){
			if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select')
			{
				i=1;
				$(this).css('border-color','red');
			}
			else
			{
				$(this).css('border-color','');
			}
		});
		$('.cust_qty').live('keyup',function(){
			
				var five_val=Number($(this).parent().parent().find('.avail_qty').val());
				if(Number(five_val) < Number($(this).val()))
				{
					$(this).css('border-color','red');
				}
				else
				{
						var sc_class=$(this).attr('class').split(" ");
						var my_val=0;var cust_val=0;
						
						$('.'+sc_class[3]).each(function() {
							my_val=my_val+Number($(this).val());
						});
					
						cust_val=cust_val+Number($('.c'+sc_class[3]).val());
						
						console.log(my_val);
						console.log(cust_val);
						if(my_val>cust_val)
						{
							$('.'+sc_class[3]).each(function() {
								$(this).css('border-color','red');
							});
							
						}
						else
						{
							$('.'+sc_class[3]).each(function() {
								$(this).css('border-color','');
							});	
						}
				}
				
		
		}); 
		
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
			 $('#sy_date').val(today);
	        jQuery('#datepicker').datepicker(); 
			
			
		
			$('#add_gen2').click(function(){
				$('#last_row').find('.total_mrp1').removeClass('class_req');
				
				var i=0;
				
				$('.class_req').each(function(){
					if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select' ||  $(this).val()==0)
					{
						i=1;
						$(this).css('border-color','red');
					}
					else
					{
						$(this).css('border-color','');
					}
				});
				$('.lot_repeat').each(function(){
						
						var arr=$(this).attr('class').split(' '); 
						//var arr=$(this).val();
						console.log(arr);
						
						
						$('.'+arr[1]).each(function(){
						
							var st_o=$(this).closest('tr').find('.style_id').val();
							var cl_o=$(this).closest('tr').find('.color_class').val();
							var my=$(this).val();
							var count=0;
							$('.'+arr[1]).each(function(){
								
								var st_o1=$(this).closest('tr').find('.style_id').val();
								var cl_o1=$(this).closest('tr').find('.color_class').val();
								
								if($(this).val()!='Select' || $(this).val()!='')
								{
									if(my==$(this).val() && st_o1==st_o && cl_o1==cl_o)
									{
										count++;
									}
								}
							});
							if( count >= 2)
							{
								i=1;
								$('.'+arr[1]).each(function(){
									if($(this).val()!='Select' || $(this).val()!='')
									{
										$(this).css('border-color','red');
									}
								});
							}
							else
							{
								$(this).css('border-color','');
							}
							
						});
						
					});
				
				
				var j=0;
				$('.cust_qty').each(function(){
					var five_val=Number($(this).parent().parent().find('.avail_qty').val());
					if(Number(five_val) < Number($(this).val()))
					{
						$(this).css('border-color','red');
						j=1;
					}
					else
					{
							var sc_class=$(this).attr('class').split(" ");
							var my_val=0;var cust_val=0;
							
							$('.'+sc_class[3]).each(function() {
								my_val=my_val+Number($(this).val());
							});
						
							cust_val=cust_val+Number($('.c'+sc_class[3]).val());
							
							console.log(my_val);
							console.log(cust_val);
							if(my_val>cust_val)
							{
								$('.'+sc_class[3]).each(function() {
									$(this).css('border-color','red');
									j=1;
								});
								
							}
							else
							{
								$('.'+sc_class[3]).each(function() {
									$(this).css('border-color','');
								});	
							}
					}
						
				});
				
				
				
				
				if(i==0 && j==0)
				{
					$('.color_class').each(function(){
						var color_id=$(this).val();
						var s_html=$(this).closest('tr').find('.s_size');	
						var s_id=$(this).closest('tr').find('.style_id');
						var s_lot_no=$(this).closest('tr').find('.lotnoclass');	
						$(s_html).each(function(){
							$(this).attr('name','size['+s_id.val()+']['+color_id+']['+s_lot_no.val()+']['+$(this).attr('id')+']');
						});
						var cust_sales_qty=$(this).closest('tr').find('.cust_sales_qty');
						if(cust_sales_qty)
						{
							$(cust_sales_qty).each(function(){
								$(this).attr('name','short_size['+s_id.val()+']['+color_id+']['+s_lot_no.val()+']['+$(this).closest('div').find('.cust_qty').attr('id')+']');
							});	
						}
								
					});
				    return true;
				}
				else
					return false;
			});	
			
			
			
		 });
 		document.onkeyup = KeyCheck;
 
		function KeyCheck(e)
		{
		   var KeyID = (window.event) ? event.keyCode : e.keyCode;
		   if(KeyID == 113)
		   {
				$('#last_row').clone().appendTo('#app_table');  	
		   }
		}
		
        $('#add_group').click(function(){
		 	 var cc=$('#last_row').clone();
			   cc.find('.style_id').addClass('class_req');
			   cc.find('.color_class').addClass('class_req');
			   cc.appendTo('#app_table');  	
		 });
		  $(".remove_comments").live('click',function(){
			$(this).closest("tr").remove();
			var full_total=0;
			$('.total_qty').each(function(){
				full_total=full_total+Number($(this).val());
			});	
			$('.full_total').val(full_total);
			
		
	   });
	   	$('#state').live('change',function(){
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						 $('#customer_td').html(result);
					  }    
				});
				
		});
		/*$('#state').live('change',function(){
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_tax",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						  data=result.split("-");
						$('#st').val(data[1]);
						$('#cst').val(data[2]);
						$('#vat').val(data[3]);
					  }    
				});
				
		});*/
		//tax removed in state vias
		$('.customer').live('change',function(){
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_tax_by_customer",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						  data=result.split("-");
						$('#st').val(data[1]);
						if(data[1]=='' || data[1]==0)
						{
							$('.tr_st_val').css('display','none');
						}
						if(data[2]=='' || data[2]==0)
						{
							$('.tr_cst_val').css('display','none');
						}
						if(data[3]=='' || data[3]==0)
						{
							$('.tr_vat_val').css('display','none');
						}
						$('#cst').val(data[2]);
						$('#vat').val(data[3]);
					  }    
				});
				
		});
		$('#upload_btn').live('click',function(){
			console.log( $('#upload_files').files);
			
		});
		
		
		$('.style_id').live('change',function(){
			$(this).closest('tr').find('.size_html').html('');
			var s_html=$(this).closest('tr').find('.color_div');	
			var lot_div=$(this).closest('tr').find('.lot_div');	
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  for_response(); 
						 s_html.html(result);
					  }    
				});
				/*$.ajax({
					  url:BASE_URL+"sales_order/get_lot_no_by_style_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						   
						lot_div.html(result);
					  }    
				});*/
			}
		});
		$('.upload_lot_no').live('change',function(){
			var color_class=$(this).closest('tr').find('.color_class');
			var style_id=$(this).closest('tr').find('.style_id');
			var size_html=$(this).closest('tr').find('.size_html');	
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_size_for_upload_sales",
					  type:'GET',
					  data:{
						  style_id:style_id.val(),
						  color_id:color_class.val(),
						  style_text:style_id.find(":selected").text(),
						  color_text:color_class.find(":selected").text(),
						  files:$('#files_id').val(),
						  lot_no:$(this).val()
						   },
					  success:function(result){
						  for_response(); 
						size_html.html(result);
					  }    
				});
				var shtml=$(this).closest('tr').find('.mrp_html');		
			
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id3",
					  type:'GET',
					  data:{
						 s_id:style_id.val(),
						  c_id:$('.customer').val(),
						  lotno:$(this).val(),
						   },
					  success:function(result){
			
						 shtml.html(result);
					  }    
				});
		});
		$('.customer').live('change',function(){
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_sp_percentage",
					  type:'GET',
					  data:{
						  c_id:$(this).val()
						   },
					  success:function(result){
						   for_response(); 
						$('#sp_div').html(result);
					  }    
				});
				$('.style_id').each(function(){
					
					var s_each=$(this);
					var s_html=$(this).closest('tr').find('.mrp_html');		
					$.ajax({
						  url:BASE_URL+"gen/get_all_style_details_by_id3",
						  type:'GET',
						  data:{
							  s_id:$(this).val(),
							  c_id:$('.customer').val()
							   },
						  success:function(result){
							 for_response(); 
							 s_html.html(result);
							 
							 
							var total=0;
							var org_mrp=0;
							var full_total=0;
							var last=0;
							
							var s_list=s_each.closest('tr').find('.s_size');	
							var s_total=s_each.closest('tr').find('.total_qty');
							var s_mrp=s_each.closest('tr').find('.total_mrp1').val();
							var s_net=s_each.closest('tr').find('.total_value');
							var sp_val=s_each.closest('tr').find('.sp_val');
							var st_val=s_each.closest('tr').find('.st_val');
							var cst_val=s_each.closest('tr').find('.cst_val');
							var vat_val=s_each.closest('tr').find('.vat_val');
							var net_val=s_each.closest('tr').find('.net_val');
							
							$(s_list).each(function(){
								total=total+Number($(this).val());
							});	
							if(Number(total))	
							s_total.val(total);
							
							org_mrp=Number(s_mrp)-Number(s_mrp) * ( Number($('#sp').val())/Number(100) );
							org_val=org_mrp * total;
							
							
							
							sp_total=Number(s_mrp)-Number(s_mrp) * ( Number($('#sp').val())/Number(100) );
							if(Number(sp_total))
							sp_val.val(sp_total.toFixed(2));
							if(Number(org_val))
							s_net.val(org_val.toFixed(2));
							p1=org_val*($('#st').val()/100);
							p2=org_val*($('#cst').val()/100);
							p3=org_val*($('#vat').val()/100);
							if(Number(p1))	
							st_val.val(p1.toFixed(2));
							if(Number(p2))	
							cst_val.val(p2.toFixed(2));
							if(Number(p3))	
							vat_val.val(p3.toFixed(2));
							last=org_val+p1+p2+p3;
							if(Number(last))	
							net_val.val(last.toFixed(2));
							
							
							
							$('.total_qty').each(function(){
								full_total=full_total+Number($(this).val());
							});	
							if(Number(full_total))
							$('.full_total').val(full_total);
							total_value=0;
							$('.total_value').each(function(){
								if(Number($(this).val()))
								total_value=total_value+Number($(this).val());
							});	
							if(Number(total_value))	
							$('.final_total').val(total_value);
							
							net_final_total=0;
							$('.net_val').each(function(){
								if(Number($(this).val()))
								net_final_total=net_final_total+Number($(this).val());
							});	
							if(Number(net_final_total))	
							$('.net_final_total').val(net_final_total.toFixed(2));
							 
							 
							 
							 
						  }    
					});
					
				});
			}
		});	
		$('.color_class').live('change',function(){
			var s_html=$(this).closest('tr').find('.size_html');
			var s_val=$(this).closest('tr').find('.style_id');	
			var lot_div=$(this).closest('tr').find('.lot_div');	
			for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/get_lot_no_by_style_id",
					  type:'GET',
					  data:{
						    s_id:s_val.val(),
						  	c_id:$(this).val()
						   },
					  success:function(result){
						for_response(); 
						lot_div.html(result);
					  }    
				});
				/*$.ajax({
					  url:BASE_URL+"sales_order/get_all_style_details_by_id1",
					  type:'GET',
					  data:{
						  s_id:s_val.val(),
						  lotno:lot_no.val(),
						  c_id:$(this).val()
						   },
					  success:function(result){
						   s_html.html(result);
					  }    
				});
				*/
		});
		
		$('.lot_no').live('change',function(){
			var s_html=$(this).closest('tr').find('.size_html');
			var s_val=$(this).closest('tr').find('.style_id');	
			var c_val=$(this).closest('tr').find('.color_class');	
			$.ajax({
				  url:BASE_URL+"sales_order/get_all_style_details_by_id1",
				  type:'GET',
				  data:{
					  s_id:s_val.val(),
					  c_id:c_val.val(),
					  lotno:$(this).val(),
					   },
				  success:function(result){
					   s_html.html(result);
				  }    
			});
			var shtml=$(this).closest('tr').find('.mrp_html');		
			
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id3",
					  type:'GET',
					  data:{
						 s_id:s_val.val(),
						  c_id:$('.customer').val(),
						  lotno:$(this).val(),
						   },
					  success:function(result){
				
						 shtml.html(result);
					  }    
				});
			
		});
		
		$('.style_id').live('change',function(){
			/*var s_html=$(this).closest('tr').find('.mrp_html');		
			for_loading();  
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id3",
					  type:'GET',
					  data:{
						  s_id:$(this).val(),
						  c_id:$('.customer').val()
						   },
					  success:function(result){
						   for_response(); 
						 s_html.html(result);
					  }    
				});*/
		});
		$('.s_size').live('keyup',function(){
			
					
					var org_mrp=0;
					var full_total=0;
					var last=0;
					var s_total=0;
					var s_list=$(this).closest('tr').find('.s_size');	
					var s_total=$(this).closest('tr').find('.total_qty');
					var s_mrp=$(this).closest('tr').find('.total_mrp1').val();
					var s_net=$(this).closest('tr').find('.total_value');
					var sp_val=$(this).closest('tr').find('.sp_val');
					var st_val=$(this).closest('tr').find('.st_val');
					var cst_val=$(this).closest('tr').find('.cst_val');
					var vat_val=$(this).closest('tr').find('.vat_val');
					var net_val=$(this).closest('tr').find('.net_val');
					var total=0;
					$(s_list).each(function(){
						total=total+Number($(this).val());
					});	
					if(Number(total))	
						s_total.val(total);
					else
						s_total.val(0);
						
					org_mrp=Number(s_mrp)-Number(s_mrp) * ( Number($('#sp').val())/Number(100) );
					org_val=org_mrp * total;
					
					
					sp_total=Number(s_mrp)-Number(s_mrp) * ( Number($('#sp').val())/Number(100) );
					if(Number(sp_total))
					sp_val.val(sp_total.toFixed(2));
					if(Number(org_val))
					s_net.val(org_val.toFixed(2));
					p1=org_val*($('#st').val()/100);
					p2=org_val*($('#cst').val()/100);
					p3=org_val*($('#vat').val()/100);
					if(Number(p1))	
					st_val.val(p1.toFixed(2));
					if(Number(p2))	
					cst_val.val(p2.toFixed(2));
					if(Number(p3))	
					vat_val.val(p3.toFixed(2));
					last=org_val+p1+p2+p3;
					if(Number(last))	
					net_val.val(last.toFixed(2));
					
					
					
					full_total=0;
					$('.total_qty').each(function(){
						full_total=full_total+Number($(this).val());
					});	
					
					if(Number(full_total))
						$('.full_total').val(full_total);
					else
						$('.full_total').val(0);
					total_value=0;
					$('.total_value').each(function(){
						if(Number($(this).val()))
						total_value=total_value+Number($(this).val());
					});	
					if(Number(total_value))	
					$('.final_total').val(total_value);
					
					net_final_total=0;
					$('.net_val').each(function(){
						if(Number($(this).val()))
						net_final_total=net_final_total+Number($(this).val());
					});	
					if(Number(net_final_total))	
					$('.net_final_total').val(net_final_total.toFixed(2));
			
		});
		
		
			/*$(document).ready(function(){
				 $.ajax({
					  url:BASE_URL+"stock/stock_details",
					  type:'GET',
					  data:{
						    },
					  success:function(result){
						  $('#stock_details').html(result);
					  }    
				});
		    });	
			$('.edit_btn').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','block');
				$('#remove_'+data[1]).css('display','block');
				$('.size_'+data[1]).removeAttr('readonly');
				$(this).hide();
			});
			$('.size_remove').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.size_'+data[1]).attr('readonly','readonly');
			});
			$('.size_ok').live('click',function(){
				data=$(this).attr('id').split("_");
				$('#remove_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.size_'+data[1]).attr('readonly','readonly');
				var c_array=arry_list='';
				$('.size_'+data[1]).each(function(){
					stock_id=arry_list[1];

					arry_list=$(this).attr('id').split("_");
					c_array=c_array+arry_list[2]+'_'+$(this).val()+',';
				});
				$.ajax({
					  url:BASE_URL+"stock/update_stock_details",
					  type:'GET',
					  data:{
						  s_id:stock_id,
						  s_list:c_array
						   },
					  success:function(result){
						  $('#stock_details').html(result);
					  }    
				});
			});
			$('.ccolor').live('keyup',function(){
		    	if($(this).val()<=0)
					$(this).css('background-color','#F4D5D5');
				else
					$(this).css('background-color','');	
				data=$(this).attr('id').split("_");	
				
				total=0;
				$('.size_'+data[1]).each(function(){
					total=total+Number($(this).val());
				});
				$('.total_'+data[1]).val(total);
				
				f_total=0;
				$('.ctotal').each(function(){
					f_total=f_total+Number($(this).val());
				});
				$('#f_total').val(f_total);
				
			});
			$('.m_style').live('change',function(){
				$.ajax({
					  url:BASE_URL+"stock/get_color_by_style_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  
						 $('#color_td').html(result);
					  }    
				});
			});*/
			
        </script>
         <script type="text/javascript">
		$(".int_val").live('keypress',function(event){
  	var characterCode = (event.charCode) ? event.charCode : event.which ;
		var browser;
		if($.browser.mozilla)
		{
      		if((characterCode > 47 && characterCode < 58) || characterCode==8 || event.keyCode==39  || event.keyCode==37 || characterCode==97 || characterCode==118) 
		  {
		   
			return true;
		  }
		  return false;
		}
		if($.browser.chrome)
		{
     		if (event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57)) {
        //display error message
        
               return false;
   			 }
		}
			 
	
 });
 $('.customer').live('change',function(){
			if($(this).val()!='Select')	 
			{
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/get_tin1",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 for_response(); 
						 $('#tin').val(result);
					  }    
				});
			}
		});
		</script>
        