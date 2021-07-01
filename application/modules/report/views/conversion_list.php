<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tbody tr td:nth-child(4){text-align:right;}
    table tbody tr td:nth-child(5){text-align:center;}
    table tbody tr td:nth-child(7){text-align:right !important;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Quotation Vs Project Conversion Ratio
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
                        <label class="col-xl-8">Conversion Ratio</label>
                        <span class="pcoded-badge label label-success total col-xl-4"></span>
                        <!--<span class="pcoded-badge label label-success total1 col-xl-4"><?php echo $pc_count ?>/<?php echo $td_count ?> </span>-->
            <!--<input type="text" id='from_date' value="<?php echo $quotation[0]['pc_total'][0]['id'] ?>/<?php echo $quotation[0]['quo_total'][0]['id'] ?>" class="form-control" name="inv_date" id="" style="width:100px">-->

                    </div>
                    <div class="col-md-4">
                        <label class="col-xl-8">Conversion Percentage</label>
                        <span class="pcoded-badge label label-success per col-xl-4"></span>
                        <!--<span class="pcoded-badge label label-success per1 col-xl-4"><?php echo number_format($percentage) ?></span>-->
           <!--<input type="text"  id='to_date' class=" form-control" name="inv_date"  value="<?php echo number_format((float) $quotation[0]['percentage']); ?>" style="width:100px">-->

                    </div>
                </div>
            </form>
            <div class="">

                <div class="table-responsive">
                    <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline pd-10" width="100%">
                        <thead>
                            <tr>
                                <td class="action-btn-align">S.No</td>
                                <td>Quotation No</td>
                                <td>Customer Name</td>
                                <td>Quotation Amount</td>
                                <td>Quotation Date</td>
                                <td>Job ID</td>
                                <td>Project Cost Amount</td>
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
</div><!-- contentpanel -->

</div><!-- mainpanel -->
<script type="text/javascript">
    $(document).ready(function () {
//        var tds = $('#basicTable').children('tbody').children('tr').find('.td_cound').length;
//        var td_pc = $('#basicTable').children('tbody').children('tr').find('td.pc_count').length;
//        var val = ((td_pc / tds) * 100).toFixed(2);
//        $('.total').html(td_pc + "/" + tds);
//        $('.per').html(val);
    });
</script>
<script type="text/javascript">
    $('.complete_remarks').live('blur', function ()
    {
        var complete_remarks = $(this).parent().parent().find(".complete_remarks").val();
        var ssup = $(this).offsetParent().find('.remark_error');
        if (complete_remarks == '' || complete_remarks == null)
        {
            ssup.html("Required Field");
        } else
        {
            ssup.html("");
        }
    });

    $(document).ready(function () {
        jQuery('.datepicker').datepicker();

    });
    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
        table.ajax.reload();
//        for_loading();
//        $.ajax({
//            url: BASE_URL + "report/search_conversion_list",
//            type: 'GET',
//            data: {
//                from_date: $('#from_date').val(),
//                to_date: $('#to_date').val()
//            },
//            success: function (result) {
////                for_response();
//                $('#result_div').html(result);
//
//            }
//        });

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
                url: BASE_URL + "report/conversion_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                },
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                        "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                {className: "td_cound", "targets": [0]},
                {className: "pc_count", "targets": [5]},
            ],
            "drawCallback": function (settings) {
                //Make your callback here.
                var tds = settings.json.quo_total;
                var td_pc = settings.json.job_total;
                var val = ((td_pc / tds) * 100).toFixed(2);
                $('.total').html(td_pc + "/" + tds);
                $('.per').html(val);
            },
        });

    });
</script>