<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tbody tr td:nth-child(4){text-align:right;}
    table tbody tr td:nth-child(5){text-align:right;}
    table tbody tr td:nth-child(6){text-align:right;}
    table tbody tr td:nth-child(7){text-align:right;}
    table tbody tr td:nth-child(8){text-align:center;}
    @media print{
        table, table tr th, table tr td, table tr td p{font-size:9px !important;}
    }
    .net_bg {
        background: #448aff;
        color: #fff;
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="">

        <div class="card-header">
            <h5>Outstanding Report
            </h5>
        </div>
        <div class="card-block table-border-style">
            <form>
                <div class="form-material row">

                    <div class="col-md-4">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-address-book"></i>
                            </div>
                            <div class="form-group form-primary">

                                <select id='customer'  class="form-control" >
                                    <option>Select Company Name</option>
                                    <?php
                                    if (isset($all_supplier) && !empty($all_supplier)) {
                                        foreach ($all_supplier as $val) {
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
                    <!--                    <div class="col-md-3">
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
                                        </div>-->
                    <!--                    <div class="col-md-3">
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

                                        </div>-->
                    <div class="col-md-2">
                        <label class="float-label hide-color">Search</label>
                        <div>
                            <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="receipt_table" class="table table-striped table-bordered responsive">
                    <thead>
                        <tr>
                            <td width="2%" class="action-btn-align">S.No</td>
                            <td width="15%">Invoice #</td>
                            <td width="25%" >Company Name</td>
                            <td class="">Inv.Amt</td>
                            <td class="">Paid.Amt</td>
                            <td class="">Discount.Amt</td>
                            <td class="">Balance</td>
                            <td class="center">Due Date</td>
                            <td width="5%" class="action-btn-align">Payment Status</td>

                        </tr>
                    </thead>
                    <tbody id='result_div' >

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="center net_bg"></td>
                            <td class="center net_bg"></td>
                            <td></td>
                            <td class="center net_bg"></td>
                            <td class=""></td>
                            <td class=""></td>

                        </tr>
                    </tfoot>
                </table>

                <div class="text-center m-10">
                    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                    <button class="btn btn-success excel_btn btn-sm waves-effect waves-light" >Excel</button>
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

        $('#search').on('click', function () {
            table.ajax.reload();
//            for_loading();
//            $.ajax({
//                url: BASE_URL + "report/quotation_search_result",
//                type: 'GET',
//                data: {
//                    q_no: $('#q_no').val(),
//                    customer: $('#customer').val(),
//                    from_date: $('#from_date').val(),
//                    to_date: $('#to_date').val()
//                },
//                success: function (result) {
////                    for_response();
//                    $('#result_div').html('');
//                    $('#result_div').html(result);
//                }
//            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function ()
        {
            table = $('#receipt_table').DataTable({
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
                    url: BASE_URL + "report/outstanding_ajaxList",
                    "type": "POST",
                    "data": function (data) {
                        data.customer = $('#customer').val();
                        data.from_date = $('#from_date').val();
                        data.to_date = $('#to_date').val();
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over all pages
                    var cols = [3, 4, 6];
                    var numFormat = $.fn.dataTable.render.number('\,', '.', 2).display;
                    for (x in cols) {
                        total = api.column(cols[x]).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        // Total over this page
                        pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        // Update footer
//                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
//                        pageTotal = pageTotal;
//                    } else {
//                        pageTotal = pageTotal.toFixed(2); /* float */
//
//                    }
                        $(api.column(cols[x]).footer()).html(numFormat(pageTotal));
                    }


                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {
//                    "targets": [0, 11], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
            });
            $("#yesin").on("click", function ()
            {

                var hidin = $(this).parent().parent().find('.id').val();
                // alert(hidin);
                $.ajax({
                    url: BASE_URL + "quotation/quotation_delete",
                    type: 'POST',
                    data: {value1: hidin},
                    success: function (result) {

                        window.location.reload(BASE_URL + "quotation/quotation_list");
                    }
                });

            });

            $('.modal').css("display", "none");
            $('.fade').css("display", "none");

        });
    </script>
