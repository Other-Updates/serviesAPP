<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?=$theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">
<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-rupee" style="margin:9px;"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Fixed Expense</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            
            <div class="col-md-15">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-info">
                    <li class="active"><a href="#home6" data-toggle="tab"><strong>List</strong></a></li>
                    <li class=""><a href="#profile6" data-toggle="tab"><strong>Add</strong></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content tab-content-info mb30">
                    <div class="tab-pane active" id="home6">
                    <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide">
                  		<tr>
                        	
                            <td>From Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text" id='from_date'  class="form-control datepicker"  placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td>To Date</td>
                            <td>
                            	<div class="input-group" style="width:70%;">
                                    <input type="text"  id='to_date' class="form-control datepicker" placeholder="dd-mm-yyyy" >
                                    
                                </div>
                            </td>
                            <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>
                        </tr>
                  </table>
                    <div id="result_div">
                      	<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <td width="4%">S NO</td>
                                    <td>Date</td>
                                     <?php 
                                       if(isset($expense) && !empty($expense))
                                       {
                                           foreach($expense as $val)
                                           {
                                               ?>
                                                    <td><?=$val['expense']?></td>
                                               <?php
                                           }
                                       }
                                       ?>
                                    <td>Total</td>
                                    <td  class="hide_class">Action</td>
                                </tr>
                            </thead>
                            <tbody >
                                <?php 
								$full_total=0;$dd=array();
                                    if(isset($all_expense) && !empty($all_expense))
                                    {
                                        $i=1;
                                        foreach($all_expense as $val)
                                        {
											
                                            ?>
                                                <tr>
                                                    <td class='first_td'><?=$i?></td>
                                                    <td><?=date('d-m-Y',strtotime($val['exp_date']))?></td>
                                                    <?php 
                                                    if(isset($val['expense_info']) && !empty($val['expense_info']))
                                                    {
														$each=0;$g=0;
                                                        foreach($val['expense_info'] as $val1)
                                                        {
															
                                                            ?>
                                                            <td style="text-align:right;">
                                                                <?php 
																	$full_total=$full_total+$val1[0]['exp_value'];
                                                                    if(isset($val1[0]['exp_value']) && !empty($val1[0]['exp_value']))
																	{
																		$dd[$g][]=$val1[0]['exp_value'];
																		$each=$each+$val1[0]['exp_value'];
                                                                        echo number_format($val1[0]['exp_value'], 2, '.', ',');
																	}
																	else
																	{
																		$dd[$g][]=0;
																		$each=$each+0;
                                                                        echo 0;		
																	}
                                                                ?>
                                                            </td>
                                                            <?php
															$g++;
                                                        }
                                                    }
                                                    ?>
                                                    <td  style="text-align:right;"><?=number_format($each, 2, '.', ',')?></td>
                                                    <td  class="hide_class">
                                                        <a href="#edit_<?=$i?>" data-toggle="modal" name="edit" class="fa fa-edit tooltips" title="" data-original-title="Edit">&nbsp;</a>
                                                        <a href="#delete_<?=$i?>" data-toggle="modal" name="delete" class="red fa fa-ban tooltips" title="In-Active">&nbsp;</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    
                                ?>
                            </tbody>
                            <tfoot>
                             <tr>
                                    <td width="4%"></td>
                                    <td></td>
                                     <?php 
									 $h=0;
                                       if(isset($expense) && !empty($expense))
                                       {
                                           foreach($expense as $val)
                                           {
                                               ?>
                                                    <td  style="text-align:right;"><?=number_format(array_sum($dd[$h]), 2, '.', ','); ?></td>
                                               <?php
											    $h++;
                                           }
										  
                                       }
                                       ?>
                                    <td  style="text-align:right;"><?=number_format($full_total, 2, '.', ',');?></td>
                                    <td  class="hide_class"></td>
                                </tr>
                            </tfoot>
                       </table>  
                       </div>
                        <input type="button" class="btn btn-default print_btn" style="float:right;"  value="Print"/>
                        <input type="button" id="export_excel" class="btn btn-default" style="float:right;margin-right:10px;" value="Export excel">
                        <br />
					  <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
                    </div><!-- tab-pane -->
                  
                    <div class="tab-pane" id="profile6">
                        <form method="post">
                            <div  style="margin:0 auto; width:50%" >          
                                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                   <tr>
                                        <td width="40%" class="first_td1">
                                            Date
                                        </td>
                                        <td width="60%">
                                            <input type="text" id='from_date1'  class="form-control datepicker"  name="exp_date" placeholder="dd-mm-yyyy">
                                             <input type="hidden" id="today" class="today" value="<?php echo $i=date("d-m-y");  ?>" />
                                             <span id="fixerror" style="color:#F00;" ></span>
                                        </td>
                                        <td></td>
                                   <tr>     
                                   
                                   <?php 
                                   if(isset($expense1) && !empty($expense1))
                                   {
                                       foreach($expense1 as $val)
                                       {
                                           ?>
                                           <tr>
                                                <td class="first_td1"><?=$val['expense']?><input type="hidden"  name="fixed_exp[exp_type][]" value="<?=$val['id']?>" /></td>
                                                <td><input placeholder="Amount" type="text" class="form-control int_val"   name="fixed_exp[exp_value][]"/></td> 
                                                <td><input placeholder="Remarks" type="text" class="form-control" style="  width: 200px;"  name="fixed_exp[exp_remarks][]"/></td>
                                           </tr>
                                           <?php
                                       }
									   ?>
                                       <tr>
                                            <td></td>
                                            <td>
                                                <input type="submit" class="btn btn-default" style="float:right;" value="Save" id="submit" />
                                            </td>
                                            <td></td>
                                           </tr>
                                       <?php
                                   }
								   else
								   {
									   ?>
                                       <tr>
                                            <td colspan="2">Kindly add master expense...</td>
                                           
                                       </tr>
                                       <?php
								   }
                                   ?>
                                   
                               </table>
                              
                               <br />
                           </div>
                       </form>
                    </div><!-- tab-pane -->
                  
                   
                </div><!-- tab-content -->
                
            </div>
         
            
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        
        <?php 
            if(isset($all_expense) && !empty($all_expense))
            {
                $i=1;
                foreach($all_expense as $val)
                {
                    ?>
                     <form method="post" action="<?=$this->config->item('base_url').'expense/update_fixed'?>">
              			<div id="edit_<?=$i;?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                    <h4 style="color:#06F">Update Expense</h4>
                                                    
                                      </div>
                                      <div class="modal-body">
                                      		<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                               <tr>
                                                    <td width="40%" class="first_td1">
                                                        Date
                                                    </td>
                                                    <td width="60%">
                                                        <input type="text"   class="form-control datepicker from_date1 date_up"  name="exp_date" placeholder="dd-mm-yyyy"  value="<?=date('d-m-Y',strtotime($val['exp_date']));?>" id="">
                                                       <input type="hidden" id="today" class="today" value="<?php echo $aa=date("d-m-y");  ?>" />
                                                        <span class="fixerrorup" style="color:#F00;"></span>
                                                    </td>
                                                    <td></td>
                                               <tr>     
                                               
                                               <?php 
                                               if(isset($val['expense_info']) && !empty($val['expense_info']))
												{
													foreach($val['expense_info'] as $val1)
													{
                                                       ?>
                                                       <tr>
                                                            <td class="first_td1"><?=$val1[0]['expense']?><input type="hidden"  name="fixed_exp[exp_type][]" value="<?=$val1[0]['exp_type']?>" /></td>
                                                            <td><input placeholder="Amount" type="text" value="<?=$val1[0]['exp_value']?>" class="form-control"   name="fixed_exp[exp_value][]"/></td>
                                                            <td><input placeholder="Remarks" style="width:200px;" type="text" value="<?=$val1[0]['exp_remarks']?>" class="form-control"   name="fixed_exp[exp_remarks][]"/></td>
                                                       </tr>
                                                       <?php
                                                   }
                                               }
                                               ?>
                                           </table>
                                            <input type="hidden" name="update_exp_date" value="<?=$val['exp_date']?>"  />
                                            <input type="hidden" name="update_created_date" value="<?=$val['created_date']?>"  />
                                      </div>
                                      <div class="modal-footer">
                                       
                                            <button type="submit" class="btn btn-primary update" id="">Update</button>
                                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> Discard</button>
                                      </div>
                            	</div>
                          </div>  
                     </div>
                     </form>
                    <?php
                    $i++;
                }
            }
        ?>
		<?php 
            if(isset($all_expense) && !empty($all_expense))
            {
                $i=1;
                foreach($all_expense as $val)
                {
                    ?>
                    <form method="post" action="<?=$this->config->item('base_url').'expense/delete_fixed'?>">
              			<div id="delete_<?=$i;?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                   <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                                                <h4 style="color:#06F">In-Active Expense</h4>
                                               
                                   </div>
                                   <div class="modal-body">
                                         
                                         <strong>
                                           Do you want In-Active? &nbsp; 
                                         </strong>
                                       
                                         <input type="hidden" name="exp_date" value="<?=$val['exp_date']?>"  />
                                         <input type="hidden" name="created_date" value="<?=$val['created_date']?>"  />
                                       </div>
                                       <div class="modal-footer">
                                        <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                                  </div>
                            </div>
                          </div>  
                     </div>
                     </form>
                    <?php
                    $i++;
                }
            }
        ?>
        
      
        
      <script>
	  $("#from_date1").live('change',function()
		{
			 var dateString =$('#from_date1').val();
			 var today = $('#today').val();
			 if(dateString== "")
			 { 
				 $("#fixerror").html("Required Field");
		
			 }
			 else
			 {
				  $("#fixerror").html("");
			 }
		}); 
		
		 /*$(".fix_empty").live('blur',function()
		 {
			$('.fix_empty').each(function(){
				//alert("hi");
			 var fix =$('.fix_empty').val();
			 if(fix=="")
			 { 
				 $(this).css('border-color','red');
		
			 }
			 else
			 {
				  $(this).css('border-color','');
			 }
		  }); 
		  });*/
		 $('#submit').live('click',function()
		 {
			 var i=0;
			  var dateString =$('#from_date1').val();
			 //var today = $('#today').val();
			 if(dateString== "")
			 { 
				 $("#fixerror").html("Required Field");
				 i=1;
			 }
			 else
			 {
				  $("#fixerror").html("");
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
$('.from_date1').live('change',function()
{
	var date=$(this).parent().parent().find(".from_date1").val();
	var today=$(this).parent().parent().find(".today").val();
	var m=$(this).offsetParent().find('.fixerrorup');
	if(date=='')
	{
		m.html("Required Field");
	}
	else
	{
		m.html("");
	}
});
$('.update').live('click',function()
{
	var i=0;
	var date=$(this).parent().parent().find(".from_date1").val();
	//var today=$(this).parent().parent().find(".today").val();
	var m=$(this).offsetParent().find('.fixerrorup');
	if(date=='')
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
		
		return true;
	}
	
});
</script> 
        
      <script type="text/javascript">
		 // Date Picker
		 $(document).ready(function(){

	        jQuery('#from_date1,.from_date1,#from_date,#to_date').datepicker(); 
		 });
		$('#search').live('click',function(){
				for_loading(); 
				$.ajax({
					  url:BASE_URL+"expense/search_fixed",
					  type:'GET',
					  data:{
							from_date:$('#from_date').val(),
							to_date  :$('#to_date').val()
						   },
					  success:function(result){
						   for_response(); 
						$('#result_div').html(result);
					  }    
				});
			});
		
		</script>
		<style type="text/css">
      	.right_td
		{
			text-align:right;
		}
      </style>
      <script>
			function fnExcelReport()
			{
				var tab_text="<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
				var textRange; var j=0;
				tab = document.getElementById('basicTable'); // id of table
				for(j = 0 ; j < tab.rows.length ; j++) 
				{     
					tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
					//tab_text=tab_text+"</tr>";
				}
				tab_text=tab_text+"</table>";
				tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
				tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
				tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE "); 
				if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
				{
					txtArea1.document.open("txt/html","replace");
					txtArea1.document.write(tab_text);
					txtArea1.document.close();
					txtArea1.focus(); 
					sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
				}  
				else                 //other browser not tested on IE 11
					sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
				return (sa);
			}
   </script>
   <script>
           
	$('#export_excel').live('click',function(){
		
		fnExcelReport();
		//window.location.href=BASE_URL+'report/pl_excel_file1';
	});
  </script>