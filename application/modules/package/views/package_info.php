<br />
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
	<thead>
        <tr>
            <th>Carton No</th>
            <th>Color</th>
            <th>Size</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php 
		//echo '<pre>';
		//print_r($package);
		if(isset($package) && !empty($package))
		{
			$full_total=0;
			foreach($package as $val)
			{
				echo "<tr><th style='text-align:left;' colspan='4'>".$val['style_name']."</th></tr>";
				
				foreach($val['style_color'] as $val1)
				{
					$total_p=0;
					foreach($val1['size'] as $val2)
					{
						$total_p=$total_p+$val2['total_qty'];
					}
					if($total_p==0)
						continue;
					?>
                    <tr>
                    	<td class="cor_class">
                        	<select class="cort_class class_req hcheck_<?=$val['style_id']?>_<?=$val1['color_id']?>" name='corton[]'>
                            	<option>Select</option>	
                            </select>
                           
                        </td>
                    	<td>
							<?=$val1['colour']?>
                        	<input type="hidden" name='style[]' class="sty_class" value="<?=$val['style_id']?>" />
                            <input type="hidden" name='color[]' class="col_class"value="<?=$val1['color_id']?>" />
                        </td>
                        <td>
                        	<?php
							$total=0;
                            	foreach($val1['size'] as $val2)
								{
									$total=$total+$val2['total_qty'];
									?>
                                    <input type="hidden" class='ccheck_<?=$val['style_id']?>_<?=$val1['color_id']?>_<?=$val2['size_id']?> avail-<?=$val['style_id']?>-<?=$val1['color_id']?>-<?=$val2['size_id']?>' value="<?=$val2['total_qty']?>"/>
                                    <div  style="border: 1px solid rgb(181, 181, 181);text-align: center;float: left;width: 62px;" >
                                        <p  style="padding-left:10px;"  ><?=$val2['size']?> <span class="hide_val" style="color:green;font-weight: bold;">( <?=$val2['total_qty']?> ) </span></p>
                                        <p   style="margin: 0 0 0px;">
                                        <input type="text" class='form-control size_val check_<?=$val['style_id']?>_<?=$val1['color_id']?>_<?=$val2['size_id']?> <?=$val['style_id']?>-<?=$val1['color_id']?>-<?=$val2['size_id']?>' />
                                        <input type="hidden" class='form-control size_name' value="<?=$val2['size_id']?>"/>    
                                        </p>
                                    </div>
                                    <?php
								}
								$full_total=$full_total+$total;
							?>
                        </td>
                        <td>
                        	
							<span class='single_val'><?=$total?></span>
                            <input type="button" value="+" title="Add row"  class="btn btn-primary add_group" />
                            <span  class='hide_remove' style="display:none;">
                            	<input type="button" value="-" title="Remove row"  class="btn btn-warning remove_group" />
                            </span>
                        </td>
                        
                    </tr>
                    <?php
				}
			}
			echo "<tr><td  style='text-align:right;' colspan='3'>Total</td><td>".$full_total."</td><input type='hidden' name='package[total_qty]' value=".$full_total." /></tr></tbody>";
		}
		else
		{
			echo "<tr><td colspan='4'>Sales Order Not Created Yet....</td></tr></tbody>";
		}
	?>
   
</table> 
 <?php 
		if(isset($package) && !empty($package))
		{
			?> 
 			<input type="submit" class="btn btn-default" id='add_package' style="float:right;" value="Create" /><br />
<?php }?>            
            