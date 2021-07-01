<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">
			<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-exchange"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>PO vs GRN vs Sales Order Report</h4>
                    </div>
                    
                </div><!-- media -->
            </div>
              <div class="contentpanel">
            
            <table style="width:55%;margin:0 auto;" class="table table-striped table-bordered no-footer dtr-inline">
            	<tbody>
                <tr>
                	<td class="first_td1"  width="100">Style</td>
                    <td width="25%" >
                    <select id='style' class="form-control">
                        <option value="">Select</option>
                        <?php 
                            if(isset($style) && !empty($style))
                            {
                                foreach($style as $val)
                                {
                                    ?>
                                    <option value="<?=$val['id']?>"><?=$val['style_name']?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                    </td>
                    <td class="first_td1" style="display:none;"width="100">Color</td>
                    <td width="100" style="display:none;">
                    <select id='color'>
                    <option value="">Select</option>
                    <?php 
						if(isset($color) && !empty($color))
						{
							foreach($color as $val)
							{
								?>
                                <option value="<?=$val['id']?>"><?=$val['colour']?></option>
                                <?php
							}
						}
					?>
                    </select>
                    </td>                    
                    <td class="first_td1" width="100">PO NO</td>
                    <td><input type="text" name="po_no" id="po_no" autocomplete="off" class="form-control" style="width:150px"/>
                    <span id="pogrn_error" style="color:#F00;"></span></td>
                    <td><input type="button" value="Search" class='search_btn form-control btn btn-primary ' /></td>
                </tr>
            	</tbody>
            </table>
                 
                  <div id="result_div">
                  	
                  </div>         
          
            </div><!-- contentpanel -->
            
        </div><!-- mainpanel -->
    
  	<script type="text/javascript">
		$().ready(function() {
			$("#po_no").autocomplete(BASE_URL+"purchase_receipt/get_po_list", {
				width: 260,
				autoFocus: true,
				matchContains: true,
				selectFirst: false
			});
		});
		$('.search_btn').live('click',function(){
			var i=0;
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"purchase_receipt/po_grn_result1",
				  type:'GET',
				  data:{
						po          :$('#po_no').val(),
						style       :$('#style').val(),
						color       :$('#color').val()
					   },
				  success:function(result){
					for_response(); 
					$('#result_div').html(result);
				  }    
			});
		});
	 </script>
     <script>
      	$('.print_btn').live('click',function(){
			window.print();
		});
      </script>