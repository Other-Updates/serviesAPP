<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .inv-detl #receipt_info tr td:nth-child(4){text-align:right;}
    .inv-detl thead tr th:nth-child(4){text-align:right;}
    #dd-w-1 .dd-c .dd-s, #dd-w-1 .dd-s-b-s, #dd-w-1 .dd-s-b-sub-y, #dd-w-1 .dd-sub-y {
        background: #448aff;
        color: #FFFFFF;
    }
    #dd-w-1 .dd-w-c {
        background: #FFFFFF;
        border: 1px solid #448aff;
        box-shadow: 0 0 10px 0 rgba(68, 138, 255, 0.43);
    }
    #dd-w-1 .dd-c:after {
        border-left: 1px solid #448aff;
        border-top: 1px solid #448aff;
    }
    #dd-w-1 .dd-n, #dd-w-1 .dd-sun {
        color: #448aff;
    }
    #dd-w-1 .dd-sun, #dd-w-1 .dd-s-b-ul li.dd-on {
        color: #448aff;
    }
</style>
<div class="card">
    <div class="card-header">
        <h5>Update Payment Receipt
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" >
            <table class="table  table-bordered responsive dataTable no-footer dtr-inline m-t-5"style="border: 1px solid #dee2e6;">
                <thead>
                <th colspan="8">Payment History</th>
                </thead>
                <thead>
                <th width="1%">S&nbsp;No</th>
                <th>Receipt&nbsp;NO</th>
                <th>Created Date</th>
                <th width="5%">Payment&nbsp;Terms</th>
                <th width="5%">Bank&nbsp;Details</th>
                <th>Received&nbsp;Amount</th>
                <th>Discount&nbsp;(&nbsp;%&nbsp;)</th>
                <th>Remarks</th>
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
                                <td><?= $i ?></td>
                                <th><?= $val['receipt_no'] ?></th>
                                <td><?= date('d-M-Y', strtotime($val['created_date'])) ?></td>
                                <td>
                                    <?php
                                    if ($val['terms'] == 1)
                                        echo "CASH";
                                    elseif ($val['terms'] == 2)
                                        echo "DD";
                                    elseif ($val['terms'] == 3)
                                        echo "CHEQUE";
                                    elseif ($val['terms'] == 4)
                                        echo "NEFT";
                                    elseif ($val['terms'] == 5)
                                        echo "RTGS";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($val['terms'] != 1 && $val['terms'] != 4 && $val['terms'] != 5) {
                                        echo "<b>A/C&nbsp;NO</b>    :<br>" . $val['ac_no'] . '<br>';
                                        echo "<b>Bank</b>    :<br>" . $val['branch'] . '<br>';
                                        echo "<b>DD&nbsp;/&nbsp;Cheque&nbsp;NO</b>:<br>" . $val['dd_no'] . '<br>';
                                    } else
                                        echo "-";
                                    ?>
                                </td>

                                <td><?= number_format($val['bill_amount'], 2, '.', ',') ?></td>
                                <td><?= number_format($val['discount'], 2, '.', ',') ?> ( <?= $val['discount_per'] ?> %)</td>
                                <td> <?= $val['remarks'] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    <tfoot>
                    <td></td><td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format($paid, 2, '.', ',') ?></td>
                    <td><?= number_format($dis, 2, '.', ',') ?></td>
                    <td></td>
                    </tfoot>
                    <?php
                } else
                    echo "<tr>
                        <td colspan='8' align='center' class='cent-align' style='text-align:center;'>No Data Found</td>
                    </tr>";
                ?>
                </tbody>
            </table>
            <form method="post">
                <input type="hidden" name="receipt_bill[receipt_id]" value="<?= $receipt_details[0]['id'] ?>">
                <table class="table  table-bordered responsive dataTable no-footer dtr-inline inv-detl">
                    <thead>
                    <th colspan="4">Invoice Details</th>
                    </thead>
                    <thead>
                    <th>S No</th>
                    <th>PO NO</th>
                    <th>GRN NO</th>
                    <th>Invoice Date</th>
                    <th align="right">Amount</th>
                    </thead>
                    <tbody id='receipt_info'>
                        <tr>
                            <td>1</td>
                            <td><?= $receipt_details[0]['po_no'] ?></td>
                            <td style="white-space: unset;width: 30%;"><?php
                                foreach ($receipt_details[0]['grn_no'] as $value) {
                                    $grn_no = $value["grn_no"];
                                    echo $grn_no;
                                }
                                ?></td>
                            <td align="center"><?= date('d-M-Y', strtotime($receipt_details[0]['created_date'])) ?></td>
                            <td align="right"><?= number_format($over_all_net_total, 2, '.', ',') ?></td>
                        </tr>
                    <input type="hidden" value="<?= $receipt_details[0]['po_no'] ?>" name="po_no">
                    <input type="hidden" value="<?= ($over_all_net_total - $dis) - $paid ?>" id="inv_amount"  />

                    <tr><td colspan="4" style="text-align:right;">Invoice Amount</td><td class="right-align"><?= number_format($over_all_net_total, 2, '.', ',') ?></td></tr>
                    <tr><td colspan="4" style="text-align:right;">Total Discount</td><td class="right-align"><?= number_format($dis, 2, '.', ',') ?></td></tr>
                    <tr><td colspan="4" style="text-align:right;">Total Received Amount</td><td class="right-align"><?= number_format($paid, 2, '.', ',') ?></td></tr>
                    <tr>
                        <td colspan="4" style="text-align:right;">Receipt NO</td><td><input name="receipt_bill[receipt_no]" class="form-control flt-right" style="width: 50%" type="text" tabindex="1" ></td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="4" style="text-align:right;">Amount Receiver</td>
                        <td>
                            <input type="radio" class="receiver flt-right" value="company" checked name="receipt_bill[recevier]" tabindex="1">Company
                            <input type="radio" class="receiver flt-right" value="agent" name="receipt_bill[recevier]" tabindex="1">Field Agent
                            <select class="select_agent" style="display: none;" name="receipt_bill[recevier_id]" tabindex="1">
                                <option value="">Select Agent</option>
                                <?php
                                if (isset($all_agent) && !empty($all_agent)) {
                                    foreach ($all_agent as $agent) {
                                        ?>
                                        <option value="<?php echo $agent['id'] ?>"><?php echo $agent['name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;">Created Date <span class="req">*</span></td>
                        <td>

                            <input id='dropper-default' style=' width:50%;'  class="form-control flt-right" name='receipt_bill[created_date]' value="<?php echo date('d-m-Y'); ?>"  tabindex="1" data-date="" data-month="" data-year="" type="text" placeholder="Select Created Date"/>
                            <span id="date_err" style="color:#F00;float:right;margin-right: 1px; width:50%; text-align:left;" ></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;">Due Date </td>
                        <td>

                            <input id='dropper-default1'  style=' width:50% ;'  class="form-control flt-right" name='receipt_bill[due_date]'  tabindex="1" data-date="" data-month="" data-year="" type="text" placeholder="Select Due Date"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='4' style='text-align: right;'>Payment Types</td><td  style='align: right;'>
                            <select class='form-control flt-right' id='terms' style="width:50%;" name='receipt_bill[terms]' tabindex="1">
                                <option value='1'>CASH</option>
                                <option value='2'>DD</option>
                                <option value='3'>CHEQUE</option>
                                <option value='4'>ONLINE TRANSFER</option>
                                <!--<option value='5'>RTGS</option>-->
                            </select>
                        </td>
                    </tr>

                    <tr class='show_tr' style='display:none'>
                        <td colspan='3' style='text-align: right;'>A / C NO</td>
                        <td  style='align: right;'>
                            <input id='ac_no'  class='form-control flt-right'  style=' width:50% ;' type='text'  name='receipt_bill[ac_no]' tabindex="1"/>
                            <span id="receiptuperror" style="color:#F00;float: right;margin-left: 5px;width:50%; text-align:left;" ></span>
                        </td>
                    </tr>
                    <tr class='show_tr' style='display:none'>
                        <td colspan='4' style='text-align: right;'>Bank</td>
                        <td  style='align: right;'>
                            <input id='branch'  class='form-control flt-right'  style=' width:50% ;' type='text'  name='receipt_bill[branch]' tabindex="1" />
                            <span id="receiptuperror1" style="color:#F00;float: right;margin-left: 5px;width:50%; text-align:left;" ></span>
                        </td>
                    </tr>
                    <tr  class='show_tr' style='display:none'>
                        <td colspan='4' style='text-align: right;'>DD / Cheque NO</td>
                        <td  style='align: right;'>
                            <input id='dd_no'  class='form-control dduplication flt-right' style=' width:50% ;' type='text'  name='receipt_bill[dd_no]' tabindex="1"/>
                            <span id="receiptuperror2" style="color:#F00;float:right ;margin-left: 5px; width:50%; text-align:left;" ></span><span id="dupperror" style="color:#F00;" ></span></td>
                    </tr>
                    <tr  class='show_ref_no' style='display:none'>
                        <td colspan='4' style='text-align: right;'>Reference NO <span class="req">*</span></td>
                        <td  style='align: right;'>
                            <input id='ref_no'  class='form-control flt-right' style=' width:50% ;' type='text'  name='receipt_bill[reference_number]' tabindex="1"/>
                            <span id="receiptref_err" style="color:#F00;float:right ;margin-left: 5px; width:50%; text-align:left;" ></span></td>
                    </tr>

                    <tr>
                        <td colspan="4" style="text-align:right;">Paid Amount <span class="req">*</span></td>
                        <td>
                            <input id='paid'  class='form-control dot_val flt-right right-align' type='text'  style=' width:50% ;'  name='receipt_bill[bill_amount]'  tabindex="1"/>
                            <span id="receiptuperror3" style="color:#F00;float:right;margin-right: 1px; width:50%; text-align:left; " ></span> </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;"><span style='  position: relative; top: 5px;' class="m-r-5">Discount</span>
                            <input id='discount_per' autocomplete='off'  class='form-control right-align' style=' width:150px;float:right;' type='text'  name='receipt_bill[discount_per]' tabindex="1"/>
                        </td>
                        <td>
                            <input id='discount'  class='form-control dot_val flt-right right-align' style=' width:50% ;' type='text'  name='receipt_bill[discount]' tabindex="1"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;">Balance</td>
                        <td>
                            <input id='balance'  class='form-control flt-right right-align' type='text'  style=' width:50% ;'  name='balance'   value='<?php echo number_format(($over_all_net_total - $dis) - $paid, 2); ?>'  readonly='readonly' />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;">Remarks</td>
                        <td>
                            <input type='text'  style=' width:50% ;'  class="form-control flt-right" name='receipt_bill[remarks]'  tabindex="1"/>
                        </td>
                    </tr>
                    <tr><td class=" text-center" style="text-align: center !important;" colspan="5"> <input  type="submit" class="btn btn-success btn-sm " value="Pay" id="pay" tabindex="1"/> </td></tr>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
    });
    $("#dropper-default1").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
    });
    $('#terms').live('change', function () {
        if ($(this).val() == 2 || $(this).val() == 3)
            $('.show_tr').show();
        else
            $('.show_tr').hide();
        if ($(this).val() == 4) {
            $('.show_ref_no').show();
        } else {
            $('.show_ref_no').hide();
        }
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
    });</script>
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
        var bal = $('#balance').val();
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");
        } else if (bal < 0)
        {
            $("#receiptuperror3").html("This Field Less then the Balance Amount");
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
    $("#ref_no").live('blur', function ()
    {
        var ref_no = $("#ref_no").val();
        if (ref_no == "" || ref_no == null || ref_no.trim().length == 0)
        {
            $("#receiptref_err").html("Required Field");
        } else
        {
            $("#receiptref_err").html("");
        }
    });
    $('#pay').live('click', function ()
    {
        i = 0;
        var paid = $('#paid').val();
        var bal = $('#balance').val();
        var date = $('#dropper-default').val();
        if (date == "")
        {
            $("#date_err").html("Required Field");
            i = 1;
        } else
        {
            $("#date_err").html("");
        }
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");
            i = 1;
        } else if (bal < 0)
        {
            $("#receiptuperror3").html("This Field Less then the Balance Amount");
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
    $(document).ready(function () {
        var d = new Date();
        var year = d.getFullYear();
        var month = d.getMonth();
        var day = d.getDate();
        var created_date = new Date(year, month, day);
        var created_date_res = formatDate(created_date);
        $("#dropper-default").val(created_date_res);
        var duedate = new Date(year, month, day + 7);
        var toDate = duedate.toISOString().slice(0, 10);
        var result = formatDate(toDate);
        $("#dropper-default1").val(result);
    });
    $('#dropper-default').change(function () {

        var d = new Date($("#dropper-default").val());
        var year = d.getFullYear();
        var month = d.getMonth();
        var day = d.getDate();
        var created_date = new Date(year, month, day);
        var created_date_res = formatDate(created_date);
        $("#dropper-default").val(created_date_res);
        var duedate = new Date(year, month, day + 7);
        var toDate = duedate.toISOString().slice(0, 10);
        var result = formatDate(toDate);
        $("#dropper-default1").val(result);
    });
    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [day, month, year].join('-');
    }
</script>