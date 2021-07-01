<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(4){text-align:center;}
    table tr td:nth-child(5){text-align:right;}
    table tr td:nth-child(6){text-align:center;}
    table tr td:nth-child(7){text-align:right;}

    @media print{
        table tr td:last-child{display:none;}
    }
    .ui-autocomplete {
        position: relative;
        z-index: 9999;
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 7px 0;
        width: 250px;
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Purchase Return List</h5>
        <button class="btn btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger " onclick="purchase_return_modal()" data-toggle="modal" data-target="#purchase_return_modal"><i class="fa fa-plus m-r-5"></i> Make Return</button>
    </div>
    <div class="modal" style="display: none;" id="purchase_return_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Return</h5>
                    <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                </div>
                <div class="modal-body">
                    <form class="form-material">
                        <div class="form-material row">
                            <div class="col-md-12">
                                <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-brand-china-mobile"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="hidden"  name="grn_id" id="grn_id"/>
                                        <label class="float-label">GRN Number</label>
                                        <input type="text" name="grn_no" class="form-control grn_no" id="grn_no" >
                                        <span class="form-bar"></span>
                                        <span class="grn_error_msg error_msg"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" name="submit" id="submit_modal" class="btn btn-primary btn-sm mobtn">Submit</button>
                    <button type="button"  class="btn btn-danger mobtn btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered" id="pr_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td style="width:157px">GRN #</td>
                        <td>Company</td>
                        <td class="action-btn-align">Tot.Qty</td>
                        <td class="text_right">Tot.Amt</td>
                        <td class="action-btn-align">R.Qty</td>
                        <td class="text_right">Ret.Amt</td>
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
        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor">
                                <h4 id="myModalLabel" class="inactivepop">In-Active user</h4>
                                <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This Purchase Order?<strong><?= $val['po_no']; ?></strong>
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
//    $().ready(function () {
//        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
//            width: 260,
//            autoFocus: true,
//            matchContains: true,
//            selectFirst: false
//        });
//    });
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
        $('.grn_no').on('keydown', function () {
            $('body').find(".grn_no").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        type: 'POST',
                        data: {grn_no: $('#grn_no').val()},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_return/get_grn_list/",
                        success: function (data) {
                            data = JSON.parse(data);
                            var c_data = data;
                            var outputArray = new Array();
                            for (var i = 0; i < c_data.length; i++) {
                                if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                                    outputArray.push(c_data[i]);
                                }
                            }
                            if (outputArray.length == 0) {
                                var nodata = 'No Data Found';
                                outputArray.push(nodata);
                                $('#grn_id').val('');
                            }
                            response(outputArray.slice(0, 10));
                        }
                    });
                },
                minLength: 0,
                delay: 0,
                autoFocus: true,
                select: function (event, ui) {
                    grn_id = ui.item.id;
                    $('#grn_id').val(grn_id);
                }
            });
        });

        $('#pr_table').DataTable({
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
                url: BASE_URL + "purchase_return/ajaxList",
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
    function purchase_return_modal() {
        $('#purchase_return_modal').show();
        $('#customer_name').focus();
    }

    function cancel_modal() {
        $('#purchase_return_modal').hide();
    }
    $('#submit_modal').live('click', function () {
        var grn_no = $('#grn_no').val();
        var m = 0;
        if (grn_no == "") {
            $('.grn_error_msg').text('This field is required');
            m++;
        } else {
            $('.grn_error_msg').text('');
        }
        if (m > 0) {
            return false;
        } else {
            var base_url = "<?php echo $this->config->item('base_url'); ?>";
            var grn_id = $('#grn_id').val();
            window.location.href = base_url + "purchase_return/po_edit/" + grn_id;
        }
    });
</script>
