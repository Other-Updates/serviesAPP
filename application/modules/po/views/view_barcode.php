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
            
        <br />  
               			<table style="margin:0 auto;">
                        	<tr>
                            	<td>
                                	<?php
										$this->load->model('master_style/master_model');
										
										if(isset($code['lot']) && !empty($code['lot']))
										{
											foreach($code['lot'] as $key=>$val)
											{
												$st=$this->master_model->get_style_name($key);
												
											//	print_r($st[0]['id']);
												foreach($val as $k1=>$v1)
												{
												//	print_r($k1);
													$cl=$this->master_model->get_color_name($k1);
													//print_r($cl[0]['id']);
													foreach($v1 as $k2=>$v2)
													{
													//	print_r($k2);
														foreach($v2 as $k3=>$v3)
														{
															
															$i=1;
															
																for($i=1;$i<=$v3;$i++)
																{
																	
																	$iid=$this->master_model->get_ids_with_all(array('style_id'=>$st[0]['id'],'color_id'=>$cl[0]['id'],'lot_no'=>$k2,'size_id'=>$k3));
																	$barcode=$st[0]['id'].'-'.$cl[0]['id'].'-'.$iid[0]['id'].'-'.$k3;
																?>
																<div class="barcode_details" ><br />
																	Brand : <span>Cotton Colors</span><br />
																	Style : <span><?=$key?></span><br />
																	Description : <span><?=$code['desc']?></span><br />
																	Size : <span><?=$all_size[$k3]?> inch waist - <?=round((int)$all_size[$k3]*2.54).'cm';?></span><br />
																	Colors : <span><?=$k1?></span><br />
																	Lot NO : <span><?=$k2?></span><br />
                                                                    QTY: ONE PIECE<br />
																	MRP : <span><i class="fa fa-rupee"></i> <?=$code['landed'][$key][$k1][$k2][$k3]?>/- <small>(incl.all taxes)</small></span><br />
																	<img style="width: 130px; margin:1px;height: 20px;" alt="<?=$barcode;?>" src="<?=$this->config->item('base_url')?>bar_code.php?codetype=code39&size=40&text=<?php echo $barcode;?>" /><br />
																	<small>Marketed By :SNEHA APPARELS</span>,<br />
                                                                    #39, Gowarathana Garden,JC Industril area,<br />
																	Yelachanshalli ,Bangalore-560062,<br />
                                                                    Ph: +91 80 2386 15567,www.cottoncolors.in<br /><br /> </small>
																</div>
																
															  
															<?php
																
															}
														}
													}
												}
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