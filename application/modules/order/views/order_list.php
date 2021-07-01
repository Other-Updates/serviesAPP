<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
.bg-cyan {
    background-color: #16cfd8 !important;
}
.bg-blue{
    background-color:#165bd8 !important;
}
 .bg-red {
    background-color: #dd4b39 !important;
}
</style>
<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-earphone pageheader_icon"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Order List</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
                    <table class="table table-striped responsive no-footer dtr-inline search_table_hide" style="display: none;">
                  		<tr>
                        	<input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>
                            <td>Style</td><td>
                            	<select id='style' style="width: 170px;" class="form-control">
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
                            <td>Supplier</td>
                            <td>
                            	<select id='supplier'  class="form-control" style="width: 170px;">
                                    <option>Select</option>
                                    <?php 
                                        if(isset($all_supplier) && !empty($all_supplier))
                                        {
                                            foreach($all_supplier as $val)
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
                                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td>To Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td><a  id='search' class="btn btn-defaultsearch4 pull-right"><span class="glyphicon glyphicon-search"></span> Search</a></td>
                        </tr>
                  </table>
                  <div id='result_div' class="panel-body mt-10">
                  <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                            <td>S.No</td>
                            <td>Quotation No</td>
                            <td>Customer Name</td>
                            <td>Total Quantity</td>
                            <td>Total Tax</td>
                            <td>Sub Total</td>
                            <td>Total Amount</td>                            
                            <td>Delivery Schedule</td>
                            <td>Notification Date</td>
                            <td>Mode of Payment</td>
                            <td>Remarks</td>
                            <td>Status</td>
                            <td class="hide_class action-btn-align">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						
                        	if(isset($quotation) && !empty($quotation))
							{
								$i=1;
								foreach($quotation as $val)
								{
									?>
                                    <tr>
                                    <td class='first_td'><?=$i?></td>
                                    <td><?=$val['q_no']?></td>	
                                    <td><?=$val['name']?></td>
                                    <td><?=$val['total_qty']?></td>
                                    <td><?=$val['tax']?></td> 
                                    <td><?=$val['subtotal_qty']?></td>
                                    <td><?=$val['net_total']?></td>
                                    <td><?=$val['delivery_schedule']?></td>
                                    <td><?=$val['notification_date']?></td>
                                    <td><?=$val['mode_of_payment']?></td>
                                    <td><?=$val['remarks']?></td>
                                    <td>
                                        <?php
                                            if($val['eStatus']==2)
                                            {?>
                                               <span class=" badge bg-cyan"><?php  echo 'Yet to Approve';?></span>
                                           <?php }
                                            else if($val['eStatus']==4)
                                            {?>
                                               <span class=" badge bg-blue"><?php  echo 'Order Approved';?></span>
                                          <?php  } 
                                            else if($val['eStatus']==5)
                                            {?>
                                                 <span class=" badge bg-red"> <?php echo 'Order Reject'; ?></span>
                                          <?php  }
                                        ?>
                                    </td>
                                    <td class=" action-btn-align"> 
                                        <a href="<?php echo $this->config->item('base_url').'order/quotation_view/'.$val['id']?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="" data-original-title="View"><span  class="fa fa-eye" ></span>&nbsp;</a>   
                                    </td>
                                    </tr>
                             	 <?php
                                 $i++;
				}
			}
			
			?>         
                    </tbody>
                  </table>
                   <div class="action-btn-align">
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                    </div>
                      
                  </div>
                   
                   
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
        <script type="text/javascript">
        $('.complete_remarks').live('blur',function()
        {
	    var complete_remarks=$(this).parent().parent().find(".complete_remarks").val();
	    var ssup=$(this).offsetParent().find('.remark_error');
	    if(complete_remarks=='' || complete_remarks==null)
	    {
		   ssup.html("Required Field");
	    }
	    else
	    {
		   ssup.html("");
	    }
        });
		$('.yesin').live('click',function(){
			var i=0;
		    var complete_remarks=$(this).parent().parent().find(".complete_remarks").val();
			var ssup=$(this).offsetParent().find('.remark_error');
			if(complete_remarks=='' || complete_remarks==null)
			{
			   ssup.html("Required Field");
			   i=1;
			}
			else
			{
			   ssup.html("");
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
		
		
		
		
		
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#po_no").autocomplete(BASE_URL+"gen/get_po_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"po/search_result",
					  type:'GET',
					  data:{
						  	po       :$('#po_no').val(),
						 	style    :$('#style').val(),
							supplier :$('#supplier').val(),
							supplier_name:$('#supplier').find('option:selected').text(),
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