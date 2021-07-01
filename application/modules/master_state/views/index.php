<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>master_state/insert_master_state">
<div class="frameset">
<h4 align="center">State</h4>
<div class="frameset_inner">
<table align="center">
<tr>
<td width="60px">
State</td>
<td>
<input type="text" name="state" class="state form-control state_dup" placeholder="Enter state" id="state" maxlength="35"  />
<span id="stateerror" class="reset" style="color:#F00; font-style:oblique;"></span>
<span id="duplica" class="dup" style="color:#F00; font-style:oblique;"></span>
</td>
<td width="10">&nbsp;</td>
<td width="40px">
ST %</td><td>
<input type="text" name="st" class="st form-control" placeholder="Enter ST %" id="st"  />
<span id="stateerror1" class="reset1" style="color:#F00; font-style:oblique;"></span>
</td>
</tr>
<tr>
<td width="70px">
CST %</td><td>
<input type="text" name="cst" class="cst form-control" placeholder="Enter CST %" id="cst"  />
<span id="stateerror2" class="reset2" style="color:#F00; font-style:oblique;"></span>
</td>
<td width="10">&nbsp;</td>
<td width="60px">
VAT %</td><td>
<input type="text" name="vat" class="vat form-control" placeholder="Enter VAT %" id="vat"  />
<span id="stateerror3" class="reset3" style="color:#F00; font-style:oblique;"></span>
<td width="30px">&nbsp;</td>
</tr>
</table>
</div>
<div class="frameset_table">
<table width="100%">
<tr>
<td width="450">&nbsp;</td>
<td><input type="submit" value="Save" class="submit btn btn-default right" id="submit" /></td>
<td><input type="reset" value="Clear" class=" btn btn-default right" id="cancel" /></td>
</tr> 
</table>
</div>
</div>
 </form>
 
 <script type="text/javascript">
