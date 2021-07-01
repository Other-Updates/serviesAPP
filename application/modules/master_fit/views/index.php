 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
  <div class="media">
  <h4>User Role Details</h4>
 </div>
<div class="panel-body ">
<div class="tabs">
<!-- Nav tabs -->
    <ul class="list-inline tabs-nav tabsize-17" role="tablist">
    
    <li role="presentation" class="active"><a href="#userrole-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">User Role List</a></li>
    <li role="presentation" class=""><a href="#userrole" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add User Role</a></li>
    </ul>
<!-- Tab panes -->
<div class="tab-content tabbor">

<div role="tabpanel" class="tab-pane" id="userrole">
<div class="frameset1">
<!--<h4 align="center" class="sup-align">Add User Role</h4>-->
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_fit/insert_master_fit">
<div class="frameset_inner">
<table align="center">
<tr>
<td width="60px">User Role</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<input type="text" name="fit" class="fit form-control fit_dup borderra0" placeholder="Enter User Role" id="fit" maxlength="30" />
<span id="fiterror" class="reset" style="color:#F00; font-style:italic;"></span>

</td>
</tr>
<tr>
<td width="60px">Permission</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<input type="text" name="permission" class="fit form-control fit_dup borderra0" placeholder="Enter Permission" id="permission" maxlength="30" />
<span id="fiterror2" class="reset" style="color:#F00; font-style:italic;"></span>       
</td>
</tr>
</table>
</div>
<div class="frameset_table action-btn-align">
<table>
<tr>
<td width="570">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn  btn-success " id="submit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class=" btn  btn-danger" id="cancel" /></td><td>&nbsp;</td>
<td><a href="<?php echo $this->config->item('base_url').'master_fit/'?>" class="btn btn-defaultback1"><span class="glyphicon"></span> Back </a></td>
</tr> 
</table>
</div>
</div>
</form>
</div>


<div role="tabpanel" class="tab-pane active tablelist" id="userrole-details">
<div class="frameset1">
<!--<h4 align="center" class="sup-align">User Role Details</h4>-->
<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
<thead>
<tr>
<th>S.No</th>
<th>User Role</th>
<th>Permission</th>
<!--<th class="action-btn-align">Action</th>-->
</tr>
</thead>
<tbody>
<?php 
if(isset($detail) && !empty($detail))
{
$i=1;
foreach($detail as $billto) 
{ 


?>   
<tr><td class="first_td"><?php echo "$i";?></td>
<td><?php echo $billto["user_role"]; ?></td>
<td><?php echo $billto["permission"]; ?></td>
<!--<td class="action-btn-align">
<a href="#test1_<?php echo $billto['id']; ?>" data-toggle="modal" name="edit" class="tooltips btn btn-info btn-xs" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
<a href="#test3_<?php echo $billto['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>
</td>-->
</tr>
<?php 
$i++;
}
}
else
{
?>
<tr>
<td colspan="3">No Data Found</td>
</tr>
<?php
}
?>
</tbody>
</table>
<div id="view"></div>
</div>
</div>
</div>                                   
</div>
                                </div>
                            </div>
                        </div>


 <script type="text/javascript">
