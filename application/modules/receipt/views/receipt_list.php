<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .blue {
        color: rgb(0, 168, 255);
    }
    .green {
        color: green;
    }
    .net_bg {
        background: #448aff;
        color: #fff;
    }
    table tbody tr td:nth-child(4){text-align:right !important;}
    table tbody tr td:nth-child(5){text-align:right;}
    table tbody tr td:nth-child(6){text-align:right;}
    table tbody tr td:nth-child(7){text-align:right;}
    table tbody tr td:nth-child(8){text-align:center;}
    table tbody tr td:nth-child(9){text-align:center;}
    table tbody tr td:nth-child(10){text-align:center;}
    table tbody thead tr th{text-align:center !important;}
    table.dataTable thead .sorting:before {
        bottom: 0.5em !important;
    }
    @media print{
        table tr td:nth-child(10){display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Payment List
        </h5>
    </div>
    <div class="card-block table-border-style">
        <table  class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide" style="display:none;">
            <tr>
                <td>Supplier
                    <input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>
                    <select id='state' class="form-control" style="width: 170px;">
                        <option>Select</option>
                        <?php
                        if (isset($all_state) && !empty($all_state)) {
                            foreach ($all_state as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['state'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select id='supplier'  class="form-control" style="width: 170px;">
                        <option>Select</option>
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
                </td>
                <td>From Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="date" id='from_date'  class="form-control" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td>To Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="date"  id='to_date' class="form-control" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td><a style="float:right;" id='search' class="btn btn-primary btn-sm">Search</a></td>
            </tr>
        </table>
        <div id='result_div' class="table-responsive">
            <table id="receipt_table" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td width="2%" class="action-btn-align">S.No</td>
                        <td width="10%">Invoice #</td>
                        <td width="15%">Company</td>
                        <td class="5%">Inv.Amt</td>
                        <td class="10%">Paid.Amt</td>
                        <td class="10%">Discount.Amt</td>
                        <td class="10%">Balance</td>
                        <td class="center">Due Date</td>
                        <td width="10%" class="action-btn-align">Payment Status</td>
                        <td width="3%" class="hide_class action-btn-align">Action</td>
                    </tr>
                </thead>
                <tbody>

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
                        <td class="hide_class"></td>
                    </tr>
                </tfoot>
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
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>
<?php
if (isset($all_gen) && !empty($all_gen)) {
    foreach ($all_gen as $val) {
        ?>
        <form method="post" action="<?= $this->config->item('base_url') . 'po/force_to_complete/1' ?>">
            <div id="com_<?= $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                            <h4 style="color:#06F">Force to Complete</h4>
                            <h3 id="myModalLabel">
                        </div>
                        <div class="modal-body">

                            <strong>
                                Are You Sure You Want to Complete This PO ?
                            </strong>
                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                <tr>
                                    <td width="40%" style="text-align:right;" class="first_td1">Remarks&nbsp;</td>
                                    <td>
                                        <input type="text" style="width:220px;" class="form-control" name='complete_remarks' />
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="update_id" value="<?= $val['id'] ?>"  />

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#receipt_table').DataTable({
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
                url: BASE_URL + "receipt/ajaxList",
                "type": "POST",
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
        for_loading();
        $.ajax({
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                state: $('#state').val(),
                supplier: $('#supplier').val(),
                supplier_name: $('#supplier').find('option:selected').text(),
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