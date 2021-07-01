<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
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
                        <h4>View Goods Receive Note</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
          
            <div class="contentpanel">
            
          <input type="hidden"  value="<?=$gen_info[0]['gen_id']?>" id="grn_no_id"/>
           <input type="hidden" style="float:left" name="po_no" value="<?=$gen_info[0]['po_no']?>" id="po_no" autocomplete="off" style="width:150px"/>&nbsp;&nbsp;
            <br />
            <div  id='grn_html'>
            
            </div>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
					  url:BASE_URL+"gen/view_po2",
					  type:'GET',
					  data:{
						  po:$('#po_no').val(),
						  grn_no_id:$('#grn_no_id').val()
						   },
					  success:function(result){
						$('#grn_html').html(result);
					  }    
				});
		});
	
		
			$('#add_gen').live('click',function(){
				$('.color_class').each(function(){
					var color_id=$(this).val();
					var s_html=$(this).closest('tr').find('.s_size');	
					var s_id=$(this).closest('tr').find('.lot_class');	
					var style_id=$(this).closest('tr').find('.style_id').val();	
					$(s_html).each(function(){
						$(this).attr('name','size['+style_id+']['+s_id.val()+']['+color_id+']['+$(this).attr('id')+']');
					});		
				});
				
			});	

 
		
        $('#add_group').click(function(){
		 	$('#last_row').clone().appendTo('#app_table');  	
		 });
		  $(".remove_comments").live('click',function(){
			$(this).closest("tr").remove();
			var full_total=0;
			$('.total_qty').each(function(){
				full_total=full_total+Number($(this).val());
			});	
			$('.full_total').val(full_total);
			console.log(full_total);
		
	   });
	   	$('#state').live('change',function(){
				$.ajax({
					  url:BASE_URL+"gen/get_all_customet",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						  
						 $('#customer_td').html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.style_html');		 
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 s_html.html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.size_html');	
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id1",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						s_html.html(result);
					  }    
				});
		});
		$('.style_id').live('change',function(){
			var s_html=$(this).closest('tr').find('.mrp_html');		 
				$.ajax({
					  url:BASE_URL+"gen/get_all_style_details_by_id2",
					  type:'GET',
					  data:{
						  s_id:$(this).val()
						   },
					  success:function(result){
						 s_html.html(result);
					  }    
				});
		});
		$('.s_size').live('keyup',function(){
			
			var total=0;
			var full_total=0;
			
			var s_list=$(this).closest('tr').find('.s_size');	
			var s_total=$(this).closest('tr').find('.total_qty');
			var s_mrp=$(this).closest('tr').find('.total_mrp1').val();
			var s_net=$(this).closest('tr').find('.total_value');
			$(s_list).each(function(){
				total=total+Number($(this).val());
			});		
			console.log(Number(s_mrp) * total);
			s_total.val(total);
			s_net.val(Number(s_mrp) * total);
			$('.total_qty').each(function(){
				full_total=full_total+Number($(this).val());
			});	
			$('.full_total').val(full_total);
			total_value=0;
			$('.total_value').each(function(){
				total_value=total_value+Number($(this).val());
			});	
			$('.final_total').val(total_value);
			
			
		});

			
        </script>