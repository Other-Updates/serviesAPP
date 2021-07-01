<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?=$theme_path?>/js/custom.js"></script>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline search_table" style="display:none;">
	<tr>
    	<td width="10%">SO NO</td>
		<td width="10%">
        	<?php 
				if($search_data['po']!='')
					echo $search_data['po'];
				else
					echo "-";		
			?>
        </td>
        <td width="10%">State</td>
		<td width="10%">
        	<?php 
				if($search_data['state_name']!='Select')
					echo $search_data['state_name'];
				else
					echo "-";		
			?>
        </td>
    	<td width="10%">Supplier</td>
		<td width="10%">
        	<?php 
				if($search_data['customer_name']!='Select')
					echo $search_data['customer_name'];
				else
					echo "-";		
			?>
        </td>
        <td  width="10%">From&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['from_date']!='')
					echo $search_data['from_date'];
				else
					echo "-";	
			?>
        </td>
        <td  width="10%">To&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['to_date']!='')
					echo $search_data['to_date'];
				else
					echo "-";		
			?>
        </td>
    </tr>
</table>
  <table  id='basicTable' class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
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
            <td>Package Status</td>
            <td  class="hide_class">Action</td>
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
                    <td  >
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
                    <td class="hide_class">
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
                    <td ></td><td></td><td></td><td></td><td></td><td><?=$count;?></td><td  class="text_right"><?=number_format($net_value, 2, '.', ',')?></td><td  class="text_right"><?=number_format($net_final_total, 2, '.', ',')?></td><td></td>
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