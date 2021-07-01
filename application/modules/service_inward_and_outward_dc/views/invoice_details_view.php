<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .ui-helper-hidden-accessible {
        display: none;
    }
    .text-center{margin:0 auto;}
</style>
<?php if ($from == 1) { ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block" style="width:40%;margin:0 auto;">

                    <form method="post" >
                    <?php } ?>

                    <input id="gst_check_status_value" type="hidden"  name="check_gst"  value="<?php echo $quotation[0]['is_gst'] ?>">
                    <input type="hidden" name="quotation[q_id]" value="  <?php echo $quotation[0]['q_id']; ?>  "  />
                    <input type="hidden" name="quotation[inv_id]" value="  <?php echo $quotation[0]['id']; ?>  "  />
                    <input type="hidden" value="<?= $quotation[0]['inv_id'] ?>"  name="inv_no">
                    <input type="hidden" value="<?= $service_type ?>"  name="type">
                    <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor newtbl-bordr">
                        <tr>
                            <td class="text-left"><span  class="f-w-700">TO,</span>
                                <div><b><?php echo $quotation[0]['store_name']; ?></b></div>
                                <div><?php echo $quotation[0]['address1']; ?> </div>
                                <div> <?php echo $quotation[0]['mobil_number']; ?></div>
                                <div> <?php echo $quotation[0]['email_id']; ?></div>
                            </td>
                            <td COLSPAN=2  class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="125px"></td>
                        </tr>
                        <tr>
                            <td  id="contact_text" class="text-left"><span  class="f-w-700">Inward DC No : </span><?php echo $quotation[0]['nick_name']; ?></td>
                            <td class="text-left"><span  class="f-w-700">Date : </span><?= ($quotation[0]['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($quotation[0]['created_date'])) : ''; ?></td>
                        </tr><tr>
                            <td class="text-left"><span  class="f-w-700">Invoice NO : </span><?php echo $quotation[0]['inv_id']; ?></td>
                            <td  id="contact_text" class="text-left"><span  class="f-w-700">Project : </span><?php echo $quotation[0]['project_name']; ?></td>
                        </tr>

                    </table>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                        <thead>
                            <tr>
                                <td width="10%" class="first_td1">Category</td>
                                <td width="10%" class="first_td1">Warranty</td>
                                <td width="10%" class="first_td1">Brand</td>
                                <td width="10%" class="first_td1">Model Number</td>
                                <td  width="8%" class="first_td1">QTY</td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden"  name="product_type[]" id="type"  value="<?php echo $vals['type'] ?>"/>
                                            <input  name="product_description[]" id="product_description" type="hidden" value="<?php echo $vals['product_description']; ?>" class='form-control product_description'  />
                                            <input type="hidden" class='cat_id static_style form-control' name='categoty[]' readonly="" value='<?php echo $vals['cat_id'] ?>'>
                                            <input type="text" class="form-control" readonly="" value='<?php echo $vals['categoryName'] ?>'>
                                        </td>
                                        <td>
                                            <?php
                                            if ($vals['is_warranty'] == 1) {
                                                $warranty = 'Warranty Item' . ' ' . date('d-M-Y', strtotime($vals['created_date'])) . ' - ' . date('d-M-Y', strtotime('+1 year', strtotime($vals['created_date'])));
                                            } else {
                                                $warranty = 'Non-Warranty Item';
                                            }
                                            ?>
                                            <input type="text" class="form-control" readonly="" value='<?php echo $warranty ?>'>
                                        </td>
                                        <td>
                                            <input type="hidden"  name='brand[]' readonly="" value='<?php echo $vals['id'] ?>'>
                                            <input type="text"  class=" form-control" readonly="" value='<?php echo $vals['brands'] ?>'>
                                        </td>
                                        <td>
                                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' value="<?php echo $vals['model_no']; ?>" readonly="readonly"/>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />

                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>


                                        <td align="center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="label label-primary">Inv.Qty</label>
                                                    <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control m-t-5 po_qty cent-align" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="label label-info">DC.Qty</label>
                                                    <input type="text"   tabindex="1"  name='dc_quantity[]'  class="m-t-5 dc_qty int_val form-control cent-align" onkeypress="return isNumber(event, this)" />
                                                </div>
                                                <span class="error_msg" style="padding-left:22px;"></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="form-group row m-10 text-center">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="btn btn-sm btn-primary waves-effect waves-light" id='add_inward_outward' value="Create"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function isNumber(evt, this_ele) {
                this_val = $(this_ele).val();
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (evt.which == 13) {//Enter key pressed
                    $(".thVal").blur();
                    return false;
                }
                if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {
                    return false;
                } else {
                    return true;
                }

            }
            $('#add_inward_outward').on('click', function () {
                m = 0;
                $('.dc_qty').each(function () {
                    var qty = $(this).closest('tr').find('.qty').val();
                    this_val = $.trim($(this).val());
                    if (this_val != "") {
                        if (Number(this_val) > Number(qty))
                        {
                            $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                            m = 1;
                        } else {
                            $(this).closest('td').find('.error_msg').text("");
                        }
                    }
                });
                if (m > 0)
                    return false;

            });
            $(".dc_qty").on('keyup', function () {
                var dc_qty = $(this).val();
                var qty = $(this).closest('tr').find('.qty').val();
                if (Number(dc_qty) > Number(qty))
                {
                    $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                } else {
                    $(this).closest('td').find('.error_msg').text("");
                }
            });
        </script>

        <?php if ($from == 1) { ?>
        </div>
    </div>
    <?php
}?>