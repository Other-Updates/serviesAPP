 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="media">
 	<h4>Update Supplier</h4>
 </div>
<div class="panel-body">
                            <div class="tabs">
                                <!-- Nav tabs -->
                                <ul class="list-inline tabs-nav tabsize-17" role="tablist">
                                    
                                    <li role="presentation" class="active"><a href="#update-supplier" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>
                                 </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabbor">
                               
                                    <div role="tabpanel" class="tab-pane active" id="update-supplier">
                                    <!-- <h4 align="center" class="sup-align">Update Supplier</h4>-->
                                        <form  method="post"  name="form1" action="<?php echo $this->config->item('base_url').'vendor/update_vendor'; ?>"> 
<?php
				if(isset($vendor) && !empty($vendor))
				{
					$i=0;
				foreach($vendor as $val)
				{
				$i++
				?>
<table  align="center" class="table table-striped responsive no-footer dtr-inline">
  <tr>
    <td>State<input type="hidden" name="id" readonly="readonly" class="id form-control" value="<?php echo $val['id'];?>" /> </td>
    <td>
    	 <select id="state_id" name='state_id' class="state_id form-control form-align">
            <option value="">Select</option>
            <?php 
            if(isset($all_state) && !empty($all_state)){
            foreach($all_state as $bill)
            {
            ?>
             <option <?=($bill['id']==$vendor[0]['state_id'])?'selected':''?> value="<?=$bill['id']?>"><?=$bill['state']?></option>
            <?php 
            }
            }
            ?>
         </select>
         <span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>City</td>
    <td>
    	<input type="text" name="city" class="form-control form-align" id="city" value="<?=$val['city']?>" />
        <span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Account No</td>
    <td>
    	<input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?=$val['account_num']?>" />
                 <span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Company Name</td>
    <td>
    	<input type="text" name="store" class="store form-control form-align" id="store" value="<?=$val['store_name']?>" />
        <span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td>Mobile Number</td>
    <td>
    	<input type="text" name="number" class="mobile form-control form-align" id="mobile" value="<?=$val['mobil_number']?>" />
        <span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   
    <td>Bank Name</td>
    <td>
    	<input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?=$val['bank_name']?>" />
        <span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Contact Person</td>
    <td>
    	<input type="text" name="name" id="name"  class="name form-control form-align" value="<?=$val['name']?>" />
        <span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Payment Terms</td>
    <td><input type="text" name="payment_terms" class="mobile form-control form-align" id="payment_terms" value="<?=$val['payment_terms']?>" />
     <span id="superror11" class="val"  style="color:#F00; font-style:oblique;"></span></td>
    
    <td>Bank Branch</td>
    <td>
    	<input type="text" name="branch" class="form-control form-align" id="branch" value="<?=$val['bank_branch']?>" />
        <span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Email Id</td>
    <td>
    	<input type="text" name="mail" class="mail form-control form-align" id="mail" value="<?=$val['email_id']?>" />
        <span id="superror5" class="val"  style="color:#F00; font-style:oblique;"></span>
        <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Pin Code</td>
    <td>
    	<input type="text" name="pin" class="form-control form-align" id="pincode" value="<?=$val['pincode']?>" />
        <span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>IFSC Code</td>
    <td><input type="text" name="ifsc" class="form-control form-align" id="" value="<?=$val['ifsc']?>" /></td>
  </tr>
  <tr>
    <td>Address1</td>
    <td>
    	<textarea  name='address1' id="address" class="form-control form-align"><?=$val['address1']?></textarea>
        <span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Address2</td>
    <td><textarea  name='address2' id="" class="form-control form-align"><?=$val['address2']?></textarea></td>
    <td>Tin / Vat No</td>
    <td>
    	<input type="text" name="tin" class="mobile form-control form-align" id="tin" value="<?=$val['tin']?>" />
        <span id="superror12" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
</table>
                
                
                
		<!--<table  align="center" class="table table-striped table-bordered responsive no-footer dtr-inline">
                <tr>
              
                 <td><strong>State</strong></td> 
                 <td>
            <select id="state_id" name='state_id' class="state_id form-control" style="width:139px" >
            <option value="">Select</option>
            <?php 
            if(isset($all_state) && !empty($all_state)){
            foreach($all_state as $bill)
            {
            ?>
             <option <?=($bill['id']==$vendor[0]['state_id'])?'selected':''?> value="<?=$bill['id']?>"><?=$bill['state']?></option>
            <?php 
            }
            }
            ?>
            </select><span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>
        </td>     
        <td><strong>Bank Branch</strong></td>        
                 <td><input type="text" name="branch" class="form-control" id="branch" value="<?=$val['bank_branch']?>" />
                 <span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span></td>  
                <td><strong>Contact Person</strong></td>               
                <td><input type="text" name="name" id="name"  class="name form-control" value="<?=$val['name']?>" />
                <span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                </tr>
                 <tr>
                <td><strong>Company Name</strong></td>               
                <td><input type="text" name="store" class="store form-control" id="store" value="<?=$val['store_name']?>" />
                <span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                 <td><strong>Account No</strong></td>        
                 <td><input type="text" name="acnum" class="" id="acnum" value="<?=$val['account_num']?>" />
                 <span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>City</strong></td>               
                <td><input type="text" name="city" class="form-control" id="city" value="<?=$val['city']?>" />
                 <span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                 
                </tr>
               
                <tr>
                 <td><strong>Address1</strong></td>        
                 <td><textarea  name='address1' id="address" class="form-control"><?=$val['address1']?></textarea>
                 <span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                 <td><strong>Address2</strong></td>        
                 <td><textarea  name='address2' id="" class="form-control"><?=$val['address2']?></textarea></td>
                 <td><strong>Bank Name</strong></td>        
                 <td><input type="text" name="bank" class="bank form-control" id="bank" value="<?=$val['bank_name']?>" />
                 <span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                </tr>
                <tr>
                <td><strong>Pin Code</strong></td>               
                <td><input type="text" name="pin" class="form-control" id="pincode" value="<?=$val['pincode']?>" />
                 <span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                 <td><strong>Mobile Number</strong></td>        
                <td><input type="text" name="number" class="mobile form-control" id="mobile" value="<?=$val['mobil_number']?>" />
                <span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td></td>
                 <td></td>
                </tr>
                <tr>
                 <td><strong>Email Id</strong></td>        
                <td><input type="text" name="mail" class="mail form-control" id="mail" value="<?=$val['email_id']?>" />
                <span id="superror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>IFSC Code</strong></td>
                 <td><input type="text" name="ifsc" class="form-control" id="" value="<?=$val['ifsc']?>" /></td>
                 
                 <td></td>
                 <td></td>
                 </tr>
                 
                 <?php /*?><td>Selling %</td>        
                <td><input type="text" name="percentage" class="percent" id="percent" value="<?=$val['selling_percent']?>" /><span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span></td><?php */?>
                
                
                 
                 
                 </table>-->
<div class="frameset_table action-btn-align">
<table>
<tr>
<td width="570">&nbsp;</td>
<td><input type="submit" value="Update" class="submit btn btn-info right" id="edit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class="btn btn-danger right" id="reset" /></td>
<td>&nbsp;</td>
<td><a href="<?php echo $this->config->item('base_url').'vendor/'?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
<td>&nbsp;</td>
</tr> 
</table>
</div>
<?php
				 }}
				?>

