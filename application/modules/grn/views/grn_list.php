<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(2){width:15%;}
    table tr td:nth-child(3){width:15%;}
    table tr td:nth-child(4){width:12%;}
    table tr td:nth-child(5){width:30%;}
    table tr td:nth-child(9){text-align: center;}
    table tr td:nth-child(7){text-align: right;}
    table tr td:nth-child(6){text-align: center;}
    table tr td:nth-child(8){text-align: center;}
    @media print{
        table tr td:last-child{display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Good Receive Note List </h5>
        <a href="<?php echo $this->config->item('base_url') . 'grn/' ?>" class="btn btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger "><i class="fa fa-plus m-r-5"></i> Add GRN</a>
    </div>
    <div class="card-block table-border-style">
        <div id='result_div' class="table-responsive">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="grn_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>GRN #</td>
                        <td>PO #</td>
                        <td>Vendor Inv #</td>
                        <td>Vendor</td>
                        <td >GRN Qty</td>
                        <td >GRN Value</td>
                        <td >Date</td>
                        <td class="hide_class action-btn-align">Action</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>
<script>
    $(document).ready(function () {
        $('#grn_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "language": {
                "infoFiltered": ""
            },
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "grn/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                    "targets": [0, 11], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
//        jQuery('.datepicker').datepicker();
    });
</script>