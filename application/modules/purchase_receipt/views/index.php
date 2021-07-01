<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Add Purchase Invoice</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            <form method="post" enctype="multipart/form-data">
            <table style="width:70%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               <tr>
               	<td colspan="5" style="text-align:center;">
                	<b><?=$last_no?></b>
                </td>
               </tr>
               <tr>
                    
                     
                    <td width="5%" class="first_td1">Supplier Name</td>
                    <td width="10%">
                    	<select id='customer' name="receipt[customer_id]" class="form-control">
                            <option value="">Select</option>
                            <?php 
                                if(isset($all_supplier) && !empty($all_supplier))
                                {
                                    foreach($all_supplier as $val)
                                    {
                                        ?>
                                            <option value='<?=$val['id']?>'><?=$val['store_name']?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select><span id="reciptinerror2" style="color:#F00;"></span>
                    </td>
                     <td width="5%"  class="first_td1">Invoice Date</td>
                    <td  width="10%" class="">
                    	<input type="text" id="from_date"  name="receipt[inv_date]" value="" class="form-control datepicker inv_class class_req" />
                        <input type="hidden" id="today" value="<?php echo $i=date("d-m-y");  ?>" />
                        <span id="reciptinerror1" style="color:#F00;"></span>
                    </td>
                    <td width="15%" rowspan="6" id='s_div'></td>
               </tr>
                <tr >
               		<td class="first_td1">Invoice No</td>
                    <td>
                    	<input type="text"  name="receipt[inv_no]" value="" id="invoice_no" class="form-control bill_no" />
                        <span id="reciptinerror3" style="color:#F00;"></span>
                        <span id="billno_error" style="color:#F00;"></span>
                    </td>
                   <td class="first_td1">Due Date</td>
                     <td>
                     	<input  id="from_date1" readonly="readonly" name="receipt[due_date]"  class="form-control" type="text" />
                     	<input type="hidden" id="today" class="today" value="<?php echo $i=date("d-m-y");  ?>" />
                     	
                     </td>
               </tr>
               <tr style="display:none;">
               		<td class="first_td1">Agent</td>
                    <td>
                    	<select name="receipt[agent_id]" class="form-control">
                            <option value="">Select</option>
                            <?php 
                                if(isset($all_agent) && !empty($all_agent))
                                {
                                    foreach($all_agent as $val)
                                    {
                                        ?>
                                            <option value='<?=$val['id']?>'><?=$val['name']?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td class="first_td1">Commission %</td>
                    <td>
                    	<input type="text"   name="receipt[agent_comm]" value="0" class="form-control" />
                    </td>
               </tr>
               </table>
               <br />
               <form method="post">
               		<table style="width:80%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               			<thead>
                        	<th>PO No</th>
                            <th>GRN NO</th>
                            <th width="10%">GRN QTY</th>
                            <th>GRN Date</th>
                            <th>GRN Value</th>
                        </thead>
                        <tbody id='receipt_info'>
                        	<tr>
                            	<td colspan="5">No Data Found</td>
                            </tr>
                        </tbody>
                    </table>
                      
               </form>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
       
       <script type="text/javascript">
	   
	   $(".bill_no").live('blur',function()
       {
	  
        var billno=$(".bill_no").val(); 
		$.ajax(
	   {
		url:BASE_URL+"purchase_receipt/checking_invoice_billno",
		type:'POST',
		data:{ value1 : billno},
		success:function(result)
		{
		   $("#billno_error").html(result);
	   
		}      
	  });
	   });
	  /* $("#from_date").live('change',function()
		{
			 var dateString =$('#from_date').val();
			 //var today = $('#today').val();
			 
			 var today = new Date();
			   var dd = today.getDate();
			   var mm = today.getMonth()+1; //January is 0!
			  
			   var yyyy = today.getFullYear();
			   if(dd<10){
				dd='0'+dd
			   } 
			   if(mm<10){
				mm='0'+mm
			   } 
			   //var today = dd+'-'+mm+'-'+yyyy;
			    var today1 = dd+'-'+mm+'-'+yyyy;
			   //alert(dateString);
			   //alert(today1);
			 if(dateString== "")
			 { 
				 $("#reciptinerror1").html("Required Field");
		
			 }
			 else if(dateString>today1)
			 { 
				$("#reciptinerror1").html("You cannot select Future date!");
			 }
			 else
			 {
				  $("#reciptinerror1").html("");
			 }
		}); */
		$("#customer").live('change',function()
		{
			 var customer =$('#customer').val();
			 if(customer== "")
			 { 
				 $("#reciptinerror2").html("Required Field");
		
			 }
			 else
			 {
				  $("#reciptinerror2").html("");
			 }
		}); 
		$("#invoice_no").live('blur',function()
		{
			
			var invoice_no=$("#invoice_no").val();
			if(invoice_no=="" || invoice_no==null || invoice_no.trim().length==0)
			{
				$("#reciptinerror3").html("Required Field");
			}
			else
			{
				$("#reciptinerror3").html("");
			}
		});
		$("#enter_inv_amount").live('blur',function()
		{
			
			var enter_inv_amount=$("#enter_inv_amount").val();
			if(enter_inv_amount=="" || enter_inv_amount==null || enter_inv_amount.trim().length==0)
			{
				
				$("#reciptinerror4").html("Required Field");
			}
			else
			{
				$("#reciptinerror4").html("");
			}
		});
		$(".remarks").live('blur',function()
		{
			
			var remarks=$("#remarks").val();
			if(remarks=="" || remarks==null || remarks.trim().length==0)
			{
				$("#reciptinerror5").html("Required Field");
			}
			else
			{
				$("#reciptinerror5").html("");
			}
		});
		
		$('#depit_per').live('keyup',function()
		{
			var depit_per=$('#depit_per').val();
			var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(depit_per=="" || depit_per==null || depit_per.trim().length==0)
			{
				
			}
			else if(!pefilter.test(depit_per))
			{
				$("#pererror").html("Enter Valid Percentage");
			}
			else
			{
				$('#pererror').html("");
			}
		});
		$('#tax_per').live('keyup',function()
		{
			var tax_per=$('#tax_per').val();
			var pfilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(tax_per=="" || tax_per==null || tax_per.trim().length==0)
			{
				
			}
			else if(!pfilter.test(tax_per))
			{
				$("#taxerror").html("Enter Valid Percentage");
			}
			else
			{
				$('#taxerror').html("");
			}
		});
		
		$('#tax_value').live('keyup',function()
		{
			
			var inv_amount=$('#inv_amount').val();
			var tax_value=$('#tax_value').val();
				
			if(Number(tax_value)>Number(inv_amount))
			{
				$(this).css('border-color','red');
			}
			else
			{
				$(this).css('border-color','');
			}
			
		});
		$('.enter_inv_amount').live('keyup',function()
		{
			var net_value=$('#net_value').val();
			var inv_value=$('.enter_inv_amount').val();
			//alert(net_value);
				if(Number(inv_value)>Number(net_value))
				{
					$(this).css('border-color','red');
				}
				else
				{
				$(this).css('border-color','');
				}
			
			var debit_val=Number($('#net_value').val())-Number($('#enter_inv_amount').val());
			$('#debit_note').val(debit_val.toFixed(2));
			var pay_val=Number($('#enter_inv_amount').val())-(Number(debit_val)+Number($('#debit_value').val()));
			$('#pay_value').val(pay_val.toFixed(2));
		});
		
		$('#depit_per').live('keyup',function()
		{
			var depit_per=$('#depit_per').val();
			var inv_value=$('.enter_inv_amount').val();
			var debit_value=$('#debit_value').val();
			var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(depit_per=="" || depit_per==null || depit_per.trim().length==0)
			{
				$("#debit_value").css('border-color','');
			}
			else if(!pefilter.test(depit_per))
			{
				$("#pererror").html("Enter Valid Percentage");
			}
			else if(Number(debit_value)>Number(inv_value))
			{
				$("#debit_value").css('border-color','red');
			}
			else
			{
				$('#pererror').html("");
				$("#debit_value").css('border-color','');
			}
			var debit_val=Number($('#net_value').val())-Number($('#enter_inv_amount').val());
			$('#debit_note').val(debit_val.toFixed(2));
			var pay_val=Number($('#enter_inv_amount').val())-(Number(debit_val)+Number($('#debit_value').val()));
			$('#pay_value').val(pay_val.toFixed(2));
		});
		  $('#debit_value').live('keyup',function()
		{

			var inv_value=$('.enter_inv_amount').val();
			var debit_value=$('#debit_value').val();
			if(Number(debit_value)>Number(inv_value))
			{
				$(this).css('border-color','red');
			}
			else
			{
				$(this).css('border-color','');
			}
			var debit_val=Number($('#enter_inv_amount').val())-Number($('#net_value').val());
			$('#debit_note').val(debit_val.toFixed(2));
			var pay_val=Number($('#enter_inv_amount').val())-(Number(debit_val)+Number($('#debit_value').val()));
			$('#pay_value').val(pay_val.toFixed(2));
		});
	   $('.submit').live('click',function()
	   {
		  var i=0;
		   var dateString = $('#from_date').val().split("-");

    //var today = $('#today').val();
    dateString=dateString[2]+'-'+dateString[1]+'-'+dateString[0];
     
    var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
     
      var yyyy = today.getFullYear();
      if(dd<10){
    dd='0'+dd
      } 
      if(mm<10){
    mm='0'+mm
      } 
       var today = yyyy+'-'+mm+'-'+dd;
      
      var d= new Date(today);
    var a= new Date(dateString);
    var diff=(a-d) /(1000*24*60*60);0
   if(diff>0)
   {
        //alert('after');
	   $("#reciptinerror1").html("You cannot select Future date!");
	   i=1;
   }
   else
   {
	   $("#reciptinerror1").html("");
       // alert('before');
   }
			 
			 $('.class_req').each(function(){
				
						if($(this).val()=='' || $(this).val()=='Select' || $(this).val()=='select' ||  $(this).val()==0)
						{
							
							$(this).css('border-color','red');
							i=1;console.log(1);
							
						}
						else
						{
							$(this).css('border-color','');
						}
						
					});
			 var customer =$('#customer').val();
			 if(customer== "")
			 { 
				 $("#reciptinerror2").html("Required Field");
				 i=1;console.log(2);
		
			 }
			 else
			 {
				  $("#reciptinerror2").html("");
			 }
			 var invoice_no=$("#invoice_no").val();
			if(invoice_no=="" || invoice_no==null || invoice_no.trim().length==0)
			{
				$("#reciptinerror3").html("Required Field");
				i=1;console.log(3);
			}
			else
			{
				$("#reciptinerror3").html("");
			}
			var enter_inv_amount=$("#enter_inv_amount").val();
			if(enter_inv_amount=="" || enter_inv_amount==null || enter_inv_amount.trim().length==0)
			{
				$("#reciptinerror4").html("Required Field");
				i=1;
				console.log(4);
			}
			else
			{
				$("#reciptinerror4").html("");
			}
			var remarks=$("#remarks").val();
			
			var inv_amount=$("#inv_amount").val();
			if(inv_amount=="" || inv_amount==0|| inv_amount.trim().length==0)
			{
				$("#reciptinerror6").html("Select Atleast One GRN");
			console.log(6);	i=1;
			}
			else
			{
				$("#reciptinerror6").html("");
			}
			var depit_per=$('#depit_per').val();
			var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(depit_per=="" || depit_per==null || depit_per.trim().length==0)
			{
				
			}
			else if(!pefilter.test(depit_per))
			{
				$("#pererror").html("Enter Valid Percentage");
				i=1;console.log(7);
			}
			else
			{
				$('#pererror').html("");
			}
			var tax_per=$('#tax_per').val();
			var pfilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
			if(tax_per=="" || tax_per==null || tax_per.trim().length==0)
			{
				
			}
			else if(!pfilter.test(tax_per))
			{
				$("#taxerror").html("Enter Valid Percentage");
				i=1;
			}
			else
			{
				$('#taxerror').html("");
			}
			var inv_amount=$('#inv_amount').val();
			var tax_value=$('#tax_value').val();
				
			if(Number(tax_value)>Number(inv_amount))
			{
				
				$('#tax_value').css('border-color','red');
				i=1;console.log(8);
			}
			else
			{
				$('#tax_value').css('border-color','');
			}
			var net_value=$('#net_value').val();
			var inv_value=$('.enter_inv_amount').val();
			
				
			var debit_value=$('#debit_value').val();
				
			if(Number(debit_value)>Number(inv_value))
			{
				$('#debit_value').css('border-color','red');
				i=1;console.log(10);
			}
			else
			{
				$('#debit_value').css('border-color','');
			}
			var m=$('#billno_error').html();
			if((m.trim()).length>0)
			{
				i=1;console.log(11);
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
                  $('#terms').live('change',function(){
				  		if($(this).val()==2 || $(this).val()==3)
							$('.show_tr').show();
						else
							$('.show_tr').hide();
				  });
                  </script>
        <script type="text/javascript">
		 // Date Picker
		 $('#add_package').live('click',function(){
					$('.sty_class').each(function(){
						
						var s_html=$(this).closest('tr').find('.size_val');	
						var size_name=$(this).closest('tr').find('.size_name');	
						var cort_class=$(this).closest('tr').find('.cort_class').val();	
						var sty_class=$(this).closest('tr').find('.sty_class').val();
						var col_class=$(this).closest('tr').find('.col_class').val();	
						
						$(s_html).each(function(){
							$(this).attr('name','size['+sty_class+col_class+cort_class+'][]');
						});	
						$(size_name).each(function(){
							$(this).attr('name','size_name['+sty_class+col_class+cort_class+'][]');
						});		
					});
				});	
			 
		
		$('#cor_no').live('keyup',function(){
			var select_op='';
			if(Number($(this).val()))
			{
				select_op=select_op+'<select class="cort_class"  name="corton[]"><option>Select</option>';
				for(i=1;i<=Number($(this).val());i++)
				{
					select_op=select_op+'<option value='+i+'>'+i+'</option>';	
				}
				select_op=select_op+'</select>';
				$('.cor_class').html(select_op);
			}
		});
	   	$('#customer').live('change',function(){
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"purchase_receipt/get_all_pending_invoice",
				  type:'GET',
				  data:{
					  c_id:$(this).val(),
					  inv_date:$('.inv_class').val()
					   },
				  success:function(result){
						$('#s_div').html(result);
						$('#from_date1').val($('#due_terms').text());
				  }    
			});
			$.ajax({
				  url:BASE_URL+"purchase_receipt/get_invoice_view",
				  type:'GET',
				  data:{
					  c_id:$(this).val()
					   },
				  success:function(result){
					    for_response(); 
						$('#receipt_info').html(result);
				  }    
			});
			
		});
		$('.so_id').live('click',function(){
			var s_arr=[];
			var i=0;
			$('.so_id').each(function(){
				if($(this).attr('checked')=='checked')
				{
					s_arr[i]=$(this).val();
					i++;
				}
			});
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"purchase_receipt/get_inv",
				  type:'GET',
				  data:{
					  	inv_id:s_arr,
					  	c_id:$('#customer').val()
					   },
				  success:function(result){
					     for_response(); 
						$('#receipt_info').html(result);
				  }    
			});
		});
		$('#discount').live('keyup',function(){
		total=0;
		total=(Number($('#inv_amount').val())-Number($(this).val()))-Number($('#paid').val());
			$('#balance').val(total.toFixed(2));
		});
		$('#paid').live('keyup',function(){
		total=0;
		total=(Number($('#inv_amount').val())-Number($('#discount').val()))-Number($(this).val());
			$('#balance').val(total.toFixed(2));
		});
		$('.gen_list').live('click',function(){
			var g_val=0;
			$('.gen_list').each(function(){
				if($(this).attr('checked')=='checked')
				{
					g_val=g_val+Number($(this).closest('tr').find('.gen_value').val());	
				}
			});
			$('#inv_amount').val(g_val.toFixed(2));
			$('#net_value').val(g_val.toFixed(2));
		});
		/*$('#enter_inv_amount').live('keyup',function(){
			$('#debit_value').val(Number($('#inv_amount').val())-Number($(this).val()));
		});*/
		$(document).ready(function(){
	        jQuery('.datepicker').datepicker(); 
		});
		</script>
        
        
        
        <script>
		$("#from_date").live('change',function()
		{
		 var dateString = $('#from_date').val().split("-");

    //var today = $('#today').val();
    dateString=dateString[2]+'-'+dateString[1]+'-'+dateString[0];
     
    var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
     
      var yyyy = today.getFullYear();
      if(dd<10){
    dd='0'+dd
      } 
      if(mm<10){
    mm='0'+mm
      } 
       var today = yyyy+'-'+mm+'-'+dd;
      
      var d= new Date(today);
			var a= new Date(dateString);
			var diff=(a-d) /(1000*24*60*60);0
		   if(diff>0)
		   {
				//alert('after');
			   $("#reciptinerror1").html("You cannot select Future date!");
		   }
		   else
		   {
			   $("#reciptinerror1").html("");
			   $(this).css('border-color','');
			   // alert('before');
		   }
			$.ajax({
				  url:BASE_URL+"purchase_receipt/get_terms",
				  type:'GET',
				  data:{
					  inv_date:$(this).val(),
					  customer:$('#customer').val()
					   },
				  success:function(result){
						$('#from_date1').val(result);
				  }    
			});
		});
		$('#depit_per').live('keyup', function(){
			var tt=$('#enter_inv_amount').val()*($(this).val()/100);
			$('#debit_value').val(tt.toFixed(2));
			var debit_val=Number($('#net_value').val())-Number($('#enter_inv_amount').val());
			$('#debit_note').val(debit_val.toFixed(2));
			var pay_val=Number($('#enter_inv_amount').val())-(Number(debit_val)+Number($('#debit_value').val()));
			$('#pay_value').val(pay_val.toFixed(2));
		});
		$('#debit_value').live('keyup', function(){
			var tt=($(this).val()/$('#enter_inv_amount').val())*100;
			$('#depit_per').val(tt.toFixed(2));
			var debit_val=Number($('#net_value').val())-Number($('#enter_inv_amount').val());
			$('#debit_note').val(debit_val.toFixed(2));
			var pay_val=Number($('#enter_inv_amount').val())-(Number(debit_val)+Number($('#debit_value').val()));
			$('#pay_value').val(pay_val.toFixed(2));
		});
		
		$('#tax_per').live('keyup', function(){
			var tt=$('#inv_amount').val()*($(this).val()/100);
			$('#tax_value').val(tt.toFixed(2));
			var nv=Number($('#inv_amount').val())+Number($('#tax_value').val());
			$('#net_value').val(nv.toFixed(2));
		});
		$('#tax_value').live('keyup', function(){
			var tt=($(this).val()/$('#inv_amount').val())*100;
			$('#tax_per').val(tt.toFixed(2));
		});
		$('.al_so_id').live('click',function(){
			if($(this).attr('checked')=='checked')
			{
				$('.so_id').attr('checked','checked');
			}
			else
			{
				$('.so_id').removeAttr('checked');
			}
			var s_arr=[];
			var i=0;
			$('.so_id').each(function(){
				if($(this).attr('checked')=='checked')
				{
					s_arr[i]=$(this).val();
					i++;
				}
			});
			for_loading(); 
			$.ajax({
				  url:BASE_URL+"purchase_receipt/get_inv",
				  type:'GET',
				  data:{
					  	inv_id:s_arr,
					  	c_id:$('#customer').val()
					   },
				  success:function(result){
					     for_response(); 
						$('#receipt_info').html(result);
				  }    
			});
		});
		
		</script>