<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<style>
    table tbody tr td:nth-child(2){text-align:center;}
    table tbody tr td:nth-child(3){text-align:center;}
    table tbody tr td:nth-child(5){text-align:center;}
    table tbody tr td:nth-child(6){text-align:center;}
    @media print{
        table tbody td:nth-child(3){white-space:unset;}}
    </style>
    <div class="card">
        <?php
        $this->load->view("admin/main-printheader");
        ?>
    <div class="card-header">
        <h5>Inward & Outward DC List </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="col-md-6 hide_class">
            <label class="col-form-label">Type</label>
            <div class="form-radio">
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="Radio" value="<?php if ($this->user_auth->is_action_allowed('service_inward_and_outward_dc', 'service_inward_and_outward_dc', 'add')): ?>inward<?php endif ?>" class="<?php if (!$this->user_auth->is_action_allowed('service', 'service', 'add')): ?>alerts<?php endif ?>">
                        <i class="helper"></i>Inward
                    </label>
                </div>
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="Radio" value="<?php if ($this->user_auth->is_action_allowed('service_inward_and_outward_dc', 'service_inward_and_outward_dc', 'add')): ?>outward<?php endif ?>" class="<?php if (!$this->user_auth->is_action_allowed('service', 'service', 'edit')): ?>alerts<?php endif ?>">
                        <i class="helper"></i>Outward
                    </label>
                </div>
            </div>
        </div>
        <div id='result_div' class="table-responsive">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="inward_outward_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>DC #</td>
                        <td>Inv #</td>
                        <td>Project</td>
                        <td>Type</td>
                        <td>Total Qty</td>
                        <td>Created Date</td>
                        <td>Action</td>
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
    $('input[type="radio"]').click(function () {
        if ($(this).attr("value") == "inward") {
            window.location.replace("<?php echo $this->config->item('base_url') . 'service_inward_and_outward_dc/add_inward_dc/' ?>");
        }
        if ($(this).attr("value") == "outward") {
            window.location.replace("<?php echo $this->config->item('base_url') . 'service_inward_and_outward_dc/add_outward_dc/' ?>");
        }
    });
    $(document).ready(function () {
        table = $('#inward_outward_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "service_inward_and_outward_dc/inward_and_outward_ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
</script>