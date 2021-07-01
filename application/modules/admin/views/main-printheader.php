<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
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
        <?= $data['company_details'][0]['email'] ?>

    </div>

</div>

<div class="print-line"></div>
