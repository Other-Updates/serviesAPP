 <?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
 <script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">
 <div class="media">
 </div>
<div class="contentpanel">
<input type="button" value="Download Sales Order Formate" class="btn btn-primry formate_btn" style="display:none;float:right;" />
<div class="col-md-15">
    <!-- Nav tabs -->
    
    <ul class="nav nav-tabs nav-info">
        <li class="active"><a href="#home6" data-toggle="tab"><strong>Style</strong></a></li>
        <li class=""><a href="#profile6" data-toggle="tab"><strong>Add</strong></a></li>
        <li class=""><a href="#order" data-toggle="tab"><strong>Sales Order Formate</strong></a></li>
    </ul>




    <!-- Tab panes -->
    <div class="tab-content tab-content-info mb30">
        <div class="tab-pane active" id="home6">
            <div class="frameset_big1">
                <div id="list">
                
                <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                <th>S.no</th>
                <th>Image</th>
                <th>Style</th>
                <th>Product</th>
                <th>Fit</th>
                <th>Landed Cost</th>
               <!-- <th>MRP</th>-->
                <th>Actions</th>
                </thead>
                <tbody>
                <?php
                        if(isset($style) && !empty($style))
                        {
                            $i=1;
                            foreach($style as $val)
                            {
                        ?>
                            <tr>
                                <td class="first_td"><?php echo "$i";?></td>
                                <td><img src="<?php echo $this->config->item('base_url')?>/style_image/<?=$val['style_image']?>" style="width:30px;height:30px;radius:5px;border-radius: 50%;" /></td>
                                <td><?=$val['style_name']?></td>
                                 <td><?=$val['style_type']?></td>
                                  <td><?=$val['master_fit']?></td>
                                 <td><?=$val['sp']?></td>
                                <td style="display:none;"><?=$val['mrp']?></td>
                               
                               
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
                                <td colspan="7">No Data Found</td>
                            </tr>
                           <?php
                        }
                         ?>    
                </tbody>
                </table>
                </div>
                </div>
        </div><!-- tab-pane -->
      
        <div class="tab-pane" id="profile6">
            <form enctype="multipart/form-data" action="<?php echo $this->config->item('base_url'); ?>master_style/insert_style"  name="form" method="post"> 
                <table class="table table-striped table-bordered no-footer dtr-inline">
                    <tr>
                      <td>Style</td>
                      <td>
                        <input type="text" name="style[style_name]" class="style  style_namedup form-control" placeholder="Style" id="style_name" />
                        <span id="snameerror" class="val" style="color:#F00; font-style:italic;"></span>
                       <span id="nameduplic" class="val" style="color:#F00; font-style:italic;"></span>
                        </td>
                      <td>Product</td>
                      <td>
                        <select  name="style[style_type]" class="form-control" id="style_type"> 
                          <option value="">Select</option>
                          <?php 
                                    if(isset($all_style_type) && !empty($all_style_type))
                                    {
                                        foreach($all_style_type as $val1)
                                        {
                                            ?>
                          <option value='<?=$val1['style_type_id']?>'><?=$val1['style_type']?></option>
                          <?php
                                        }
                                    }
                                ?>
                          </select> 
                       <span id="snameerror3" class="val" style="color:#F00; font-style:italic;"></span>
                        </td>
                       
                      <td rowspan="2">Color</td>
                      <td rowspan="2">
                        <select name="style_color[]" class="form-control" multiple style="width: 100px;height: 117px;" id="style_color">
                            <?php 
                                if(isset($all_color) && !empty($all_color))
                                {
                                    foreach($all_color as $color_val)
                                    {
                                        ?>
                                            <option value="<?=$color_val['id']?>"><?=$color_val['colour']?></option>
                                        <?php
                                    }
                                }
                           ?>
                          </select><span id="snameerror5" class="val" style="color:#F00; font-style:italic;"></span> 
                        </td>
                       <td rowspan="2">Size</td>
                      <td rowspan="2">
                        <select name="style_size[]" class="form-control" multiple style="width: 100px;height: 117px;" id="style_size">
                          <?php 
                                if(isset($all_size) && !empty($all_size))
                                {
                                    foreach($all_size as $val2)
                                    {
                                        ?>
                          <option value="<?=$val2['id']?>"><?=$val2['size']?></option>
                          <?php
                                    }
                                }
                            ?>
                          </select><span id="snameerror4" class="val" style="color:#F00; font-style:italic;"></span> 
                        </td> 
                      <td rowspan="2">Image</td>
                      <td rowspan="2">
                        <img id="blah" class="add_staff_thumbnail" width="100px" height="100px"
                src=""/>
                        <input type='file' name="admin_name" id="imgInp" class="form-control"/><span id="snameerror7" class="val" style="color:#F00; font-style:italic;"></span>
                        </td>
                      </tr>
                <tr>
                  
                  <td>Landed Cost</td>
                  <td>
                    <input type="text" name="style[sp]" class="l_cost form-control low_mrp dot_val" id="landedcost"/> <span id="snameerror6" class="val" style="color:#F00; font-style:italic;"></span>
                  </td>
                   <td>Fit</td>
                        <td>
                       <select name="style[fit]" class="form-control" id="stfit">
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
                        </select><span id="snameerror8" class="val" style="color:#F00; font-style:italic;"></span> 
                        </td>
                 
                      
                  </tr>
                </table>
                <table style="width:50%;margin:0 auto;"  class="table table-striped table-bordered no-footer dtr-inline">
                	<tr>
                    	<td width="26%">Style Description</td>
                        <td>
                        	<textarea  style="width: 375px;" name="style[style_desc]"></textarea>
                        </td>
                    </tr>
                </table>
                <div class="clear"></div>
                <table style="width:50%;margin:0 auto;"  class="table table-striped table-bordered no-footer dtr-inline">
               
                    	<tr>
                        	<td class="first_td1">Customer</td>
                            <td class="first_td1">MRP</td>
                        </tr>
                 
					<?php 
                        if(isset($all_customer) && !empty($all_customer))
                        {
                            foreach($all_customer as $val)
                            {
                                ?>
                                <tr>
                                	<td>
                                    	<input type="hidden" value='<?=$val['id']?>' name="style_customer[]" />
                                        <?=$val['store_name']?>
                                    </td>
                                	<td>
                                    	<input type="text" class="form-control mrp_cost mrp_cost1 dot_val" id="mrp_cost1" name="style_mrp[]" />
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
               
                    <tr style="display:none;">
                        <td>MRP</td>
                        <td><input type="text" name="style[mrp]" value="1"  class="form-control dot_val" id="mrp" />
                        <span id="snameerror2" class="val" style="color:#F00; font-style:italic;"></span>
                        <span class="low_mrp"></span>
                        </td>
                    </tr>
                </table>
                <div class="frameset_table right">
                
                <table>
                <tr>
                <td width="410">&nbsp;</td>
                <td><input type="submit" name="submit" class="btn btn-default right" value="Add" id="submit" /></td>
                <td>&nbsp;</td>
                <td><input type="reset" value="Clear" class="submit btn btn-default right" id="reset" /></td>
                
                </tr> 
                </table>
                
                </div>
            </form>
            <br /><br />
        </div><!-- tab-pane -->
      <div class="tab-pane" id="order">
      	<?php 
if(isset($style) && !empty($style))
{
	?>
    <table id='sales_formate' class="table table-bordered" >
    	<thead>
        	<th>Style</th>
            <th>Color</th>
            <?php 
				if(isset($all_size) && !empty($all_size))
				{
					foreach($all_size as $val2)
					{
						?>
		  					<td><?=$val2['size']?></td>
		  <?php
					}
				}
			?>
        </thead>
            <tbody>
            <?php
            foreach($style as $val) 
            {
               
                foreach($val['style_color'] as $val1) 
                {
					?>
                    <tr>
                    	<td><?=$val['style_name']?></td><td><?=$val1['colour']?></td>
                    	<?php 
							if(isset($all_size) && !empty($all_size))
							{
								foreach($all_size as $val2)
								{
									?>
										<td>0</td>
					  <?php
								}
							}
						?>
                    </tr>
                    <?php
                }
                
             ?>
             <?php 
            }
            }
             ?>
             </tbody>
     </table>
      </div>
    </div><!-- tab-content -->
    
</div>




<script type="text/javascript">
	 function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").live('change',function(){
	if($(this).val()=="" || $(this).val()==null)
	{
		
	}
	else
	{
readURL(this);
	}
    });
	
	function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".imgInp").live('change',function(){
	if($(this).val()=="" || $(this).val()==null)
	{
		
	}
	else
	{
readURL1(this);
	}
    });
	</script>
    <script type="text/javascript">
   $(".style_namedup").live('blur',function()
  	{
         name=$("#style_name").val();

		 $.ajax(
		 {
		  url:BASE_URL+"master_style/add_duplicate_stylename",
		  type:'get',
		   data:{ value1:name},
		  success:function(result)
		  {
		     $("#nameduplic").html(result);	
		  }    		
		});
   }); 
   /*$('.mrp_cost').live('blur',function()
	{
	
	var mrp=$(this).closest('tbody').find('.l_cost').val();
	var org_mrp=Number(mrp)+Number(mrp*(2.5/100));
	//console.log(org_mrp);
	alert(mrp);
	if($(this).val() < org_mrp)
	{
		$(this).closest('tbody').find('.low_mrp').html('MRP is lessthan 2.5 % of Landed Cost');
		$(this).closest('tbody').find('.low_mrp').css('color','red');
	}
	else
	{
		$(this).closest('tbody').find('.low_mrp').html('');
		$(this).closest('tbody').find('.low_mrp').css('color','');
	}
	});*/
	
	$('.mrp_cost').live('keyup',function()
	{    
	var mrp=$(".l_cost").val();
	var org_mrp=Number(mrp)+Number(mrp*(25/100));
	//console.log(org_mrp);
	if($(this).val() < org_mrp)
	{
		//alert("wrong");
	    $(this).closest('tbody').find('.low_mrp').html('MRP is lessthan 2.5 % of Landed Cost');
		$(this).closest('tbody').find('.low_mrp').css('color','red');
		//$('.mrp_cost1').css('border','solid 1px red');
	}
	else
	{
		//alert("correct");
		//$(this).closest('tbody').find('.low_mrp').html('');
		//$(this).closest('tbody').find('.low_mrp').css('color','');
		$('#mrp_cost1').css('border','');
	}
	});

  </script>

