<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>

<div class="card">
    <div class="card-header">
        <h5>View stock
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                <td class="action-btn-align" colspan="2">Vendor Purchase Details</td>
                </thead>
                <?php
                if (isset($stock[0]['stock_details']) && !empty($stock[0]['stock_details'])) {
                    foreach ($stock[0]['stock_details'] as $val) {
                        ?>
<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                        <tr>
                            <td width="50%" class="text-left"><span  class="f-w-700">PO NO: </span><?= $val['po_no'] ?></td>
                            <td width="50%" class="text-left"><span  class="f-w-700">Vendor Name: </span><?php echo $val['name']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="text-left"><span  class="f-w-700">Vendor Mobile No: </span><?php echo $val['mobil_number']; ?></td>
                            <td width="50%" class="text-left"><span  class="f-w-700">Vendor Email ID: </span><?= $val['email_id'] ?></td>
                        </tr>
                        <tr>
                            <td width="50%" class="text-left" style="white-space: unset"><span  class="f-w-700" style="word-wrap:break-word">Vendor Address: </span><?= $val['address1'] ?></td>
                            <td width="50%" class="text-left"><span  class="f-w-700">Quantity: </span><?= $val['quantity'] ?></td>
                        </tr>
						</table>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="2">Data not found...</td></tr>';
                }
                ?>
            </table>
            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <a href="<?php echo $this->config->item('base_url') . 'stock/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"><span class="glyphicon"></span> Back </a>
                </div>
            </div>
        </div>
    </div>
</div>

