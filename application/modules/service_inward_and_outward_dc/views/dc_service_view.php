<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {

    }
    
    #complaint_details {
        height: 70px;
        text-align: top;
        vertical-align: top;
        white-space: unset;
    }
</style>

<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>View Service Inward Outward DC
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($quotation) && !empty($quotation)) {
                foreach ($quotation as $val) {
                    ?>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor" style="border:1px solid #dee2e6;">
                        <tr>
                            <td class="text-left"><span  class="f-w-700">TO,</span><br/>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                            </td>
                            <td class="action-btn-align" colspan="2"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="260px"></td>
                        </tr>
                        <tr>
                            <?php if ($val['service_type'] == 'inward') { ?>
                                <td id="inward_dc_no" class="text-left"><span  class="f-w-700">Inward DC No : </span><?php echo $val['dc_no']; ?></td>
                            <?php } else { ?>
                                <td id="outward_dc_no" class="text-left"><span  class="f-w-700">Outward DC No : </span><?php echo $val['dc_no']; ?></td>
                            <?php } ?>
                            <td class="text-left"><span  class="f-w-700"> Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                        </tr>
                        <tr>
                            <td id="inv_no" class="text-left"><span  class="f-w-700">Invoice No : </span><?php echo $val['invoice_no']; ?></td>
                            <td class="text-left"><span  class="f-w-700"> Project : </span><?= $val['project']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2" id="complaint_details" class="text-left"><span  class="f-w-700">Complaint Details : </span><?php echo $val['complaint_details']; ?></td>
                        </tr>

                    </table>

                    <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation" style="border:1px solid #dee2e6;">
                        <thead>
                            <tr>
                                <td  width="1%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="8%" class="first_td1">Model No</td>
                                <td width="8%" class="first_td1">Serial No</td>
                                <td width="18%" class="first_td1 pro-wid">Product Description</td>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>
                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td >
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <td >
                                            <?php echo $vals['serial_no'] ?>
                                        </td>
                                        <td class="remove_nowrap">
                                            <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                            <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['dc_quantity'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td class=""></td>
                                <td colspan="2" class="totbold" style=" text-align:right;">Total</td>
                                <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>

                            </tr>
                        </tfoot>
                    </table>
                    <table style="width:100%;" class="table table-striped tablecolor m-t-5 terms-bottom-tbl table-bordered">
                        <tr>
                            <th class="tabth" colspan="4">TERMS AND CONDITIONS</th>
                        </tr>
                        <tr>
                            <th class="tabth remark-tbl-bottom">Remarks:<span class="termcolor"> <?php echo $val['remarks']; ?></span></th>
						</tr>
						<tr>
                            <th class="tabth">Delivery:<span class="termcolor"><?php echo $val['delivery']; ?></span>
                            </th>
						</tr>
						<tr>
                            <th class="tabth">Warranty:<span class="termcolor"><?php echo $val['warranty']; ?></span>
                            </th>
                        </tr>

                    </table>
                    <div class="hide_class text-center m-t-5">
                        <a href="<?php echo $this->config->item('base_url') . 'service_inward_and_outward_dc' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
                        <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>

