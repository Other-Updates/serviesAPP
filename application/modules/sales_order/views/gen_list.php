<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
 <script>


// only init when the page has loaded
$(document).ready(function() {
    var pressed = false; 
    var chars = []; 
    // trigger an event on any keypress on this webpage
    $(window).keypress(function(e) {
        // check the keys pressed are numbers
        if (e.which <= 150) {
            // if a number is pressed we add it to the chars array
            chars.push(String.fromCharCode(e.which));
        }
        if (pressed == false) {
            setTimeout(function(){
                // check we have a long length e.g. it is a barcode
                if (chars.length >= 10) {
                    // join the chars array to make a string of the barcode scanned
                    var barcode = chars.join("");
                    // debug barcode to console (e.g. for use in Firebug)
                    alert("Barcode Scanned: " + barcode);
                    // assign value to some input (or do whatever you want)
                    $("#text_code").val('');
                }
                chars = [];
                pressed = false;
            },500);
        }
    });
});

</script>

<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-log-out pageheader_icon"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Sales Order</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
            <a href="<?php echo $this->config->item('base_url').'sales_order/'?>" class="btn btn-defaultadd3 right topgen"><span class="glyphicon glyphicon-plus"></span> Add Sales Order</a>
            <a href="#upload_so"  data-toggle="modal"  title="Upload client excel file" class="btn btn-defaultupload8 topgen" style="float:right;margin-right: 10px;"><span class="glyphicon glyphicon-upload"></span> Upload Sales Order</a><br /><br />
                  <table class="table table-striped no-footer dtr-inline search_table_hide">
                  		<tr>
                        	<td>SO&nbsp;No</td><td><input type="text" name="so_no" id="so_no" class="form-control" autocomplete="off" style="width:150px"/></td>
                            <td>State</td>
                            <td>
                            	<select id='state' class="form-control" style="width: 170px;">
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
                            </td>
                            <td>Customer</td>
                            <td>
                            	<select id='customer' class="form-control" style="width: 170px;">
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
                                </select></td>
                            <td>From Date</td>
                            <td>
                            	<div style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                 
                                </div>
                            </td>
                             <td>To Date</td>
                            <td>
                            	<div style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td><a style="float:right;" id='search' class="btn btn-defaultsearch4"><span class="glyphicon glyphicon-search"></span> Search</a></td>
                        </tr>
                  </table>
                 <div id='result_div'>
                  <table class="table table-bordered table-striped responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>SO No</td>
                        	<!--<td>Invoice No</td>-->
                            <td>State</td>
                            <td>Customer Name</td>
                            <td>Invoice Date</td>
                            <td>Sales Qty</td>
                            <td>Sales Value<br />(Without Tax)</td>
            				<td>Sales Value<br />(With Tax)</td>
                            <td class="action-btn-align">Package Status</td>
                            <td  class="hide_class action-btn-align">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$count=0;$net_final_total=0;$net_value=0;
                        	if(isset($all_gen) && !empty($all_gen))
							{
								$i=1;
								foreach($all_gen as $val)
								{
									?>
                                    <tr>
                                    <td class='first_td'><?=$i?></td>
                                    <td><?=$val['grn_no']?></td>	
                                    <!--<td><?=$val['inv_no']?></td>-->
                                    <td><?=$val['state']?></td>
                                    <td><?=$val['store_name']?></td>
                                    <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                    <td><?=$val['full_total']?></td>
                                     <td  class="text_right"><?=number_format($val['net_value'], 2, '.', ',')?></td>
                                    <td  class="text_right"><?=number_format($val['net_final_total'], 2, '.', ',')?></td>
                                    <td class="action-btn-align">
                                    	<?php 
										if($val['package_status']==0)
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="No"><span class="fa fa-times red"></span></a>';
										}
										else
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Yes"><span class="fa fa-check green"></span></a>';
										}
										
										?>
                                    </td>
									<td  class="hide_class action-btn-align">
                                    	<!--<a href="<?php echo $this->config->item('base_url').'sales_order/edit_sales_order/'.$val['id']?>" class="btn btn-primary btn-rounded">Edit</a>-->
                                        <a href="<?php echo $this->config->item('base_url').'sales_order/view_sales_order/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                    </td>
                                    </tr>
                                    <?php
									$i++;
									$count=$count+$val['full_total'];
									$net_value=$net_value+$val['net_value'];
									$net_final_total=$net_final_total+$val['net_final_total'];
								}
								?>
								 <tr >
                    <td></td><td></td><td></td><td></td><td></td><td><?=$count;?></td><td  class="text_right"><?=number_format($net_value, 2, '.', ',')?></td><td  class="text_right"><?=number_format($net_final_total, 2, '.', ',')?></td><td></td>
                </tr>
								<?php
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
            <div class="action-btn-align">
                 <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print "></span> Print</button> 
            </div>		  
                 <script>
                    $('.print_btn').click(function(){
                        window.print();
                    });
                  </script>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
         <form method="post" enctype="multipart/form-data" action="<?=$this->config->item('base_url').'sales_order/upload_excel'?>">
                <div id="upload_so" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header modal-padding "><a class="close modal-close " data-dismiss="modal">×</a>
                                        <h4 style="color:#06F">Upload client sales order excel file</h4>
                                       
                           </div>
                           <div class="modal-body">
                                 
                                
                                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                    <tr>
                                        <td width="40%" style="text-align:right;">Customer</td>
                                        <td>
                                            <select name='customer' class="form-control customer" id="customer" style="width: 170px;">
                                                <option value="">Select</option>
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
                                            <span id="cuerror" class="cuerror" style="color:#F00;"></span>
                                        </td>
                                    </tr>
                                    <tr>    
                                        <td  style="text-align:right;">Excel File</td>
										<td>
                                        	<input type="file" name="upload_files" id="imginp" class="imginp"/>
                                             <span id="cuerror1" class="cuerror1" style="color:#F00;"></span>
                                        </td>
                                    </tr>
                                </table>	
                             
                               </div>
                               <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary delete_yes yesin" type="submit" id="client_submit">Upload Excel</button>
                                <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                          </div>
                    </div>
                  </div>  
             </div>
         </form>
         <script type="text/javascript">
		 $('#client_submit').live('click',function()
		 {
			 i=0;
			var customer=$(this).parent().parent().find(".customer").val();
	        var m=$(this).offsetParent().find('.cuerror');
			if(customer=='')
			{
				m.html("Required Field");
				i=1;
			}
			else
			{
				m.html(" ");
			}
			var n=$(this).offsetParent().find('.cuerror1').html();
			if((n.trim()).length>0)
			{
				i=1;
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
		    $('#customer').live('change',function()
			{
				//var customer=$('#customer').val();
				
				var customer=$(this).parent().parent().find(".customer").val();
	            var m=$(this).offsetParent().find('.cuerror');
				if(customer=="")
				{
				    m.html("Required Field");
				}
				else
				{
					m.html(" ");
				}
			});
			
			$('#no').live('click',function()
		    {
				var m=$(this).offsetParent().find('.cuerror');
				m.html("");
			});
		 </script>
         <script type="text/javascript">
		  $(".imginp").live('change',function() {
			//alert("hi");
				//var val = $(this).val();
				var val=$(this).parent().parent().find(".imginp").val();
				//alert(val);
				 var n=$(this).offsetParent().find('.cuerror1');
				
				switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
				case 'xls': case '':
						$(this).parent().parent().find(".imginp").val();
						n.html("");
						break;
					default:
						$(this).parent().parent().find(".imginp").val();
					   
					    n.html("Upload xls Files");
						break;
				}
			});
		 </script>
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
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"sales_order/search_result",
					  type:'GET',
					  data:{
						  	po       :$('#so_no').val(),
						 	state    :$('#state').val(),
							customer :$('#customer').val(),
							state_name    :$('#state').find('option:selected').text(),
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