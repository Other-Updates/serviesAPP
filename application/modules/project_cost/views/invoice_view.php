<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {
        color: #448aff !important;
    }
    .termcolor {
        color: #222d33 !important;
    }
    .m-ll-10{margin-left:-10px;}

    .bo-l{border:0px !important;}
    .extra-tbl input{float:left;}
    td.bo-l input {
        color: #505a64;
        font-weight: 500;
    }
    .ml-38{margin-left:38px;}
    .ml-27{margin-left:27px;}
    .ml-19{margin-left:19px;}
    .ml-30{margin-left:30px;}
    @media print{
        .extra-tbl input{border:0px;}
        .bo-l{border:0px !important;}
        .extra-tbl tr td{border:0px !important; border-right:1px solid #ccc !important;}
        .bb-l{border-bottom:1px solid #ccc !important;}
    }
</style>
<div class="card">
    <?php
    $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
    $data['company_details'] = $this->admin_model->get_company_details();
    ?>
    <!--    <div class="print_header print-align ml-95" style="display:none">
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
    <?php if ($quotation[0]['is_gst'] == 1) { ?>
                                                            <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
    <?php } ?>

            </div>

        </div>-->

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Invoice
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($quotation) && !empty($quotation)) {
                foreach ($quotation as $val) {
                    ?>
                    <table  class="table table-bordered responsive dataTable no-footer dtr-inline tablecolor newtbl-bordr extra-tbl">
                        <tr class="bb-l">
                            <td width="44.6%" class="text-left">
                                <h4 style="color: #53b7df;"><?= $data['company_details'][0]['company_name'] ?></h4>
                                <?= $data['company_details'][0]['address1'] ?>,
                                <?= $data['company_details'][0]['address2'] ?>,<br/>
                                <?= $data['company_details'][0]['city'] ?>,
                                <?= $data['company_details'][0]['state'] ?>
                                <?= $data['company_details'][0]['pin'] ?>-<br/>

                                <strong>Ph</strong>:
                                <?= $data['company_details'][0]['phone_no'] ?>, <strong>Email</strong>:
                                <?= $data['company_details'][0]['email'] ?><br/>
                                <?php if ($quotation[0]['is_gst'] == 1) { ?>
                                    <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
                                <?php } ?>
                            </td>
                            <td width="" COLSPAN=2  class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="240px"></td>
                        </tr>
                        <tr>
                            <td width="" class="text-left" rowspan="6" style="vertical-align: top;"><span  class="f-w-700">Billing Address</span><br/>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                <?php } ?>
                            </td>
                            <td  class="text-left"><span  class="f-w-700">Shipping Address</span>
                                <!--<div><b><input type="text" value="<?php echo $val['store_name']; ?>"></b></div>
                                <div><input type="text" value="<?php echo $val['address1']; ?> "></div>
                                <div> <input type="text" value="<?php echo $val['mobil_number']; ?>"></div>
                                <div> <input type="text" value="<?php echo $val['email_id']; ?> "></div>
                                <?php if ($val['is_gst'] == 1) { ?>
                                                                                                <div> <b>GTSIN NO:</b> <input type="text" value="<?php echo $val['tin']; ?>"></div>
                                <?php } ?>-->
                            </td>
                            <td  class="text-left">
                                <div><span  class="f-w-700">Invoice NO : </span><?php echo $val['inv_id']; ?></div>
                                <!--<div><span  class="f-w-700">Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></div></br>
                                <div><span  class="f-w-700">PO NO : </span><input type="text" value=""></div></br>
                                <div><span  class="f-w-700">PO Date : </span><input type="text" value=""></div></br>
                                <div><span  class="f-w-700">Terms : </span><input type="text" value=""></div>-->
                            </td>
                        </tr>
                                                <!--<tr>
                                                <td><span  class="f-w-700">Shipping Address</span></td>
                                                <td><div><span  class="f-w-700">Invoice NO : </span><?php echo $val['inv_id']; ?></div></td>
                                                </tr>-->
                        <tr>
                            <td class="bo-l"><input type="text" value="<?php echo $val['store_name']; ?>"></td>
                            <td align="left" class="bo-l" style=";"><span  class="f-w-700">Date <span class="ml-38">:</span> </span><span style="float:left;"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></span></td>
                        </tr>
                        <tr>
                            <td class="bo-l"><input type="text" value="<?php echo $val['address1']; ?> "></td>
                            <td class="bo-l"><span  class="f-w-700">PO NO <span class="ml-27">:</span> </span><input type="text" value="" style="margin-left:0px;"></td>
                        </tr>
                        <tr>
                            <td class="bo-l"> <input type="text" value="<?php echo $val['mobil_number']; ?>"></td>
                            <td class="bo-l"><span  class="f-w-700">PO Date <span class="ml-19">:</span> </span><input type="text" value="" style="margin-left:0px;" class=""></td>
                        </tr>
                        <tr>
                            <td class="bo-l"> <input type="text" value="<?php echo $val['email_id']; ?> "></td>
                            <td class="bo-l"><span  class="f-w-700">Terms <span class="ml-30">:</span> </span><input type="text" value="" style="margin-left:0px;"></td>
                        </tr>
                        <tr>
                            <td class="bo-l"><?php if ($val['is_gst'] == 1) { ?>
                                    <div> <input type="text" value="GTSIN NO: <?php echo $val['tin']; ?>" class="m-ll-62"></div>
                                <?php } ?></td>
                            <td class="bo-l"></td>
                        </tr>

                    </table>

                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5 newtbl-bordr" id="add_quotation">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="12%" class="first_td1 hide_class">Category</td>
                                <td width="12%" class="first_td1 hide_class">Brand</td>
                                <td width="12%" class="first_td1 hide_class">Model No</td>
                                <td width="35%" class="first_td1 pro-wid">Product Description</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="10%" class="first_td1 ">HSN Code</td>
                                <?php } else { ?>
                                    <td width="10%" class="first_td1 hide_class">Add Amt</td>
                                <?php } ?>
                                <td  width="3%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="6%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="3%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
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
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="" align="center">
                                                <?php echo $vals['hsn_sac'] ?>
                                            </td>
                                        <?php } else { ?>
                                            <td class="hide_class text-right">
                                                <?php echo $vals['add_amount'] ?>
                                            </td>
                                        <?php } ?>
                                        <td class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
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
                                            <?php echo number_format($vals['sub_total'], 2) ?>
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
                                    <td></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td  colspan="2" style=" text-align:right;">Total</td>
                                    <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                    <td colspan="3" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="4" class="totbold" style="text-align:right !important;">CGST:</td>
                                    <td class="text-right"><?php echo number_format($cgst, 2, '.', ','); ?></td>
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
                                    <td></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="6"  style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2); ?>

                                </tr>
                                <?php
                                foreach ($val['other_cost'] as $key) {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="hide_class" style="text-align:right;"></td>
                                        <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo $key['item_name']; ?> </td>
                                        <td class="text-right">
                                            <?php echo number_format($key['amount'], 2); ?></td>

                                    </tr>
                                <?php }
                                ?>
                                <tr>

                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td align="left" colspan="6"> <span class="flt-left"><?php echo ucfirst($in_words); ?></span></td>
                                    <td style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right"><?php echo number_format($val['net_total'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td class="remark-tbl-bottom"><span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> </td>
                                    <td colspan="10" style="text-align:left; vertical-align:top;">
                                        <?php echo $val['remarks']; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        <?php } else { ?>

                            <tfoot>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="1" class="totbold" style=" text-align:right;">Total</td>
                                    <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="3"  style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2); ?>

                                </tr>
                                <?php
                                foreach ($val['other_cost'] as $key) {
                                    ?>
                                    <tr>
                                        <td class=""></td>
                                        <td colspan="4" class="hide_class" style="text-align:right;"></td>
                                        <td colspan="3" style="text-align:right;font-weight:bold;"><?php echo $key['item_name']; ?> </td>
                                        <td class="text-right">
                                            <?php echo number_format($key['amount'], 2); ?></td>

                                    </tr>
                                <?php }
                                ?>
                                <tr>

                                    <td colspan="4" class="hide_class" style="text-align:right;"></td>
                                    <td align="left" colspan="3"> <span class="flt-left"><?php echo ucfirst($in_words); ?></span></td>
                                    <td style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right"><?php echo number_format($val['net_total'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td class="remark-tbl-bottom"><span style="float:left;  top:12px;" class="f-w-700">Remarks&nbsp;&nbsp;&nbsp;</span> </td>
                                    <td colspan="5" style="text-align:left; vertical-align:top;">
                                        <?php echo $val['remarks']; ?>
                                    </td>
                                    <td colspan="3" class="hide_class"></td>
                                </tr>

                            </tfoot>

                        <?php } ?>
                        <table class="table extra-tbl table-bordered">
                            <tr>  <td colspan="2" class=""></td>
                                <td colspan="3" class="hide_class"></td>
                                <td  colspan="2"  class="text-left">
                                    <span style="float:left;  top:12px;" class="f-w-700">Bank Details&nbsp;&nbsp;&nbsp;</span></td>
                                <td  colspan="2"  class="text-right">For INCREDIBLE SOLUTIONS</td>
                            </tr>
                            <tr>	<td colspan="2" class=""></td>
                                <td colspan="3" class="hide_class"></td>
                                <td  colspan="2"  class="text-left">
                                    <span  class="f-w-700">Bank Name:&nbsp; </span><?php echo $data['company_details'][0]['bank_name']; ?></td>
                                <td colspan="2" class=""></td>
                            </tr>
                            <tr>   	<td colspan="2" class=""></td>
                                <td colspan="3" class="hide_class"></td>
                                <td  colspan="2"  class="text-left">
                                    <span  class="f-w-700">Account Number :&nbsp; </span><?= $data['company_details'][0]['ac_no']; ?></td>
                                <td colspan="2" class=""></td>
                            </tr>
                            <tr>
                                <td colspan="2" class=""></td>
                                <td colspan="3" class="hide_class"></td>
                                <td  colspan="2"  class="text-left">
                                    <span  class="f-w-700">Branch: &nbsp;</span><?php echo $data['company_details'][0]['branch']; ?></td>
                                <td colspan="2" class=""></td>
                            </tr>
                            <tr>

                                <td colspan="2" class="text-left"><span  class="f-w-500">Company's PAN : &nbsp;</span> <?= $data['company_details'][0]['pan_id']; ?></td>
                                <td colspan="3" class="hide_class"></td>
                                <td  colspan="2"  class="text-left">
                                    <span  class="f-w-700">IFSC Code : &nbsp;</span> <?= $data['company_details'][0]['ifsc']; ?>
                                </td>
                                <td colspan="2" class="text-right">Authorized Signatory</td>
                            </tr>
                        </table>

                    </table>
                    <div class="row text-center m-10">
                        <div class="col-sm-12 invoice-btn-group hide_class text-center">
                            <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                            <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"><span class="glyphicon"></span> Back </a>

                            <input type="button" class="btn btn-success btn-sm waves-effect waves-light f-right m-r-10" id='send_mail' value="Send Email"/>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#send_mail').click(function () {
            var s_html = $('.size_html');
//            for_loading();
            $.ajax({
                url: BASE_URL + "project_cost/send_email",
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
    $('.print_btn').click(function () {
        window.print();
    });
</script>

