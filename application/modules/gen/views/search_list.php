<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script>
	
        jQuery(document).ready(function() {

            jQuery('#basicTable').DataTable({
                responsive: true
            });

            var shTable = jQuery('#shTable').DataTable({
                "fnDrawCallback": function(oSettings) {
                    jQuery('#shTable_paginate ul').addClass('pagination-active-dark');
                },
                responsive: true
            });

            // Show/Hide Columns Dropdown
            jQuery('#shCol').click(function(event) {
                event.stopPropagation();
            });

            jQuery('#shCol input').on('click', function() {

                <!--Notification JSON coding-->



                // Get the column API object
                var column = shTable.column($(this).val());

                // Toggle the visibility
                if ($(this).is(':checked'))
                    column.visible(true);
                else
                    column.visible(false);
            });

            var exRowTable = jQuery('#exRowTable').DataTable({
                responsive: true,
                "fnDrawCallback": function(oSettings) {
                    jQuery('#exRowTable_paginate ul').addClass('pagination-active-success');
                },
                "ajax": "ajax/objects.txt",
                "columns": [{
                    "class": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                }, {
                    "data": "name"
                }, {
                    "data": "position"
                }, {
                    "data": "office"
                }, {
                    "data": "salary"
                }],
                "order": [
                    [1, 'asc']
                ]
            });

            // Add event listener for opening and closing details
            jQuery('#exRowTable tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = exRowTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });


            // DataTables Length to Select2
            jQuery('div.dataTables_length select').removeClass('form-control input-sm');
            jQuery('div.dataTables_length select').css({
                width: '60px'
            });
            jQuery('div.dataTables_length select').select2({
                minimumResultsForSearch: -1
            });

        });

        function format(d) {
            // `d` is the original data object for the row
            return '<table class="table table-bordered nomargin">' +
                '<tr>' +
                '<td>Full name:</td>' +
                '<td>' + d.name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extension number:</td>' +
                '<td>' + d.extn + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '</table>';
        }var UP_ARROW = 38,
				DOWN_ARROW = 40;
		$('input').live('keyup',function(evt){
			var str = $(this).val();
			if (evt.keyCode != 37 && evt.keyCode != 39)
			{
				str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					return letter.toUpperCase();
				});
				$(this).val(str);
			}
			
		});
		
    </script>
<table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline search_table" style="display:none;">
	<tr>
    	<td width="10%">GRN</td>
		<td width="10%">
        	<?php 
				if($search_data['grn']!='')
					echo $search_data['grn'];
				else
					echo "-";		
			?>
        </td>
        <td width="10%">po</td>
		<td width="10%">
        	<?php 
				if($search_data['po']!='')
					echo $search_data['po'];
				else
					echo "-";		
			?>
        </td>
        <td width="10%">State</td>
		<td width="10%">
        	<?php 
				if($search_data['state_name']!='Select')
					echo $search_data['state_name'];
				else
					echo "-";		
			?>
        </td>
    	<td width="10%">Supplier</td>
		<td width="10%">
        	<?php 
				if($search_data['supplier_name']!='Select')
					echo $search_data['supplier_name'];
				else
					echo "-";		
			?>
        </td>
        <td  width="10%">From&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['from_date']!='')
					echo $search_data['from_date'];
				else
					echo "-";	
			?>
        </td>
        <td  width="10%">To&nbsp;Date</td>
        <td  width="10%">
        	<?php 
				if($search_data['to_date']!='')
					echo $search_data['to_date'];
				else
					echo "-";		
			?>
        </td>
    </tr>
</table>
<?php 
//echo "<pre>";
//print_r($search_data);
?>
                  <table  id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                  	<thead>
                    	<tr>
                        	<td>S.No</td>
                        	<td>GRN No</td>
                        	<td>PO No</td>
                           <td >Style</td>
                            <td>Supplier</td>
                            <td>Date</td>
                            <td>GRN Qty</td>
                            <td>GRN Value</td>
                          
                            <td  class="hide_class">Ation</td>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
						$count=0;$total_value=0;
                        	if(isset($all_gen) && !empty($all_gen))
							{
								$j=1;
								foreach($all_gen as $val)
								{
									?>
                                    <tr>
                                    <td class='first_td'><?=$j?></td>
                                    <td><?=$val['grn']?></td>
                                    <td><?=$val['po_no']?></td>	
                                   <td><?=$val['style_name']?></td>	
                                    <td><?=$val['store_name']?></td>
                                    <td><?=date('d-M-Y',strtotime($val['inv_date']))?></td>
                                    <td><?=$val['total_qty']?></td>
                                    <td  class="text_right"><?=number_format($val['total_value'], 2, '.', ',')?></td>
                                   
                                    	<?php
											$i=1;
										?>
                                    
									<td  class="hide_class">
                                     <a href="<?php echo $this->config->item('base_url').'gen/view_gen/'.$val['gen_id']?>" data-toggle="tooltip" class="fa fa-eye tooltips" title="" data-original-title="View">&nbsp;</a>
                                     <a style="display:none;" href="<?php echo $this->config->item('base_url').'gen/edit_gen/'.$val['gen_id']?>" data-toggle="tooltip" class="fa fa-edit tooltips hide_edit" title="" data-original-title="Edit">&nbsp;</a> 
                                       
                                    </td>
                                    </tr>
                                    <?php
									$j++;
										$count=$count+$val['full_total'];
										$total_value=$total_value+$val['total_value'];
								}
								?>
                                <tfoot>
                                    <tr  class='first_td'>
                                        <td></td><td></td><td></td><td></td><td></td><td></td><td><?=$count;?></td><td  class="text_right"><?=number_format($total_value, 2, '.', ',')?></td><td class="hide_class"></td>
                                    </tr>
                                </tfoot>
								<?php
							}
							
						?>
                    </tbody>
                  </table>
                 