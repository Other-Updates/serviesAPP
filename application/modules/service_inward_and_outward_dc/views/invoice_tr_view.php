
<?php
if (isset($quotation_details) && !empty($quotation_details)) {
    foreach ($quotation_details as $vals) {
        ?>
        <tr>
            <td>
                <input type="text"  tabindex="4" name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' value="<?php echo $vals['model_no']; ?>" readonly="readonly"/>
                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                <input type="hidden"  name="product_type[]" id="type"  value="<?php echo $vals['type'] ?>" class=' tabwid form-control type' />
                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
            </td>
            <td>
                <input type="text"  tabindex="-1" name="serial_no[]" id='serial_no' value="" class='form-control'>
                <span class="error_msg text-danger"></span>
            </td>
            <td>
                <textarea  name="product_description[]"  tabindex="-1" id="product_description" type="hidden" class='form-control product_description'> <?php echo $vals['product_description']; ?> </textarea>
            </td>
            <td align="center">
                <div class="row">
                    <div class="col-md-6">
                        <label class="label label-primary">Inv.Qty</label>
                        <input type="text"   tabindex="-1"  name='quantity[]' class="qty max_qty form-control m-t-5 po_qty cent-align" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />
                    </div>
                    <div class="col-md-6">
                        <label class="label label-info">DC.Qty</label>
                        <input type="text"   tabindex="5"  name='dc_quantity[]'  class="m-t-5 dc_qty int_val required form-control cent-align" onkeypress="return isNumber(event, this)" />
                    </div>
                    <span class="error_msg" style="padding-left:22px;"></span>
                </div>
            </td>
            <td class="action-btn-align">

            </td>
        </tr>

        <?php
    }
}
?>