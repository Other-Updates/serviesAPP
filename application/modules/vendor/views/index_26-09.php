 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>

<div class="contentpanel">
<div class="media">
 	<h4>Supplier Details</h4>
 </div>
	<div class="panel-body">
                            <div class="tabs">
                                <!-- Nav tabs -->
                                <ul class="list-inline tabs-nav tabsize-17" role="tablist">
                                    
                                    <li role="presentation" class="active"><a href="#supplier-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Supplier List</a></li>
                                    <li role="presentation" class=""><a href="#supplier" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Supplier</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabbor">
                               
                                    <div role="tabpanel" class="tab-pane" id="supplier">
                                   <!-- <h4 align="center" class="sup-align">Add Supplier</h4>-->
                                        <form action="<?php echo $this->config->item('base_url'); ?>vendor/insert_vendor" enctype="multipart/form-data" name="form" method="post"> 
<table  width="100%" class="table table-striped responsive no-footer dtr-inline">
  <tr>
    <td>State</td>
    <td>
    	<select id="state_id" name='state_id' class="state_id form-control form-align" >
            <option value="">Select</option>
            <?php 
            if(isset($all_state) && !empty($all_state)){
            foreach($all_state as $val)
            {
            ?>
            <option value="<?=$val['id']?>"><?=$val['state']?></option>
            <?php 
            }
            }
            ?>
            </select><span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>City</td>
    <td>
    	<input type="text" name="city" class="form-control form-align" id="city" />
		<span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Account No</td>
    <td>
    	<input type="text" name="acnum" class="form-control form-align" id="acnum" />
		<span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Company Name</td>
    <td>
    	<input type="text" name="store" class="store form-control form-align" id="store" />
		<span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td>Mobile Number</td>
    <td>
    	<input type="text" name="number" class="number form-control form-align" id="number" />
		<span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   
    <td>Bank Name</td>
    <td>
    	<input type="text" name="bank" class="form-control form-align" id="bank" />
		<span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Contact Person</td>
    <td>
    	<input type="text" name="name" class="name form-control form-align" id="name"/>
		<span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td>Payment Terms</td>
    <td>
    	<input type="text" name="payment_terms" class="number form-control form-align" id="payment_terms" />
        <span id="superror11" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   
    <td>Bank Branch</td>
    <td>
    	<input type="text" name="branch" class="form-control form-align" id="branch" />
		<span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
  <tr>
    <td>Email Id</td>
    <td>
    	<input type="text" name="mail" class="mail form-control form-align" id="mail" />
		<span id="superror5" class="val" style="color:#F00; font-style:oblique;"></span>
		<span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Pin Code</td>
    <td>
    	<input type="text" class="form-control form-align" name="pin" id="pincode" />
		<span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>IFSC Code</td>
    <td><input type="text" name="ifsc" class="form-control form-align" id="" /></td>
  </tr>
  <tr>
    <td>Address1</td>
    <td>
    	<textarea name="address1" id="address1" class="form-control form-align"></textarea>
		<span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Address2</td>
    <td><textarea name="address2" id="address2" class="form-control form-align"></textarea></td>
    <td>Tin / Vat No</td>
    <td>
    	<input type="text" name="tin" class="number form-control form-align" id="tin" />
        <span id="superror12" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
  </tr>
</table>



<!--<table width="100%" class="table table-striped table-bordered responsive no-footer dtr-inline" >
<tr>
<td>State</td>
<td>
            <select id="state_id" name='state_id' class="state_id form-control" >
            <option value="">Select</option>
            <?php 
            if(isset($all_state) && !empty($all_state)){
            foreach($all_state as $val)
            {
            ?>
            <option value="<?=$val['id']?>"><?=$val['state']?></option>
            <?php 
            }
            }
            ?>
            </select><span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>
        </td>
<td>Bank Branch</td>
<td>
<input type="text" name="branch" class="form-control" id="branch" />
<span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span></td>       
<td>Contact Person</td>
<td><input type="text" name="name" class="name form-control" id="name"/>
<span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span></td>
</tr>
<tr>
<td>Company Name</td>
<td><input type="text" name="store" class="store form-control" id="store" />
<span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span></td>
<td>Account No</td>
<td><input type="text" name="acnum" class="form-control" id="acnum" />
<span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span>
</td>
<td>City</td>
<td><input type="text" name="city" class=" form-control" id="city" />
<span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span></td>
</td>

