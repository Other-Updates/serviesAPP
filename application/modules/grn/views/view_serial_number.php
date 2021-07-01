<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .ui-helper-hidden-accessible {
        display: none;
    }
    .serial_error_msg {
        font-size: 13px;
        color: #ff5252 !important;
    }
	table tr td:nth-child(4){text-align:left;}
	table tr td{text-align:left;}
	table tr td:first-child, table tr td:last-child {
    text-align: left;
}
</style>
<div class="col-md-12 table-responsive">
<table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
    <?php
    if (isset($gen_details) && !empty($gen_details)) {
        foreach ($gen_details as $vals) {
            ?>
            <tr>
                <td class="first_td1">GRN NO</td>
                <td><b><?= $vals['gen'][0]['grn_no'] ?></b></td>
            <input type="hidden" value="<?php echo $last_no ?>" name="grn_no">
            <td class="first_td1">PO NO</td>
            <td align="left">
                <?= $vals['gen'][0]['po_no'] ?>
            </td>

        </tr>
        <tr>
            <td class="first_td1">Product Details</td>
            <td >
                Product:<b><?php echo $vals['product_name'] ?></b>
                <br>
                Model No: <b><?= $vals['model_no'] ?></b>  <br>
                Category: <b><?= $vals['categoryName'] ?></b>  <br>
                Brand: <b><?= $vals['brands'] ?></b>
            </td>
            <td class="first_td1">Vendor Details</td>
            <td id='customer_td'>
                Name: <b><?= $vals['gen'][0]['name'] ?></b>  <br>
                Company: <b><?= $vals['gen'][0]['store_name'] ?></b>  <br>
                Address: <b><?= $vals['gen'][0]['address1'] ?> </b> <br>
                Email: <b><?= $vals['gen'][0]['email_id'] ?> </b> <br>
                Mobile: <b> <?= $vals['gen'][0]['mobil_number'] ?></b>
            </td>
        </tr>

        <?php
    }
}
?>

</table>
</div>
