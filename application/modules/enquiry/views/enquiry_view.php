<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
.leadview td:first-child, table tr td:last-child {
    text-align: left;
}
td, th {
    white-space: unset;
}

</style>
<div class="card">
<?php 
	$this->load->view("admin/main-printheader");

?>
    <div class="card-header">
        <h5>View Leads
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($all_enquiry) && !empty($all_enquiry)) {
                foreach ($all_enquiry as $val) {
                    ?>
                    <table class="table table-striped table-bordered leadview">
                        <tr>
                            <td><span  class="f-w-700">TO,</span>
                                <div><?php echo $val['customer_address']; ?> </div>
                            </td>
                            <td class="action-btn-align"> <img class="leadimg" src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" style="width:125px;"></td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">Leads Number:</span><?php echo $val['enquiry_no']; ?> </td>
                            <td><span  class="f-w-700">Customer Name:</span><?php echo $val['customer'][0]['name']; ?> </td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">Leads About:</span> <?php echo $val['enquiry_about']; ?> </td>
                            <td><span  class="f-w-700">Customer Email:</span><?php echo $val['customer'][0]['email_id']; ?></td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">Contact Number:</span><?php echo $val['customer'][0]['mobil_number']; ?></td>
                            <td><span  class="f-w-700">Remarks:</span> <?php echo $val['remarks']; ?></td>

                        </tr>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>
            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button type="button" class="btn btn-round btn-primary print_btn btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                    <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>

