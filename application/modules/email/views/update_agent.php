 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="panel-body">
                            <div class="tabs">
                                <!-- Nav tabs -->
                                <ul class="list-inline tabs-nav tabsize-17" role="tablist">
                                    
                                    <li role="presentation" class="active"><a href="#update-field" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update Field Agent</a></li>
                                 </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                               
                                    <div role="tabpanel" class="tab-pane active" id="update-field">
                                     <h4 align="center" class="sup-align">Update Field Agent</h4>
                                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url').'agent/update_agent'; ?>"> 
<table class="table table-striped  responsive no-footer dtr-inline">
<?php
if(isset($agent) && !empty($agent))
{   
	$i=0;
foreach($agent as $val)
{ 
$i++
?>
  <tr>
    <td>Name</td>
    <td>
        <input type="text" name="name" id="name"  class="name form-control form-align" value="<?=$val['name']?>" />
        <input type="hidden" name="id" class="id id_dup form-control" readonly="readonly" value="<?php echo $val['id'];?>" />
        <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td>City</td>
    <td>
        <input type="text" name="city" id="city"  class="form-control form-align" value="<?=$val['city']?>" />
        <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   <td>Account No</td>
   <td>
        <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?=$val['account_num']?>" />
        <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Mobile Number</td>
    <td>
        <input type="text" name="number" class="mobile form-control form-align" id="mobile" value="<?=$val['mobil_number']?>" />
        <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Pin Code</td>
    <td>
        <input type="text" name="pin" id="pincode"  class="form-control form-align" value="<?=$val['pincode']?>" />
        <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   
    <td>Bank Name</td>
    <td>
        <input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?=$val['bank_name']?>" />
        <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Email Id</td>
    <td>
        <input type="text" name="mail" class="mail up_mail_dup form-control form-align" id="mail" value="<?=$val['email_id']?>" />
        <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
        <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td>IFSC Code </td>
    <td>
        <input type="text" name="ifsc" class="form-control form-align" id="" value="<?=$val['ifsc']?>" />
    </td>
    
    <td>Bank Branch</td>
    <td>
        <input type="text" name="branch" class="form-control form-align" id="branch" value="<?=$val['bank_branch']?>" />
        <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Address1</td>
    <td>
        <textarea  name='address1' id="address" class="form-control form-align"><?=$val['address1']?></textarea>
                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Address2</td>
        <td>
            <textarea  name='address2' id="address" class="form-control form-align"><?=$val['address2']?></textarea>
       </td>
  </tr>
  <?php
 	}
 }
?>
</table>
		<!--<table class="table table-striped table-bordered no-footer dtr-inline" >
        <?php
				if(isset($agent) && !empty($agent))
				{   
					$i=0;
				foreach($agent as $val)
				{ 
				$i++
				?>
                <tr>
                <td><strong>Name</strong></td>               
                <td><input type="text" name="name" id="name"  class="name form-control" value="<?=$val['name']?>" />
                <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span></td>
				<input type="hidden" name="id" class="id id_dup form-control" readonly="readonly" value="<?php echo $val['id'];?>" />
                <td><strong>Address1</strong></td>        
                <td><textarea  name='address1' id="address" class="form-control"><?=$val['address1']?></textarea>
                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>Address2</strong></td>        
                <td><textarea  name='address2' id="address" class="form-control"><?=$val['address2']?></textarea></td>
                </tr>
                <tr>
                <td><strong>City</strong></td>               
                <td><input type="text" name="city" id="city"  class="form-control" value="<?=$val['city']?>" />
                <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>Pin Code</strong></td>        
                <td><input type="text" name="pin" id="pincode"  class="form-control" value="<?=$val['pincode']?>" />
                <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>Mobile Number</strong></td>
                <td><input type="text" name="number" class="mobile form-control" id="mobile" value="<?=$val['mobil_number']?>" />
                <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span></td> 
                </tr>
                <tr>
                <td><strong>Email Id</strong></td>        
                <td><input type="text" name="mail" class="mail up_mail_dup form-control" id="mail" value="<?=$val['email_id']?>" />
                <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>Bank Name</strong></td>        
                <td><input type="text" name="bank" class="bank form-control" id="bank" value="<?=$val['bank_name']?>" />
                <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td><strong>Bank Branch</strong></td>        
                <td><input type="text" name="branch" class="form-control" id="branch" value="<?=$val['bank_branch']?>" />
                <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <tr>
                <td><strong>IFSC Code</strong></td>
                <td><input type="text" name="ifsc" class="form-control" id="" value="<?=$val['ifsc']?>" /></td>
                <td><strong>Account No</strong></td>        
                <td><input type="text" name="acnum" class="form-control" id="acnum" value="<?=$val['account_num']?>" />
                <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                <td></td>
                <td></td>
                </tr>
           </table>
                  
                <?php
				 }}
				?>-->
        <div class="frameset_table action-btn-align">
        <table>
            <tr>
            <td width="570">&nbsp;</td>
            <td><input type="submit" value="Update" class="submit btn btn-info" id="edit" /></td>
            <td>&nbsp;</td>
            <td><input type="reset" value="Clear" class="submit btn btn-danger " id="reset" /></td>
            <td>&nbsp;</td>
           <td><input type="button" value="Back" class="btn btn-defaultback" onclick="history.go(-1);return true;" autocomplete="off"></td>
            </tr> 
        </table>
        </div>
	</form>
                                    </div>
                                    
                                    

                                </div>


   </div>
