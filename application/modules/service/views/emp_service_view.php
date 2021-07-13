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
    @media print{
        .gallery-page{display:none !important;}
    }
    .work_performed {
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
        <h5>View Service
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive1" id='result_div'>
            <?php
            if (isset($service) && !empty($service)) {
                foreach ($service as $val) {
                    ?>
                    <table class="table table-striped table-bordered leadview">
                        <tr>
                            <td><span  class="f-w-700">Ticket No:</span>
                                <div><?php echo $val['ticket_no']; ?></div>
                                <div><span  class="f-w-700">Customer Name:</span><?php echo $val['customer'][0]['name']; ?> </div>
                            </td>
                            <td class="action-btn-align"> <img class="leadimg" src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" style="width:125px;"></td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">Invoice Number:</span><?php echo $val['inv_no']; ?> </td>
                            <td><span  class="f-w-700">Status:</span>
                                <?php
                                if ($val['status'] == 1) {
                                    echo 'completed';
                                } else if ($val['status'] == 2) {
                                    echo 'Pending';
                                } else {
                                    echo 'In-Progress';
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">Warranty:</span> <?php echo $val['warrenty']; ?> </td>
                            <td><span  class="f-w-700">Customer Email:</span><?php echo $val['customer'][0]['email_id']; ?></td>
                        </tr>
                        <tr>
                            <td><span  class="f-w-700">About Issues:</span><?php echo $val['description']; ?></td>
                            <td><span  class="f-w-700">Service Date:</span> <?= date('m/d/Y', strtotime($val['created_date'])); ?></td>

                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2" ><span  class="f-w-700 work_performed">Work Performed:</span><?php echo $val['work_performed']; ?></td>

                        </tr>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>


            <!-- Page body start -->
            <div class="page-body gallery-page">
                <div class="row">
                    <!-- image grid -->
                    <div class="col-sm-12">

                        <div class="card">
                            <div class="card-header">
                                <h5>Product Service Image - Employee</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <?php
                                    //print_r($service_images);
                                    if (!empty($service_images_employee)) {
                                        foreach ($service_images_employee as $service_images_val) {
                                            ?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <a href="#" data-lightbox="1" data-title="My caption 1">
                                                            <img src="<?php echo $service_images_val['img_path']; ?>" alt="" class="img-fluid img-thumbnail">
                                                        </a>
                                                    </div>
                                                    <span title="Work Performed"><b>Work Performed</b> : <?php echo ($val['work_performed'] != '' ? $val['work_performed'] : '- ');?></span></br>
                                                    <span title="Description"><b>Description</b> : <?php echo ($val['description'] != '' ? $val['description'] : '-');?></span>

                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } 
                                    if (!empty($service_history)) {
                                        foreach ($service_history as $history) {
                                            ?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <a href="#" data-lightbox="1">
                                                            <img src="<?php echo ($history['emp_image_upload'] != '' ?$history['emp_image_upload'] : $theme_path.'/assets/images/favicon.png'); ?>" alt="" class="img-fluid img-thumbnail">
                                                        </a>
                                                    </div>
                                                    <span title="Work Performed"><b>Work Performed</b> : <?php echo ($history['work_performed'] != '' ? $history['work_performed'] : '- ');?></span></br>
                                                    <span title="Description"><b>Description</b> : <?php echo ($history['description'] != '' ? $history['description'] : '-');?></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } 
                                    if(empty($service_images_employee) && empty($service_history)) {
                                        ?>
                                        <div class="col-lg-12 col-sm-6">
                                            No data found
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>Product Service Image - Customer</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <?php
                                    //print_r($service_images);
                                    if (!empty($service_images_customer)) {
                                        foreach ($service_images_customer as $service_images_val) {
                                            ?>

                                            <div class="col-lg-2 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <a href="#" data-lightbox="1" data-title="My caption 1">
                                                            <img src="<?php echo $service_images_val['img_path']; ?>" alt="" class="img-fluid img-thumbnail">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-lg-12 col-sm-6">
                                            No data found
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center m-10">
                <div class="col-sm-12 invoice-btn-group text-center">
                    <button type="button" class="btn btn-round btn-primary print_btn btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                    <a href="<?php echo $this->config->item('base_url') . 'service/to_do_service/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
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

