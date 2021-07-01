<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-lock pageheader_icon"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Package List</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
             <a href="<?php echo $this->config->item('base_url').'package/'?>" class="btn btn-defaultadd3 right"><span class="glyphicon glyphicon-plus"></span> Add Package Order</a><br /><br />
                  <table class="table table-striped responsive dataTable no-footer dtr-inline search_table_hide">
                  		<tr>
                        	<td>PS&nbsp;No</td><td><input type="text"  id="ps_no" class="form-control" autocomplete="off" style="width:150px"/></td>
                            
                            <td>Customer Name</td>
                            <td>
                            	<select id='customer' style="width: 170px;" class="form-control">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_customer) && !empty($all_customer))
                                        {
                                            foreach($all_customer as $val)
                                            {
                                                ?>
                                                    <option value='<?=$val['id']?>'><?=$val['store_name']?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>From Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" id="">
                              
                                </div>
                            </td>
                            <td>To Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" id="">
                                   
                                </div>
                            </td>
                            <td><a  id='search' class="btn btn-defaultsearch4 pull-right"><span class="glyphicon glyphicon-search"></span> Search</a></td>
                        </tr>
                  </table>
                  
                 <div id='result_div'>
                  <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>PS No</td>
                            <td>Customer Name</td>
                            
                            <!--/*<td>Ship Mode</td>*/-->
                            <td>Shipment Date</td>
                            <td>Transport</td>
                            <td>LR NO</td>
                            <td>No of Cotton</td>
                            <td>Package Qty</td>
                            <td class="hide_class action-btn-align">Action</td>
                            <td class="hide_class action-btn-align">Invoice</td>
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
                                   
                                     <!--<td><?=$val['ship_mode']?></td>-->
                                    <td><?=date('d-M-Y',strtotime($val['ship_date']))?></td>
                                    <td><?=$val['llr_no']?></td>
                                    <td><?=$val['lr_no']?></td>
                                    <td><?=$val['no_corton']?></td>
                                    <td><?=$val['total_qty']?></td>
									<td class="hide_class action-btn-align">
                                    	<!--<a href="<?php echo $this->config->item('base_url').'sales_order/edit_sales_order/'.$val['id']?>" class="btn btn-primary btn-rounded">Edit</a>-->
                                        <a href="<?php echo $this->config->item('base_url').'package/package_view/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                         
                                    </td>
                                    <td class="hide_class action-btn-align">
                                    	<?php 
										if(isset($val['inv_no'][0]['inv_no']) && !empty($val['inv_no'][0]['inv_no']))
										{
											?>
                                            <a href="<?php echo $this->config->item('base_url').'invoice/view/'.$val['inv_no'][0]['inv_id']?>" data-toggle="tooltip" class="fa fa-eye tooltips green" title="" data-original-title="View">&nbsp;</a>
                                            <?php 
										}
										else
										{
										?>
                                    	<a href="<?php echo $this->config->item('base_url').'invoice/create/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips red" title="" data-original-title="Create">&nbsp;</a>
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
                </div> 
             <div class="action-btn-align">
                <button class="btn btn-defaultprint6 print_btn "><span class="glyphicon glyphicon-print"></span> Print</button>
             </div>
                 <script>
                    $('.print_btn').click(function(){
                        window.print();
                    });
                  </script>
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
<script type="text/javascript">
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#ps_no").autocomplete(BASE_URL+"package/get_ps_no_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"package/search_result",
					  type:'GET',
					  data:{
						  	ps_no    :$('#ps_no').val(),
							customer :$('#customer').val(),
						    customer_name :$('#customer').find('option:selected').text(),
							from_date:$('#from_date').val(),
							to_date  :$('#to_date').val()
						   },
					  success:function(result){
						   for_response(); 
						$('#result_div').html(result);
					  }    
				});
			});
		</script>