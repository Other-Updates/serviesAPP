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
                        <h4>Add buying and sales plan</h4>
                    </div>
                </div><!-- media -->
                
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            <?php 
				if(isset($_GET['send']) && !empty($_GET['send']))
				{
			?>
                <div class="alert alert-success">
                    <a href="<?=$this->config->item('base_url').'buying/add_buying'?>" class="alert-link close">×</a>
                   	Record inserted successfully.
                </div>
            <?php }?>
            <form method="post">
              <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                	<tr>
                   	  <td width="10%">Lot No</td>
                      <td width="10%"><input name="lot_no" type="text" /></td>
                      <td width="10%">Year</td>
                      <td width="10%">
                      		<select name="year" >
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
                      <td width="10%">Season</td>
                      <td width="10%">
                        <select name="season_id">
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
                        <td width="10%">Period</td>
                        <td>
                        <select name="from_month" >
                            	<option value="">From</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <select name="to_month" >
                            	<option value="">To</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  <tr>
                    <td>Item Code</td>
                    <td><input name="item_code" type="text" /></td>
                  </tr>
                  <tr>
                    <td>Style </td>
                    <td>
                    	<select name="style_id" style="width: 173px;">
                        	<option>Select</option>
                             <?php 
								if(isset($all_style) && !empty($all_style))
								{
									foreach($all_style as $val)
									{
										?>
											<option value="<?=$val['id']?>"><?=$val['style_name']?></option>
										<?php
									}
								}
							?>
                        </select>	
                    </td>
                  </tr>
                  <tr>
                    <td>Color </td>
                    <td> 
                    	<select name="color_id"  style="width: 173px;">
                        	<option>Select</option>
                            <?php 
								if(isset($all_color) && !empty($all_color))
								{
									foreach($all_color as $val)
									{
										?>
											<option value="<?=$val['id']?>"><?=$val['colour']?></option>
										<?php
									}
								}
							?>
                        </select>	
                    </td>
                  </tr>
                  <tr>
                    <td>Desciption </td>
                    <td><input type="text" name="description" /> </td>
                  </tr>
                  <tr>
                    <td>Fit </td>
                    <td>
                    	<select name="fit_id"  style="width: 173px;">
                        	<option>Select</option>
                             <?php 
								if(isset($all_fit) && !empty($all_fit))
								{
									foreach($all_fit as $val)
									{
										?>
											<option value="<?=$val['id']?>"><?=$val['master_fit']?></option>
										<?php
									}
								}
							?>
                        </select>
                  	 </td>
                  </tr>
                  <tr>
                    <td>MRP </td>
                    <td> <input type="text" autocomplete="off" name="mrp"/></td>
                  </tr>
                  <tr>
                    <td>Landed Cost</td>
                    <td><input type="text" autocomplete="off"name="landed_cost" id='l_cost'/></td>
                  </tr>
                  <tr>
                    <td>Available Material</td>
                    <td><input type="text" autocomplete="off" name="avail_material" id='avail'/></td>
                  </tr>
                  <tr>
                    <td>Consumption</td>
                    <td><input type="text" autocomplete="off" name="consumption"  id='comsum'/></td>
                  </tr>
                  <tr>
                    <td>No of Pieces</td>
                    <td><input type="text" readonly="readonly" name="pieces"  id='pieces'/></td>
                  </tr>
                  <tr>
                    <td>Landed Value</td>
                    <td><input type="text" readonly="readonly"  name="landed_value" id='l_val'/></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="submit" class="btn btn-success" value="ADD" />&nbsp; <button type="reset" class="btn btn-warning">CANCEL</button></td>
                  </tr>
                </table>
              </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
 		<script type="text/javascript">
			$('#avail,#comsum').live('keyup',function(){
				var pieces=0;
				var avail=Number($('#avail').val());
				var consum=Number($('#comsum').val());
				if(consum>0)
				pieces=avail/consum;
				$('#pieces').val(pieces.toFixed(0));
				l_val=pieces*Number($('#l_cost').val());
				$('#l_val').val(l_val.toFixed(0));
			});
			$('#l_cost').live('keyup',function(){
				var pieces=0;
				var avail=Number($('#avail').val());
				var consum=Number($('#comsum').val());
				if(consum>0)
				pieces=avail/consum;
				$('#pieces').val(pieces.toFixed(0));
				l_val=pieces*Number($(this).val());
				$('#l_val').val(l_val.toFixed(0));
			});
        </script>        