</div>
</div>
</form>
                                    </div>
                                    
                                    

                                </div>
                            </div>
                        </div>






<script type="text/javascript">
$('#reset').live('click',function(){
	$('.val').html("");
});



$('#state_id').live('blur',function()
{
	var state=$('#state_id').val();
	if(state=="")
	{
		$('#superror').html("Select State");
	}
	else
	{
		$('#superror').html("");
	}
});
$("#name").live('blur',function()
{
	var name=$("#name").val();
	var filter= /^[a-zA-Z.\s]{3,30}$/;
	if(name=="" || name==null || name.trim().length==0)
	{
		$("#superror1").html("Required Field");
	}
	else if(!filter.test(name))
	{
		$("#superror1").html("Alphabets and Min 3 to Max 30 ");
	}
	else
	{
		$("#superror1").html("");
	}
});
$("#store").live('blur',function()
{
	var store=$("#store").val();
	if(store=="" || store==null || store.trim().length==0)
	{
		$("#superror2").html("Required Field");
	}
	else
	{
		$("#superror2").html("");
	}
});
$('#address').live('blur',function()
{
	var address=$('#address').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#superror3').html("Enter Address");
	}
	else
	{
		$('#superror3').html("");
	}
});
$("#mobile").live('blur',function()
{
	var number=$("#mobile").val();
	var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
	if(number=="")
	{
		$("#superror4").html("Required Field");
	}
	else if(!nfilter.test(number))
	{
		$("#superror4").html("Enter valid Mobile Number");
	}
	else
	{
		$("#superror4").html("");
	}
});
$("#mail").live('blur',function()
{
	var mail=$("#mail").val();
	var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if(mail=="")
	{
		$("#superror5").html("Required Field");
	}
	else if(!efilter.test(mail))
	{
		$("#superror5").html("Enter Valid Email");
	}
	else
	{
		$("#superror5").html("");
	}
});
$('#bank').live('blur',function()
{
	var bank=$('#bank').val();
	if(bank=="" || bank==null || bank.trim().length==0)
	{
		$('#superror6').html("Enter Details");
	}
	else
	{
		$('#superror6').html("");
	}
});
$('#city').live('blur',function()
{
	var city=$('#city').val();
	if(city=="" || city==null || city.trim().length==0)
	{
		$('#superror7').html("Required Field");
	}
	else
	{
		$('#superror7').html("");
	}
});
$("#pincode").live('blur',function()
{
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#superror8").html("Required Field");
	}
	else if (pincode.length!=6) 
    {
	    $("#superror8").html("Maximum 6 Numbers");	
    }
	else
	{
		$("#superror8").html("");
	}
});
$("#branch").live('blur',function()
{
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#superror9").html("Required Field");
	}
	else
	{
		$("#superror9").html("");
	}
});
$("#acnum").live('blur',function()
{
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#superror10").html("Required Field");
	}
	else if(!acfilter.test(acnum))
	{
		$("#superror10").html("Numeric or Alphanumeric");
	}
	else
	{
		$("#superror10").html("");
	}
});
$("#payment_terms").live('blur',function()
{
	var payment_terms=$("#payment_terms").val();
	
	if(payment_terms=="")
	{
		$("#superror11").html("Required Field");
	}
	
	else
	{
		$("#superror11").html("");
	}
});
$('#tin').live('blur',function()
{
	var tin=$('#tin').val();
	if(tin=="" || tin==null || tin.trim().length==0)
	{
		$('#superror12').html("Required Field");
	}
	else
	{
		$('#superror12').html("");
	}
});
</script>
<script type="text/javascript">
$('#edit').live('click',function()
{
	var i=0;
	var state=$('#state_id').val();
	if(state=="")
	{
		$('#superror').html("Select State");
		i=1;
	}
	else
	{
		$('#superror').html("");
	}
	var name=$("#name").val();
	var filter= /^[a-zA-Z.\s]{3,30}$/;
	if(name=="" || name==null || name.trim().length==0)
	{
		$("#superror1").html("Required Field");
		i=1;
	}
	else if(!filter.test(name))
	{
		$("#superror1").html("Alphabets and Min 3 to Max 30 ");
		i=1;
	}
	else
	{
		$("#superror1").html("");
	}
	var store=$("#store").val();
	if(store=="" || store==null || store.trim().length==0)
	{
		$("#superror2").html("Required Field");
		i=1;
	}
	else
	{
		$("#superror2").html("");
	}
	var address=$('#address').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#superror3').html("Enter Address");
		i=1;
	}
	else
	{
		$('#superror3').html("");
	}
	var number=$("#mobile").val();
	var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
	if(number=="")
	{
		$("#superror4").html("Required Field");
		i=1;
	}
	else if(!nfilter.test(number))
	{
		$("#superror4").html("Enter Valid Mobile Number");
		i=1;
	}
	else
	{
		$("#superror4").html("");
	}
	var mail=$("#mail").val();
	var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if(mail=="")
	{
		$("#superror5").html("Required Field");
		i=1;
	}
	else if(!efilter.test(mail))
	{
		$("#superror5").html("Enter Valid Email");
		i=1;
	}
	else
	{
		$("#superror5").html("");
	}
	var bank=$('#bank').val();
	if(bank=="" || bank==null || bank.trim().length==0)
	{
		$('#superror6').html("Enter Details");
		i=1;
	}
	else
	{
		$('#superror6').html("");
	}
	var city=$('#city').val();
	if(city=="" || city==null || city.trim().length==0)
	{
		$('#superror7').html("Required Field");
		i=1;
	}
	else
	{
		$('#superror7').html("");
	}
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#superror8").html("Required Field");
		i=1;
	}
	else if (pincode.length!=6) 
    {
	    $("#superror8").html("Maximum 6 Numbers");
		i=1;	
    }
	else
	{
		$("#superror8").html("");
	}
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#superror9").html("Required Field");
		i=1;
	}
	else
	{
		$("#superror9").html("");
	}
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#superror10").html("Required Field");
		i=1;
	}
	else if(!acfilter.test(acnum))
	{
		$("#superror10").html("Numeric or Alphanumeric");
		i=1;
	}
	else
	{
		$("#superror10").html("");
	}
	var payment_terms=$("#payment_terms").val();
	
	if(payment_terms=="")
	{
		$("#superror11").html("Required Field");
		i=1;
	}	
	else
	{
		$("#superror11").html("");
	}
	var tin=$('#tin').val();
	if(tin=="" || tin==null || tin.trim().length==0)
	{
		$('#superror12').html("Required Field");
		i=1;
	}
	else
	{
		$('#superror12').html("");
	}
	var mess=$('#upduplica').html();
	if((mess.trim()).length>0)
	{
		i=1;
	}
	if(i==1)
	{
		return false;
	}
	else
	{
		return true;
	}
	
});
</script>
<script type="text/javascript">
$(".mail").live('blur',function()
  			{
			
			 mail=$("#mail").val();
			 id=$('.id').val();
		   
		 $.ajax(
		 {
		  url:BASE_URL+"vendor/update_duplicate_mail",
		  type:'POST',
		   data:{ value1:mail,value2:id},
		  success:function(result)
		  {
		      $("#upduplica").html(result);
		  }    		
		});
   }); 
   </script>