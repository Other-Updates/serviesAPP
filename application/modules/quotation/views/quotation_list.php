<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(6){text-align:center;}
    table tr td:nth-child(7){text-align:right;}
    table tr td:nth-child(8){text-align:center;}
    table tr td:nth-child(9){text-align:center;}
    @media print{
        table tr td:last-child{display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Quotation List</h5>
        <a href="<?php echo $this->config->item('base_url') . 'quotation/' ?>" class="btn btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger "><i class="fa fa-plus m-r-5"></i> Add Quotation</a>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped table-bordered " id="quotation_table">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td class="action-btn-align">Quotation No</td>
                        <td class="action-btn-align">Project Name</td>
                        <!--<td class="action-btn-align">Reference Name</td>-->
                        <td class="action-btn-align">Referred By</td>
                        <td class="action-btn-align">Company Name</td>
                        <td class="action-btn-align">Quantity</td>
                        <td class="action-btn-align">Total Amount</td>
                        <td class="action-btn-align">Created Date</td>
                        <td class="action-btn-align">Status</td>
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
    </div>
</div>
<?php
if (isset($quotation) && !empty($quotation)) {
    foreach ($quotation as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active Quotation</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This Quotation?<strong><?= $val['q_no']; ?></strong>
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
<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        $('#adv_data').hide();
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
    function delete_quotation(val) {
        $('#test3_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $('#quotation_table').DataTable({
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
                url: BASE_URL + "quotation/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
        $(".delete_yes").on("click", function ()
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
