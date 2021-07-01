<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>

<!--<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>-->
<script type='text/javascript' src='<?php echo $theme_path; ?>/assets/js/jquery.table2excel.min.js'></script>
<style>
    .total-bg {
        background:#448aff;
        font-weight:bold;
        color:#fff;
    }
    .dataTable tbody tr td:nth-child(2) {
        text-align: left !important;
    }
    .dataTable tbody tr td:nth-child(3) {
        text-align: center !important;
    }
    .dataTable tbody tr td:nth-child(4) {
        text-align: right !important;
    }
    .dataTable tbody tr td:nth-child(5) {
        text-align: right !important;
    }
    .dataTable tbody tr td:nth-child(6) {
        text-align: right !important;
    }
	    .dataTable tbody tr td:nth-child(7) {
        text-align: left !important;
    }

    #myDIVSHOW {
        display:none;
    }
    .btn-success {
        color: #fff;
        background-color: #4bd396;
        border-color: #4bd396;
    }
    .mtop4{margin-top:-10px;}
</style>
<?php
$this->load->model('admin/admin_model');
$data['company_details'] = $this->admin_model->get_company_details();
?>
<!--<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo-login.png" /></div>
            </td>
            <td width="85%">
                <div class="print_header_tit" >
                    <h3>The Total</h3>
                    <p>
<?= $data['company_details'][0]['address1'] ?>,
<?= $data['company_details'][0]['address2'] ?>,
                    </p>
                    <p></p>
                    <p><?= $data['company_details'][0]['city'] ?>-
<?= $data['company_details'][0]['pin'] ?>,
<?= $data['company_details'][0]['state'] ?></p>
                    <p></p>
                    <p>Ph:
<?= $data['company_details'][0]['phone_no'] ?>, Email:
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>-->
<div class="mainpanel">
    <div class="media">

    </div>
    <div class="contentpanel">
        <div  class="media">
            <div class="col-md-10">
                <h4>Balance Sheet Report</h4>
            </div>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <div class="tab-pane" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Balance Sheet Report</h5>
                        </div>
                        <div class="card-block">
                            <div class="panel-body">
                                <div class="row search_table_hide search-area">
                                    <div class="col-md-12 grid-margin stretch-card hide_class">
                                        <div class="card-block table-border-style">
                                            <form id="form-filter">
                                                <div class="form-material row">
                                                    <!--                                                    <div class="col-md-2">
                                                                                                            <div class="material-group">
                                                                                                                <div class="material-addone">
                                                                                                                    <i class="icofont icofont-address-book"></i>
                                                                                                                </div>
                                                                                                                <div class="form-group form-primary">
                                                                                                                    <label class="float-label">Opening Balance</label>
                                                                                                                    <input type="text" id='opening_amt'  class="form-control" name="opening_amount" readonly="">
                                                                                                                    <span class="form-bar"></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>-->
                                                    <div class="col-md-3">
                                                        <div class="material-group">
                                                            <div class="material-addone">
                                                                <i class="icofont icofont-ui-user"></i>
                                                            </div>
                                                            <div class="form-group form-primary">
                                                                <select name="exp[exp_cat_type]" id="exp_cat_type" class="form-control form-align ">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                    if (!empty($category)) {
                                                                        foreach ($category as $cat_type) {
                                                                            ?>
                                                                            <option value="<?php echo $cat_type['id']; ?>"><?php echo ucfirst($cat_type['category_name']); ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="material-group">
                                                            <div class="material-addone">
                                                                <i class="icofont icofont-ui-calendar"></i>
                                                            </div>
                                                            <div class="form-group form-primary">
                                                                <label class="float-label">From Date</label>
                                                                <input tabindex="1" id="from_date" name="from_date" data-date="" data-month="" data-year=""  class="form-control required dropper-default" type="text" placeholder="" />
                                                                <span class="form-bar"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="material-group">
                                                            <div class="material-addone">
                                                                <i class="icofont icofont-ui-calendar"></i>
                                                            </div>
                                                            <div class="form-group form-primary">
                                                                <label class="float-label">To Date</label>
                                                                <input tabindex="1" id="to_date" name="to_date" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
                                                                <span class="form-bar"></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div>
                                                            <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                                                            <a class="btn btn-danger btn-print-invoice m-b-10 btn-sm waves-effect waves-light" id='clear' title="Clear"> Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" >
                                <div class="contentpanel">
                                    <div class="panel-body mt-top5">
                                        <div class="">
                                            <div class="">
                                                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline  ">
                                                    <thead>
                                                        <tr>
                                                            <td class="action-btn-align">S.No</td>


                                                            <!--<td class="action-btn-align">Type</td>-->
                                                            <td class="action-btn-align">Category</td>
                                                            <!--<td class="action-btn-align">Opening Balance</td>-->
                                                            <td class="action-btn-align">Created Date</td>
                                                            <td class="action-btn-align">Debit Amt</td>
                                                            <td class="action-btn-align">Credit Amt</td>
                                                            <td class="action-btn-align">Balance</td>
                                                            <td class="action-btn-align">Remarks</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="result_data">
                                                        <tr>
                                                            <td colspan="7" class="action-btn-align">No Records Found</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot id="footer_id" style="display:none">
                                                        <tr>
                                                            <!--<td></td>-->
                                                            <td></td>
                                                            <!--<td></td>-->
                                                            <td></td>
                                                            <td></td>
                                                            <td class="total-bg text_right"></td>
                                                            <td class="total-bg text_right"></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <!--                                                <div class="action-btn-align mb-10 excel_show" style="display:none">
                                                                                                    <button class="btn btn-primary print_btn"><span class="icon-printer"></span> Print</button>
                                                                                                    <div class="btn-group">
                                                                                                        <button type="button" class=" btn btn-success" data-toggle="dropdown">
                                                                                                            Excel
                                                                                                        </button>
                                                                                                        <ul class="dropdown-menu" role="menu">
                                                                                                            <li><a href="#" class="excel_btn1">Current Entries</a></li>
                                                                                                            <li><a href="#" id="excel-prt">Entire Entries</a></li>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="export_excel"></div>
<script>
    $(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-m-Y'
    });
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
    });
    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').click(function () { //button filter event click
        var table;

