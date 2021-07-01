
            <form method="post">
            <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            	<tr>
                	<td class="first_td1">PO NO</td>
                    <td >
                   		<b><?=$gen_info[0]['grn_no']?></b>
                    </td>
                    <td class="first_td1">Supplier</td>
                    <td id='customer_td'>
                    	<?=$gen_info[0]['store_name']?>
                    	<!--<select  name="customer"  style="width: 170px;">
                        	<option>Select</option>
                        </select>-->
                    </td>
                </tr>
               
               <tr>
               		<td class="first_td1">GRN NO</td>
                    <td><!--<input type="text" name="inv_no"  />--><b><?=$gen_no[0]['grn_no']?></b></td>
                    <td class="first_td1">Date</td>
                    <td>
                    	<?=date('d-M-Y',strtotime($gen_no[0]['inv_date']))?>
                    	 <!-- <div class="input-group">
                            <input type="text" class="form-control" name="inv_date" placeholder="mm/dd/yyyy" id="datepicker">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>-->
                    </td>
              
               </tr>
             
               </table>
      <br/>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                    	<td width="10%" class="first_td1">Style</td>
                 
                        <td width="10%" class="first_td1">Color</td>
                        <td width="14%" class="first_td1">Lot No</td>
						  <td  class="first_td1">Size</td>
                         <td  width="8%" class="first_td1">QTY</td>
                          <td  width="8%" class="first_td1">Location</td>
                        <td  width="10%" class="first_td1">Landed Cost</td>
                        <td  width="8%" class="first_td1">Net Value</td>
                        <!--<td width="5%"><input type="button" value="+" title="Add row" id='add_group' class="btn btn-primary" /></td>-->
                    </tr>
                    <tbody id='app_table'>	
                    <?php 
					$this->load->model('po/gen_model');
				
					$net_val=0;$net_qty=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
						
						$where=array('lot_no'=>$info['lot_no'],'stock_from'=>'po');
						$location=$this->gen_model->get_location($where);
						$tlc='';
						foreach($location as $lc)
						{
							if($lc['location']!='')
							$tlc=$lc;
						}
						
					?>
                    	<tr>
                        	<td>
                            <?=$info['style_name'];?>
                            
                            	<input type="hidden" value="<?=$info['style_id'];?>" class='style_id'  name="style_all[]">
                                   
                            </td>
                          
                            <td>
                            	<?=$info['colour'];?>
                            	<input type="hidden" value="<?=$info['color_id'];?>"  class="color_class" name="color[]">
                                    
                            </td>
                             <td>
                            	<?=$info['lot_no'];?>
                            	<input type="hidden" value="<?=$info['lot_no'];?>"  class="color_class" name="lot_no[]">
                                    
                            </td>
                            
                            
                              
                            <td class="size_html">
                            
                           		 <?php 
								 		$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												
												/*echo $gen_no[0]['gen_id'];
												echo $info['style_id'];
												echo $info['color_id'];
												echo $val['size_id'];*/
												$where=array('gen_id'=>$gen_no[0]['gen_id'],'style_id'=>$info['style_id'],'color_id'=>$info['color_id'],'size_id'=>$val['size_id']);
											
													$sum=$this->gen_model->get_size_val_old($where);
													$bal=$val['qty'];
													$full_total=$full_total+$sum[0]['avail_qty'];
													
													$net_qty=$net_qty+$sum[0]['avail_qty'];
                                                ?>
                                                    <div class='div_css' >
                                                    	<p class='p_css'><?=$val['size']?></p>
                                                        <p class='p_css' style="display:none;" >
                                                        	<?=$val['qty']?>
                                                        </p>
                                                        <p class='p_css' >
                                                        	<?=$sum[0]['avail_qty']?>
                                                        </p>
                                                        
                                                    </div>
                                                <?php
                                            }
                                        }
							
										$last_val=$full_total*$info['landed'];
										$net_val=$net_val+$last_val;
                                    ?>
                            
                            </td>
                            <td>
                            	<?=$full_total?>
                            </td>
                            <td><?=$tlc['location'];?></td>
                            <td  class="mrp_html text_right">
                            	<?=number_format($info['landed'], 2, '.', ',');?>
                            </td>
                             <td  class="text_right">
                            	<?=number_format($last_val, 2, '.', ',')?>
                            </td>
                           <!-- <td>
                            	
                            </td>-->
                            
                        </tr>
                        <?php 
							}
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:70px; text-align:right;">Total</td>
                            <td ><?=$net_qty;?></td>
                             <td></td><td></td>
                            <td  class="text_right"><?=number_format($net_val, 2, '.', ',')?></td>
                           <!-- <td></td>-->
                        </tr>
                    </tfoot>
                </table>
                
                </form>
              
                   <input type="button" class="btn btn-default print_btn" style="float:right;"  value="Print"/>
                
             <script>
      	$('.print_btn').click(function(){
			window.print();
		});
      </script>