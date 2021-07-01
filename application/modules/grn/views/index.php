<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<?php
$po_no_json = array();
if (!empty($po_number)) {
    foreach ($po_number as $list) {
        $po_no_json[] = '{ value: "' . $list['po_no'] . '", id: "' . $list['id'] . '"}';
    }
}
?>
<style>

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Goods Receive Note</h5>
            </div>
            <form method="post">
                <div class="card-block">
                    <div class="col-md-4">

                        <table  class="table table-striped table-bordered pono-view">
                            <thead>
                                <tr>
                                    <td class="action-btn-align">PO NO</td>
                                    <td><input type="text"  id="po_no" autocomplete="off" class="form-control po_no_dup"/>
                                        <input type="hidden" id="purchase_order_id">
                                    </td>
                                    <td><input type="button" class="btn btn-mini btn-success " id='view_po' value='View'/>

                                    </td>


                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="pono-v">
                            <span id="poerror" style="color:#F00;"></span>
                            <span id="duplica" style="color:#F00;"></span>
                        </div>
                    </div>
                    <div>
                        <br />
                        <div  id='grn_html'>

                        </div>
                    </div>

                </div>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {

                $('#po_no').on('keydown', function () {
                    $('body').on('keydown', 'input#po_no', function (e) {
                        var c_data = [<?php echo implode(',', $po_no_json); ?>];
                        $("#po_no").autocomplete({
                            source: function (request, response) {
                                // filter array to only entries you want to display limited to 10
                                var outputArray = new Array();
                                for (var i = 0; i < c_data.length; i++) {
                                    if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                                        outputArray.push(c_data[i]);
                                    }
                                }
                                response(outputArray.slice(0, 10));
                            },
                            minLength: 0,
                            autoFill: false,
                            select: function (event, ui) {
                                po_id = ui.item.id;
                                $.ajax({
                                    type: 'POST',
                                    data: {po_id: po_id},
                                    url: "<?php echo $this->config->item('base_url'); ?>" + "grn/get_po_list/",
                                    success: function (data) {
                                        result = JSON.parse(data);
                                        if (result != null && result.length > 0) {
                                            $("#po_no").val(result[0].po_no);
                                            $("#purchase_order_id").val(result[0].id);
                                        }
                                    }
                                });
                            }
                        });
                    });
                });
            });
            $(".po_no_dup").live('blur', function ()
            {
                po_no = $(".po_no_dup").val();
                $.ajax(
                        {
                            url: BASE_URL + "grn/po_duplication",
                            type: 'post',
                            data: {value1: po_no},
                            success: function (result)
                            {

                                $("#duplica").html(result);
                            }
                        });
            });
            $('#view_po').live('click', function () {
                var i = 0;
                var po = $("#po_no").val();
                if (po == '')
                {
                    $("#poerror").html("Enter PO NO");
                    i = 1;

                } else
                {
                    $("#poerror").html("");
                }

                po_no = $(".po_no_dup").val();
                $.ajax(
                        {
                            url: BASE_URL + "grn/po_duplication",
                            type: 'post',
                            data: {value1: po_no},
                            success: function (result)
                            {
                                if ((result.trim()).length > 0) {
                                    i = 1;
                                }
                                if (i == 1)
                                {
                                    return false;
                                } else
                                {
                                    //            for_loading();
                                    $.ajax({
                                        url: BASE_URL + "grn/view_po",
                                        type: 'GET',
                                        data: {
                                            po: $('#po_no').val()
                                        },
                                        success: function (result) {
                                            //                    for_response();
                                            $('#grn_html').html(result);
                                        }
                                    });
                                }
                            }
                        });

                if (i == 1)
                {
                    return false;
                } else
                {
                    return true;
                }
            });

            $('.cum_qty').live('keyup', function () {

                var round_val = Number($(this).parent().parent().find('.avail_qty').val());
                //alert(round_val);
                var five_val = Number($(this).parent().parent().find('.avail_qty').val());
                //alert(five_val);
                //alert($(this).val());
                if (Number(five_val) < Number($(this).val()))
                {

                    $(this).css('border-color', 'red');

                } else
                {
                    //alert('enter1');
                    /*if(Number($(this).parent().parent().find('.avail_qty').val())==0 && Number($(this).parent().parent().find('.avail_qty').val())!=Number($(this).val()))
                     $(this).css('border-color','red');
                     else*/
                    $(this).css('border-color', '');
                }

            });
            $('#add_gen').live('click', function () {
                var i = 0;
                var j = 0;
                $(".deliver_qty").each(function () {
                    var current_qty = $(this).attr('data-current_qty');
                    this_val = $.trim($(this).val());
                    if (Number(this_val) == '') {
                        // $(this).closest('td').find('span.error_msg').text("Enter Atleast One D.Qty");
                    } else if (Number(this_val) > Number(current_qty))
                    {
                        $(this).closest('td').find('span.error_msg').text('Invalid Delivery Quantity').css('display', 'inline-block');
                        i = 1;
                    } else {
                        if (Number(this_val) > 0) {
                            j++;
                        }
                        $(this).closest('td').find('span.error_msg').text("");

                    }
                });
                if (j == 0) {
                    $('.total_qty').closest('td').find('span.error_msg').text("Enter Atleast One D.Qty");
                    return false;
                } else {
                    $('.total_qty').closest('td').find('span.error_msg').text("");
                }
                if (i == 1)
                {
                    return false;
                } else
                {
                    return true;
                }
            });

        </script>