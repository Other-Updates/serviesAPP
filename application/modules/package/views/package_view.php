<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                        <h4>Package Order</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
            <div class="contentpanel">
            <form method="post">
            <table style="width:60%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">  	
               <tr>
               	<td colspan="4" style="text-align:center;">
                	<b><?=$package_details[0]['package_slip']?></b>
                </td>
               </tr>
               <tr>
               		<td width="17%">Customer Name</td>
                    <td width="27%">
                    	<?=$package_details[0]['store_name']?>
                    </td>
                    <td width="17%">No&nbsp;of&nbsp;Cottons</td>
                    <td  width="27%"><?=$package_details[0]['no_corton']?></td>
               </tr>
               <tr>
               		<td>Ship Mode</td>
                    <td><?=$package_details[0]['ship_mode']?></td>
                    <td>Ship Date</td>
                    <td>
                    	<?=$package_details[0]['ship_date']?>
                    </td>
               </tr>
               <tr>
               		<td>Country of Origin</td>
                    <td><?=$package_details[0]['origin']?></td>
                    <td>Destination</td>
                    <td><?=$package_details[0]['destination']?></td>
               </tr>
               <tr>
               		<td>LR NO</td>
                    <td><?=$package_details[0]['lr_no']?></td>
                    <td>Transport</td>
                    <td><?=$package_details[0]['llr_no']?></td>
               </tr>
               </table>
               <br />
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                        	<th>Style</th>
                            <th>Carton No</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Total Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					
                        if(isset($package_info) && !empty($package_info))
                        {
                            $full_total=0;
                            foreach($package_info as $val)
                            {
                                
                                
                                foreach($val['style_color'] as $val1)
                                {
									
									$total_p=0;
									foreach($val1['size'] as $val2)
									{
										$total_p=$total_p+$val2['qty'];
									}
									if($total_p==0)
										continue;
									?>
                                    <tr>
                                    	<td><?=$val['style_name'];?></td>
                                        <td class="cor_class" style="text-align:center;">
                                            <?=$val1['corton_no']?>
                                        </td>
                                        <td>
                                            <?=$val1['colour']?>
                                        </td>
                                        <td >
                                            <?php
                                            $total=0;
                                                foreach($val1['size'] as $val2)
                                                {
                                                    $total=$total+$val2['qty'];
                                                    ?>
                                                    <div  style="border: 1px solid rgb(181, 181, 181);text-align: center;float: left;width: 62px;" >
                                                        <p  style="margin: 0 0 0px;"  ><?=$val2['size']?></p>
                                                        <p   style="margin: 0 0 0px;">
                                                            <?=$val2['qty']?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }
                                                $full_total=$full_total+$total;
                                            ?>
                                        </td>
                                        <td><?=$total?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            echo "<tr><td  style='text-align:right;' colspan='4'>Total Qty</td><td>".$full_total."</td><input type='hidden' name='package[total_qty]' value=".$full_total." /></tr></tbody>";
                        }
                        else
                        {
                            echo "<tr><td colspan='5'>Sales Order Not Created Yet....</td></tr></tbody>";
                        }
                    ?>
                   
                </table> 
                <div class="action-btn-align">
                  <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                    </div>
                
             <script>
				$('.print_btn').click(function(){
					window.print();
				});
			  </script>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
      