$('#state').live('blur',function()
{
	var state=$('#state').val();
	if(state=='' || state==null || state.trim().length==0)
	{
		$('#stateerror').html("Required Field");
	}
	else
	{
		$('#stateerror').html(" ");
	}
});
$('#st').live('blur',function()
{
	var st=$('#st').val();
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(st=='' || st==null || st.trim().length==0)
	{
		$('#stateerror1').html("Required Field");
	}
	else if(!filter.test(st))
	{
		$('#stateerror1').html("Enter Valid Percentage");
	}
	else
	{
		$('#stateerror1').html(" ");
	}
});
$('#cst').live('blur',function()
{
	var cst=$('#cst').val();
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(cst=='' || cst==null || cst.trim().length==0)
	{
		$('#stateerror2').html("Required Field");
	}
	else if(!filter.test(cst))
	{
		$('#stateerror2').html("Enter Valid Percentage");
	}
	else
	{
		$('#stateerror2').html(" ");
	}
});
$('#vat').live('blur',function()
{
	var vat=$('#vat').val();
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(vat=='' || vat==null || vat.trim().length==0)
	{
		$('#stateerror3').html("Required Field");
	}
	else if(!filter.test(vat))
	{
		$('#stateerror3').html("Enter Valid Percentage");
	}
	else
	{
		$('#stateerror3').html(" ");
	}
});


    $('#submit').live('click',function()
    {
	var i=0;
	var state=$('#state').val();
	if(state=='' || state==null || state.trim().length==0)
	{
		$('#stateerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#stateerror').html("");
	}
	var st=$('#st').val();
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(st=='' || st==null || st.trim().length==0)
	{
		$('#stateerror1').html("Required Field");
		i=1;
	}
	else if(!filter.test(st))
	{
		$('#stateerror1').html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		$('#stateerror1').html(" ");
	}
	var cst=$('#cst').val();
	//var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(cst=='' || cst==null || cst.trim().length==0)
	{
		$('#stateerror2').html("Required Field");
		i=1;
	}
	else if(!filter.test(cst))
	{
		$('#stateerror2').html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		$('#stateerror2').html(" ");
	}
	var vat=$('#vat').val();
	//var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(vat=='' || vat==null || vat.trim().length==0)
	{
		$('#stateerror3').html("Required Field");
		i=1;
	}
	else if(!filter.test(vat))
	{
		$('#stateerror3').html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		$('#stateerror3').html(" ");
	}
	var m=$('#duplica').html();
	if((m.trim()).length >0)
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
   $(".state_dup").blur(function()
  			{
         	state=$("#state").val();
		    //alert(busno);
		 $.ajax(
		 {
		  url:BASE_URL+"master_state/add_duplicate_state",
		  type:'get',
		   data:{ value1:state},
		  success:function(result)
		  {
		     $("#duplica").html(result);
      		/*len=( (result + '').length );
			if(len>2){$("#submit").attr("disabled", true);}
			else{$("#submit").attr("disabled", false);}*/
		  	
		  }    		
		});
   }); 
  </script>
  
<br />
<div class="frameset">
<h4 align="center">State Details</h4>
<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
		<thead>
        <tr><th>S.No</th>
            <th>State</th>
            <th>ST %</th>
            <th>CST %</th>
            <th>VAT %</th>
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
         <tr>
         <td class="first_td"><?php echo "$i";?></td>
         <td><?php echo $billto["state"]; ?></td>
          <td><?php echo $billto["st"]; ?></td>
           <td><?php echo $billto["cst"]; ?></td>
            <td><?php echo $billto["vat"]; ?></td>
       
          <td>
        	 <a href="#test1_<?php echo $billto['id']; ?>" data-toggle="modal" name="edit" title="Edit" class="tooltips" ><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
             <!--<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="" data-original-title="Close Panel"><i class="fa fa-times"></i></a>-->
         		<a href="#test3_<?php echo $billto['id']; ?>" data-toggle="modal" name="delete" class="tooltips" title="In-Active"><span class="fa fa-ban red"></span></a>
        	 </td>
            <?php 
   $i++;
   }
  }
  else
  {
   ?>
   </tr>
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
    <h4 align="center">Update State</h4>
    </div>
  	<div class="modal-body">
     <table width="60%">
      	
         <tr>
         
        <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $billto["id"]; ?>" readonly /></td>
         </tr>         
         <tr>
         <td><strong>State</strong></td>
    		<td>
            <input type="text" class="up_state form-control up_state_dup" id="up_state" name="up_state" maxlength="35" value="<?= $billto["state"]; ?>" autocomplete="off" />
     <span id="upstateerror" class="upstateerror" style="color:#F00; font-style:italic;"></span>
     <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
         <input type="hidden" class="h_state" id="h_state" value="<?php echo $billto["state"]; ?>" />
         </td>
         </tr>
         <tr>
         <td width="60px"><strong>ST %</strong></td>
         <td>
<input type="text" name="st_up" class="st_up form-control st" value="<?php echo $billto["st"]; ?>"  />
<span id="upstateerror1" class="upstateerror1" style="color:#F00; font-style:italic;"></span>
<input type="hidden" name="h_st_up" class="h_st_up form-control" id="h_st_up" value="<?php echo $billto["st"]; ?>"  />
</td>
</tr>         
<tr>
<td><strong>CST %</strong></td>
<td>
<input type="text" name="cst_up" class="cst_up form-control cst" value="<?php echo $billto["cst"]; ?>"  />
<span id="upstateerror2" class="upstateerror2" style="color:#F00; font-style:italic;"></span>
<input type="hidden" name="h_cst_up" class="h_cst_up form-control" id="h_cst_up" value="<?php echo $billto["cst"]; ?>"  />

</td>
</tr>         
<tr>
<td><strong>VAT %</strong></td>
<td>
<input type="text" name="vat_up" class="vat_up form-control vat" value="<?php echo $billto["vat"]; ?>"  />
<span id="upstateerror3" class="upstateerror3" style="color:#F00; font-style:italic;"></span>
<input type="hidden" name="h_vat_up" class="h_vat_up form-control" id="h_vat_up" value="<?php echo $billto["vat"]; ?>"  />


</tr>
         </table>
  	</div>
  		<div class="modal-footer">         
            <button type="button" class="edit btn btn-primary  mr5 edit"  id="edit">Update</button>
    		 <button type="reset" class="btn btn-danger "  id="no" data-dismiss="modal"> Discard</button>
    
  		</div>
</div>
</div>        
</div>
<!-- Update script  -->
  
  <script type="text/javascript">
  $("#edit").live("click",function()
  {  //alert("dfsdfds");
 
  var i=0; 
  var id=$(this).parent().parent().find('.id').val();
 
  var up_state=$(this).parent().parent().find(".up_state").val();
   var st_up=$(this).parent().parent().find(".st_up").val();
    var cst_up=$(this).parent().parent().find(".cst_up").val();
	 var vat_up=$(this).parent().parent().find(".vat_up").val();
  
    var percentage_up=$(this).parent().parent().find(".percentage_up").val();
	var m=$(this).offsetParent().find('.upstateerror');
	var stm=$(this).offsetParent().find('.upstateerror1');
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	var cstm=$(this).offsetParent().find('.upstateerror2');
	var vatm=$(this).offsetParent().find('.upstateerror3');
	//var mess=$(this).offsetParent().find('.upduplica');
	 var mess=$(this).parent().parent().find('.upduplica').html();
	
	
	if(up_state=='' || up_state==null || up_state.trim().length==0)
	{
		m.html("Required Field");
		i=1;
	}
	else
	{
		m.html("");
	}
	if(st_up=='' || st_up==null || st_up.trim().length==0)
	{
		stm.html("Required Field");
		i=1;
	}
	else if(!filter.test(st_up))
	{
		stm.html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		stm.html(" ");
	}
	if(cst_up=='' || cst_up==null || cst_up.trim().length==0)
	{
		cstm.html("Required Field");
		i=1;
	}
	else if(!filter.test(cst_up))
	{
		cstm.html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		cstm.html(" ");
	}
	if(vat_up=='' || vat_up==null || vat_up.trim().length==0)
	{
		vatm.html("Required Field");
		i=1;
	}
	else if(!filter.test(vat_up))
	{
		vatm.html("Enter Valid Percentage");
		i=1;
	}
	else
	{
		vatm.html(" ");
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
      url:BASE_URL+"master_state/update_state",
      type:'POST',
      data:{ value1:id,value2:up_state,value3:st_up,value4:cst_up,value5:vat_up, },
      success:function(result)
   {
  window.location.reload(BASE_URL+"master_state");
   for_response('Updated Successfully...');
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
</script>
<script type="text/javascript">
$('.up_state').live('blur',function()
{
	var ustate=$(this).parent().parent().find(".up_state").val();
	var m=$(this).offsetParent().find('.upstateerror');
	if(ustate=='' || ustate==null || ustate.trim().length==0)
	{
		m.html("Required Field");
	}
	else
	{
		m.html("");
	}
});
$('.st_up').live('blur',function()
{
	
	var st=$(this).parent().parent().find(".st_up").val();
	var stm=$(this).offsetParent().find('.upstateerror1');
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(st=='' || st==null || st.trim().length==0)
	{
		stm.html("Required Field");
	}
	else if(!filter.test(st))
	{
		stm.html("Enter Valid Percentage");
	}
	else
	{
		stm.html(" ");
	}
});
$('.cst_up').live('blur',function()
{
	
	var cst=$(this).parent().parent().find(".cst").val();
	var cstm=$(this).offsetParent().find('.upstateerror2');
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(cst=='' || cst==null || cst.trim().length==0)
	{
		cstm.html("Required Field");
	}
	else if(!filter.test(cst))
	{
		cstm.html("Enter Valid Percentage");
	}
	else
	{
		cstm.html(" ");
	}
});
$('.vat_up').live('blur',function()
{
	
	var vat=$(this).parent().parent().find(".vat").val();
	var vatm=$(this).offsetParent().find('.upstateerror3');
	var filter=/^\d{0,2}(\.\d{0,2}){0,1}$/;
	if(vat=='' || vat==null || vat.trim().length==0)
	{
		vatm.html("Required Field");
	}
	else if(!filter.test(vat))
	{
		vatm.html("Enter Valid Percentage");
	}
	else
	{
		vatm.html(" ");
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
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4>In-Active State</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto["state"]; ?></strong>
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
	  for_loading('Loading Data Please Wait...');
   var hidin=$(this).parent().parent().find('.hidin').val();
    
     $.ajax({
      url:BASE_URL+"master_state/delete_master_state",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){
		  

	 window.location.reload(BASE_URL+"master_state/");
	 for_response('Data Deleted Successfully...');
	  }
	 });
	 
  });
		 
	  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
  });
  </script>
  
  
<script type="text/javascript">
   $("#no").live("click",function()
  {
      
   
   var h_state=$(this).parent().parent().parent().find('.h_state').val();
  
   $(this).parent().parent().find('.up_state').val(h_state);
   
    var h_st_up=$(this).parent().parent().parent().find('.h_st_up').val();
    $(this).parent().parent().find('.st_up').val(h_st_up);
	
    var h_cst_up=$(this).parent().parent().parent().find('.h_cst_up').val();
   $(this).parent().parent().find('.cst_up').val(h_cst_up);
   
    var h_vat_up=$(this).parent().parent().parent().find('.h_vat_up').val();
   $(this).parent().parent().find('.vat_up').val(h_vat_up);
   var m=$(this).offsetParent().find('.upstateerror');
   m.html("");
   var stm=$(this).offsetParent().find('.upstateerror1');
	var cstm=$(this).offsetParent().find('.upstateerror2');
	var vatm=$(this).offsetParent().find('.upstateerror3');
	var message=$(this).offsetParent().find('.upduplica');
    stm.html("");
	cstm.html("");
	vatm.html("");
	message.html("");
    });
	
   </script>
   <script>
 $(".up_state_dup").live('blur',function()
  			{
			var state=$(this).parent().parent().find('.up_state').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplica');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_state/update_duplicate_state",
		  type:'POST',
		   data:{ value1:state,value2:id},
		  success:function(result)
		  {
		     message.html(result);
      		//len=( (result + '').length );
//			if(len>2){$("#update").attr("disabled", true);}
//			else{$("#update").attr("disabled", false);}
		  	
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
		 $('.reset1').html(""); 
		 $('.reset2').html(""); 
		 $('.reset3').html(""); 
		 $('.dup').html("");
		
		   
		   
	   });
    
});
   
   </script>