//        var firm_id = $('#firm').val();
        var firm_id = '1';
        if (firm_id != '') {
            $("#footer_id").show();
            $(".excel_show").show();
            table = $('#basicTable_call_back').DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "language": {
                    "infoFiltered": ""
                },
                //"lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "retrieve": true,
                "order": [], //Initial no order.
                //dom: 'Bfrtip',
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('expense/balance_sheet/balancesheet_ajaxList/'); ?>",
                    "type": "POST",
                    "data": function (data) {
                        data.firm_id = $('#firm_id').val();
                        data.from_date = $('#from_date').val();
                        data.to_date = $('#to_date').val();
                        data.exp_cat_type = $('#exp_cat_type').val();
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {
//                        "targets": [0, 6], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
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
                    var cols = [3, 4];
                    var currency_symbol = '<span class="hide_rupee">&#8377;</span>'
//                    var numFormat = $.fn.dataTable.render.number('\,', '.', 2, currency_symbol).display;
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
                        if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
                            pageTotal = pageTotal;
                        } else {
                            pageTotal = pageTotal.toFixed(2); /* float */

                        }
                        $(api.column(cols[x]).footer()).html(numFormat(pageTotal));
                    }


                },
                responsive: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: -2}
                ]
            });
        } else {
            swal("Please select Company");
        }
        table.ajax.reload();  //just reload table
//        new $.fn.dataTable.FixedHeader(table);
    });


    $(document).on('click', '#clear', function () {
        $('#form-filter')[0].reset();
    });


//    var firm_id = $(this).val();
    $(document).ready(function () {
        $("#opening_amt").parent().find(".float-label").removeClass('newClass1');
        $("#opening_amt").parent().find(".float-label").addClass('newClass');
        var firm_id = '1';
        $.ajax({
            url: BASE_URL + "expense/balance_sheet/get_company_amount",
            type: "post",
            data: {firm_id: firm_id},
            dataType: 'json',
            success: function (result) {
                if (result[0].opening_balance != null && result[0].opening_balance > 0) {
                    opening_amt = (result[0].opening_balance);
                    $("#opening_amt").val(opening_amt);
                } else {
                    $("#opening_amt").val('0');
                }
            }

        });
    });


    $(document).on('click', '.excel_btn1', function () {
        fnExcelReport2();
    });
    function fnExcelReport2() {

        var tab_text = "<table id='custom_export' border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('basicTable_call_back'); // id of table
        for (j = 0; j < tab.rows.length; j++)
        {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        $('#export_excel').show();
        $('#export_excel').html('').html(tab_text);
        $('#export_excel').hide();
        $("#custom_export").table2excel({
            exclude: ".noExl",
            name: "Balance List",
            filename: "Balance List",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false
        });
    }
    $('#excel-prt').on('click', function () {
        var firm_id = '1';
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        window.location = (BASE_URL + 'expense/balance_sheet/getall_balance_entries?firm_id=' + firm_id + '&from_date=' + from_date + '&to_date=' + to_date);
    });

</script>
<!--<script src="<?= $theme_path; ?>/assets/js/dataTables.fixedHeader.min.js"></script>-->