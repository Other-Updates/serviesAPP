<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?=$theme_path?>/js/custom.js"></script>
<table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline search_table" style="display:none;">
	<tr>
    	<td width="10%">PS</td>
		<td width="10%">
        	<?php 
				if($search_data['ps_no']!='')
					echo $search_data['ps_no'];
				else
					echo "-";		
			?>
        </td>
        <td width="10%">customer</td>
		<td width="10%">
        	<?php 
				if($search_data['customer_name']!='Select')
					echo $search_data['customer_name'];
				else
					echo "-";		
			?>
        </td>
        <td  width="10%">From&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['from_date']!='')
					echo $search_data['from_date'];
				else
					echo "-";	
			?>
        </td>
        <td  width="10%">To&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['to_date']!='')
					echo $search_data['to_date'];
				else
					echo "-";		
			?>
        </td>
    </tr>
</table>
                  <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>PS No</td>
                            <td>Customer Name</td>
             <!--               <td>Origin</td>-->
                            
                            <td>Shipment Date</td>
                            <td>Transport</td>
                            <td>LR NO</td>
                            <td>No of Cotton</td>
                            <td>Package Qty</td>
                            <td class="hide_class">Action</td>
                            <td class="hide_class">Invoice</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
							$total_qty=0;
                        	if(isset($all_package) && !empty($all_package))
							{
								$i=1;
								foreach($all_package as $val)
								{
									$total_qty=$total_qty+$val['total_qty'];
									?>
                                    <tr>
                                    
                                    <td class='first_td'><?=$i?></td>
                                    <td><?=$val['package_slip']?></td>	
                                    <td><?=$val['store_name']?></td>
                                 <!--   <td><?=$val['origin']?></td>-->
                                    
                                    <td><?=date('d-M-Y',strtotime($val['ship_date']))?></td>
                                    <td><?=$val['llr_no']?></td>
                                    <td><?=$val['lr_no']?></td>
                                    <td><?=$val['no_corton']?></td>
                                    <td><?=$val['total_qty']?></td>
									<td class="hide_class">
                                    	<!--<a href="<?php echo $this->config->item('base_url').'sales_order/edit_sales_order/'.$val['id']?>" class="btn btn-primary btn-rounded">Edit</a>-->
                                        <a href="<?php echo $this->config->item('base_url').'package/package_view/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                         
                                    </td>
                                    <td class="hide_class">
                                    	<?php 
										if(isset($val['inv_no'][0]['inv_no']) && !empty($val['inv_no'][0]['inv_no']))
										{
											?>
                                            <a href="<?php echo $this->config->item('base_url').'invoice/view/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips green" title="" data-original-title="View">&nbsp;</a>
                                            <?php 
										}
										else
										{
										?>
                                    	<a href="<?php echo $this->config->item('base_url').'invoice/create/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips red" title="" data-original-title="View">&nbsp;</a>
                                        <?php }?>
                                    </td>
                                    </tr>
                                    <?php
									$i++;
								}
								?>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$total_qty?></td>
                                    <td class="hide_class"></td>
                                    <td class="hide_class"></td>
                                </tr>
                                </tfoot>
                                <?php
							}
							else
							{
								?>
                                <tr><td colspan="10">No data found...</td></tr>
                                <?php
							}
						?>
                    </tbody>
                  </table>
               