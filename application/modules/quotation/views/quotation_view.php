<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .ml-14{margin-left:14px;}
    .ml-11{margin-left:11px;}
    .tabth{width:110px;}
    .terms-bottom-tbl{border: 1px solid #dee2e6;}
    .terms-bottom-tbl tr{border: 1px solid #dee2e6;}
    @media print {
        html, body {
            border: 1px solid white;
            height: 99%;
            page-break-after: avoid;
            page-break-before: avoid;
        }
    }
</style>
<div class="card">
    <?php
    $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
    $data['company_details'] = $this->admin_model->get_company_details();
    ?>
    <div class="print_header print-align ml-95" style="display:none">
        <div class="print_header_logo " >
            <img class="img-fluid" src="<?= $theme_path; ?>/assets/images/printlogo.png" alt="Theme-Logo" style="width:200px;"/>
        </div>
        <div class="print_header_tit">
            <h3 style="color:#448aff"> <?= $data['company_details'][0]['company_name'] ?></h3>
            <?= $data['company_details'][0]['address1'] ?>,
            <?= $data['company_details'][0]['address2'] ?>,
            <?= $data['company_details'][0]['city'] ?>,
            <?= $data['company_details'][0]['state'] ?>
            <?= $data['company_details'][0]['pin'] ?>-<br/>

            <strong>Ph</strong>:
            <?= $data['company_details'][0]['phone_no'] ?>, <strong>Email</strong>:
            <?= $data['company_details'][0]['email'] ?><br/>
            <?php if ($quotation[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Quotation
        </h5>
        <a href="<?php echo $this->config->item('base_url') . 'quotation/history_view/' . $quotation[0]['id'] ?>" class="btn btn-primary btn-sm waves-effect waves-light f-right d-inline-block md-trigger ">Quotation History</a>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($quotation) && !empty($quotation)) {
                foreach ($quotation as $val) {
                    ?>
                    <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor" style="border: 1px solid #dee2e6;">
                        <tr>
                            </td>
                            <?php if ($val['is_gst'] == 1) { ?>
                                <td width="59%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                    <div><b><?php echo $val['store_name']; ?></b></div>
                                    <div><?php echo $val['address1']; ?> </div>
                                    <div> <?php echo $val['mobil_number']; ?></div>
                                    <div> <?php echo $val['email_id']; ?></div>
                                    <?php if ($val['is_gst'] == 1) { ?>
                                        <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td width="100%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                    <div><b><?php echo $val['store_name']; ?></b></div>
                                    <div><?php echo $val['address1']; ?> </div>
                                    <div> <?php echo $val['mobil_number']; ?></div>
                                    <div> <?php echo $val['email_id']; ?></div>
                                    <?php if ($val['is_gst'] == 1) { ?>
                                        <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                    <?php } ?>
                                </td>
                            <?php } ?>


                            <td  class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="250px"></td>
                        </tr>
                        <tr>
                            <td class="text-left"><span  class="f-w-700">Quotation NO <span class="ml-11">: </span></span><?php echo $val['q_no']; ?></td>
                            <td class="text-left"><span  class="f-w-700">Date <span class="ml-14">:</span> </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>

                        </tr>
                        <tr>
                            <td id="contact_text" class="text-left"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                            <td class="text-left"><span  class="f-w-700">Project : </span><?= $val['project_name'] ?></td>
                            <td id="contact_text1" style="display: none;"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                            <!--<td></td><td></td>-->
                        </tr>
         <!--                    <tr>
                         <td colspan="3"><span  class="tdhead">Advance Amount&nbsp;&nbsp; :&nbsp;&nbsp;</span><?= ($val['advance'] > 0) ? (number_format($val['advance'], 2)) : '-'; ?></td>
                     </tr>-->
                    </table>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation" style="border: 1px solid #dee2e6;">
                        <thead>
                            <tr><td width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class=" first_td1 hide_class">Category</td>
                                <td width="10%" class=" first_td1 hide_class">Brand</td>
                                <td width="10%" class=" first_td1 hide_class">Model No</td>
                                <td width="20%" class="first_td1 pro-wid">Product Description</td>
                                <td width="10%" class="first_td1 action-btn-align proimg-wid">Product Image</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td align="center" width="5%" class="first_td1">HSN Code</td>
                                <?php } else { ?>
                                    <td width="5%" class="first_td1  hide_class">Add Amt</td>
                                <?php } ?>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="5%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="2%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="6%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <td  width="8%" class="first_td1 action-btn-align qty-wid">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            $cgst = 0;
                            $sgst = 0;
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {

                                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                        } else {
                                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                        }
                                    }
                                    $cgst += $cgst1;
                                    $sgst += $sgst1;
                                    ?>

                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['brands'] ?>
                                        </td>
                                        <td class="hide_class" align="center">
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <td class="remove_nowrap">
                                            <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                            <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php
                                            if (!empty($vals['product_image'])) {
                                                $file = FCPATH . 'attachement/product/' . $vals['product_image'];
                                                $exists = file_exists($file);
                                            }
                                            $cust_image = (!empty($exists) && isset($exists)) ? $vals['product_image'] : "no-img.gif";
                                            ?>
                                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image img-50" src="<?php echo $this->config->item("base_url") ?>attachement/product/<?php echo $cust_image; ?>"/>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="" align="center">
                                                <?php echo $vals['hsn_sac']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td class="hide_class text-right">
                                                <?php echo $vals['add_amount']; ?>
                                            </td>
                                        <?php } ?>

                                        <td class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2) ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['tax'] ?>
                                            </td>
                                            <?php
                                            $gst_type = $quotation[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td class="action-btn-align">
                                                        <?php echo $vals['gst']; ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="action-btn-align">
                                                        <?php echo $vals['igst']; ?>
                                                    </td>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <td class="text-right">
                                            <?php echo number_format($vals['sub_total'], 2, '.', ',') ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <tfoot>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="3" class="hide_class"></td>
                                    <td colspan="3" class="totbold" style=" text-align:right;">Total</td>
                                    <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                                    <td colspan="3" class="totbold" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2, '.', ','); ?></td>

                                </tr>
                                <tr class="hide_class">
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class"></td>
                                    <td colspan="6" class="totbold" style="text-align:right !important;">Advance Amount</td>
                                    <td class="text-right"><?php echo (!empty($val['advance'])) ? number_format($val['advance'], 2, '.', ',') : 0.00; ?></td>
                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="3" class="hide_class"></td>
                                    <td colspan="4" class="totbold" style="text-align:right !important;">CGST:</td>
                                    <td colspan="2" class="text-right"><?php echo number_format($cgst, 2, '.', ','); ?></td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td class="totbold" style="text-align:right;">SGST:</td>
                                        <?php } else { ?>
                                            <td  class="totbold" style="text-align:right;">IGST:</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td class="text-right"><?php echo number_format($sgst, 2, '.', ','); ?></td>
                                </tr>
                                <tr>
                                    <td class=""></td>

                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="7" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2, '.', ','); ?></td>

                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="6">  <?php echo ucfirst($in_words); ?></td>
                                    <td style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right net_bg"><?php echo number_format($val['net_total'], 2, '.', ','); ?></td>

                                </tr>
                            </tfoot>
                        <?php } else { ?>
                            <tfoot>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="2" class="totbold" style=" text-align:right;">Total</td>
                                    <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2, '.', ','); ?></td>

                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="4" class="totbold" style="text-align:right !important;">Advance Amount</td>
                                    <td class="text-right"><?php echo (!empty($val['advance'])) ? number_format($val['advance'], 2, '.', ',') : 0.00; ?></td>
                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2, '.', ','); ?></td>

                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td align="left" colspan="3"> <span class="flt-left"><?php echo ucfirst($in_words); ?></span></td>
                                    <td style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right net_bg"><?php echo number_format($val['net_total'], 2, '.', ','); ?></td>

                                </tr>
                            </tfoot>
                        <?php } ?>
                    </table>
                    <table class="table table-striped tablecolor m-t-5 terms-bottom-tbl ">
                        <tr>
                            <th class="tabth" colspan="2">TERMS AND CONDITIONS</th>
                        </tr>
                        <tr>
                            <th class="tabth">Warranty </th><th><span class="">:</span><span class="termcolor"><?php echo $val['warranty']; ?></span></th>
                        </tr>
                        <tr>
                            <th class="tabth">Payment Terms </th><th><span class="">:</span><span class="termcolor"><?php echo $val['mode_of_payment']; ?></span></th>
                        </tr>
                        <tr>
                            <th class="tabth remark-tbl-bottom">Remarks </th><th style="vertical-align:top;"><span class="">:</span><span class="termcolor"><?php echo $val['remarks']; ?></span></th>
                        <tr>
                            <th class="tabth">Validity </th><th><span class="">:</span><span class="termcolor"><?php echo $val['validity']; ?></span></th>
                        </tr>
                    </table>

                    <div class="hide_class text-center m-t-5">
                        <?php if ($val['estatus'] == 2) { ?>

                            <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"><span class="glyphicon"></span> Back </a>
                            <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                            <input type="button" class="btn btn-success btn-sm waves-effect waves-light f-right m-r-10" id='send_mail' value="Send Email"/>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-success btn-sm waves-effect waves-light complete" id="complete_btn" > Complete </button>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <!--<a href="<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>" class="btn btn-info btn-sm waves-effect waves-light complete"> Complete </a>-->

                            <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
                            <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                            <input type="button" class="btn btn-success btn-sm waves-effect waves-light f-right m-r-10" id='send_mail'  value="Send Email"/>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
if (isset($quotation) && !empty($quotation)) {
    foreach ($quotation as $val) {
        ?>
        <form method="post" id="form_id" name="form" action = '<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>'>
            <?php
            if (isset($quotation_details) && !empty($quotation_details)) {
                foreach ($quotation_details as $vals) {
                    ?>
                    <input type="hidden"  name="categoty[]"  value='<?php echo $vals['cat_id'] ?>'>
                    <input type="hidden"  name="brand[]"  value='<?php echo $vals['brand'] ?>'>
                    <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                    <input type="hidden"  name="product_description[]"  value='<?php echo $vals['product_description'] ?>'>
                    <input type="hidden"  name="type[]"  value='<?php echo $vals['type'] ?>'>
                    <input type="hidden"  name="quantity[]"  value='<?php echo $vals['quantity'] ?>'>
                    <input type="hidden"  name="per_cost[]"  value='<?php echo $vals['per_cost'] ?>'>
                    <input type="hidden"  name="project_cost_per_cost[]"  value='<?php echo $vals['project_cost_per_cost'] ?>'>
                    <input type="hidden"  name="add_amount[]"  value='<?php echo $vals['add_amount'] ?>'>
                    <input type="hidden"  name="tax[]"  value='<?php echo $vals['tax'] ?>'>
                    <input type="hidden"  name="gst[]"  value='<?php echo $vals['gst'] ?>'>
                    <input type="hidden"  name="igst[]"  value='<?php echo $vals['igst'] ?>'>
                    <input type="hidden"  name="sub_total[]"  value='<?php echo $vals['sub_total'] ?>'>
                    <input type="hidden"  name="project_cost_sub_total[]"  value='<?php echo $vals['project_cost_sub_total'] ?>'>
                    <?php
                }
            }
            ?>
            <input type="hidden"  name="quotation[remarks]"  value="<?php echo ($val['remarks']) ?>">
            <input type="hidden"  name="quotation[q_no]"  value="<?php echo ($val['q_no']) ?>">
            <input type="hidden"  name="quotation[tax]"  value="<?php echo ($val['tax']) ?>">
            <input type="hidden"  name="quotation[tax_label]"  value="<?php echo ($val['tax_label']) ?>">
            <input type="hidden"  name="quotation[advance]"  value="<?php echo $val['advance'] ?>">
            <input type="hidden" name='quo_old_amount' class="old_adv_amt" value="<?php echo $val['advance']; ?>"/>
            <input type="hidden"  name="quotation[subtotal_qty]"  value="<?php echo $val['subtotal_qty']; ?>">
            <input type="hidden"  name="quotation[project_cost_subtotal_qty]"  value="<?php echo $val['project_cost_subtotal_qty']; ?>">
            <input type="hidden"  name="quotation[total_qty]"  value="<?php echo $val['total_qty']; ?>">
            <input type="hidden"  name="quotation[net_total]"  value="<?php echo $val['net_total']; ?>">
            <input type="hidden"  name="quotation[project_cost_net_total]"  value="<?php echo $val['project_cost_net_total']; ?>">
            <input type="hidden"  name="check_gst"  value="<?php echo ($val['is_gst'] == 1) ? 'on' : ''; ?>">
            <input type="hidden"  name="quotation[job_id]" value="<?php echo $val['job_id']; ?> " >
            <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['customer']; ?>"/>
            <input name="quotation[created_date]" type="hidden" value="<?php echo date('d-m-Y', strtotime($val['created_date'])); ?>"/>
        </form>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {
        $('#send_mail').click(function () {
            var s_html = $('.size_html');
//            for_loading();
            $.ajax({
                url: BASE_URL + "quotation/send_email",
                type: 'GET',
                data: {
                    id:<?= $quotation[0]['id'] ?>
                },
                success: function (result) {
//                    for_response();
                }
            });
        });
    });
    $("#complete_btn").click(function () {
        $("#form_id").submit();
    });
    $('.print_btn').click(function () {
        window.print();
        //return false;
    });
</script>
<?php //exit;    ?>
