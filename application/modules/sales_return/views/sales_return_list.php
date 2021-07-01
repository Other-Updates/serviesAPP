<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(4){text-align:center;}
    table tr td:nth-child(5){text-align:center;}
    table tr td:nth-child(6){text-align:center;}
    table tr td:nth-child(7){text-align:right;}
    table tr td:nth-child(8){text-align:right;}
    @media print{
        table tr td:nth-child(10){display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Sales Return List
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div id='result_div' class="table-responsive">
            <table id="sales_return_table" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline newtbl-bordr">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Invoice #</td>
                        <td>Company</td>
                        <td class="action-btn-align">Tot.Qty</td>
                        <td class="action-btn-align">Ret.Qty</td>
                        <td class="action-btn-align">Pre.Qty</td>
                        <td class="text_right">Sub.Tot</td>
                        <td class="text_right">Tot.Amt</td>
                        <td class="hide_overflow">Remarks</td>
                        <td class="hide_class action-btn-align">Action</td>
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
        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>

                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This Purchase Order?<strong><?= $val['po_no']; ?></strong>
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                                <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
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
        for_loading();
        $.ajax({
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                style: $('#style').val(),
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
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#sales_return_table').DataTable({
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
                url: BASE_URL + "sales_return/ajaxList",
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
        $("#yesin").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "purchase_order/po_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "purchase_order/purchase_order_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
