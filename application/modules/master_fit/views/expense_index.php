<?php
$theme_path = $this->config->item('theme_locations') . $this->config->item('active_template');
?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media"> </div>
<div class="contentpanel">
	<div class="frameset ">
	<h4 align="center">Expense</h4>
		<div class="frameset_inner">
	<form name="myform" method="post" action="<?php
echo $this->config->item('base_url');
?>master_fit/insert_master_expense">
<table align="center">
<tr>
<td width="30px">Expense</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
<input type="text" name="expense" class="expense form-control e_dup" placeholder="Enter expense"  id="expense" maxlength="30"  />
<span id="expenseerror" class="reset" style="color:#F00; font-style:italic;"></span>
<span id="duplica" class="dup" style="color:#F00; font-style:italic;"></span></td>
<td>&nbsp;</td><td>&nbsp;</td>
<td>Expense Type:</td><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;&nbsp;<input type="radio" value="fixed" class="fixed ratio e_dup" id="fixed" name="expense_type" checked="checked"/>&nbsp;&nbsp;Fixed&nbsp;&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td><input type="radio" value="variable" class="variable ratio e_dup" id="variable" name="expense_type" />&nbsp;&nbsp;Variable</td>
</tr>
</table>
</div><span id="expenseerror1" class="reset" style="color:#F00; font-style:italic;"></span>
<div class="frameset_table">
<table width="100%">
<tr>
<td width="450">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn btn-default right" onClick="makeUppercase();" id="submit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class=" btn btn-default right" id="cancel" /></td>
<td>&nbsp;</td>

</tr> 
</table>
</div>
</div>
</form>

<br />

 <div class="col-md-6">

<div ><h4 align="center" >Fixed</h4></div>
<table width="351" height="" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
        <thead>
        <tr><th width="37">S.No</th>
            <th width="109">Expense</th>
            <th width="189">Action</th>
        </tr></thead>
        <tbody>
        <?php
if (isset($details) && !empty($details)) {
    $i = 1;
    foreach ($details as $billto) {
?>   
         <tr><td class="first_td"><?php
        echo "$i";
?></td>
         <td><?php
        echo $billto["expense"];
?></td>
        <td>
             <a href="#test1_<?php
        echo $billto['id'];
?>" data-toggle="modal" name="edit" class="tooltips" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                 <a href="#test3_<?php
        echo $billto['id'];
?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
             </td>
           <?php
        $i++;
    }
} else {
?>
           <tr>
             <td colspan="7">No Data Found</td>
            </tr>
           <?php
}
?>
       </tbody>
        </table>
        <div id="view"></div>
</div>  

<div class="col-md-6">

<div ><h4 align="center">Variable</h4></div>
<table width="358" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
        <thead>
        <tr><th width="40">S.No</th>
            <th width="125">Expense</th>
            <th width="177">Action</th>
        </tr></thead>
        <tbody>
        <?php
if (isset($variable) && !empty($variable)) {
    
    $i = 1;
    foreach ($variable as $billto) {
        
        
?>   
         <tr><td class="first_td"><?php
        echo "$i";
?></td>
         <td><?php
        echo $billto["expense"];
?></td>
        <td>
             <a href="#test1_<?php
        echo $billto['id'];
?>" data-toggle="modal" name="edit" class="tooltips" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                 <a href="#test3_<?php
        echo $billto['id'];
?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
             </td>
           <?php
        $i++;
    }
} else {
?>
           <tr>
             <td colspan="7">No Data Found</td>
            </tr>
           <?php
}
?>
       </tbody>
        </table>
        <div id="view"></div>
</div>
</div>



      
 <?php
if (isset($details) && !empty($details)) {
    $i = 0;
    foreach ($details as $billto) {
?>  
        
<div id="test1_<?php
        echo $billto['id'];
?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
      <div class="modal-dialog">
      <div class="modal-content">
    <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:#06F">Update Expense</h3>
    </div>
      <div class="modal-body">
     <table width="60%">
          
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php
        echo $billto["id"];
?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>Expense</strong></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><input type="text" class="up_expense form-control up_expense_dup" id="up_expense" name="up_expense" value="<?php
        echo $billto["expense"];
?>" maxlength="30" /><span id="upexpenseerror" class="upexpenseerror" style="color:#F00; font-style:italic;"></span>
         <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
         <input type="hidden" class="h_expense" id="h_expense" value="<?php echo $billto["expense"];?>" />
          <input type="hidden" class="t_expense" id="t_expense" value="<?php echo $billto["expense_type"];?>" />
         </td>
         </tr>
        
         
         </table>
      </div>
          <div class="modal-footer">         
            <button type="button" class="btn btn-primary  edit1"  id="edit"> Update</button>
             <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
          </div>
</div>
</div>        
</div>

<?php
    }
}
?>
       
        
        
        
 <?php