</div>
<script type="text/javascript">
$("#name").live('blur',function()
{
	var name=$("#name").val();
	var filter= /^[a-zA-Z.\s]{3,30}$/;
	if(name=="" || name==null || name.trim().length==0)
	{
		$("#cuserror1").html("Required Field");
	}
	else if(!filter.test(name))
	{
		$("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
	}
	else
	{
		$("#cuserror1").html("");
	}
});
$("#store").live('blur',function()
{
	var store=$("#store").val();
	if(store=="" || store==null || store.trim().length==0)
	{
		$("#cuserror2").html("Required Field");
	}
	else
	{
		$("#cuserror2").html("");
	}
});
$('#address').live('blur',function()
{
	var address=$('#address').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#cuserror3').html("Enter Address");
	}
	else
	{
		$('#cuserror3').html("");
	}
});
$("#mobile").live('blur',function()
{
	var number=$("#mobile").val();
	var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
	if(number=="")
	{
		$("#cuserror4").html("Required Field");
	}
	else if(!nfilter.test(number))
	{
		$("#cuserror4").html("Enter Valid Mobile Number");
	}
	else
	{
		$("#cuserror4").html("");
	}
});
$("#mail").live('blur',function()
{
	var mail=$("#mail").val();
	var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if(mail=="")
	{
		$("#cuserror5").html("Required Field");
	}
	else if(!efilter.test(mail))
	{
		$("#cuserror5").html("Enter Valid Email");
	}
	else
	{
		$("#cuserror5").html("");
	}
});
$('#bank').live('blur',function()
{
	var bank=$('#bank').val();
	if(bank=="" || bank==null || bank.trim().length==0)
	{
		$('#cuserror6').html("Enter Details");
	}
	else
	{
		$('#cuserror6').html("");
	}
});
$('#percent').live('blur',function()
{
	var percentage=$('#percent').val();
	var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
	if(percentage=="" || percentage==null || percentage.trim().length==0)
	{
		$('#cuserror7').html("Required Field");
	}
	else if(!pefilter.test(percentage))
	{
		$("#cuserror7").html("Enter Valid Percentage");
	}
	else
	{
		$('#cuserror7').html("");
	}
});
$('#city').live('blur',function()
{
	var city=$('#city').val();
	if(city=="")
	{
		$('#cuserror8').html("Required Field");
	}
	else
	{
		$('#cuserror8').html("");
	}
});
$("#pincode").live('blur',function()
{
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#cuserror9").html("Required Field");
	}
	else if (pincode.length!=6) 
    {
	    $("#cuserror9").html("Maximum 6 characters");	
    }
	else
	{
		$("#cuserror9").html("");
	}
});
$("#branch").live('blur',function()
{
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#cuserror10").html("Required Field");
	}
	else
	{
		$("#cuserror10").html("");
	}
});
$("#acnum").live('blur',function()
{
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#cuserror11").html("Required Field");
	}
	else if(!acfilter.test(acnum))
	{
		$("#cuserror11").html("Numeric or Alphanumeric");
	}
	else
	{
		$("#cuserror11").html("");
	}
});
</script>
<script type="text/javascript">
$('#edit').live('click',function()
{
	var i=0;
		var name=$("#name").val();
	var filter= /^[a-zA-Z.\s]{3,30}$/;
	if(name=="" || name==null || name.trim().length==0)
	{
		$("#cuserror1").html("Required Field");
		i=1;
	}
	else if(!filter.test(name))
	{
		$("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
		i=1;
	}
	else
	{
		$("#cuserror1").html("");
	}
	
	var address=$('#address').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#cuserror3').html("Enter Address");
		i=1;
	}
	else
	{
		$('#cuserror3').html("");
	}
	var number=$("#mobile").val();
	var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
	if(number=="")
	{
		$("#cuserror4").html("Required Field");
		i=1;
	}
	else if(!nfilter.test(number))
	{
		$("#cuserror4").html("Enter Valid Mobile Number");
		i=1;
	}
	else
	{
		$("#cuserror4").html("");
	}
	var mail=$("#mail").val();
	var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if(mail=="")
	{
		$("#cuserror5").html("Required Field");
		i=1;
	}
	else if(!efilter.test(mail))
	{
		$("#cuserror5").html("Enter Valid Email");
		i=1;
	}
	else
	{
		$("#cuserror5").html("");
	}
	var bank=$('#bank').val();
	if(bank=="" || bank==null || bank.trim().length==0)
	{
		$('#cuserror6').html("Enter Details");
		i=1;
	}
	else
	{
		$('#cuserror6').html("");
	}
	
	var city=$('#city').val();
	if(city=="")
	{
		$('#cuserror8').html("Required Field");
		i=1;
	}
	else
	{
		$('#cuserror8').html("");
	}
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#cuserror9").html("Required Field");
		i=1;
	}
	else if (pincode.length!=6) 
    {
	    $("#cuserror9").html("Maximum 6 characters");
		i=1;	
    }
	else
	{
		$("#cuserror9").html("");
	}
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#cuserror10").html("Required Field");
		i=1;
	}
	else
	{
		$("#cuserror10").html("");
	}
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#cuserror11").html("Required Field");
		i=1;
	}
	else if(!acfilter.test(acnum))
	{
		$("#cuserror11").html("Numeric or Alphanumeric");
		i=1;
	}
	else
	{
		$("#cuserror11").html("");
	}
	var mess=$("#upduplica").html();
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
$('#reset').live('click',function()
{
	$('.val').html("");
});
</script>
 <script>
 $("#mail").live('blur',function()
  			{
			 mail=$("#mail").val();
			 id=$('.id').val();
		   
		 $.ajax(
		 {
		  url:BASE_URL+"agent/update_duplicate_email",
		  type:'POST',
		   data:{ value1:mail,value2:id},
		  success:function(result)
		  {
		      $("#upduplica").html(result);
		  }    		
		});
   }); 
   </script> 
