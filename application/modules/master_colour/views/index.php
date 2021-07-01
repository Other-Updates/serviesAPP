 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="frameset">
<h4 align="center">Brand</h4>
<form action="<?php echo $this->config->item('base_url'); ?>master_colour/insert_colour"  name="form" method="post"> 
<div class="frameset_inner">
<table align="center">
<tr>
<td>Brand Name</td>
<td width="10">&nbsp;</td>
<td><input type="text" name="colour" class="colour form-control colournamedup" placeholder=" Enter Brand" id="colourname" maxlength="40" /><span id="cnameerror" class="reset" style="color:#F00; font-style:italic;"></span>
<span id="dup" class="dup" style="color:#F00; font-style:italic;"></span>
</td>
</tr>
</table>
</div>
<div class="frameset_table">
<table width="100%">
<tr>
<td width="100%">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn btn-default1 right" id="submit" /></td>
<td>&nbsp;</td>
<td><input type="reset" value="Clear" class=" btn btn-default2 right" id="cancel" /></td>
</tr> 
</table>
</div>
</form>
</div>
<script type="text/javascript">
$('#colourname').live('blur',function()
{
	var cname=$('#colourname').val();
	if(cname=='' || cname==null || cname.trim().length==0)
	{
		$('#cnameerror').html("Required Field");
	}
	else
	{
		$('#cnameerror').html(" ");
	}
});


    $('#submit').live('click',function()
    {
	var i=0;
	var cname=$('#colourname').val();
	if(cname=='' || cname==null || cname.trim().length==0)
	{
		$('#cnameerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#cnameerror').html("");
	}
	var m=$('#dup').html();
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
<script type="text/javascript">
// STYLE NAME DUPLICATION
$(".colournamedup").live('blur',function()
{
			
         cname=$("#colourname").val();
		
		    //alert(sname);
		 $.ajax(
		 {
		  url:BASE_URL+"master_colour/add_duplicate_colorname",
		  type:'POST',
		   data:{ value1:cname},
		  success:function(result)
		  {
		    $("#dup").html(result);	  	
		  }    		
		});
 }); 
</script>
<br />
<div class="frameset">
<div id="list">
<h4 align="center">Brand Details</h4>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
<thead>
<th>S.No</th>
<th>Brand Name</th>
<th>Actions</th>
</thead>
<tbody>
<?php
				if(isset($colour) && !empty($colour))
				{
					$i=1;
				foreach($colour as $val)
				{ 
				?>
             <tr>
                 <td class="first_td"><?php echo "$i";?></td>
                <td ><?=$val['brand'];?></td>
               
         <td>
        	 <a href="#test1_<?php echo $val['id']; ?>" data-toggle="modal" name="edit" class="tooltips" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
         		<a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
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
             <td colspan="3">No Data Found</td>
            </tr>
           <?php
  }
   ?>    
</tbody>
</table>
</div>

</div>
<?php 
if(isset($colour) && !empty($colour))
{
foreach($colour as $val) 
{
 ?>   

<div id="test1_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
  	<div class="modal-dialog">
  	<div class="modal-content">
    <div class="modal-header modal-padding"><a class="close modal-close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:#06F;margin-top:10px">Update Brand</h3>
    </div>
  	<div class="modal-body">
    <form>
     	 <table width="60%">
         <tr>
         <!--<td><strong>S.No</strong></td>-->
        <td><input type="hidden" name="id" class="id form-control id_update" id="id" value="<?php echo $val["id"]; ?>" readonly="readonly" /></td>
         </tr>  
         <tr>
         <td><strong>Brand Name</strong></td>
         <td><input type="text" class="colour form-control colornameup colornamecup" name="colour" 
         value="<?php echo $val["brand"];  ?>" id="colornameup" maxlength="40" /><input type="hidden" class="root1_h"  value="<?php echo $val["brand"]; ?>"  />
         <span id="cnameerrorup" class="cnameerrorup" style="color:#F00; font-style:italic;"></span>
          <span id="dupup" class="dupup" style="color:#F00; font-style:italic;"></span>
         </td>
         </tr>
         </table>
         </form>
  	</div>
  		<div class="modal-footer">
             <button type="button" class="edit btn btn-primary "  id="edit">Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
  		</div>
</div>
</div>       
</div>


<script type="text/javascript">
$('.colornamecup').live('change',function()
{
	 var cname=$(this).parent().parent().find(".colornamecup").val();
	//var sname=$('.style_nameup').val();
	var m=$(this).offsetParent().find('.cnameerrorup');
	if(cname=='' || cname==null || cname.trim().length==0)
	{
		m.html("Required Field");
	}
	else
	{
		m.html("");
	}
});
$(document).ready(function()
{
    $('#no').live('click',function()
    {
		var root_h=$(this).parent().parent().parent().find('.root1_h').val();
        $(this).parent().parent().find('.colornameup').val(root_h);
		var m=$(this).offsetParent().find('.cnameerrorup');
		var message=$(this).offsetParent().find('.dupup');
		//var message=$(this).parent().parent().find('.dupup').html();
		m.html("");
		message.html("");
	});
});
</script>
<script type="text/javascript">
 $(".colornameup").live('blur',function()
  			{
				//alert("hi");
			var cname=$(this).parent().parent().find('.colornameup').val();
			var id=$(this).offsetParent().find('.id_update').val();
			var message=$(this).offsetParent().find('.dupup');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_colour/update_duplicate_colourname",
		  type:'get',
		   data:{ value1:cname,value2:id},
		  success:function(result)
		  {
		     message.html(result);  	
		  }    		
		});
   }); 
</script>
<?php }} ?>


<?php 
if(isset($colour) && !empty($colour))
{
foreach($colour as $val) 
{
 ?>   
<div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog">
  <div class="modal-content">
     <div class="modal-header modal-padding"> <a class="close modal-close" data-dismiss="modal">×</a>
   
    <h3 id="myModalLabel" style="color:#06F;margin-top:10px">In-Active Color</h3>
    </div>
  <div class="modal-body">
     Do You Want In-Active? &nbsp; <strong><?php echo $val["brand"]; ?></strong>
     <input type="hidden" value="<?php echo $val['id']; ?>" class="hidin" />
  </div>
  <div class="modal-footer">
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
$("#edit").live("click",function()
  {	  
  var i=0;
  var id=$(this).parent().parent().find('.id').val();
  var colour=$(this).parent().parent().find(".colour").val();
  var m=$(this).offsetParent().find('.cnameerrorup');
  //var message=$(this).offsetParent().find('.dupup');
  var message=$(this).parent().parent().find('.dupup').html();
  if((message.trim()).length>0)
	{
		i=1;
	}
  if(colour=='' || colour==null || colour.trim().length==0)
	{
		m.html("Required Field");
		i=1;
	}
	else
	{
		m.html("");
	}
	if(i==1)
	{
		return false;
	}
	else
	{
		
     $.ajax({
		 
      url:BASE_URL+"master_colour/update_colour",
      type:'POST',
      data:{ value1:id,value2:colour },
      success:function(result)
	  {
	 window.location.reload(BASE_URL+"index/");
      }   
	 });
	}
	 $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
		 </script>
         
        <script type="text/javascript">
$(document).ready(function()
 {
$("#yesin").live("click",function()
  {
 
   var hidin=$(this).parent().parent().find('.hidin').val();
     
     $.ajax({
      url:BASE_URL+"master_colour/delete_master_colour",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

  window.location.reload(BASE_URL+"master_colour/");
   }
  });
  
  });
   
   $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
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