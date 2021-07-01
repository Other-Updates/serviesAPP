 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel mb-25">
  <div class="media">
  <h4>Field Agent Details</h4>
 </div>
<div class="panel-body">
                            <div class="tabs">
                                <!-- Nav tabs -->
                                <ul class="list-inline tabs-nav tabsize-17" role="tablist">
                                    
                                    <li role="presentation" class="active"><a href="#field-agent-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Field Agent List</a></li>
                                    <li role="presentation" class=""><a href="#field-agent" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Field Agent</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabbor">
                               
                                    <div role="tabpanel" class="tab-pane" id="field-agent">
                                   <!--  <h4 align="center" class="sup-align">Add Filed Agent</h4>-->
                                        <form action="<?php echo $this->config->item('base_url'); ?>agent/insert_agent" enctype="multipart/form-data" name="form" method="post"> 
<table class="table table-striped responsive no-footer dtr-inline">
  <tr>
    <td>Name</td>
    <td>
        <input type="text" name="name" class="form-control form-align" id="name" /> 
        <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
     <td >User Name</td>
    <td>
        <input type="text" name="username" class=" form-control form-align" id="username" />
        <span id="username1" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td> 
     <td>Password</td>
     <td>
       <input type="password" name="password" class="form-control form-align" id="password" />
        <span id="password1" class="val"  style="color:#F00; font-style:oblique;"></span>
      </td>
    
  </tr>
  <tr>
       <td>City</td>
    <td>
        <input type="text" name="city" class=" form-control form-align" id="city" />
        <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   <td>Account No</td>
   <td>
        <input type="text" name="acnum" class="form-control form-align" id="acnum" />
        <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Mobile Number</td>
    <td>
        <input type="text" name="number" class="number form-control form-align" id="number" />
        <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    
  </tr>
  <tr>
    <td>Pin Code</td>
    <td>
        <input type="text" name="pin" class=" form-control form-align" id="pincode" />
        <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
   
    <td>Bank Name</td>
    <td>
        <input type="text" name="bank" class="form-control form-align" id="bank" />
        <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td>Email Id</td>
    <td>
        <input type="text" name="mail" class="mail form-control email_dup form-align" id="mail" />
        <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
        <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    
  </tr>
  <tr>
    <td>IFSC Code </td>
    <td>
        <input type="text" name="ifsc" class="form-control form-align" id="" />
    </td>
     
    <td>Bank Branch</td>
    <td>
        <input type="text" name="branch" class="form-control form-align" id="branch" />
        <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
    <td >Role</td>
          <td >
               <select name="role" class="form-control form-align" id="role" >
                          <option value="4">Field Agent</option>                        
                      </select>
              <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
          </td>
    
  
  </tr>
  <tr>
   <td>Address1</td>
    <td>
        <textarea name="address1" id="address" class="form-control form-align"></textarea>
        <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
    </td>
      <td>Address2</td>
        <td>
            <textarea name="address2" id="address"  class="form-control form-align"></textarea>
       </td>
       
  </tr>
  
</table>

    <div class="frameset_table action-btn-align">
    <table>
        <td width="570">&nbsp;</td>
        <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>
        <td>&nbsp;</td>
        <td><input type="reset" value="Clear" class=" btn btn-danger" id="reset" /></td>   <td>&nbsp;</td>
        <td><a href="<?php echo $this->config->item('base_url').'agent/'?>" class="btn btn-defaultback1"><span class="glyphicon"></span> Back </a></td>
    </table>
    </div>
</form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane active tablelist" id="field-agent-details">
                                        <div class="frameset_big1">

  <!--<h4 align="center" class="sup-align">Field Agent Details</h4>-->