<script type="text/javascript">
/*$('#style_name').live('keyup',function(){
	 $.ajax({
		  url    :BASE_URL+"master_style/get_lot_no",
		  type   :'get',
		  data   :{
			     style_name:$(this).val()
		   },
		 	 success:function(result)
		  {
			  $('#lot_no').val(result.trim());
		  }
		});
});*/
$('#style_name').live('blur',function()
{
	var sname=$('#style_name').val();
	if(sname=='' || sname==null || sname.trim().length==0)
	{
		$('#snameerror').html("Required Field");
	}
	else
	{
		$('#snameerror').html(" ");
	}
});
$('#stfit').live('blur',function()
{
	
	var stfit=$('#stfit').val();
	if(stfit=='')
	{
		$('#snameerror8').html("Required Field");
	}
	else
	{
		$('#snameerror8').html(" ");
	}
});
$("#mrp").live('blur',function()
{
	var mrp=$("#mrp").val();
	var nfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	if(mrp=="" || mrp==null || mrp.trim().length==0)
	{
		$("#snameerror2").html("Required Field");
	}
	else if(!nfilter.test(mrp))
	{
		$("#snameerror2").html("Numeric Only");
	}
	else
	{
		$("#snameerror2").html("");
	}
});
$('#style_type').live('blur',function()
{
	var stype=$('#style_type').val();
	if(stype=='')
	{
		$('#snameerror3').html("Required Field");
	}
	else
	{
		$('#snameerror3').html(" ");
	}
});
$('#style_size').live('blur',function()
{
	var ssize=$('#style_size').val();
	if(ssize=='' || ssize==null)
	{
		$('#snameerror4').html("Select Size");
	}
	else
	{
		$('#snameerror4').html(" ");
	}
});
$('#style_color').live('blur',function()
{
	
	var scolor=$('#style_color').val();
	if(scolor=='' || scolor==null)
	{
		$('#snameerror5').html("Select color");
	}
	else
	{
		$('#snameerror5').html(" ");
	}
});
$("#landedcost").live('blur',function()
{
	var landedcost=$("#landedcost").val();
	var llfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	if(landedcost=="" || landedcost==null || landedcost.trim().length==0)
	{
		$("#snameerror6").html("Required Field");
	}
	else if(!llfilter.test(landedcost))
	{
		$("#snameerror6").html("Numeric Only");
	}
	else
	{
		$("#snameerror6").html("");
	}
});
$("#imgInp").change(function() {
		//alert("hi");

    var val = $(this).val();

    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'gif': case 'jpg': case 'png': case 'jpeg': case '':
            $("#snameerror7").html("");
            break;
        default:
            $(this).val();
            // error message here
           $("#snameerror7").html("Invalid File Type");
            break;
    }
});
//submit function
    $('#submit').live('click',function()
    {
	var i=0;
	var sname=$('#style_name').val();
	if(sname=='' || sname==null || sname.trim().length==0)
	{
		$('#snameerror').html("Required Field");
		i=1;
	}
	else
	{
		$('#snameerror').html("");
	}
	
	var mrp=$("#mrp").val();
	var nfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	if(mrp=="" || mrp==null || mrp.trim().length==0)
	{
		$("#snameerror2").html("Required Field");
		i=1;
	}
	else if(!nfilter.test(mrp))
	{
		$("#snameerror2").html("Numeric Only");
		i=1;
	}
	else
	{
		$("#snameerror2").html("");
	}
	var stype=$('#style_type').val();
	if(stype=='')
	{
		$('#snameerror3').html("Required Field");
		i=1;
	}
	else
	{
		$('#snameerror3').html(" ");
	}
	var ssize=$('#style_size').val();
	if(ssize=='' || ssize==null)
	{
		$('#snameerror4').html("Select Size");
		i=1;
	}
	else
	{
		$('#snameerror4').html(" ");
	}
	var scolor=$('#style_color').val();
	if(scolor=='' || scolor==null)
	{
		$('#snameerror5').html("Select color");
		i=1;
	}
	else
	{
		$('#snameerror5').html(" ");
	}
	var landedcost=$("#landedcost").val();
	var llfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	if(landedcost=="" || landedcost==null || landedcost.trim().length==0)
	{
		$("#snameerror6").html("Required Field");
		i=1;
	}
	else if(!llfilter.test(landedcost))
	{
		$("#snameerror6").html("Numeric Only");
		i=1;
	}
	else
	{
		$("#snameerror6").html("");
	}
	var stfit=$('#stfit').val();
	if(stfit=='')
	{
		$('#snameerror8').html("Required Field");
		i=1;
	}
	else
	{
		$('#snameerror8').html(" ");
	}
	var m=$('#nameduplic').html();
	if((m.trim()).length>0)
	{
		i=1;
	}
	var mc=$('#snameerror7').html();
	if((mc.trim()).length>0)
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

$(document).ready(function()
{
    $('#reset').live('click',function()
    {
		$('.val').html("");
		
	});
});
</script>
<div style="clear:both"></div>
<br />


<?php 
if(isset($style) && !empty($style))
{
foreach($style as $val) 
{
	
	
 ?>   

<div id="test1_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" 
  role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
  	<div class="modal-dialog"  style="width: 1000px;">
  	<div class="modal-content">
    <div class="modal-header"><a class="close" data-dismiss="modal">×</a>   
    <h3 id="myModalLabel" style="color:#06F">Update Style</h3>
    </div>
  	<div class="modal-body" style="overflow:auto">
    <form method="post" enctype="multipart/form-data" action="<?=$this->config->item('base_url').'master_style/update_style'?>">
    	<input type="hidden" name="style_id" value="<?php echo $val['id']; ?>" class="id_dup form-control" />
        <div style="width:60%; float:left">
    	<table width="100%" border="0" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" style="margin:0; padding:0;">
    	  <tr>
    	    <td rowspan="7" width="6%">
             <img class="blah" src="<?=$this->config->item('base_url').'/style_image/'.$val["style_image"]?>" class="add_staff_thumbnail" width="160px" height="100px"src=""/><span id="imgtype" class="val imgtype"  style="color:#F00; font-style:oblique;"></span>
            <input type='file' name="admin_name2" class="imgInp form-control" />
            </td>
    	    <td width="10%" ><strong>Style</strong></td>
    	    <td width="10%"><input type="text" name="style_update[style_name]" value="<?=$val["style_name"]?>" class="form-control style_nameup up_stylename_dup" />
            <span id="snameerrorup" class="val snameerrorup"  style="color:#F00; font-style:oblique;"></span> 
            <span id="upduplication" class="val upduplication"  style="color:#F00; font-style:oblique;"></span></td>
  	    </tr>
    	 
    	  <tr>
    	    <td><strong>Product</strong></td>
    	    <td>
            	<select  name="style_update[style_type]" class="style_id_up form-control" id="style_id_up" >
                   
                    <?php
				 
                            if(isset($all_style_type) && !empty($all_style_type))
                            {
                                $s=0;
                                foreach($all_style_type as $val1)
                                {
                                    ?>
                						 <option <?=($val1['style_type_id']==$val['style_type_id'])?'selected':''?> value="<?=$val1['style_type_id']?>"><?=$val1['style_type']?></option>
                                    <?php
                                }
                            }
                        ?>
               </select>
            </td>
  	    </tr>
        <tr>
        	<td><strong>Fit</strong></td>
            <td>
            	<select class="form-control" name="style_update[fit]">
                   
                    <?php
                        if(isset($fit) && !empty($fit))
                        {
                            foreach($fit as $fit_val)
                            {
                                ?>
                                    <option <?=($fit_val['id']==$val['fit'])?'selected':''?> value="<?=$fit_val['id']?>"><?=$fit_val['master_fit']?></option>
                               <?php
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
    	  <tr>
    	    <td><strong>Color</strong></td>
    	    <td>
            <select  name="style_color_update[]" multiple id="" class="style_size_up form-control style_upcolor">
			 <?php 
                if(isset($all_color) && !empty($all_color))
                {
                    foreach($all_color as $val2)
                    {
						
                        ?>
             				<option
                            <?php
                            	if(isset($val['style_color']) && !empty($val['style_color']))
								{
									foreach($val['style_color'] as $res)
									{
										if($res['color_id']==$val2['id'])
										{
											echo "selected";
										}
									}
								}
							?>
                            
                             value="<?=$val2['id']?>"><?=$val2['colour']?></option>
            			 <?php
                    }
                }
            ?>
   </select><span id="snameerrorup3" class="val snameerrorup3"  style="color:#F00; font-style:oblique;"></span>
            </td>
  	    </tr>
        <tr>
    	    <td><strong>Size</strong></td>
    	    <td>
            <select  name="style_size_update[]" multiple  id="style_size_up" class="style_size_up form-control style_upsize">
			 <?php 
                if(isset($all_size) && !empty($all_size))
                {
                    foreach($all_size as $val2)
                    {
						
                        ?>
             				<option
                            <?php
                            	if(isset($val['style_size']) && !empty($val['style_size']))
								{
									foreach($val['style_size'] as $res)
									{
										if($res['size_id']==$val2['id'])
										{
											echo "selected";
										}
									}
								}
							?>
                            
                             value="<?=$val2['id']?>"><?=$val2['size']?></option>
            			 <?php
                    }
                }
            ?>
   </select><span id="snameerrorup4" class="val snameerrorup4" style="color:#F00; font-style:italic;"></span>
            </td>
  	    </tr>
        <tr>
    	    <td><strong>Landed Cost</strong></td>
    	    <td><input type="text"  name="style_update[sp]" class="l_cost form-control dot_val" value="<?=$val["sp"]?>" />
            <span id="snameerrorup1" class="val snameerrorup1" style="color:#F00; font-style:italic;"></span></td>
  	    </tr>
      
        
  	  </table>
      </div>
      <div style="width:40%;float:left;">
       <table style="width:50%;margin:0 auto;"  class="table table-striped table-bordered no-footer dtr-inline">
                	<tr>
                    	<td width="26%">Style Description</td>
                        <td>
                        	<textarea  style="width: 222px;" name="style_update[style_desc]"><?=$val["style_desc"]?></textarea>
                        </td>
                    </tr>
                </table>
       <table style="width:80%;margin:0 auto;"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">   
            <tr>
                <td>Customer</td>
                <td>MRP</td>
            </tr>
     
        <?php 
            if(isset($val['style_mrp']) && !empty($val['style_mrp']))
            {
                foreach($val['style_mrp'] as $key=>$val1)
                {
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" value='<?=$key?>' name="style_customer[]" />
                            <?=$val1['customer_name']?>
                        </td>
                        <td>
                            <input type="text" class="form-control dot_val" value="<?php if(isset($val1[0]['mrp'])) echo $val1[0]['mrp']; else echo 0; ?>" name="style_mrp[]" class="low_mrp" />
                        </td>
                    </tr>
                    <?php
                }
            }
        ?>
   
         <tr style="display:none">
    	    <td><strong>MRP</strong></td>
    	    <td>
            <input type="text"  name="style_update[mrp]" class='mrp_cost dot_val' value="<?=$val["mrp"]?>" />
            <span class='low_mrp'></span>	
             <span id="snameerrorup2" class="val snameerrorup2" style="color:#F00; font-style:italic;"></span></td>
  	    </tr>
    </table>
      
      </div>
  	</div>
  		<div class="modal-footer">
  		  
             <input type="submit" class="edit btn btn-primary"  id="edit" value="Update"></button>
    		 <button type="reset" class="btn btn-danger"  id="no" data-dismiss="modal"> Discard</button>
  		</div>
</div>
 </form>
</div>        
</div>

<script type="text/javascript">
$('.style_nameup').live('blur',function()
{
	 var sname=$(this).parent().parent().find(".style_nameup").val();
	//var sname=$('.style_nameup').val();
	var m=$(this).offsetParent().find('.snameerrorup');
	if(sname=='' || sname==null || sname.trim().length==0)
	{
		m.html("Required Field");
	}
	else
	{
		m.html("");
	}
});

$(".mrp_cost").live('blur',function()
{
	 var mrp=$(this).parent().parent().find(".mrp_cost").val();
	var nfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	var p=$(this).offsetParent().find('.snameerrorup2');
	if(mrp=="" || mrp==null || mrp.trim().length==0)
	{
		p.html("Required Field");
	}
	else if(!nfilter.test(mrp))
	{
		p.html("Numeric Only");
	}
	else
	{
		p.html("");
	}
});
$(".l_cost").live('blur',function()
{
	 var lcost=$(this).parent().parent().find(".l_cost").val();
	var llfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
	var l=$(this).offsetParent().find('.snameerrorup1');
	if(lcost=="" || lcost==null || lcost.trim().length==0)
	{
		l.html("Required Field");
	}
	else if(!llfilter.test(lcost))
	{
		l.html("Numeric Only");
	}
	else
	{
		l.html("");
	}
});
$('.style_upcolor').live('blur',function()
{
	 var supcolor=$(this).parent().parent().find(".style_upcolor").val();
	 var lup=$(this).offsetParent().find('.snameerrorup3');
	if(supcolor=='' || supcolor==null)
	{
		lup.html("Required Field");
	}
	else
	{
		lup.html("");
	}
});
$('.style_upsize').live('blur',function()
{
	 var supsize=$(this).parent().parent().find(".style_upsize").val();
	 var ssup=$(this).offsetParent().find('.snameerrorup4');
	if(supsize=='' || supsize==null)
	{
		ssup.html("Required Field");
	}
	else
	{
		ssup.html("");
	}
});
$(".imgInp").change(function() {
		//alert("hi");

   // var val = $(this).val();
	 var val=$(this).parent().parent().find(".imgInp").val();
	 var im=$(this).offsetParent().find('.imgtype');
    switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        case 'gif': case 'jpg': case 'png': case 'jpeg': case '':
           im.html("");
            break;
        default:
            $(this).val();
            // error message here
          im.html("Invalid File Type");
            break;
    }
});
</script>
<script type="text/javascript">
    $('#edit').live('click',function()
    {
		var i=0;
		var sname=$(this).parent().parent().find(".style_nameup").val();
		var m=$(this).offsetParent().find('.snameerrorup');
		
		if(sname=='' || sname==null || sname.trim().length==0)
		{
			m.html("Required Field");
			i=1;
		}
		else
		{
			m.html("");
		}
		 var mrp=$(this).parent().parent().find(".mrp_cost").val();
		var nfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
		var p=$(this).offsetParent().find('.snameerrorup2');
		if(mrp=="" || mrp==null || mrp.trim().length==0)
		{
			p.html("Required Field");
			i=1;
		}
		else if(!nfilter.test(mrp))
		{
			p.html("Numeric Only");
			i=1;
		}
		else
		{
			p.html("");
		}
		 var lcost=$(this).parent().parent().find(".l_cost").val();
		var llfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
		var l=$(this).offsetParent().find('.snameerrorup1');
		if(lcost=="" || lcost==null || lcost.trim().length==0)
		{
			l.html("Required Field");
			i=1;
		}
		else if(!llfilter.test(lcost))
		{
			l.html("Numeric Only");
			i=1;
		}
		else
		{
			l.html("");
		}
		var supcolor=$(this).parent().parent().find(".style_upcolor").val();
		 var lup=$(this).offsetParent().find('.snameerrorup3');
		if(supcolor=='' || supcolor==null)
		{
			lup.html("Required Field");
			i=1;
		}
		else
		{
			lup.html("");
		}
		var supsize=$(this).parent().parent().find(".style_upsize").val();
		var ssup=$(this).offsetParent().find('.snameerrorup4');
		if(supsize=='' || supsize==null)
		{
			ssup.html("Required Field");
			i=1;
		}
		else
		{
			ssup.html("");
		}
		//var message=$(this).parent().parent().parent().parent().find('.upduplication').val();
		var message=$(this).offsetParent().find('.upduplication').html();
		if((message.trim()).length>0)
		{
			i=1;
		}
		var mi=$(this).offsetParent().find('.imgtype').html();
		if((mi.trim()).length>0)
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

$(document).ready(function()
{
    $('#no').live('click',function()
    {
		var r_code=$(this).parent().parent().parent().find('.r_code').val();
        $(this).parent().parent().find('.style_code_up').val(r_code);
		var r_name=$(this).parent().parent().parent().find('.r_name').val();
        $(this).parent().parent().find('.style').val(r_name);
		var r_mrp=$(this).parent().parent().parent().find('.r_mrp').val();
        $(this).parent().parent().find('.mrp_up').val(r_mrp);
		var message=$(this).offsetParent().find('.val');	
		message.html("");
	});
});
</script>
 <script type="text/javascript">
 $(".up_stylename_dup").live('blur',function()
  			{
			var name=$(this).parent().parent().find('.style_nameup').val();
			var id=$(this).offsetParent().find('.id_dup').val();
			var message=$(this).offsetParent().find('.upduplication');
			
		   
		 $.ajax(
		 {
		  url:BASE_URL+"master_style/update_duplicate_stylename",
		  type:'POST',
		   data:{ value1:name,value2:id},
		  success:function(result)
		  {
		     message.html(result);
		  }    		
		});
   }); 
   </script> 
  
<?php 
}

}
 ?>

<?php 
if(isset($style) && !empty($style))
{
foreach($style as $val) 
{
 ?>   
<div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
<div class="modal-dialog">
  <div class="modal-content">
     <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
   
    <h3 id="myModalLabel" style="color:#06F">In-Active Style</h3>
    </div>
  <div class="modal-body">
     Do You Want In-Active? &nbsp; <strong><?php echo $val["style_name"]; ?></strong>
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
	// $(".edit").live("click",function()
//  {	  
//  
//  var i=0;
//  var id=$(this).parent().parent().find('.id').val(); 
//  var style=$(this).parent().parent().find(".style").val();
// // var style_code=$(this).parent().parent().find(".style_code_up").val();
//   var style_lot=$(this).parent().parent().find(".style_lot_up").val();
//   var style_id=$(this).parent().parent().find(".style_id_up").val();
//   var mrp_up=$(this).parent().parent().find(".mrp_up").val();
//   var style_size_up=$(this).parent().parent().find(".style_size_up").val();alert(style_size_up);
//  	var c=$(this).offsetParent().find('.snameerrorup1');
//		var m=$(this).offsetParent().find('.snameerrorup');
//	if(style=='' || style==null || style.trim().length==0)
//	{
//		m.html("Required Field");
//		i=1;
//	}
//	else
//	{
//		m.html("");
//	}
//	var nfilter=/^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
//	var p=$(this).offsetParent().find('.snameerrorup2');
//	if(mrp_up=="" || mrp_up==null || mrp_up.trim().length==0)
//	{
//		p.html("Required Field");
//		i=1;
//	}
//	else if(!nfilter.test(mrp_up))
//	{
//		p.html("Numeric only and Maximum 12");
//		i=1;
//	}
//	else
//	{
//		p.html("");
//	}
//	var st=$(this).offsetParent().find('.snameerrorup3');
//	if(style_id=='')
//	{
//		st.html("Select Style Type");
//		i=1;
//	}
//	else
//	{
//		st.html("");
//	}
//	if(i==1)
//	{
//		return false;
//	}
//	else
//	{
//     $.ajax({
//      url:BASE_URL+"master_style/update_style",
//      type:'POST',
//      data:{ value1:id,value2:style,value3:style_code,value4:style_lot,value5:style_id,value6:mrp_up, },
//      success:function(result)
//	  {
//	 window.location.reload(BASE_URL+"index/");
//      }   
//	 
//	 });
//	}
//	 $('.modal').css("display", "none");
//    $('.fade').css("display", "none"); 
//  });
		 </script>


         
        <script type="text/javascript">
$(document).ready(function()
 {
$("#yesin").live("click",function()
  {
 
   var hidin=$(this).parent().parent().find('.hidin').val();
     
     $.ajax({
      url:BASE_URL+"master_style/delete_master_style",
      type:'get',
      data:{ value1 : hidin},
      success:function(result){

  window.location.reload(BASE_URL+"master_style/");
   }
  });
  
  });
   
   $('.modal').css("display", "none");
    $('.fade').css("display", "none"); 
  
  });
  $(".int_val").live('keypress',function(event){
  	var characterCode = (event.charCode) ? event.charCode : event.which ;
		var browser;
		if($.browser.mozilla)
		{
      		if((characterCode > 47 && characterCode < 58) || characterCode==8 || event.keyCode==39  || event.keyCode==37 || characterCode==97 || characterCode==118) 
		  {
		   
			return true;
		  }
		  return false;
		}
		if($.browser.chrome)
		{
     		if (event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57)) {
        //display error message
        
               return false;
   			 }
		}
			 
	
 });
  </script>
