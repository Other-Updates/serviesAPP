<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<table border=0 cellpadding=0 cellspacing=0 style="table-layout:fixed; width: 100%" align="center">
    <tr>
        <td valign="top" align="left" width="20%" >
            <img src="<?= $theme_path; ?>/images/printlogo.png" width="50px" height="50px">
        </td>
        <td valign="top" width="60%">
            <font size="15px"><b><?= $company_details[0]['company_name'] ?></b></font><br />
            <font size="10px">
            <?= $company_details[0]['city'] ?>,
            <?= $company_details[0]['state'] ?> -
            <?= $company_details[0]['pin'] ?><br>
            PH:<?= $company_details[0]['phone_no'] ?><br>
            Email:<?= $company_details[0]['email'] ?>
            </font>
        </td>
        <td valign="top" align="right" width="20%">
            <font size="10px"><?php echo date('m/d/Y ') ?> <br>
            </font>
        </td>
    </tr>
</table>

