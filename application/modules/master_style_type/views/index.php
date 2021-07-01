 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>


<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="frameset">
<h4 align="center">Product Type</h4>
<div class="frameset_inner">
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_style_type/insert_master_style_type">
<table align="center">
<tr>
<td width="100px">
Product Type</td><td>
<input type="text" name="style_type" class="style_type form-control product_dup" placeholder="Enter Product" id="style_type" maxlength="50" />
<span id="stypeerror" class="reset" style="color:#F00; font-style:italic;"></span>
<span id="duplica" class="dup" style="color:#F00; font-style:italic;"></span></td>
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
</div>
</form>
 <script type="text/javascript">
$('#style_type').live('blur',function()
{
	var style_type=$('#style_type').val();
	if(style_type=='' || style_type==null || style_type.trim().length==0)
	{
		$('#stypeerror').html("Required Field");
	}
	else
	{
		$('#stypeerror').html(" ");
	}
});


    $('#submit').live('click',function()
    {
	var i=0;
	var style_type=$('#style_type').val();
	if(style_type=='' || style_type==null || style_type.trim().length==0)
	{
		$('#stypeerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#stypeerror').html("");
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
   $(".product_dup").live('blur',function()
  			{
         	product=$("#style_type").val();
		    //alert(product);
		 $.ajax(
		 {
		  url:BASE_URL+"master_style_type/add_duplicate_product",
		  type:'get',
		   data:{ value1:product},
		  success:function(result)
		  {
		     $("#duplica").html(result);	
		  }    		
		});
   }); 
  </script>
<br />
<div class="frameset">
<div><h4 align="center" >Product Type Details</h4></div>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
		<thead>
        <tr><th>S.No</th>
            <th>Product Type</th>
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
         <td><?php echo $billto["style_type"]; ?></td>
        <td>
        	 <a href="#test1_<?php echo $billto['id']; ?>" data-toggle="modal" name="edit" class="tooltips" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
         		<a href="#test3_<?php echo $billto['id']; ?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
        	 </td>
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
    <h3 id="myModalLabel" style="color:#06F">Update Product Type</h3>
    </div>
  	<div class="modal-body">
     <table width="60%">
      	
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $billto["id"]; ?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>Product Type</strong></td>
         <td><input type="text" class="up_style form-control up_product_dup" id="up_style" name="up_style" value="<?php echo $billto["style_type"]; ?>" maxlength="50" /><span id="upstypeerror" class="upstypeerror" style="color:#F00; font-style:italic;"></span>
         <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
         <input type="hidden" class="h_fit" id="h_fit" value="<?php echo $billto["style_type"]; ?>" />
         </tr>
        
         
         </table>
  	</div>
  		<div class="modal-footer">         
            <button type="button" class="btn btn-primary "  id="edit"> Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
  		</div>
</div>
</div>        
</div>
<script type="text/javascript">
$('.up_style').live('blur',function()
{
	var up_style=$(this).parent().parent().find(".up_style").val();
	var m=$(this).offsetParent().find('.upstypeerror');
	if(up_style=='' || up_style==null || up_style.trim().length==0)
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
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4 style="color:#06F">In-Active Product Type</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto["style_type"]; ?></strong>
     <input type="hidden" value="<?php echo $billto['id']; ?>" id="hidin" class="hidin" />
  </div><div class="modal-footer">
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
	
   var hidin=$(this).parent().parent().find('.hidin').val();
     
     $.ajax({
      url:BASE_URL+"master_style_type/delete_master_style_type",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

	 window.location.reload(BASE_URL+"master_style_type/");
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

  var up_style=$(this).parent().parent().find(".up_style").val();
  var m=$(this).offsetParent().find('.upstypeerror');
  var mess=$(this).parent().parent().find(".upduplica").html();
	if(up_style=='' || up_style==null || up_style.trim().length==0)
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
      url:BASE_URL+"master_style_type/update_fit",
      type:'POST',
      data:{ value1:id,value2:up_style },
      success:function(result)
   {
  window.location.reload(BASE_URL+"master_style_type");
      }   
  });
	}
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
   $("#no").live("click",function()
  {
      
   
   var h_fit=$(this).parent().parent().parent().find('.h_fit').val();
  
   $(this).parent().parent().find('.up_style').val(h_fit);
   var m=$(this).offsetParent().find('.upstypeerror');
   m.html("");
   var message=$(this).offsetParent().find('.upduplica');
   message.html("");
   
    });
   </script>
    <script>
 $(".up_product_dup").live('blur',function()
  			{
			var product=$(this).parent().parent().find('.up_style').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplica');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_style_type/update_duplicate_product",
		  type:'get',
		   data:{ value1:product,value2:id},
		  success:function(result)
		  {
		     message.html(result);
		  }    		
		});
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