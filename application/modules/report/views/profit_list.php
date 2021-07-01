<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tbody tr td:nth-child(4){text-align:right;}
    table tbody tr td:nth-child(7){text-align:right;}
    table tbody tr td:nth-child(9){text-align:right;}
    table tbody tr td:nth-child(10){text-align:center;}
    table tbody tr td:nth-child(6){text-align:center;}
    table tbody tr td:nth-child(11){text-align:right !important;}
    table thead tr td{text-align:center !important;}
    @media print{
        body{font-size:8px !important;}
        table, table tr th, table tr td, table tr td p{font-size:9px !important;}
    }
    @page {
        size:A4 Portrait !important;

    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Profit and Loss Report
        </h5>
    </div>
    <div class="card-block table-border-style">
        <form>
            <div class="form-material row">
                <div class="col-md-3">
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='company_name' class="form-control">
                                <option>Select Company Name</option>
                                <?php
                                if (isset($all_company) && !empty($all_company)) {
                                    foreach ($all_company as $val) {
                                        ?>
                                        <option value='<?= $val['id'] ?>'><?= $val['store_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
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
                            <label class="float-label">From Date</label>
                            <input tabindex="1" id="from_date" name="inv_date" data-date="" data-month="" data-year=""  class="form-control required dropper-default" type="text" placeholder="" />
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
    <div id='result_div' class="card-block table-border-style">
        <div class="table-responsive">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Quotation #</td>
                        <td>Customer</td>
                        <td>Quotation Amt</td>
                        <td>Inv #</td>
                        <td>Inv Date</td>
                        <td>Inv Amt</td>
                        <td>Job ID</td>
                        <td>Project Cost Amount</td>
                        <td>Profit %</td>
                        <td>Profit Amt</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
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
    $('.complete_remarks').on('blur', function ()
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

//                $().ready(function() {
//                        $("#po_no").autocomplete(BASE_URL+"gen/get_po_list", {
//                                width: 260,
//                                autoFocus: true,
//                                matchContains: true,
//                                selectFirst: false
//                        });
//                });
    $('#search').on('click', function () {
        table.ajax.reload();
//        for_loading();
//        $.ajax({
//            url: BASE_URL + "report/search_profit_list",
//            type: 'GET',
//            data: {
//                from_date: $('#from_date').val(),
//                to_date: $('#to_date').val()
//            },
//            success: function (result) {
////                for_response();
//                $('#result_div').html(result);
//            }
//        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
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
                url: BASE_URL + "report/profit_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                    data.company_name = $('#company_name').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                        "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
        $("#yesin").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "Project_cost_model/quotation_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "Project_cost_model/quotation_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
