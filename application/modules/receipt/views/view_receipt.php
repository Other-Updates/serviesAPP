<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="card">
    <?php
    $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
    $data['company_details'] = $this->admin_model->get_company_details();
    ?>
    <div class="print_header print-align ml-95" style="display:none">
        <div class="print_header_logo " >
            <img class="img-fluid" src="<?= $theme_path; ?>/assets/images/printlogo.png" alt="Theme-Logo" style="width:200px;"/>
        </div>
        <div class="print_header_tit" >
            <h3><?= $data['company_details'][0]['company_name'] ?></h3>
            <?= $data['company_details'][0]['address1'] ?>,
            <?= $data['company_details'][0]['address2'] ?>,
            <?= $data['company_details'][0]['city'] ?>,
            <?= $data['company_details'][0]['state'] ?>
            <?= $data['company_details'][0]['pin'] ?>-<br/>

            <strong>Ph</strong>:
            <?= $data['company_details'][0]['phone_no'] ?>, <strong>Email</strong>:
            <?= $data['company_details'][0]['email'] ?><br/>
            <?php if ($po[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Payment Receipt
        </h5>
    </div>
    <?php
    $adv = $receipt_details[0]['advance'];
    if (isset($receipt_details[0]['receipt_history']) && !empty($receipt_details[0]['receipt_history'])) {
        $i = 1;
        $dis = 0;
        $paid = 0;
        foreach ($receipt_details[0]['receipt_history'] as $val) {
            $paid = $paid + $val['bill_amount'];
            $dis = $dis + $val['discount'];
        }
    }
    ?>
    <div class="card-block table-border-style">
        <!--<form method="post">-->
        <input type="hidden" name="receipt_bill[receipt_id]" value="<?= $receipt_details[0]['id'] ?>">
        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            <thead>
            <td class="action-btn-align" colspan="4">Supplier Invoice Details</td>
            </thead>
            <tr>
                <td class="text-left"><span  class="f-w-700">Invoice NO:</span><?= $receipt_details[0]['inv_id'] ?></td>
                <td class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="260px"></td>
            </tr>
            <tr>
                <td class="text-left"><span  class="f-w-700">Date:</span><?= date('d-M-Y', strtotime($receipt_details[0]['created_date'])) ?></td>
                <td class="text-left"><span  class="f-w-700">Total Discount:</span><?= number_format($dis, 2, '.', ',') ?></td>
            </tr>
            <tr>
                <td class="text-left"><span  class="f-w-700">Total Amount:</span><?= number_format($over_all_net_total, 2, '.', ',') ?></td>
                <td class="text-left"><span  class="f-w-700">Total Received Amount:</span><?= number_format(($paid), 2, '.', ',') ?></td>
            </tr>
            <tr>
                <td class="text-left"><span  class="f-w-700 hide_class">Advance Amount:<?= number_format($adv, 2, '.', ',') ?></span></td>
                <td class="text-left"><span  class="f-w-700">Balance:</span><?php echo number_format($over_all_net_total - ($dis + $adv + $paid), 2, '.', ','); ?></td>

            </tr>
            <tr>
                <?php if ($po[0]['is_gst'] == 1) { ?>
                    <td class="text-left"><span  class="f-w-700">GSTIN No:</span><?php echo $receipt_details[0]['tin']; ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <td></td>
            </tr>
        </table>
        <!--</form>-->
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5">
                <thead>
                <td colspan="9">Payment History</td>

                </thead>
                <thead>
                <td width="1%" class="action-btn-align">S&nbsp;No</td>
                <td>Receipt&nbsp;NO</td>
                <td>Receiver</td>
                <td>Received Date</td>
                <td width="5%">Payment&nbsp;Terms</td>
                <td width="5%">Bank&nbsp;Details</td>
                <td class="action-btn-align">Received&nbsp;Amount</td>
                <td class="action-btn-align">Discount&nbsp;(&nbsp;%&nbsp;)</td>
                <td class="action-btn-align">Remarks&nbsp;(&nbsp;%&nbsp;)</td>

                </thead>
                <tbody id='receipt_info'>
                    <?php
                    if (isset($receipt_details[0]['receipt_history']) && !empty($receipt_details[0]['receipt_history'])) {
                        $i = 1;
                        $dis = 0;
                        $paid = 0;
                        foreach ($receipt_details[0]['receipt_history'] as $val) {
                            $paid = $paid + $val['bill_amount'];
                            $dis = $dis + $val['discount'];
                            ?>
                            <tr>
                                <td class="action-btn-align"t><?= $i ?></td>
                                <th><?= $val['receipt_no'] ?></th>
                                <th><?= $val['recevier'] ?></th>
                                <td><?= date('d-M-Y', strtotime($val['created_date'])) ?></td>
                                <td>
                                    <?php
                                    if ($val['terms'] == 1)
                                        echo "CASH";
                                    elseif ($val['terms'] == 2)
                                        echo "DD";
                                    elseif ($val['terms'] == 3)
                                        echo "Cheque";
                                    elseif ($val['terms'] == 4)
                                        echo "ONLINE TRANSFER";
//                                    elseif ($val['terms'] == 5)
//                                        echo "RTGS";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($val['terms'] != 1 && $val['terms'] != 4 && $val['terms'] != 5) {
                                        echo "<b>A/C&nbsp;NO</b>    :<br>" . $val['ac_no'] . '<br>';
                                        echo "<b>Bank</b>    :<br>" . $val['branch'] . '<br>';
                                        echo "<b>DD&nbsp;/&nbsp;Cheque&nbsp;NO</b>:<br>" . $val['dd_no'] . '<br>';
                                    } else if ($val['terms'] == 4) {
                                        echo "<b>REFERENCE&nbsp;NO</b>    :<br>" . $val['reference_number'];
                                    } else
                                        echo "-";
                                    ?>
                                </td>

                                <td class="text_right"><?= number_format($val['bill_amount'], 2, '.', ',') ?></td>
                                <td class="text_right"><?= number_format($val['discount'], 2, '.', ',') ?> ( <?= $val['discount_per'] ?> %)</td>
                                <td><?= $val['remarks'] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    <tfoot>
                    <td></td><td></td><td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text_right"><?= number_format($paid, 2, '.', ',') ?></td>
                    <td class="text_right"><?= number_format($dis, 2, '.', ',') ?></td>
                    <td></td>
                    </tfoot>
                    <?php
                } else
                    echo "<tr>
                            	<td colspan='9'>No Data Found</td>
                            </tr>";
                ?>
                </tbody>
            </table>
            <div class="hide_class text-center m-t-10">
                <a href="<?php echo $this->config->item('base_url') ?>receipt/receipt_list"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#terms').live('change', function () {
        if ($(this).val() == 2 || $(this).val() == 3)
            $('.show_tr').show();
        else
            $('.show_tr').hide();
    });
    $('.receiver').live('click', function () {
        if ($(this).val() == 'agent')
            $('.select_agent').css('display', 'block');
        else
            $('.select_agent').css('display', 'none');
    });
    // Date Picker
    $('#add_package').live('click', function () {
        $('.sty_class').each(function () {

            var s_html = $(this).closest('tr').find('.size_val');
            var size_name = $(this).closest('tr').find('.size_name');
            var cort_class = $(this).closest('tr').find('.cort_class').val();
            var sty_class = $(this).closest('tr').find('.sty_class').val();
            var col_class = $(this).closest('tr').find('.col_class').val();

            $(s_html).each(function () {
                $(this).attr('name', 'size[' + sty_class + col_class + cort_class + '][]');
            });
            $(size_name).each(function () {
                $(this).attr('name', 'size_name[' + sty_class + col_class + cort_class + '][]');
            });
        });
    });

    $(document).ready(function () {

        jQuery('#from_date1').datepicker();
    });
    $('#cor_no').live('keyup', function () {
        var select_op = '';
        if (Number($(this).val()))
        {
            select_op = select_op + '<select class="cort_class"  name="corton[]"><option>Select</option>';
            for (i = 1; i <= Number($(this).val()); i++)
            {
                select_op = select_op + '<option value=' + i + '>' + i + '</option>';
            }
            select_op = select_op + '</select>';
            $('.cor_class').html(select_op);
        }
    });
    $('#customer').live('change', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "receipt/get_all_pending_invoice",
            type: 'GET',
            data: {
                c_id: $(this).val()
            },
            success: function (result) {
                $('#s_div').html(result);
            }
        });
        $.ajax({
            url: BASE_URL + "receipt/get_invoice_view",
            type: 'GET',
            data: {
                c_id: $(this).val()
            },
            success: function (result) {
                for_response();
                $('#receipt_info').html(result);
            }
        });

    });
    $('.so_id').live('click', function () {
        var s_arr = [];
        var i = 0;
        $('.so_id').each(function () {
            if ($(this).attr('checked') == 'checked')
            {
                s_arr[i] = $(this).val();
                i++;
            }
        });
        for_loading();
        $.ajax({
            url: BASE_URL + "receipt/get_inv",
            type: 'GET',
            data: {
                inv_id: s_arr,
                c_id: $('#customer').val()
            },
            success: function (result) {
                for_response();
                $('#receipt_info').html(result);
            }
        });
    });
    $('#discount').live('keyup', function () {
        total = 0;
        total = (Number($('#inv_amount').val()) - Number($(this).val())) - Number($('#paid').val());
        $('#balance').val(total.toFixed(2));

        var tt = ($(this).val() / $('#inv_amount').val()) * 100;
        $('#discount_per').val(tt.toFixed(2));
    });
    $('#paid').live('keyup', function () {
        total = 0;
        total = (Number($('#inv_amount').val()) - Number($('#discount').val())) - Number($(this).val());
        $('#balance').val(total.toFixed(2));
    });
    $('#discount_per').live('keyup', function () {
        var tt = $('#inv_amount').val() * ($(this).val() / 100);
        $('#discount').val(tt.toFixed(2));

        total = 0;
        total = (Number($('#inv_amount').val()) - Number($('#discount').val())) - Number($('#paid').val());
        $('#balance').val(total.toFixed(2));
    });
