<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tr td:nth-child(5){text-align:center;}
    table tr td:nth-child(6){text-align:center !important;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Service vs Completed service Ratio
        </h5>
    </div>
    <div class="">
        <div class="card-block table-border-style">
            <form>
                <div class="form-material row">
                    <div class="col-md-3">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-ui-calendar"></i>
                            </div>
                            <div class="form-group form-primary">
                                <label class="float-label">From Date</label>
                                <input tabindex="1" id="from_date" name="inv_date" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
                                <span class="form-bar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-ui-calendar"></i>
                            </div>
                            <div class="form-group form-primary">
                                <label class="float-label">To Date</label>
                                <input tabindex="1" id="to_date" name="inv_date" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
                                <span class="form-bar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div>
                            <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <div id='result_div' class="card-block">
            <form>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="col-xl-8">Service Ratio</label>
                        <span class="pcoded-badge label label-success total col-xl-4"></span>
                        <!--<span class="pcoded-badge label label-success col-xl-4"><?php echo $pending_count ?>/<?php echo $completed_count ?> </span>-->
                    </div>
                    <div class="col-md-4">
                        <label class="col-xl-8">Service Percentage</label>
                        <span class="pcoded-badge label label-success per col-xl-4"></span>
                       <!--<span class="pcoded-badge label label-success per1 col-xl-4"><?php echo number_format($service_percentage) ?></span>-->
                    </div>
                </div>
            </form>
            <div class="">

                <div class="table-responsive">
                    <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline pd-10">
                        <thead>
                            <tr>
                                <td width="33" class="action-btn-align">S.No</td>
                                <td width="35">Inv No</td>
                                <td width="35">Ticket No</td>
                                <td width="35">Description</td>
                                <td width="35">Warranty</td>
                                <td width="35">Created Date</td>
                                <td width="92">Status</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="text-center m-10">
                    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                    <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>
<script type="text/javascript">

    $('#search').live('click', function () {
        table.ajax.reload();
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        table = $('#basicTable').DataTable({
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
                url: BASE_URL + "report/service_ratio_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                },
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
            "drawCallback": function (settings) {
                //Make your callback here.
                var td_service = settings.json.total_service;
                var td_pending = settings.json.pending_service;
                var td_completed = settings.json.completed_service;
                var val = ((td_completed / td_service) * 100).toFixed(2);
                $('.total').html(td_pending + "/" + td_completed);
                $('.per').html(val);
            },
        });

    });
</script>