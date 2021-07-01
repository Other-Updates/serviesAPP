<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tbody tr td:nth-child(4){text-align:center;}
    table tbody tr td:nth-child(5){text-align:right;}
    table tbody tr td:nth-child(6){text-align:right;}
    @media print{
        table tr td:last-child{display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Service and Repair</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="col-md-6 hide_class">
            <label class="col-form-label">Service Type</label>
            <div class="form-radio">
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="Radio" value="<?php if ($this->user_auth->is_action_allowed('service', 'service', 'add')): ?>paid<?php endif ?>" class="<?php if (!$this->user_auth->is_action_allowed('service', 'service', 'add')): ?>alerts<?php endif ?>">
                        <i class="helper"></i>Spot Billing
                    </label>
                </div>
                <div class="radio radiofill radio-primary radio-inline">
                    <label>
                        <input type="radio" name="Radio" value="<?php if ($this->user_auth->is_action_allowed('service', 'service', 'edit')): ?>warranty<?php endif ?>" class="<?php if (!$this->user_auth->is_action_allowed('service', 'service', 'edit')): ?>alerts<?php endif ?>">
                        <i class="helper"></i>Warranty Service
                    </label>
                </div>
            </div>
        </div>

        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered" id="service_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Quotation No</td>
                        <td>Company Name</td>
                        <td class="action-btn-align">Total Quantity</td>
    <!--                            <td class="action-btn-align">Total Tax</td>-->
                        <td class="text-right">Sub Total</td>
                        <td class="text-right">Total Amount</td>
<!--                        <td class="center">Delivery Schedule</td>
                        <td class="center">Notification Date</td>-->
                        <td class="center">Mode of Payment</td>
                        <td class="action-btn-align">Validity</td>
                        <td>Remarks</td>
                        <td class="hide_class action-btn-align">Action</td>
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
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>
<script>
    $('input[type="radio"]').click(function () {
        if ($(this).attr("value") == "paid") {
            window.location.replace("<?php echo $this->config->item('base_url') . 'service/paid_service_add/' ?>");
        }
        if ($(this).attr("value") == "warranty") {
            window.location.replace("<?php echo $this->config->item('base_url') . 'service/project_cost_update/' ?>");
        }
    });
    $(document).ready(function ()
    {
        $('#service_table').DataTable({
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
                url: BASE_URL + "service/ajaxList",
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
    });
</script>
