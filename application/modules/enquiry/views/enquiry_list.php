<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(5){text-align:center;}
    table tr td:nth-child(6){text-align:center;}
    table tr td:nth-child(9){text-align:center;}
    table tr td:nth-child(8){ }
    @media print{
        table tr td:last-child{display:none;}
        body{font-size:8px !important;}
        table, table tr th, table tr td, table tr td p{font-size:9px !important;}
    }
    @page {
        size:A5 Portrait !important;

    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Leads Details</h5>
        <a href="<?php if ($this->user_auth->is_action_allowed('enquiry', 'enquiry', 'add')): ?><?php echo $this->config->item('base_url') . 'enquiry/' ?><?php endif ?>" class="btn btn-round btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger <?php if (!$this->user_auth->is_action_allowed('enquiry', 'enquiry', 'add')): ?>alerts<?php endif ?>"><i class="fa fa-plus m-r-5"></i> Add Leads</a>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered" id="leads_table">
                <thead>
                    <tr>
                        <th class="action-btn-align">S.No</th>
                        <th>Leads #</th>
                        <th>Customer</th>
                        <th>Cus.Address</th>
                        <th>Date</th>
                        <th>Followup Date</th>
                        <th>Assigned</th>
                        <th>About</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <?php
                        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
                        if (($user_info[0]['role'] != 5)) {
                            ?>
                            <th class="hide_class action-btn-align" >Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button type="button" class="btn btn-round btn-primary print_btn btn-sm waves-effect waves-light">Print</button>
                </div>
            </div>
        </div>
        <?php
        if (isset($all_enquiry) && !empty($all_enquiry)) {
            foreach ($all_enquiry as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor">
                                <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>
                                <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This user?<strong><?= $val['enquiry_no']; ?></strong>
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                                <button type="button" class="btn btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
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
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
    });
    $().ready(function () {
        $("#ps_no").autocomplete(BASE_URL + "enquiry/get_ps_no_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').on('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "enquiry/search_result",
            type: 'GET',
            data: {
                ps_no: $('#ps_no').val(),
                customer: $('#customer').val(),
                customer_name: $('#customer').find('option:selected').text(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_div').html(result);
            }
        });
    });
</script>



<script type="text/javascript">
    function delete_leads(val) {
        $('#test3_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $('#leads_table').DataTable({
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
                url: BASE_URL + "enquiry/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 10], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
        $(".delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            //alert(hidin);
            $.ajax({
                url: BASE_URL + "enquiry/enquiry_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "enquiry/enquiry_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
