<?php 
if($from==1)
{
?>
<table>
	<tr>
    	<td>Hi <?=$po_info['store_name']?>,</td>
    </tr>
    <tr>
    	<td>
        	<?=$po_info['delivery_schedule']?> is the delivery date for purchase order [ <?=$po_info['grn_no']?> ].
        </td>
    </tr>
</table>
<?php }?>
<?php 
if($from==2)
{
?>
<table>
	<tr>
    	<td>Hi <?=$po_info['store_name']?>,</td>
    </tr>
    <tr>
    	<td>
        	Purchase order [ <?=$po_info['grn_no']?> ] will expire within 2 days [ <?=$po_info['delivery_schedule']?> ].
        </td>
    </tr>
</table>
<?php }?>
<?php 
if($from==3)
{
?>
<table>
	<tr>
    	<td>Hi <?=$po_info['store_name']?>,</td>
    </tr>
    <tr>
    	<td>
        	Purchase order [ <?=$po_info['grn_no']?> ] was expired.
        </td>
    </tr>
</table>
<?php }?>