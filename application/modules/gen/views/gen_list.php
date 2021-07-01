<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-truck pageheader_icon"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Goods Receive Note</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
            <div class="contentpanel">
            <a href="<?php echo $this->config->item('base_url').'gen/'?>" class="btn btn-default right"><span>Add GRN</span></a><br /><br />
           <form method="post" action="<?=$this->config->item('base_url').'gen/barcode_scanner_grn/'?>">
            <table  style="width:40%;margin:0 auto;" class="table table-striped table-bordered no-footer dtr-inline">
            	<tr>
                	<td class="first_td1" width="100">PO NO</td>
                    <td><input type="text"  id="po_no1" name="po" autocomplete="off" class="form-control po_no_dup"/></td>
                    <td><input type="submit" class="btn btn-default "  value='Use Scanner for GRN'/><span id="poerror" style="color:#F00;"></span><span id="duplica" style="color:#F00;"></span></td>
                    
                </tr>
            </table>
            <script>
					$().ready(function() {
						$("#po_no1").autocomplete("gen/get_po_list", {
							width: 260,
							autoFocus: true,
							matchContains: true,
							selectFirst: false
						});
					});
		
            </script>
            </form>
                  <table class="table table-striped table-bordered no-footer dtr-inline search_table_hide">
                  		<tr>
                        	<td>GRN</td><td><input type="text" id="grn_no" autocomplete="off" style="width:100px" class="form-control"/></td>
                        	<td>PO</td><td><input type="text"  id="po_no" autocomplete="off" style="width:100px" class="form-control"/></td>
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
                            <td>State</td>
                            <td>
                            	<select id='state' style="width: 100px;" class="form-control">
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
                            <td>Supplier</td>
                            <td>
                            	<select id='supplier' style="width: 100px;" class="form-control">
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
                            <td>Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                                   
                                </div>
                            </td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">
                                   
                                </div>
                            </td>
                            <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>
                        </tr>
                  </table>
                  <div id='result_div'>
                  <table  id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td class="first_td1">S.No</td>
                            <td class="first_td1">GRN No</td>
                        	<td class="first_td1">PO No</td>
                         	<td class="first_td1" style="width:70px;">Style</td>
                            <td class="first_td1">Supplier</td>
                            <td class="first_td1">Date</td>
                            <td class="first_td1">GRN Qty</td>
                            <td class="first_td1">GRN Value</td>
                            <!--<td>Status</td>-->
                            <td  class="hide_class">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
							$count=0;$total_value=0;
                        	if(isset($all_gen) && !empty($all_gen))
							{
								$j=1;
								foreach($all_gen as $val)
								{
									?>
                                    <tr>
                                    <td class='first_td'><?=$j?></td>
                                    <td><?=$val['grn']?></td>
                                    <td><?=$val['po_no']?></td>	
                                	<td><?=$val['style_name']?></td>	
                                    <td><?=$val['store_name']?></td>
                                    <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                    <td><?=$val['total_qty']?></td>
                                    <td  class="text_right"><?=number_format($val['total_value'], 2, '.', ',')?></td>
                                   <!-- <td>
                                    	<?php
											$i=0;
                                        	if($val['total_qty'] < $val['full_total'])
											{
												$i=1;
												echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
											}
											else
												echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
										?>
                                    </td>-->
									<td  class="hide_class">
                                     <a href="<?php echo $this->config->item('base_url').'gen/view_gen/'.$val['gen_id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                    	<a style="display:none;" href="<?php echo $this->config->item('base_url').'gen/edit_gen/'.$val['gen_id']?>" data-toggle="tooltip" class="fa fa-edit tooltips" title="" data-original-title="Edit">&nbsp;</a>
                                       
                                    </td>
                                    </tr>
                                    <?php
									$j++;
									$count=$count+$val['full_total'];
									$total_value=$total_value+$val['total_value'];
								}
								?>
								 <tfoot>
                                    <tr  class='first_td'>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td><?=$count;?></td><td  class="text_right"><?=number_format($total_value, 2, '.', ',')?></td><td  class="hide_class"></td>
                                    </tr>
                                </tfoot>
								<?php
							}
							
						?>
                    </tbody>
                  </table>
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
	<script type="text/javascript">
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
			$().ready(function() {
				$("#po_no").autocomplete(BASE_URL+"gen/get_po_no_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
				$("#grn_no").autocomplete(BASE_URL+"gen/get_grn_no_list", {
					width: 260,
					autoFocus: true,
					matchContains: true,
					selectFirst: false
				});
			});
			$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"gen/search_result",
					  type:'GET',
					  data:{
						  	grn       :$('#grn_no').val(),
						  	po        :$('#po_no').val(),
						 	state     :$('#state').val(),
							style     :$('#style').val(),
							supplier  :$('#supplier').val(),
							supplier_name:$('#supplier').find('option:selected').text(),
							state_name:$('#state').find('option:selected').text(),
							from_date :$('#from_date').val(),
							to_date   :$('#to_date').val()
						   },
					  success:function(result){
						for_response(); 
						$('#result_div').html(result);
					  }    
				});
			});
		</script>