<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-log-in pageheader_icon"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Purchase Order</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
                    <a href="<?php echo $this->config->item('base_url').'po/'?>" class="btn btn-defaultadd3 right topgen"><span class="glyphicon glyphicon-plus"></span> Add PO</a>
                    <br /><br />
                  <table class="table table-striped  responsive no-footer dtr-inline search_table_hide">
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
                  <div id='result_div'>
                  <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>PO #</td>
                            <td>Style</td>
                            <td>Supplier</td>
                            <td>Date</td>
                            <td>PO Qty</td>
                            <td>PO Value<br />(Without Tax)</td>
            				<td>PO Value<br />(With Tax)</td>
                            <td class="action-btn-align">Delivery Status</td>
                            <td>Remarks</td>
                            <td class="hide_class action-btn-align">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$net_total=0;$org_total=0;
                        	if(isset($all_gen) && !empty($all_gen))
							{
								$i=1;$count=0;
								foreach($all_gen as $val)
								{
									?>
                                    <tr>
                                    <td class='first_td'><?=$i?></td>
                                    <td><?=$val['grn_no']?></td>	
                                    <td><?=$val['style_name']?></td>
                                    <td><?=$val['store_name']?></td>
                                    <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                    <td><?=$val['full_total']?></td>
                                    <td class="text_right"><?=number_format($val['org_total'], 2, '.', ',')?></td>
                                    <td  class="text_right"><?=number_format($val['net_total'], 2, '.', ',')?></td>
                                    <td class="action-btn-align">
										<?php 
										if($val['delivery_status']==0)
										{
											if($val['cancel_status']=='true')
												echo '<a href="#" data-toggle="modal" class="tooltips ahref " title="Rejected"><span class="fa fa-times red"></span></a>';	
											else
												echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Pending"><span class="fa fa-warning orange">&nbsp;</span></a>';
										}
										else if($val['delivery_status']==1)
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
											
											echo '<a href="#com_'.$val['id'].'" data-toggle="modal" name="edit" class="btn btn-danger btn-rounded btn-sm" title="Force to Complete">Force to Complete</a>';
										}
										else if($val['delivery_status']==2)
										{
											echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
										}
										
										?>
                                   </td>
									<td>
                                    	<?=$val['complete_remarks']?>
                                    </td>
									<td  class="hide_class action-btn-align">
                                      <a href="<?php echo $this->config->item('base_url').'po/view_gen/'.$val['id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="View" >&nbsp;</a>
                                    <?php 
									if($val['cancel_status']!='true' && $val['delivery_status']!=2)
									{
									?>
                                    	<a href="<?php echo $this->config->item('base_url').'po/edit_gen/'.$val['id']?>" data-toggle="tooltip" class="fa fa-edit tooltips" title="Edit">&nbsp;</a>
                                        <?php }?>
                                      
                                    </td>
                                    </tr>
                                    <?php
									$count=$count+$val['full_total'];
									$net_total=$net_total+$val['net_total'];
									$org_total=$org_total+$val['org_total'];	
									$i++;
								}
								?>
                                <tfoot>
								<tr  class='first_td'>
									<td></td><td></td><td></td><td></td><td></td><td><?=$count;?></td><td  class="text_right"><?=number_format($org_total, 2, '.', ',')?></td><td  class="text_right"><?=number_format($net_total, 2, '.', ',')?></td><td></td><td></td><td  class="hide_class"></td>
								</tr>
                            </tfoot>
								<?php
							}
							
						?>
                    </tbody>
                  </table>
                      
                  </div>
                    <div class="row">
                        <div class="col-md-12">
                  <p class="left black"><span class="fa fa-thumbs-up green">&nbsp;</span> - Complete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-thumbs-down blue">&nbsp;</span> - In-Complete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-times red"></span> - Rejected&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-warning orange">&nbsp;</span> - Pending &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-eye blue1"></span> - View &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-edit blue1"></span> - Edit</p>
                        </div>
                    </div>
                    <div class="action-btn-align">
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                    </div>
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
        
        <?php
			if(isset($all_gen) && !empty($all_gen))
			{
				foreach($all_gen as $val)
				{
					?>
                    <form method="post" action="<?=$this->config->item('base_url').'po/force_to_complete/1'?>">
                            <div id="com_<?=$val['id'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                       <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                    <h4 style="color:#06F">Force to Complete</h4>
                                                   
                                       </div>
                                       <div class="modal-body">
                                             
                                             <strong>
                                               Are You Sure You Want to Complete This PO ?  
                                             </strong>
                                           	<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                            	<tr>
                                                	<td width="40%" style="text-align:right;">Remarks&nbsp;</td>
                                                    <td>
                                                    	<input type="text" style="width:220px;" class="form-control complete_remarks" name='complete_remarks' />
                                                        <span class="remark_error" style="color:#F00;"></span>
                                                    </td>
                                                </tr>
                                            </table>	
                                             <input type="hidden" name="update_id" value="<?=$val['id']?>"  />
                                    
                                           </div>
                                           <div class="modal-footer">
                                            <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                                      </div>
                                </div>
                              </div>  
                         </div>
                     </form>
       				 <?php
				}
			}
		
		?>             
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