$('#fit').live('blur',function()
{
	
	var fit=$('#fit').val();
	if(fit=='' || fit==null || fit.trim().length==0)
	{
		
		$('#fiterror').html("Required Field");
	}
	else
	{
		
		$('#fiterror').html("");
	}
});
$('#permission').live('blur',function()
{
	
	var permission=$('#permission').val();
	if(permission=='' || permission==null || permission.trim().length==0)
	{
		
		$('#fiterror2').html("Required Field");
	}
	else
	{
		
		$('#fiterror2').html("");
	}
});


    $('#submit').live('click',function()
    {
	var i=0;        
	var permission=$('#permission').val();
	if(permission=='' || permission==null || permission.trim().length==0)
	{
		
		$('#fiterror2').html("Required Field");
                i=1;
	}
	else
	{
		
		$('#fiterror2').html("");
	}
	var fit=$('#fit').val();
	if(fit=='' || fit==null || fit.trim().length==0)
	{
		$('#fiterror').html("Required Field");
		i=1;
	}
	else
	{
		$('#fiterror').html("");
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

<br />
        
 <?php 
			if(isset($detail) && !empty($detail))
			{
				$i=0;
				foreach($detail as $billto) 
				{ ?>  
        
<div id="test1_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
  	<div class="modal-dialog">
  	<div class="modal-content modalcontent-top">
    <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:white;margin-top:10px;">Update User Role</h3>
    </div>
  	<div class="modal-body">
     <table width="60%">
      	<tr>
            <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $billto["id"]; ?>" readonly /></td>
        </tr>         
        <tr>
            <td><strong>User Role</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="text" class="up_fit form-control up_fit_dup borderra0" id="up_fit" name="up_fit" value="<?php echo $billto["user_role"]; ?>" maxlength="30" /><span id="upfiterror" class="upfiterror" style="color:#F00; font-style:italic;"></span>
                <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
                <input type="hidden" class="h_fit" id="h_fit" value="<?php echo $billto["user_role"]; ?>" />
            </td>
         </tr>
        <tr>
         <td><strong>permission</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="text" class="up_per form-control up_fit_dup borderra0" id="up_per" name="up_per" value="<?php echo $billto["permission"]; ?>" maxlength="30" /><span id="upfiterror" class="upfiterror" style="color:#F00; font-style:italic;"></span>
                <span id="fiterror2" class="reset" style="color:#F00; font-style:italic;"></span>   
                <input type="hidden" class="h_fit" id="h_fit" value="<?php echo $billto["permission"]; ?>" />
            </td>
         </tr>
        
         
         </table>
  	</div>
  		<div class="modal-footer action-btn-align">         
            <button type="button" class="btn btn-info "  id="edit"> Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
  		</div>
</div>
</div>        
</div>

<script type="text/javascript">
$('.up_fit').live('blur',function()
{
	var up_fit=$(this).parent().parent().find(".up_fit").val();
	var m=$(this).offsetParent().find('.upfiterror');
	if(up_fit=='' || up_fit==null || up_fit.trim().length==0)
	{
		m.html("Required Field");
	}
	else
	{
		m.html("");
	}
});
</script>
<?php   
            }}
        ?>
<!--delete all-->
<?php 
if(isset($detail) && !empty($detail))
{
foreach($detail as $billto) 
{
 ?>   
<div id="test3_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog"><div class="modal-content modalcontent-top"><div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a><h4 class="inactivepop">In-Active Fit</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto["master_fit"]; ?></strong>
     <input type="hidden" value="<?php echo $billto['id']; ?>" id="hidin" class="hidin" />
  </div><div class="modal-footer action-btn-align">
    <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
    <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
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
	  for_loading('Loading Data Please Wait...');
	
   var hidin=$(this).parent().parent().find('.hidin').val();
     
     $.ajax({
      url:BASE_URL+"master_fit/delete_master_fit",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

	 window.location.reload(BASE_URL+"master_fit/");
	 for_response('Deleted Successfully...');
	  }
	 });
	 
  });
		 
	  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
  });
  </script>
  
  
<!-- Update script  -->
  
  <script type="text/javascript">
  $("#edit").live("click",function()
  { 
  var i=0;  
  var id=$(this).parent().parent().find('.id').val();

  var up_fit=$(this).parent().parent().find(".up_fit").val();
  var up_per=$(this).parent().parent().find(".up_per").val();
  var m=$(this).offsetParent().find('.upfiterror');
  var mess=$(this).parent().parent().find(".upduplica").html(); 
	if(up_fit=='' || up_fit==null || up_fit.trim().length==0)
	{
		m.html("Required Field");
		i=1;
	}
	else
	{
		m.html("");
	}
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
		for_loading('Loading Data Please Wait...');
     $.ajax({
      url:BASE_URL+"master_fit/update_fit",
      type:'POST',
      data:{ value1:id,value2:up_fit ,value3:up_per},
      success:function(result)
   {
  window.location.reload(BASE_URL+"master_fit");
  for_response('Updated Successfully...');
      }   
  });
	}
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
   $("#no").live("click",function()
  {
      
   
   var h_fit=$(this).parent().parent().parent().find('.h_fit').val();
  
   $(this).parent().parent().find('.up_fit').val(h_fit);
   var m=$(this).offsetParent().find('.upfiterror');
   var message=$(this).offsetParent().find('.upduplica');
   m.html("");
   message.html("");
   
    });
   </script>
<!--   <script>
 $(".up_fit_dup").live('blur',function()
  			{
			var fit=$(this).parent().parent().find('.up_fit').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplica');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_fit/update_duplicate_fit",
		  type:'POST',
		   data:{ value1:fit,value2:id},
		  success:function(result)
		  {
		     message.html(result);
		  }    		
		});
   }); 
   </script> -->
  
   <script type="text/javascript">
  $(document).ready(function() {
	  $('#cancel').live('click',function()
	  {
		$('.reset').html(""); 
		$('.dup').html("");  
	  });
});
  </script>