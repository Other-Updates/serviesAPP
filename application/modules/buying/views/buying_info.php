<table width="100%" border="1" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
<thead>
	<tr>
    	<th>Lot No</th>
        <th>Item Code</th>
        <th>Style</th>
        <th>Color</th>
        <th>Desciption</th>
        <th>Fit</th>
        <th>MRP</th>
        <th>Landed Cost</th>
        <th>Available Material</th>
        <th>Consumption</th>
        <th>No of Pieces</th>
        <th>Landed Value</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php
	if(isset($buying_info) && !empty($buying_info))
	{
		foreach($buying_info as $val)
		{
			?>
            <tr>
                <td><?=$val['lot_no']?><input type="hidden" id='lot_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['lot_no']?>"/></td>
                <td><?=$val['item_code']?><input type="hidden" id='code_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['item_code']?>"/></td>
                <td><?=$val['style_name']?><input type="hidden" id='style_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['style_name']?>"/></td>
                <td><?=$val['colour']?><input type="hidden"  id='color_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value=" <?=$val['colour']?>"/></td>
                <td><input type="text" id='desc_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['description']?>"/></td>
                <td>
                <select name="fit_id" id='fit_<?=$val['id']?>'  class="form-control buying_<?=$val['id']?>"  style="width: 73px;" readonly="readonly" value="<?=$val['master_fit']?>" >
                    <?php 
                        if(isset($all_fit) && !empty($all_fit))
                        {
                            foreach($all_fit as $val1)
                            {
                                ?>
                                    <option <?=($val1['id']==$val['fit_id'])?'selected':''?>  value="<?=$val1['id']?>"><?=$val1['master_fit']?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                </td>
                <td><input type="text" id='mrp_<?=$val['id']?>' class="form-control buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['mrp']?>"/></td>
                <td><input type="text" id='lcost_<?=$val['id']?>' class="form-control lcost buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['landed_cost']?>"/></td>
                <td><input type="text" id='avail_<?=$val['id']?>' class="form-control avail buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['avail_material']?>"/></td>
                <td><input type="text" id='consum_<?=$val['id']?>' class="form-control consum buying_<?=$val['id']?>" style="width:70px;" readonly="readonly" value="<?=$val['consumption']?>"/></td>
                <td><input type="text" readonly="readonly" id='pieces_<?=$val['id']?>' class="form-control" style="width:70px;" readonly="readonly" value="<?=$val['pieces']?>"/></td>
                <td><input type="text"  readonly="readonly" id='lval_<?=$val['id']?>' class="form-control" style="width:70px;" readonly="readonly" value="<?=$val['landed_value']?>"/></td>
                <td width="10%">
                	<button class="btn btn-primary edit_btn" id='edit_<?=$val['id']?>'><span class="fa fa-edit"></span></button>
                    <button class="btn btn-success size_ok" style="display:none;float:left;" id='ok_<?=$val['id']?>'><span class="glyphicon glyphicon-ok"></span></button>
                     <button class="btn btn-warning size_remove" style="display:none;float:left;" id='remove_<?=$val['id']?>'><span class="glyphicon glyphicon-remove"></span></button>
                </td>
                
            </tr>
	   <?php
		}
	}
?>
</tbody>
</table>