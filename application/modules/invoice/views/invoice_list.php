<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

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
                        <h4>Package List</h4>
                    </div>
                    <a style="float:right;" href="<?php echo $this->config->item('base_url').'package/'?>" class="btn btn-default"><span>Add Package Order</span></a>
                </div><!-- media -->
            </div>
            <div class="contentpanel">
                  
                  
                 <div id='result_div'>
                  <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>PS No</td>
                            <td>Customer</td>
                            <td>Origin</td>
                            <td>Destination</td>
                            <td>Ship Mode</td>
                            <td>Ship Date</td>
                            <td>No Corton</td>
                            <td>Total Qty</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
                        	if(isset($all_package) && !empty($all_package))
							{
								foreach($all_package as $val)
								{
									?>
                                    <tr>
                                    <td><?=$val['package_slip']?></td>	
                                    <td><?=$val['name']?></td>
                                    <td><?=$val['origin']?></td>
                                    <td><?=$val['destination']?></td>
                                    <td><?=$val['ship_mode']?></td>
                                    <td><?=date('d-M-Y',strtotime($val['ship_date']))?></td>
                                    <td><?=$val['no_corton']?></td>
                                    <td><?=$val['total_qty']?></td>
									<td>
                                    	<!--<a href="<?php echo $this->config->item('base_url').'sales_order/edit_sales_order/'.$val['id']?>" class="btn btn-primary btn-rounded">Edit</a>-->
                                        <a href="<?php echo $this->config->item('base_url').'package/package_view/'.$val['id']?>" class="btn btn-info btn-rounded">View</a>
                                         <a href="<?php echo $this->config->item('base_url').'invoice/create/'.$val['id']?>" class="btn btn-warning btn-rounded">Invoice</a>
                                    </td>
                                    </tr>
                                    <?php
								}
							}
							else
							{
								?>
                                <tr><td colspan="9">No data found...</td></tr>
                                <?php
							}
						?>
                    </tbody>
                  </table>
                </div>  
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
<script type="text/javascript">
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#so_no").autocomplete(BASE_URL+"sales_order/get_so_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				$.ajax({
					  url:BASE_URL+"sales_order/search_result",
					  type:'GET',
					  data:{
						  	po       :$('#so_no').val(),
						 	state    :$('#state').val(),
							customer :$('#customer').val(),
							from_date:$('#from_date').val(),
							to_date  :$('#to_date').val()
						   },
					  success:function(result){
						$('#result_div').html(result);
					  }    
				});
			});
		</script>