<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
table tr td:nth-child(1){text-align:left;}
table tr td:nth-child(3){text-align:center;}
table tr td:nth-child(4){text-align:center;}
table tr td:nth-child(5){text-align:center;}
table tr td:nth-child(6){text-align:center;}

</style>
<div class="card">
    <div class="card-header">
        <h5>User Role Permissions (<?php echo $user_role[0]['user_role']; ?>)
        </h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                <li><i class="fa fa-window-maximize full-card"></i></li>
                <li><i class="fa fa-minus minimize-card"></i></li>
                <li><i class="fa fa-refresh reload-card"></i></li>
                <li><i class="fa fa-trash close-card"></i></li>
            </ul>
        </div>
    </div>
    <?php echo form_open_multipart('masters/user_roles/user_permissions/' . $user_role_id, 'name="user_permission" id="user_permission" class="form-horizontal"'); ?>
    <input type="hidden" name="user_role_id" id="user_role_id" value="<?php echo $user_role_id; ?>">
    <div class="form-group">
        <div class="col-sm-12 ">
            <div class="border-checkbox-section" style="float:right;">
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input class="border-checkbox grand_all" type="checkbox"  name="grand_all" id="checkbox1"  value="1" <?php echo (isset($user_role[0]['grand_all']) && $user_role[0]['grand_all'] == 1) ? 'checked' : ''; ?>>
                    <label class="border-checkbox-label" for="checkbox1">Grand All</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Section</th>
                        <th>Enable Menu</th>
                        <th>View</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($user_sections)) {
                        foreach ($user_sections as $key => $value) {
                            if (!empty($value['sections'])) {
                                $k = 1;
                                foreach ($value['sections'] as $section) {
                                    if (($section['user_section_key'] == 'user_modules') || ($section['user_section_key'] == 'user_sections') || (!in_array($section['user_section_key'], array('user_modules', 'user_sections')))) {
                                        $checked_all = (isset($user_permissions[$key][$section['id']]['acc_all']) && $user_permissions[$key][$section['id']]['acc_all'] == 1) ? 'checked' : '';
                                        $checked_view = (isset($user_permissions[$key][$section['id']]['acc_view']) && $user_permissions[$key][$section['id']]['acc_view'] == 1) ? 'checked' : '';
                                        $checked_add = (isset($user_permissions[$key][$section['id']]['acc_add']) && $user_permissions[$key][$section['id']]['acc_add'] == 1) ? 'checked' : '';
                                        $checked_edit = (isset($user_permissions[$key][$section['id']]['acc_edit']) && $user_permissions[$key][$section['id']]['acc_edit'] == 1) ? 'checked' : '';
                                        $checked_delete = (isset($user_permissions[$key][$section['id']]['acc_delete']) && $user_permissions[$key][$section['id']]['acc_delete'] == 1) ? 'checked' : '';
                                        ?>
                                        <tr class="danger">
                                            <td><strong><?php echo ($k == 1) ? ucfirst($value['user_module_name']) : ''; ?></strong></td>
                                            <td><?php echo ucfirst($section['user_section_name']); ?></td>
                                            <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_all]" class="menu_all" value="1" <?php echo $checked_all; ?> /></td>
                                            <?php if ($section['acc_view'] == 1): ?>
                                                <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_view]" class="allow_access" value="1" <?php echo $checked_view; ?> /></td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_view'] == 0): ?>
                                                <td>NA</td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_add'] == 1): ?>
                                                <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_add]" class="allow_access" value="1" <?php echo $checked_add; ?> /></td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_add'] == 0): ?>
                                                <td>NA</td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_edit'] == 1): ?>
                                                <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_edit]" class="allow_access" value="1" <?php echo $checked_edit; ?> /></td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_edit'] == 0): ?>
                                                <td>NA</td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_delete'] == 1): ?>
                                                <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_delete]" class="allow_access" value="1" <?php echo $checked_delete; ?> /></td>
                                            <?php endif; ?>
                                            <?php if ($section['acc_delete'] == 0): ?>
                                                <td>NA</td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php
                                        $k++;
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="form-group row text-center m-10">
                <div class="col-md-12 text-center">
				<button type="submit" class="btn btn-round btn-primary m-b-10 btn-sm waves-effect waves-light" style="">Submit</button>
                    <button type="button" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" onclick="window.location = '<?php echo base_url('masters/user_roles'); ?>'" style="">Cancel</button>
                    
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.menu_all').click(function () {
            if ($(this).prop('checked') == true) {
                $(this).closest('tr').find('input.allow_access').prop('checked', true);
            } else {
                $(this).closest('tr').find('input.allow_access').prop('checked', false);
            }

            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);
            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);
            if (total_checkbox == checked_checkbox) {
                $('input.grand_all').prop('checked', true);
            } else {
                $('input.grand_all').prop('checked', false);
            }


        });

        $('.grand_all').click(function () {
            if ($(this).prop('checked') == true) {
                $('input.allow_access,input.menu_all').prop('checked', true);
            } else {
                $('input.allow_access,input.menu_all').prop('checked', false);
            }
        });

        $('.allow_access').click(function () {
            length = Number($(this).closest('tr').find('input.allow_access:checked').length);
            if (length == 4) {
                $(this).closest('tr').find('input.menu_all').prop('checked', true);
            } else {
                $(this).closest('tr').find('input.menu_all').prop('checked', false);
            }
            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);
            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);
            if (total_checkbox == checked_checkbox) {
                $('input.grand_all').prop('checked', true);
            } else {
                $('input.grand_all').removeAttr('checked');
            }
            if (length >= 1) {
                $(this).closest('tr').find('input.menu_all').prop('checked', true);
            } else {
                $(this).closest('tr').find('input.menu_all').prop('checked', false);
            }
        });
    });
</script>