</tr>
<tr >
<td>Address1</td>
<td><textarea name="address1" id="address1" class="form-control"></textarea>
<span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span>
</td>
<td>Address2</td>
<td><textarea name="address2" id="address2" class="form-control"  placeholder="Optional"></textarea>
</td>
<td>Bank Name</td>
<td><input type="text" name="bank" class="form-control" id="bank" />
<span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span></td>
</tr>
<tr>
<td>Pin Code</td>
<td><input type="text" class="form-control" name="pin" id="pincode" />
<span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span>
</td>
<td>Mobile Number</td>
<td><input type="text" name="number" class="number form-control" id="number" />
<span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span></td>
<td></td>
<td></td>
<tr >
<td>Email Id</td>
<td><input type="text" name="mail" class="mail form-control" id="mail" />
<span id="superror5" class="val" style="color:#F00; font-style:oblique;"></span>
<span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span></td>
<td>IFSC Code</td>
<td><input type="text" name="ifsc" class="form-control" id="" /></td>
<td></td>
<td></td>
</tr>
</table>-->
<div class="frameset_table action-btn-align">
<table>
<tr>
<td width="570">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn btn-success  savebtn" id="submit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class=" btn btn-danger " id="reset" /></td><td>&nbsp;</td>
<td><a href="<?php echo $this->config->item('base_url').'vendor/'?>" class="btn btn-defaultback1"><span class="glyphicon"></span> Back </a></td>

</tr> 
</table>
</div>
</form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane active tablelist" id="supplier-details">
                                        <div class="frameset_big1">
<!--<h4 align="center" class="sup-align">Supplier Details</h4>-->
<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline " id="list">
<thead align="center">
<th width="33">S.No</th>
<th width="35">State</th>
<th width="92">Contact Person</th>
<th width="92">Company Name</th>
<th width="28">City</th>
<th style="display:none;" width="63">Address1</th>
<th style="display:none;" width="63">Address2</th>
<th style="display:none;" width="51">Pin Code</th>
<th width="88">Mobile Number</th>
<th width="51">Email Id</th>
<th width="66">Bank Details</th>
<th width="107" class="action-btn-align">Action</th>
</thead>
<tbody>
<?php
				if(isset($vendor) && !empty($vendor))
				{
					$i=0;
				foreach($vendor as $val)
				{
				$i++
				?>
             <tr>
                 <td class="first_td"><?php echo "$i";?></td>
                  <td><?=$val['state']?></td>
                <td><?=$val['name']?></td>
                <td><?=$val['store_name']?></td>
                <td><?=$val['city']?></td>
                <td style="display:none;"><?=$val['address1']?></td>
                 <td style="display:none;"><?=$val['address2']?></td>
                  <td width="8%" style="display:none;"><?=$val['pincode']?></td>
                <td><?=$val['mobil_number']?></td>
                <td><?=$val['email_id']?></td>
                <td><strong>NAME:</strong><?=$val['bank_name']?><br />
               <strong>BRANCH:</strong><?=$val['bank_branch']?><br />	
               <strong>A/C:</strong><?=$val['account_num']?><br />
                <strong>IFSC CODE:</strong><?=$val['ifsc']?></td>
         <td class="action-btn-align">
        	 <a href="<?=$this->config->item('base_url').'vendor/edit_vendor/'.$val['id']?>" class="tooltips  btn btn-info btn-xs" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
         <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>
         
                 <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                      <div class="modal-content modalcontent-top">
                         <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" class="inactivepop">In-Active Supplier</h3>
                        </div>
                      <div class="modal-body">
                         Do You Want In-Active This Supplier? <?php echo $val['name'];  ?> <strong>(<?php echo $val['store_name'];  ?>)</strong>
                         <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                      </div>
                      <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
                      </div>
                    </div>
                    </div> 
                    
         
        	 </td>
       </tr>   
  <?php }} ?>    
</tbody>
</table>


</div>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>