<table id="basicTable"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="list">
        <thead>
        <th>S.No</th>
        <th>Employee Id</th>
        <th>Name</th>
        <th>User Name</th>           
        <th>Pin Code</th>
        <th>Mobile Number</th>
        <th>Email Id</th>
        <th>Bank Details</th>
        <th class="action-btn-align">Action</th>
        <!--</thead>-->
        <tbody>
        <?php
            if(isset($agent) && !empty($agent))
            {
             $i=0;
            foreach($agent as $val)
            {
            $i++
            ?>
                     <tr>
                        <td class="first_td"><?php echo "$i";?></td>
                         <td>EMP_ID_<?=$val['id']?></td>
                        <td><?=$val['name']?></td>
                        <td><?=$val['username']?></td>
<!--                        <td><?=$val['city']?></td>-->
<!--                        <td><?=$val['address1']?></td>
                        <td><?=$val['address2']?></td>-->
                        <td><?=$val['pincode']?></td>
                        <td><?=$val['mobil_number']?></td>
                        <td><?=$val['email_id']?></td>
                        <td>
                        <strong>NAME:</strong><?=$val['bank_name']?><br />	
                        <strong>BRANCH:</strong><?=$val['bank_branch']?><br />
                        <strong>A/C NO:</strong><?=$val['account_num']?><br />
                        <strong>IFSC CODE:</strong><?=$val['ifsc']?>
                        </td>
                    <td class="action-btn-align">
                    <a href="<?=$this->config->item('base_url').'agent/edit_agent/'.$val['id']?>" class="tooltips btn btn-info btn-xs" title="Edit">
                    <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active">
                    <span class="fa fa-ban"></span></a>
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


<br />
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
		$('#cuserror3').html("Required Field");
	}
	else
	{
		$('#cuserror3').html("");
	}
});
$("#number").live('blur',function()
{
	var number=$("#number").val();
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
		$('#cuserror6').html("Required Field");
	}
	else
	{
		$('#cuserror6').html("");
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
$("#username").live('blur',function()
{
   
	var username=$("#username").val();        
	if(username=="" || username==null || username.trim().length==0)
	{
		$("#username1").html("Required Field");
	}
	else
	{
		$("#username1").html("");
	}
});
$("#password").live('blur',function()
{

	var password=$("#password").val();
	if(password=="" || password==null || password.trim().length==0)
	{
		$("#password1").html("Required Field");
	}
	else
	{
		$("#password1").html("");
	}
});
$("#acnum").live('blur',function()
{
	var acnum=$("#username").val();
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
$('#reset').live('click',function()
{
	$('.val').html("");
});
</script>
<script type="text/javascript">
$('#submit').live('click',function()
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
	
	var number=$("#number").val();
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
		$('#cuserror6').html("Required Field");
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
	var address=$('#address').val();
	if(address=="" || address==null || address.trim().length==0)
	{
		$('#cuserror3').html("Required Field");
		i=1;
	}
	else
	{
		$('#cuserror3').html("");
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
        
        var username=$("#username").val();
	if(username=="" || username==null || username.trim().length==0)
	{
		$("#username1").html("Required Field");
                	i=1;
	}
	else
	{
		$("#username1").html("");
	}
        
        var password=$("#password").val();
	if(password=="" || password==null || password.trim().length==0)
	{
		$("#password1").html("Required Field");
                	i=1;
	}
	else
	{
		$("#password1").html("");
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
<script>
   $(".email_dup").live('blur',function()
  	{
         email=$("#mail").val();
		 $.ajax(
		 {
		  url:BASE_URL+"agent/add_duplicate_email",
		  type:'get',
		   data:{ value1:email},
		  success:function(result)
		  {
		     $("#duplica").html(result);	
		  }    		
		});
   }); 
  </script>



	<?php 
    if(isset($agent) && !empty($agent))
    {
    foreach($agent as $val) 
    {
     ?>   
    <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
    <div class="modal-dialog">
      <div class="modal-content modalcontent-top">
         <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
          <h3 id="myModalLabel" class="inactivepop">In-Active agent</h3>
         </div>
         <div class="modal-body">
             Do You Want In-Active This agent?<strong><?= $val['name']; ?></strong>
             <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
          </div>
          <div class="modal-footer action-btn-align">
            <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
          </div>
         </div>
        </div>  
       </div>
      <?php }} ?>
     </div>
    </div>

<script type="text/javascript">
$(document).ready(function()
 {
$("#yesin").live("click",function()
  {
 
   var hidin=$(this).parent().parent().find('.id').val();
     
     $.ajax({
      url:BASE_URL+"agent/delete_agent",
      type:'POST',
      data:{ value1 : hidin},
      success:function(result){

  window.location.reload(BASE_URL+"agent/");
   }
  });
  
  });
   
   $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
  });
  </script>