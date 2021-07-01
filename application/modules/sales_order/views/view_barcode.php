<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<style>
	@media print {
		.barcode_details	{ page-break-before: auto;page-break-inside:avoid;line-height:7px !important;letter-spacing: 0.5px;width:100%}
		.barcode_details { font-size:7px; margin-bottom: 5px;}
		.barcode_details span { font-size:5px; font-weight:700;}
		.barcode_details small { line-height:8px; font-size:5px;}
		@page{size:portrait;}
	}
	.barcode_details small { line-height:8px;}
	@page {margin: 0.2cm 0.1cm;width:65mm;height:55mm}
</style>
<div class="mainpanel">
            <div class="pageheader hide_class">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Barcode</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            <div class="contentpanel">
           <br /><br />
               			<table style="margin:0 auto;">
                        	<tr>
                  <td>
                 
              <?php $this->load->model('sales_order_model');?>
              
                    <?php  //echo "<pre>";
					$net_o_val=0;
					$net_final_val=0;
					if(isset($gen_info[0]['style_size']) && !empty($gen_info[0]['style_size']))
					{
						foreach($gen_info[0]['style_size'] as $info)
						{
					?>
                           		 <?php 
								 	//echo "<pre>";
									//print_r($info);
								 	$full_total=0;
                                        if(isset($info['list']) && !empty($info['list']))
                                        {
                                            foreach($info['list'] as $val)
                                            {
												$full_total=$full_total+$val['qty'];
												
												$c=0;
												
			  									if(isset($post_data['lot'][$info['lot_no']][$val['size_id']]) && $post_data['lot'][$info['lot_no']][$val['size_id']])
												$c=$post_data['lot'][$info['lot_no']][$val['size_id']];
											
												$bar_code=$info['style_id'].'-'.$info['color_id'].'-'.$val['size_id'].'-'.'12345';
												
                                               
											$c_mrp=$this->sales_order_model->get_sales_details1($gen_info[0]['id'],$info['style_id']);
											$info['mrp']=$c_mrp[0]['c_mrp'];
												for($i=1;$i<=$c;$i++)
												{
													//echo $bar_code;
												?>
                                                    <div class="barcode_details" >
                                                        Brand : <span>Cotton Colors</span><br />
                                                        Style : <span><?=$info['style_name']?></span><br />
                                                        Description : <span><?=$info['style_desc']?></span><br />
                                                        Size : <span><?=$val['size']?> inch waist -<?=round((int)$val['size']*2.54).'cm';?></span><br />
                                                        Colors : <span><?=$info['colour']?></span><br />
                                                        Lot NO : <span><?=$info['lot_no']?></span><br />
                                                        Qty :<span>One Piece Pkd : <?=date('m',strtotime($gen_info[0]['inv_date']))?>/<?=date('y',strtotime($gen_info[0]['inv_date']))?></span><br />
                                                        MRP :<span><i class="fa fa-rupee"></i> <?=$info['mrp']?>/- (incl.all taxes)</span><br />
                                                        <img style="width: 130px; margin:1px;height: 20px;" alt="<?=$bar_code?>" src="<?=$this->config->item('base_url')?>bar_code.php?codetype=code39&size=40&text=<?=$bar_code?>" /><br />
                                                      <small>Marketed By :SNEHA APPARELS</span>,<br />
                                                        #39, Gowarathana Garden,JC Industril area,<br />
                                                        Yelachanshalli ,Bangalore-560062,<br />
                                                        Ph: +91 80 2386 15567,www.cottoncolors.in<br /><br /> </small>
                                                    </div>
                                                  
                                                <?php
												}
                                            }
                                        }
                                    ?>
                          
                        <?php 
							}
						}
						?>
                     </td>
                            </tr>
 						</table>
                			
                           
              <input type="button" class="btn btn-default print_btn" style="float:right;"  value="Print"/>
             
             <script>
			 $('#export_excel').live('click',function(){
                        
						fnExcelReport();
						//window.location.href=BASE_URL+'report/pl_excel_file1';
                    });
			 $(document).ready(function() {
                $('.print_header').addClass( "hide_class" );
            });
      	$('.print_btn').click(function(){
			window.print();
		});
		
      </script>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
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
    tab = document.getElementById('pl'); // id of table
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