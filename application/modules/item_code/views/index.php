 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<div class="frameset">
<h4 align="center">Item Code</h4>
<form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>item_code/insert_item_code">

<table align="center" class="table table-striped table-bordered responsive no-footer dtr-inline" >
  <tr>
    <td style="vertical-align:middle">Item Code</td>
    <td>
    	<input type="text" name="item[item_code]" class="item form-control code_dup" placeholder="Enter Item Code" id="item"  />
		<span id="codeerror" class="reset" style="color:#F00; font-style:italic;"></span>
		<span id="duplica" class="dup" style="color:#F00; font-style:italic;"></span>
    </td>
    <td rowspan="6" width="10%" class='style_image_div'>
    	 <img  class="add_staff_thumbnail" style="width: 164px;height: 164px;" src=""/>
    </td>
  </tr>
  <tr>
    <td>Fabric Type</td>
    <td><input type="text" class="form-control" name="item[fabric_type]" id="fabric"/>
    <span id="codeerror1" class="reset1" style="color:#F00; font-style:italic;"></span></td>
    </tr>
  <tr>
    <td>Fit</td>
    <td>
    	<select name="item[fit]" class="form-control" id="itemfit">
        	<option value="">Select</option>
            <?php
            	if(isset($fit) && !empty($fit))
				{
					foreach($fit as $fit_val)
					{
						?>
                        	<option value="<?=$fit_val['id']?>"><?=$fit_val['master_fit']?></option>
                       <?php
					}
				}
			?>
        </select> <span id="codeerror2" class="reset2" style="color:#F00; font-style:italic;"></span>
    </td>
    </tr>
  <tr>
    <td>Pattern</td>
    <td><input type="text" name="item[pattern]" class="form-control" id="pattern"/>
    <span id="codeerror3" class="reset3" style="color:#F00; font-style:italic;"></span></td>
  </tr>
   <tr>
    <td>Style</td>
    <td>
    	<select  name="item[style_no]" class="form-control style_class" id="style_no">
        	<option value="">Select</option>
             <?php
            	if(isset($style) && !empty($style))
				{
					foreach($style as $style_val)
					{
						?>
                        	<option value='<?=$style_val['id']?>'><?=$style_val['style_name']?></option>
                       <?php
					}
				}
			?>
        </select><span id="codeerror4" class="reset4" style="color:#F00; font-style:italic;"></span>
    </td>
    
  </tr>
	<tr>
    <td>Color</td>
    <td class="style_color_div">
    	<select  class="form-control" id="itemcolor">
        	<option value="">Select</option>
        </select><span id="codeerror5" class="reset5" style="color:#F00; font-style:italic;"></span>
    </td>
    
  </tr>
  
</table>
<div align="right" class="frameset_table">
<table width="100%">
<tr>
    <td width="450">&nbsp;</td>
    <td><input type="submit" value="Save" class="submit btn btn-default right" id="submit" class="form-control"></td>
       <td>&nbsp;</td>
  <td><input type="reset" value="Clear" class=" btn btn-default right" id="cancel" /></td>

  </tr>
  </table>
  </div>
</div>
<p>&nbsp;</p>
</form>

<script type="text/javascript">
$('.style_class').live('change',function(){
	var val=$(this).closest('table').find('.style_image_div');
	var val1=$(this).closest('table').find('.style_color_div');
	$.ajax(
	{
		  url:BASE_URL+"item_code/get_image",
		  type:'get',
		   data:{ s_id:$(this).val()},
		  success:function(result)
		  {
			 val.html(result);	
		  }    		
	});
	$.ajax(
	{
		  url:BASE_URL+"item_code/get_color",
		  type:'get',
		   data:{ s_id:$(this).val()},
		  success:function(result)
		  {
			 val1.html(result);	
		  }    		
	});
});

