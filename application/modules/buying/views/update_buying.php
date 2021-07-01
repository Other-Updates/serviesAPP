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
                        <h4>Update buying and sales plan</h4>
                    </div>
                </div><!-- media -->
                
            </div><!-- pageheader -->
            
            <div class="contentpanel">
              <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                   	 <td>Year</td>
                      <td>
                      		<select name="year" id='year' >
                            	<option value="">Select</option>
                                <?php 
									for($i=2010;$i<=2050;$i++)
									{
										?>
                                        	<option value="<?=$i?>" ><?=$i?></option>
                                        <?php
									}
								?>
                            </select>
                      		
 						                     
                      </td>
                      <td>Season</td>
                      <td>
                        <select name="season_id" id='season_id'>
                        	<option>Select</option>
                            <?php 
								if(isset($all_season) && !empty($all_season))
								{
									foreach($all_season as $val)
									{
										?>
											<option value="<?=$val['id']?>"><?=$val['season']?></option>
										<?php
									}
								}
							?>
                        </select>
                      	</td>
                    </tr>
                </table>
              </form>
            <div id='stock_details'></div>  
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script type="text/javascript">
        	$('#season_id').live('change',function(){
				 $.ajax({
					  url:BASE_URL+"buying/update_buying_details",
					  type:'GET',
					  data:{
						  	year:$('#year').val(),
							season_id:$('#season_id').val()
						   },
					  success:function(result){
						  $('#stock_details').html(result);
					  }    
				});
			});
			
			$('.edit_btn').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','block');
				$('#remove_'+data[1]).css('display','block');
				$('.buying_'+data[1]).removeAttr('readonly');
				$(this).hide();
			});
			$('.size_remove').live('click',function(){
				
				data=$(this).attr('id').split("_");
				$('#ok_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.buying_'+data[1]).attr('readonly','readonly');
			});
			$('.size_ok').live('click',function(){
				data=$(this).attr('id').split("_");
				$('#remove_'+data[1]).css('display','none');
				$(this).css('display','none');
				$('#edit_'+data[1]).css('display','block');
				$('.buying_'+data[1]).attr('readonly','readonly');
			});
        </script>  
        <script type="text/javascript">
			$('.avail').live('keyup',function(){
				var pieces=0;
				data=$(this).attr('id').split("_");
				var avail=Number($('#avail_'+data[1]).val());
				var consum=Number($('#consum_'+data[1]).val());
				console.log(avail);
				console.log(avail);
				if(consum>0)
				pieces=avail/consum;
				$('#pieces_'+data[1]).val(pieces.toFixed(0));
				l_val=pieces*Number($('#lcost_'+data[1]).val());
				$('#lval_'+data[1]).val(l_val.toFixed(0));
			});
			$('.consum').live('keyup',function(){
				var pieces=0;
				data=$(this).attr('id').split("_");
				var avail=Number($('#avail_'+data[1]).val());
				var consum=Number($('#consum_'+data[1]).val());
				console.log(avail);
				console.log(avail);
				if(consum>0)
				pieces=avail/consum;
				$('#pieces_'+data[1]).val(pieces.toFixed(0));
				l_val=pieces*Number($('#lcost_'+data[1]).val());
				$('#lval_'+data[1]).val(l_val.toFixed(0));
			});
			$('.lcost').live('keyup',function(){
				var pieces=0;
				data=$(this).attr('id').split("_");
				var avail=Number($('#avail_'+data[1]).val());
				var consum=Number($('#consum_'+data[1]).val());
				if(consum>0)
				pieces=avail/consum;
				$('#pieces_'+data[1]).val(pieces.toFixed(0));
				l_val=pieces*Number($(this).val());
				$('#lval_'+data[1]).val(l_val.toFixed(0));
			});
        </script>              