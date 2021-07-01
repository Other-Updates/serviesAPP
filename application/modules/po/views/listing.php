<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
 <style type="text/css">
 	.text_right
	{
		text-align:right;
	}
 </style>
 <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
 
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
 
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

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
                        <h4>Add PO</h4>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->
            
        <div class="contentpanel">
            <div class="">
                <table id="example" class="display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Empid</th>
                            <th>Name</th>
                            <th>Salary</th>

                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                           <th>Empid</th>
                            <th>Name</th>
                            <th>Salary</th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div><!-- contentpanel -->
    </div><!-- mainpanel -->
    <script>
        $( document ).ready(function() {
            $('#example').dataTable({
                "bProcessing": true,
                "sAjaxSource": BASE_URL+"sales_order/get_all_customet",,
                "aoColumns": [
                       { mData: 'Empid' } ,
                       { mData: 'Name' },
                       { mData: 'Salary' }
               ]
            });   
        });
    </script>  