$('#item').live('blur',function()
{
	var item=$('#item').val();
	if(item=='' || item==null || item.trim().length==0)
	{
		$('#codeerror').html("Required Field");
	}
	else
	{
		$('#codeerror').html(" ");
	}
});
$('#fabric').live('blur',function()
{
	var fabric=$('#fabric').val();
	if(fabric=='' || fabric==null || fabric.trim().length==0)
	{
		$('#codeerror1').html("Required Field");
	}
	else
	{
		$('#codeerror1').html(" ");
	}
});
$('#itemfit').live('blur',function()
{
	var itemfit=$('#itemfit').val();
	if(itemfit=='')
	{
		$('#codeerror2').html("Required Field");
	}
	else
	{
		$('#codeerror2').html(" ");
	}
});
$('#pattern').live('blur',function()
{
	var pattern=$('#pattern').val();
	if(pattern=='' || pattern==null || pattern.trim().length==0)
	{
		$('#codeerror3').html("Required Field");
	}
	else
	{
		$('#codeerror3').html(" ");
	}
});
$('#style_no').live('blur',function()
{
	var style_no=$('#style_no').val();
	if(style_no=='')
	{
		$('#codeerror4').html("Required Field");
	}
	else
	{
		$('#codeerror4').html(" ");
	}
});
$('#itemcolor').live('blur',function()
{
	var itemcolor=$('#itemcolor').val();
	if(itemcolor=='')
	{
		$('#codeerror5').html("Required Field");
	}
	else
	{
		$('#codeerror5').html(" ");
	}
});

    $('#submit').live('click',function()
    {
	var i=0;
	var item=$('#item').val();
	if(item=='' || item==null || item.trim().length==0)
	{
		$('#codeerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror').html("");
	}
	var fabric=$('#fabric').val();
	if(fabric=='' || fabric==null || fabric.trim().length==0)
	{
		$('#codeerror1').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror1').html(" ");
	}
	var itemfit=$('#itemfit').val();
	if(itemfit=='')
	{
		$('#codeerror2').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror2').html(" ");
	}
	var pattern=$('#pattern').val();
	if(pattern=='' || pattern==null || pattern.trim().length==0)
	{
		$('#codeerror3').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror3').html(" ");
	}
	var style_no=$('#style_no').val();
	if(style_no=='')
	{
		$('#codeerror4').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror4').html(" ");
	}
	var itemcolor=$('#itemcolor').val();
	if(itemcolor=='')
	{
		$('#codeerror5').html("Required Field");
		i=1;
	}
	else
	{
		$('#codeerror5').html(" ");
	}
	var me=$('#duplica').html();
	if((me.trim()).length>0)
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
   $(".code_dup").live('blur',function()
  			{
         	code=$("#item").val();
		    //alert(busno);
		 $.ajax(
		 {
		  url:BASE_URL+"item_code/add_duplicate_code",
		  type:'get',
		   data:{ value1:code},
		  success:function(result)
		  {
		     $("#duplica").html(result);	
		  }    		
		});
   }); 
  </script>
</table>


<div><h4 align="center" >Item Code Details</h4></div>
		<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" style="width: 100%;margin: 0 auto;">
		<thead>
            <tr>
                <th>S.No</th>
                <th>Item Code</th>
                <th>Fabric Type</th>
                <th>Fit</th>
                <th>Pattern</th>
                <th>Style</th>
                <th>Color</th>
                <th>Action</th>
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
         				<tr>
            				<td class="first_td"><?php echo "$i";?></td>
         					<td><?php echo $billto["item_code"]; ?></td>
                            <td><?php echo $billto["fabric_type"]; ?></td>
                            <td><?php echo $billto["master_fit"]; ?></td>
                            <td><?php echo $billto["pattern"]; ?></td>
                            <td><?php echo $billto["style_name"]; ?></td>
                            <td><?php echo $billto["colour"]; ?></td>
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
             <td>No Data Found</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
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
		{ 
		
		?>      
            <div id="test1_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" 
              role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
                        <h3 id="myModalLabel" style="color:#06F">Update Item Code</h3>
                        </div>
                        <div class="modal-body">
                            <form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>item_code/update_item">
            					<input type="hidden" value="<?php echo $billto['id']?>" name="item_id">
                                <table align="center" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" style="width:90%" border="1">
                                  <tr>
                                    <td><strong>Item Code</strong></td>
                                    <td>
                                        <input type="text" name="item[item_code]" value='<?=$billto['item_code']?>' class="item form-control up_item up_code_dup" placeholder="Enter Item Code" id=""  />
                                        <span id="upcodeerror" class="upcodeerror" style="color:#F00; font-style:italic;"></span>
                                        <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
                                    </td>
                                    <td rowspan="6" width="10%" class='style_image_div'>
                                         <img  class="add_staff_thumbnail" style="width: 164px;height: 164px;" src="<?=$this->config->item('base_url').'style_image/'.$billto['style_image']?>"/>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><strong>Fabric Type</strong></td>
                                    <td><input type="text" class="form-control itemfabric" value='<?=$billto['fabric_type']?>' name="item[fabric_type]" />
                                    <span id="upcodeerror1" class="upcodeerror1" style="color:#F00; font-style:italic;"></span></td>
                                    </tr>
                                  <tr>
                                    <td><strong>Fit</strong></td>
                                    <td>
                                        <select name="item[fit]" class="form-control">
                                           
                                            <?php
                                                if(isset($fit) && !empty($fit))
                                                {
                                                    foreach($fit as $fit_val)
                                                    {
                                                        ?>
                                                            <option <?=($billto['fit_id']==$fit_val['id'])?'selected':''?> value="<?=$fit_val['id']?>"><?=$fit_val['master_fit']?></option>
                                                       <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    </tr>
                                  <tr>
                                    <td><strong>Pattern</strong></td>
                                    <td><input type="text" name="item[pattern]"  value='<?=$billto['pattern']?>' class="form-control itempattern" />
                                    <span id="upcodeerror3" class="upcodeerror3" style="color:#F00; font-style:italic;"></span></td>
                                  </tr>
                                   <tr>
                                    <td><strong>Style</strong></td>
                                    <td>
                                        <select  name="item[style_no]" class="form-control style_class">
                                           
                                             <?php
                                                if(isset($style) && !empty($style))
                                                {
                                                    foreach($style as $style_val)
                                                    {
                                                        ?>
                                                            <option <?=($billto['style_id']==$style_val['id'])?'selected':''?> value='<?=$style_val['id']?>'><?=$style_val['style_name']?></option>
                                                       <?php
                                                    }
                                                }
                                            ?>
                                        </select>  
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td><strong>Color</strong></td>
                                    <td class="style_color_div">
                                       <select  name="item[color_id]" class="form-control style_class itemupcolor">
                                            <option value="">Select</option>
                                             <?php
											 
                                                if(isset($billto['style_color']) && !empty($billto['style_color']))
                                                {
                                                    foreach($billto['style_color'] as $style_val)
                                                    {
                                                        ?>
                                                            <option <?=($billto['color_id']==$style_val['color_id'])?'selected':''?> value='<?=$style_val['color_id']?>'><?=$style_val['colour']?></option>
                                                       <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span id="upcodeerror5 reset4" class="upcodeerror5" style="color:#F00; font-style:italic;"></span>
                                    </td>
                                    
                                  </tr>
                                  
                                </table>
                                <p>&nbsp;</p>
                          
            
                        </div>
                        <div class="modal-footer">         
                           <input type="submit" value="Update" class="submit btn btn-primary " id="edit" class="form-control">
                           <button type="reset" class="btn btn-danger"  id="no" data-dismiss="modal">Discard</button>
                        </div> 
                        </form>
                    </div>
                </div>        
            </div>
	   <?php   
            }
		}
       ?>
        <script type="text/javascript">
            $('.up_item').live('blur',function()
            {
                var uitem=$(this).parent().parent().find(".up_item").val();
                var m=$(this).offsetParent().find('.upcodeerror');
                if(uitem=='' || uitem==null || uitem.trim().length==0)
                {
                    m.html("Required Field");
                }
                else
                {
                    m.html("");
                }
            });
			 $('.itemfabric').live('blur',function()
            {
                var itemfabric=$(this).parent().parent().find(".itemfabric").val();
                var f=$(this).offsetParent().find('.upcodeerror1');
                if(itemfabric=='' || itemfabric==null || itemfabric.trim().length==0)
                {
                    f.html("Required Field");
                }
                else
                {
                    f.html("");
                }
            });
			$('.itempattern').live('blur',function()
            {
                var uitem=$(this).parent().parent().find(".itempattern").val();
                var ip=$(this).offsetParent().find('.upcodeerror3');
                if(uitem=='' || uitem==null || uitem.trim().length==0)
                {
                    ip.html("Required Field");
                }
                else
                {
                   ip.html("");
                }
            });
			$('.itemupcolor').live('blur',function()
            {
                var itemupcolor=$(this).parent().parent().find(".itemupcolor").val();
                var ic=$(this).offsetParent().find('.upcodeerror5');
                if(itemupcolor=='')
                {
                    ic.html("Required Field");
                }
                else
                {
                    ic.html("");
                }
            });
            </script>
<!--delete all-->
<?php 
if(isset($detail) && !empty($detail))
{
foreach($detail as $billto) 
{
 ?>   
<div id="test3_<?php echo $billto['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h4 style="color:#06F">In-Active Item Code</h4><h3 id="myModalLabel">
</div><div class="modal-body">
     Do you want In-Active? &nbsp; <strong><?php echo $billto["item_code"]; ?></strong>
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
      url:BASE_URL+"item_code/delete_item_code",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

	 window.location.reload(BASE_URL+"item_code/");
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

  var up_item=$(this).parent().parent().find(".up_item").val();
  var m=$(this).offsetParent().find('.upcodeerror');
  var message=$(this).parent().parent().find(".upduplica").html();
   var itemfabric=$(this).parent().parent().find(".itemfabric").val();
	var f=$(this).offsetParent().find('.upcodeerror1');
	var uitem=$(this).parent().parent().find(".itempattern").val();
	var ip=$(this).offsetParent().find('.upcodeerror3');
	 var itemupcolor=$(this).parent().parent().find(".itemupcolor").val();
	var ic=$(this).offsetParent().find('.upcodeerror5');
	if(up_item=='' || up_item==null || up_item.trim().length==0)
	{
		m.html("Required Field");
		i=1;
	}
	else
	{
		m.html("");
	}
	if(itemfabric=='' || itemfabric==null || itemfabric.trim().length==0)
	{
		f.html("Required Field");
		i=1;
	}
	else
	{
		f.html("");
	}
	
	if(uitem=='' || uitem==null || uitem.trim().length==0)
	{
		ip.html("Required Field");
		i=1;
	}
	else
	{
	   ip.html("");
	}
	if(itemupcolor=='')
	{
		ic.html("Required Field");
		i=1;
	}
	else
	{
		ic.html("");
	}
	if((message.trim()).length>0)
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
      url:BASE_URL+"item_code/update_item",
      type:'POST',
      data:{ value1:id,value2:up_item },
      success:function(result)
   {
	    //THIS IS FOR ALERT
					  jQuery.gritter.add({
					   title: 'Success!',
					   text: 'Item code Update Successfully.',
					  class_name: 'growl-success',
					  image: '<?=$theme_path?>/images/screen.png',
					   sticky: false,
					   time: ''
					  });
  window.location.reload(BASE_URL+"item_code");
      }   
  });
	}
  $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  });
   $("#no").live("click",function()
  {
   var h_item=$(this).parent().parent().parent().find('.h_item').val();
  
   $(this).parent().parent().find('.up_item').val(h_item);
   var m=$(this).offsetParent().find('.upcodeerror');
   var message=$(this).offsetParent().find('.upduplica');
   message.html("");
   m.html("");
    });
   </script>
 <script>
 $(".up_code_dup").live('blur',function()
  			{
			var code=$(this).parent().parent().find('.up_item').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplica');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"item_code/update_duplicate_code",
		  type:'POST',
		   data:{ value1:code,value2:id},
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
		 $('.reset1').html("");
		 $('.reset2').html("");
		 $('.reset3').html("");
		 $('.reset4').html("");
		 $('.reset5').html("");
		 $('.dup').html("");
		  
	  });
    
});
  
  </script>