<?php 
//echo '<pre>';
//print_r($po_info);
if($from==1)
{
	$bal=$po_info['total_amount']-($po_info['paid_amt'][0]['total_dis']+$po_info['paid_amt'][0]['total_paid'])
?>
<?php 
			if(isset($pay_from) && !empty($pay_from))
			{
				$name=$po_info['store_name'];
				$pay='payment';
			}
			else
			{
				$name=$company_details[0]['company_name'];
				$pay='purchase';	
			}
		?>
<table>
	<tr>
    	<td>Hi <?=$name?>,</td>
    </tr>
    <tr>
    	<td style="line-height: 27px;">
        
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=date('d-M-Y',strtotime($po_info['due_date']))?> is the due date for <?=$pay?> receipt [ <?=$po_info['receipt_no']?> ].<br />
            You have pay RS :<span style="color:red;"><b><?=number_format($bal, 2, '.', ',')?></b></span>
        </td>
    </tr>
</table>
<?php }?>
<?php 
if($from==2)
{
	$bal=$po_info['total_amount']-($po_info['paid_amt'][0]['total_dis']+$po_info['paid_amt'][0]['total_paid']);
	if(isset($pay_from) && !empty($pay_from))
	{
		$name=$po_info['store_name'];
		$pay='payment';
	}
	else
	{
		$name=$company_details[0]['company_name'];
		$pay='purchase';	
	}
?>

<table>
	<tr>
    	<td>Hi <?=$name?>,</td>
    </tr>
    <tr>
    	<td  style="line-height: 27px;">
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Today is the due date for <?=$pay?> receipt [ <?=$po_info['receipt_no']?> ].<br />
            You have pay RS :<span style="color:red;"><b><?=number_format($bal, 2, '.', ',')?></b></span>
        </td>
    </tr>
</table>
<?php }?>