<script type="text/javascript">
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
$('#address1').live('blur',function()
{
	var address=$('#address1').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#superror3').html("Required Field");
	}
	else
	{
		$('#superror3').html("");
	}
});
$("#number").live('blur',function()
{
	var number=$("#number").val();
	var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
	if(number=="")
	{
		$("#superror4").html("Required Field");
	}
	else if(!nfilter.test(number))
	{
		$("#superror4").html("Enter Valid Mobile Number");
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
		$('#superror6').html("Required Field");
	}
	else
	{
		$('#superror6').html("");
	}
});
/*$('#percentage').live('blur',function()
{
	var percentage=$('#percentage').val();
	if(percentage=="" || percentage==null || percentage.trim().length==0)
	{
		$('#superror7').html("Required Field");
	}
	else if (percentage.trim().length>3 || percentage>100) 
	{
		$("#superror7").html("Invalid Selling Percentage");
	}
	else
	{
		$('#superror7').html("");
	}
});*/
$("#pincode").live('blur',function()
{
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#superror7").html("Required Field");
	}
	else if (pincode.length!=6) 
    {
	    $("#superror7").html("Maximum 6 Numbers");	
    }
	else
	{
		$("#superror7").html("");
	}
});
$("#branch").live('blur',function()
{
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#superror8").html("Required Field");
	}
	else
	{
		$("#superror8").html("");
	}
});
$("#acnum").live('blur',function()
{
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#superror9").html("Required Field");
	}
	else if(!acfilter.test(acnum))
	{
		$("#superror9").html("Numeric or Alphanumeric");
	}
	else
	{
		$("#superror9").html("");
	}
});
$("#city").live('blur',function()
{
	var city=$("#city").val();
	if(city=="" || city==null || city.trim().length==0)
	{
		$("#superror10").html("Required Field");
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
$("#tin").live('blur',function()
{
	var tin=$("#tin").val();
	if(tin=="" || tin==null || tin.trim().length==0)
	{
		$("#superror12").html("Required Field");
	}
	else
	{
		$("#superror12").html("");
	}
});
$('#reset').live('click',function()
{
	$('.val').html("");
});

</script>
<script type="text/javascript">
$('#submit').live('click',function()
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
	var address=$('#address1').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#superror3').html("Required Field");
		i=1;
	}
	else
	{
		$('#superror3').html("");
	}
	var number=$("#number").val();
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
		$('#superror6').html("Required Field");
		i=1;
	}
	else
	{
		$('#superror6').html("");
	}
	var pincode=$("#pincode").val();
	if(pincode=="")
	{
		$("#superror7").html("Required Field");
		i=1;
	}
	else if (pincode.length!=6) 
    {
	    $("#superror7").html("Maximum 6 Numbers");
		i=1;	
    }
	else
	{
		$("#superror7").html("");
	}
	var branch=$("#branch").val();
	if(branch=="" || branch==null || branch.trim().length==0)
	{
		$("#superror8").html("Required Field");
		i=1;
	}
	else
	{
		$("#superror8").html("");
	}
	var acnum=$("#acnum").val();
	var acfilter=/^[a-zA-Z0-9]+$/;
	if(acnum=="")
	{
		$("#superror9").html("Required Field");
		i=1;
	}
	else if(!acfilter.test(acnum))
	{
		$("#superror9").html("Numeric or Alphanumeric");
		i=1;
	}
	else
	{
		$("#superror9").html("");
	}
	var city=$("#city").val();
	if(city=="" || city==null || city.trim().length==0)
	{
		$("#superror10").html("Required Field");
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
	var tin=$("#tin").val();
	if(tin=="" || tin==null || tin.trim().length==0)
	{
		$("#superror12").html("Required Field");
		i=1;
	}
	else
	{
		$("#superror12").html("");
	}
	var mess=$('#duplica').html();
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
<br /><br /><br />
</div>
</div>

<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">
<div class="modal-dialog">
<div class="modal-content">
<a class="close1" data-dismiss="modal">×</a>
<div class="modal-body">
<img src="<?=$this->config->item('base_url').'/vendor_image/original/'.$val['vendor_image']?>" width="50%" />

</div>
</div>
</div>
</div>	


<script type="text/javascript">
$(document).ready(function()
 {
$("#yesin").live("click",function()
  {
 
   var hidin=$(this).parent().parent().find('.id').val();
     
     $.ajax({
      url:BASE_URL+"vendor/delete_vendor",
      type:'POST',
      data:{ value1 : hidin},
      success:function(result){

  window.location.reload(BASE_URL+"vendor/");
   }
  });
  
  });
   
   $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
  });
  </script>
<script type="text/javascript">
   $(".mail").live('blur',function()
  	{
         mail=$("#mail").val();
		 $.ajax(
		 {
		  url:BASE_URL+"vendor/add_duplicate_mail",
		  type:'get',
		   data:{ value1:mail
		   },
		  success:function(result)
		  {
		     $("#duplica").html(result);	
		  }    		
		});
   }); 
  </script>