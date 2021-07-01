 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="frameset">
<h4 align="center">Transport</h4>
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_transport/insert_master_transport">
<div class="frameset_inner">
<table align="center">
<tr>
 
<td width="60px" align="center">Transport Name</td><td width="10"></td><td><input type="text" name="transport"  placeholder="Enter Transport Name" class="men form-control cat_dup" id="men" maxlength="40" />
<span id="caterror" class="reset" style="color:#F00; font-style:oblique;"></span>
<span id="duplica" class="dup" style="color:#F00; font-style:oblique;"></span></td>


<td width="30px">&nbsp;</td>
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
 
<br />
<script>
$('#men').live('blur',function()
{
	var men=$('#men').val();
	if(men=='' || men==null || men.trim().length==0)
	{
		$('#caterror').html("Required Field");
	}
	else
	{
		$('#caterror').html(" ");
	}
});

$('#submit').live('click',function()
{
	i=0;
	var men=$('#men').val();
	if(men=='' || men==null || men.trim().length==0)
	{
		$('#caterror').html("Required Field");
		i=1;
	}
	else
	{
		$('#caterror').html(" ");
	}
	var m=$('#duplica').html();
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
</script>
<script>
   $(".cat_dup").live('blur',function()
  			{
         	cat=$("#men").val();
		    //alert(busno);
		 $.ajax(
		 {
		  url:BASE_URL+"master_category/add_duplicate_category",
		  type:'get',
		   data:{ value1:cat},
		  success:function(result)
		  {
		     $("#duplica").html(result);	
		  }    		
		});
   }); 
  </script>
<div class="frameset">
<h4 align="center">Transport Details</h4>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
		<thead>
        <tr><th>S.No</th>
            <th>Transport Name</th>
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
         <td><?php echo $billto["transport_name"]; ?></td>
           </td>
       
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
      
        
 <?php 
			if(isset($detail) && !empty($detail))
			{
				$i=0;
				foreach($detail as $billto) 
				{ ?>  
</div>         
<div id="test1_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
  	<div class="modal-dialog">
  	<div class="modal-content">
    <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel">Update Category</h3>
    </div>
    <form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_transport/update_master_transport">
  	<div class="modal-body">
    
     <table width="60%">
      	
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $billto["id"]; ?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>Transport</strong></td>
         <td><input type="text" class="up_men form-control up_category up_cat_dup" id="up_men" name="up_men" value="<?php echo $billto["transport_name"]; ?>" maxlength="40" /><span id="upcategoryerror" class="upcategoryerror" style="color:#F00; font-style:italic;"></span>
         <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
     
         </td>
         </tr>
         </table>
  	</div>
  		<div class="modal-footer">         
            <button type="submit" class="edit  btn btn-primary mr5 mb10"  id="edit">Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal">Discard</button>
    
  		</div>
        </form>
</div>
</div>        
</div>
<script type="text/javascript">
$('.up_category').live('blur',function()
{
	var ucategory=$(this).parent().parent().find(".up_category").val();
	var m=$(this).offsetParent().find('.upcategoryerror');
	if(ucategory=='' || ucategory==null || ucategory.trim().length==0)
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
{//print_r($billto);exit;
 ?> 
  <form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_transport/delete_master_transport">
<div id="test3_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a>
<h4 style="color:#06F">In-Active Category</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto['transport_name'];  ?></strong>
     <input type="hidden" value="<?php echo $billto['id']; ?>" id="hidin" name="hidin" class="hidin" />
  </div><div class="modal-footer">
    <input type="submit" class="btn btn-primary" value="Yes" />
    <button type="button" class="btn btn-danger"  data-dismiss="modal" id="no">No</button>
  </div>
</div>
</div>  
</div>
</form>
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
      url:BASE_URL+"master_category/delete_master_category",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){
		  

	 window.location.reload(BASE_URL+"master_category/");
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
  var up_men=$(this).parent().parent().find(".up_men").val();
  var up_women=$(this).parent().parent().find(".up_women").val();
  var up_kids=$(this).parent().parent().find(".up_kids").val();
  var m=$(this).offsetParent().find('.upcategoryerror');
   var mess=$(this).parent().parent().find('.upduplica').html();
	if(up_men=='' || up_men==null || up_men.trim().length==0)
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
      url:BASE_URL+"master_category/update_category",
      type:'POST',
      data:{ value1:id,value2:up_men,value3:up_women,value4:up_kids },
      success:function(result)
   {
  window.location.reload(BASE_URL+"master_category");
   for_response('Updated Successfully...');
      }   
  });
	}
 
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
   $("#no").live("click",function()
  {
      
   
   var h_category=$(this).parent().parent().parent().find('.h_category').val();
  
   $(this).parent().parent().find('.up_category').val(h_category);
   var m=$(this).offsetParent().find('.upcategoryerror');
   var message=$(this).offsetParent().find('.upduplica');
   m.html("");
    message.html("");
    });
	
   </script>
  
   <script>
 $(".up_cat_dup").live('keyup',function()
  			{
			var cat=$(this).parent().parent().find('.up_men').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplica');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_category/update_duplicate_category",
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