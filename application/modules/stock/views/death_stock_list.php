<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(4){text-align:center;}
    table tr td:nth-child(5){text-align:center;}
    table tr td:nth-child(6){text-align:center;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Dead Stock List</h5>
        <a href="<?php if ($this->user_auth->is_action_allowed('stock', 'death_stock', 'add')): ?><?php echo $this->config->item('base_url') . 'stock/death_stock/add' ?><?php endif ?>" class="btn btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger <?php if (!$this->user_auth->is_action_allowed('stock', 'death_stock', 'add')): ?>alerts<?php endif ?>"><i class="fa fa-plus m-r-5"></i> Add Dead Stock</a>
    </div>

    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered" id="stock_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Product</td>

                        <td>Model #</td>

                        <td class="action-btn-align">Stock</td>
                        <td>Dead Stock Qty</td>
                        <td>Date</td>
<!--  <td class="action-btn-align">Action</td>!-->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button type="button" class="btn btn-primary print_btn btn-sm waves-effect waves-light">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
    $(document).ready(function ()
    {
        $('#stock_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "language": {
                "infoFiltered": ""
            },
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "stock/death_stock/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                    "targets": [0,6], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
</script>