if (isset($variable) && !empty($variable)) {
    $i = 0;
    foreach ($variable as $billto) {
?>  
        
<div id="test1_<?php
        echo $billto['id'];
?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
      <div class="modal-dialog">
      <div class="modal-content">
    <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:#06F">Update expense</h3>
    </div>
      <div class="modal-body">
     <table width="60%">
          
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php
        echo $billto["id"];
?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>Expense</strong></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><input type="text" class="up_expense form-control up_expense_dup" id="up_expense" name="up_expense" value="<?php
        echo $billto["expense"];
?>" maxlength="30" /><span id="upexpenseerror" class="upexpenseerror" style="color:#F00; font-style:italic;"></span>
         <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
         <input type="hidden" class="h_expense" id="h_expense" value="<?php
        echo $billto["expense"];
?>" />
<input type="hidden" class="t_expense" id="t_expense" value="<?php echo $billto["expense_type"];?>" />
         </td>
         </tr>
        
         
         </table>
      </div>
          <div class="modal-footer">         
            <button type="button" class="btn btn-primary  edit1"  id="edit1"> Update</button>
             <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
          </div>
</div>
</div>        
</div>


<?php
    }
}
?>
<!--delete all-->
<?php
if (isset($details) && !empty($details)) {
    foreach ($details as $billto) {
?>   
<div id="test3_<?php
        echo $billto['id'];
?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4 style="color:#06F">In-Active expense</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php
        echo $billto["expense"];
?></strong>
     <input type="hidden" value="<?php
        echo $billto['id'];
?>" id="hidin" class="hidin" />
  </div><div class="modal-footer">
    <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
    <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
  </div>
</div>
</div>  
</div>
<?php
    }
}
?>
<?php
if (isset($variable) && !empty($variable)) {
    foreach ($variable as $billto) {
?>   
<div id="test3_<?php
        echo $billto['id'];
?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4 style="color:#06F">In-Active expense</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php
        echo $billto["expense"];
?></strong>
     <input type="hidden" value="<?php
        echo $billto['id'];
?>" id="hidin" class="hidin" />
  </div><div class="modal-footer">
    <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
    <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
  </div>
</div>
</div>  
</div>
<?php
    }
}
?>


 </div>
</div>
<script>
   $(".e_dup").live('blur',function()
  	{
		var i=0;
		expense=$("#expense").val();
		$(".ratio").each(function ()
			{
				if($(this).attr('checked')=='checked')
				{
					var c_id=$(this).val();
					if(c_id=='fixed')
					{
						 $.ajax(
							 {
							  url:BASE_URL+"master_fit/add_duplicate_expense_fixed",
							  type:'get',
							  data:{ expense:expense,c_id:c_id},
							  success:function(result)
							  {
								 $("#duplica").html(result);
							  }    		
							});
					}
					if(c_id=='variable')
					{
						 $.ajax(
							 {
							  url:BASE_URL+"master_fit/add_duplicate_expense_variable",
							  type:'get',
							  data:{ expense:expense,c_id:c_id},
							  success:function(result)
							  {
								 $("#duplica").html(result);
							  }    		
							});
					}
				}
			});
			
		 }); 
  </script>
  
  <script type="text/javascript">
  $(".up_expense_dup").live('blur',function()
  	{
		  var t_expense=$(this).parent().parent().find(".t_expense").val();
		  var up_expense=$(this).parent().parent().find(".up_expense_dup").val();
		  var id=$(this).offsetParent().find('.id_dup').val();
		  var message=$(this).offsetParent().find('.upduplica');
		  
		 
		  if(t_expense=='fixed')
		  {
		  $.ajax(
		  {
			  url:BASE_URL+"master_fit/update_duplicate_expense_fixed",
			  type:'POST',
			  data:{ value1:up_expense,value2:id,value3:t_expense},
			  success:function(result)
			  {
				 message.html(result);
			  }    		
		  });
		  }
		  if(t_expense=='variable')
		  {
			  $.ajax(
		  {
			  url:BASE_URL+"master_fit/update_duplicate_expense_varaible",
			  type:'POST',
			  data:{ value1:up_expense,value2:id,value3:t_expense},
			  success:function(result)
			  {
				 message.html(result);
			  }    		
		  });
			  
		  }
    });
  </script>

 <script type="text/javascript">
$('#expense').live('blur',function()
{
    
    var expense=$('#expense').val();
    if(expense=='' || expense==null || expense.trim().length==0)
    {
        
        $('#expenseerror').html("Required Field");
    }
    else
    {
        
        $('#expenseerror').html("");
    }
});

    $('#submit').live('click',function()
    {
    var i=0;
    var expense=$('#expense').val();
    if(expense=='' || expense==null || expense.trim().length==0)
    {
        $('#expenseerror').html("Required Field");
        i=1;
    }
    else
    {
        $('#expenseerror').html("");
    }
	var mess=$('#duplica').html();
	if(mess.trim().length>0)
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
$(document).ready(function()
 {
$("#yesin").live("click",function()
  {
      for_loading('Loading Data Please Wait...');
    
   var hidin=$(this).parent().parent().find('.hidin').val();
     
     $.ajax({
      url:BASE_URL+"master_fit/delete_master_expense",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

     window.location.reload(BASE_URL+"master_expense/");
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
 
  
  
  $(".edit1").live("click",function()
  { 
  var i=0;  
  var id=$(this).parent().parent().find('.id').val();
  var up_expense=$(this).parent().parent().find(".up_expense").val();
  var m=$(this).offsetParent().find('.upexpenseerror');
  var mess=$(this).parent().parent().find(".upduplica").html();
 
    if(up_expense=='' || up_expense==null || up_expense.trim().length==0)
    {
        m.html("Required Field");
        i=1;
    }
    else
    {
        m.html("");
    }
	if(mess.trim().length>0)
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
      url:BASE_URL+"master_fit/update_expense",
      type:'get',
      data:{ value1:id,value2:up_expense },
      success:function(result)
   {
       
  window.location.reload(BASE_URL+"expense_index");
  for_response('Updated Successfully...');
      }   
  });
    }
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
  
  
   $("#no").live("click",function()
  {
      
   
   var h_expense=$(this).parent().parent().parent().find('.h_expense').val();
  
   $(this).parent().parent().find('.up_expense').val(h_expense);
   var m=$(this).offsetParent().find('.upexpenseerror');
   var message=$(this).offsetParent().find('.upduplica');
   m.html("");
   message.html("");
   
    });
   </script>
   <script type="text/javascript">
$(document).ready(function() {
$('#cancel').live('click',function()
{
$('.reset').html(""); 
$('.dup').html("");  
});
});
</script>