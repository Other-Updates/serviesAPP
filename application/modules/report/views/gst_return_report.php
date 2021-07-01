<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tbody tr td:nth-child(2){text-align:center;}
    table tbody tr td:nth-child(4){text-align:center;}
    table tbody tr td:nth-child(3){text-align:left;}
    table tbody  td:nth-child(5){text-align:right;}
    table tbody tr td:nth-child(6){text-align:right;}
    table tbody tr td:nth-child(7){text-align:right;}
    table tbody tr td:nth-child(8){text-align:right;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Invoice List
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
                            <select id='inv_id' class="form-control">
                                <option value="">Select Invoice ID</option>
                                <?php
                                if (isset($all_inv) && !empty($all_inv)) {
                                    foreach ($all_inv as $val) {
                                        ?>
                                        <option value='<?= $val['inv_id'] ?>'><?= $val['inv_id'] ?></option>
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
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='gst_sales_report'  class="form-control" >
                                <option value="">Select GST</option>
                                <?php
                                if (isset($all_gst) && !empty($all_gst)) {
                                    foreach ($all_gst as $val) {
                                        ?>
                                        <option value='<?= $val ?>'><?= $val ?>%</option>
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
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='customer'  class="form-control" >
                                <option value="">Select Customer</option>
                                <?php
                                if (isset($all_supplier) && !empty($all_supplier)) {
                                    foreach ($all_supplier as $val) {
                                        ?>
                                        <option value='<?= $val['id'] ?>'><?= $val['name'] ?></option>
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
                <div class="">
                    <div>
                        <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <div class="card-block table-border-style">
        <div  class=" table-responsive">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Invoice ID</td>
                        <td>Customer Name</td>
                        <td class="action-btn-align">Total Quantity</td>
                        <td class="action-btn-align">CGST</td>
                        <td>SGST</td>
                        <td>Sub Total</td>
                        <td>Invoice Amount</td>
                        <td>Invoice Date</td>

                    </tr>
                </thead>
                <tbody  id='result_div' >

                </tbody>
            </table>
            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light print_btn">Print</button>
                <button class="btn btn-success btn-sm waves-effect waves-light excel_btn"> Excel</button>
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
//            url: BASE_URL + "report/invoice_search_result",
//            type: 'GET',
//            data: {
//                inv_id: $('#inv_id').val(),
//                customer: $('#customer').val(),
//                from_date: $('#from_date').val(),
//                to_date: $('#to_date').val()
//            },
//            success: function (result) {
////                for_response();
//                $('#result_div').html('');
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
                url: BASE_URL + "report/gst_return_report/invoice_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.inv_id = $('#inv_id').val();
                    data.customer = $('#customer').val();
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                    data.gst = $('#gst_sales_report').val();
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
