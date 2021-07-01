<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <?php
        $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
        $data['company_details'] = $this->admin_model->get_company_details();
        ?>

        <div class="print_header print-align ml-95" style="display:none">
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
                <?php if ($his_quo[0]['is_gst'] == 1) { ?>
                    <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
                <?php } ?>

            </div>
        </div><br/>
        <!--<div class="print-line"></div>-->


        <div class="col-lg-12">
            <div class="tab-header card ">
                <div class="card-header">

                    <h5>View Quotation History
                    </h5>
                </div>
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <?php
                    if (isset($his_quo) && !empty($his_quo)) {
                        $i = 1;
                        foreach ($his_quo as $val) {
                            ?>
                            <li class="nav-item col-md-2">
                                <a class="nav-link <?php echo ($i == 1) ? 'active' : '' ?>" data-toggle="tab" href="#fa-icons<?php echo $val['id'] ?>" role="tab"><?php echo date('Y-m-d H:i:s', strtotime($val['history_details'][0]['created_date'])); ?></a>
                                <div class="slide"></div>
                            </li>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-content">
                <?php
                if (isset($his_quo) && empty($his_quo)) {
                    ?>
                    <div class="card">
                        <div class="card-block">
                            <div class="text-center"> No History data found...</div>
                            <div class="hide_class text-center">
                                <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>

                            </div>
                        </div>
                    </div>
                <?php }
                ?>
                <?php
                if (isset($his_quo) && !empty($his_quo)) {
                    $j = 1;
                    foreach ($his_quo as $val) {
                        ?>
                        <div class="tab-pane <?php echo ($j == 1) ? 'active' : ''; ?>" id="fa-icons<?php echo $val['id'] ?>" role="tabpanel">
                            <div class="card">
                                <div class="card-block">
                                    <?php
                                    $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation_history_by_id($val['id']);
                                    $datas["in_words"] = $this->Gen_model->convert_number($datas["quotation"][0]['net_total']);
                                    $datas["quotation_details"] = $quotation_details = $this->Gen_model->get_all_quotation_history_details_by_id($val['id']);
                                    $datas["category"] = $category = $this->master_category_model->get_all_category();
                                    $datas["brand"] = $brand = $this->master_brand_model->get_brand();
                                    $datas['company_details'] = $this->admin_model->get_company_details();
                                    $this->load->view('view_only', $datas);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $j++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>