</script>
<script type="text/javascript">

    $(".dduplication").live('blur', function ()
    {
        //alert("hi");
        var checkno = $(".dduplication").val();
        if (checkno == "")
        {
        } else
        {
            $.ajax(
                    {
                        url: BASE_URL + "receipt/update_checking_payment_checkno",
                        type: 'POST',
                        data: {value1: checkno},
                        success: function (result)
                        {
                            $("#dupperror").html(result);

                        }
                    });
        }
    });
    $("#paid").live('blur', function ()
    {
        var paid = $('#paid').val();
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");

        } else
        {
            $("#receiptuperror3").html("");
        }
    });
    $("#ac_no").live('blur', function ()
    {
        var ac_no = $("#ac_no").val();
        if (ac_no == "" || ac_no == null || ac_no.trim().length == 0)
        {
            $("#receiptuperror").html("Required Field");
        } else
        {
            $("#receiptuperror").html("");
        }
    });
    $("#branch").live('blur', function ()
    {
        var branch = $("#branch").val();
        if (branch == "" || branch == null || branch.trim().length == 0)
        {
            $("#receiptuperror1").html("Required Field");
        } else
        {
            $("#receiptuperror1").html("");
        }
    });
    $("#dd_no").live('blur', function ()
    {
        var dd_no = $("#dd_no").val();
        if (dd_no == "" || dd_no == null || dd_no.trim().length == 0)
        {
            $("#receiptuperror2").html("Required Field");
        } else
        {
            $("#receiptuperror2").html("");
        }
    });
    $('#pay').live('click', function ()
    {
        i = 0;
        var paid = $('#paid').val();
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");
            i = 1;

        } else
        {
            $("#receiptuperror3").html("");
        }
        var terms = $("#terms").val();
        if (terms == 1 || terms == 4 || terms == 5)
        {
        } else
        {
            var ac_no = $("#ac_no").val();
            if (ac_no == "" || ac_no == null || ac_no.trim().length == 0)
            {
                $("#receiptuperror").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror").html("");
            }
            var branch = $("#branch").val();
            if (branch == "" || branch == null || branch.trim().length == 0)
            {
                $("#receiptuperror1").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror1").html("");
            }
            var dd_no = $("#dd_no").val();
            if (dd_no == "" || dd_no == null || dd_no.trim().length == 0)
            {
                $("#receiptuperror2").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror2").html("");
            }
            var m = $('#dupperror').html();
            if ((m.trim()).length > 0)
            {
                i = 1;
            }
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
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>