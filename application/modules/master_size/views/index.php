 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="frameset">
<h4 align="center">Size</h4>
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_size/insert_master_size">
<div class="frameset_inner">
<table align="center">
<tr>
 
<td width="60px">
Size</td><td>
<input type="text" name="size" class="size form-control" placeholder="Enter size" id="size" maxlength="35" />
<span id="sizeerror" class="reset" style="color:#F00; font-style:italic;"></span>
<span id="errormessage" class="dup" style="color:#F00;"></span>
</td>
</tr>
</table>
</div>
<div class="frameset_table">
<table width="100%">
<tr>
<td width="450">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn btn-default right" id="submit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class=" btn btn-default right" id="cancel" /></td>
</tr> 
</table>
</div>
 </form>
</div> 
 <script type="text/javascript">
$('#size').live('blur',function()
{
	var size=$('#size').val();
	if(size=='' || size==null || size.trim().length==0)
	{
		$('#sizeerror').html("Required Field");
	}
	else
	{
		$('#sizeerror').html(" ");
	}
});


    $('#submit').live('click',function()
    {
	var i=0;
	var size=$('#size').val();
	if(size=='' || size==null || size.trim().length==0)
	{
		$('#sizeerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#sizeerror').html("");
	}
	var m=$('#errormessage').html();
	if((m.trim()).length>0)
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
	
	
	 $("#size").live('blur',function()
  {
	  
        var size=$("#size").val();  
    $.ajax(
   {
    url:BASE_URL+"master_size/checking_master_size",
    type:'POST',
    data:{ value1 : size},
    success:function(result)
    {
       $("#errormessage").html(result);
   
    }      
  });
   });
</script>
<br />
<div class="frameset">
<h4 align="center">Size Details</h4>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
		<thead>
        <tr><th>S.No</th>
            <th>Size</th>
            <th>Action</th>
        </tr></thead>
		<tbody>
		<?php 
			if(isset($detail) && !empty($detail))
			{
				$i=1;
				foreach($detail as $billto) 
				{ 
		?>   
         <tr><td class="first_td"><?php echo "$i";?></td>
         <td><?php echo $billto["size"]; ?></td>
       
          <td>
        	 <a href="#test1_<?php echo $billto['id']; ?>" data-toggle="modal" name="edit" class="tooltips" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
         		<a href="#test3_<?php echo $billto['id']; ?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
        	 </td>
             </tr>
            <?php 
   $i++;
   }
  }
  else
  {
   ?>
            <tr>
             <td colspan="7">No Data Found</td>
            </tr>
           <?php
  }
   ?>
        </tbody>
		</table>
</div>	        
        
 <?php 
			if(isset($detail) && !empty($detail))
			{
				$i=0;
				foreach($detail as $billto) 
				{ ?>  
        
<div id="test1_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
  	<div class="modal-dialog">
  	<div class="modal-content">
    <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:#06F">Update Size</h3>
    </div>
  	<div class="modal-body">
     <table width="60%">
      	
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $billto["id"]; ?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>Size</strong></td>
         <td><input type="text" class="up_size form-control up_size_dup" id="up_size" name="up_size" value="<?php echo htmlspecialchars($billto["size"]); ?>" maxlength="35" /><span id="upsizeerror" class="upsizeerror" style="color:#F00; font-style:italic;"></span>
         <span id="upduplic" class="upduplic" style="color:#F00; font-style:italic;"></span>
         <input type="hidden" class="h_size" id="h_size" value="<?php echo $billto["size"]; ?>" />
         <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
         </tr>
        
        
         
         </table>
  	</div>
  		<div class="modal-footer">         
            <button type="button" class="btn btn-primary  mr5 mb10"  id="edit"> Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
  		</div>
</div>
</div>        
</div>
<script type="text/javascript">
$('.up_size').live('blur',function()
{
	var usize=$(this).parent().parent().find(".up_size").val();
	var m=$(this).offsetParent().find('.upsizeerror');
	if(usize=='' || usize==null || usize.trim().length==0)
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
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4 style="color:#06F">In-Active Size</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto["size"]; ?></strong>
     <input type="hidden" value="<?php echo $billto['id']; ?>" id="hidin" class="hidin" />
  </div><div class="modal-footer">
    <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
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
   var hidin=$(this).parent().parent().find('.hidin').val();
    
     $.ajax({
      url:BASE_URL+"master_size/delete_master_size",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){
		  

	 window.location.reload(BASE_URL+"master_size/");
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
  var up_size=$(this).parent().parent().find(".up_size").val();
    var percentage_up=$(this).parent().parent().find(".percentage_up").val();
	var m=$(this).offsetParent().find('.upsizeerror');
	var mess=$(this).parent().parent().find('.upduplic').html();
	if(up_size=='' || up_size==null || up_size.trim().length==0)
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
     $.ajax({
      url:BASE_URL+"master_size/update_size",
      type:'POST',
      data:{ value1:id,value2:up_size,value3:percentage_up },
      success:function(result)
   {
  window.location.reload(BASE_URL+"master_size");
      }   
  });
	}
  $('body').oLoader({
  wholeWindow: true, 
  effect:'door',
  hideAfter: 1500
});
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
   $("#no").live("click",function()
  {
   var h_size=$(this).parent().parent().parent().find('.h_size').val();
   $(this).parent().parent().find('.up_size').val(h_size);
   var m=$(this).offsetParent().find('.upsizeerror');
   m.html("");
    });
	
   </script>
   
    <script>
 $(".up_size_dup").live('blur',function()
  			{
			var cat=$(this).parent().parent().find('.up_size').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplic');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_size/update_duplicate_size",
		  type:'POST',
		   data:{ value1:cat,value2:id},
		  success:function(result)
		  {
		     message.html(result);
		  }    		
		});
   }); 
   </script> 
    
    <script type="text/javascript">
	$(document).ready(function()
	 {
		 $('#cancel').live('click',function()
		 {
			$('.reset').html("");
			$('.dup').html(""); 
		 });
    });
	</script>