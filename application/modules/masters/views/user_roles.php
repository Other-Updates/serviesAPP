<?php
$theme_path = $this->config->item('theme_locations') . $this->config->item('active_template');
?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#userrole-details" role="tab">User Role List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'user_roles', 'add')): ?>#userrole<?php endif ?>" role="tab">Add User Role</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="userrole-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">User Role List</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered" id="user_role_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User Role</th>
                                        <th class="action-btn-align">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($user_roles) && !empty($user_roles)) {
                                        $i = 1;
                                        foreach ($user_roles as $list) {
                                            ?>
                                            <tr><td class="first_td"><?php echo $i; ?></td>
                                                <td><?php echo ucfirst($list['user_role']); ?></td>
                                                <td class="action-btn-align">
                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?><?php echo base_url() . 'masters/user_roles/user_permissions/' . $list['id']; ?><?php endif ?>" toggle="tooltip" data-placement="top" title="User Permissions" class="btn btn-info  btn-mini waves-effect waves-light <?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?>alerts<?php endif ?>"><span class="fa fa-gear"></span></a>&nbsp;
                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?><?php echo base_url() . 'masters/user_roles/user_role_edit/' . $list['id']; ?><?php endif ?>"  toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-mini waves-effect waves-light <?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?>alerts<?php endif ?>" ><span class="fa fa-pencil"></span></a>
                                                    <?php if ($list['id'] != '1') { ?>
                                                        <a onclick="delete_user_role(<?php echo $list['id']; ?>)" delete_id="test3_<?php echo $list['id']; ?>"  toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-mini waves-effect waves-light delete_row <?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'delete')): ?>alerts<?php endif ?>" ><span class="fa fa-trash" style="color: white;"></span></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3">No User Roles found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="userrole" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add User Role</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>masters/user_roles/add/">
                            <div class="form-material row">

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">User Role <span class="req">*</span></label>
                                            <input type="text" name="user_role[user_role]" id="user_role" class="form-control" placeholder="" id="fit" maxlength="30" />
                                            <span class="form-bar"></span>
                                            <span id="user_role_error" class="reset  text-danger" style="color:#F00;"></span>
                                            <span id="duplica_user" class="val text-danger"  style="color:#F00;"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="cancel" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });

    $('#user_role').on('blur', function () {
        var user_role = $('#user_role').val();
        if (user_role == '' || user_role == null || user_role.trim().length == 0) {
            $('#user_role_error').html('Required Field');
        } else {
            $('#user_role_error').html('');
        }
    });

    $('#submit').on('click', function () {
        var i = 0;
        var user_role = $('#user_role').val();
        if (user_role == '' || user_role == null || user_role.trim().length == 0) {
            $('#user_role_error').html('Required Field');
            i = 1;
        } else {
            $('#user_role_error').html('');
        }

        var user = $('#duplica_user').html();
        if ((user.trim()).length > 0)
        {
            i = 1;
        }
        if (i == 1) {
            return false;
        } else {
            return true;
        }
    });
    $("#user_role").on('blur', function ()
    {
        email = $("#user_role").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/user_roles/add_duplicate_user",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#duplica_user").html(result);
                    }
                });
    });
</script>
<br />
<?php
if (isset($user_roles) && !empty($user_roles)) {
    $i = 0;
    foreach ($user_roles as $role) {
        ?>
        <div id="test1_<?php echo $role['id']; ?>" class="modal fade in" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" style="color:white;margin-top:10px;">Update User Role</h3>
                    </div>
                    <div class="modal-body">
                        <table width="60%">
                            <tr>
                                <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $role['id']; ?>" readonly /></td>
                            </tr>
                            <tr>
                                <td><strong>User Role</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input type="text" class="up_fit form-control up_fit_dup borderra0" id="up_fit" name="up_fit" value="<?php echo $role['user_role']; ?>" maxlength="30" /><span id="upfiterror" class="upfiterror" style="color:#F00; font-style:italic;"></span>
                                    <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
                                    <input type="hidden" class="h_fit" id="h_fit" value="<?php echo $role['user_role']; ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button type="button" class="btn btn-info" id="edit"> Update</button>
                        <button type="reset" class="btn btn-danger" id="no" data-dismiss="modal"> Discard</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<!--delete all-->
<?php
if (isset($user_roles) && !empty($user_roles)) {
    foreach ($user_roles as $role) {
        ?>
        <div id="test3_<?php echo $role['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active User Role </h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do you want In-Active? &nbsp; <strong><?php echo $role['user_role']; ?></strong>
                        <input type="hidden" value="<?php echo $role['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<script type="text/javascript">
    function delete_user_role(val) {

        $('#test3_' + val).modal('show');
    }
    $(document).ready(function () {

        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "masters/user_roles/delete_user_role",
                type: 'POST',
                data: {id: hidin},
                success: function (result) {
                    window.location.reload(BASE_URL + "masters/user_roles");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

        $('#user_role_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        });
    });

    $('.up_fit').on('blur', function () {
        var up_fit = $(this).parent().parent().find('.up_fit').val();
        var m = $(this).offsetParent().find('.upfiterror');
        if (up_fit == '' || up_fit == null || up_fit.trim().length == 0) {
            m.html('Required Field');
        } else {
            m.html('');
        }
    });

    $('#cancel').on('click', function () {
        $('.reset').html('');
        $('.dup').html('');
    });

    $('#edit').on('click', function () {
        var i = 0;
        var id = $(this).parent().parent().find('.id').val();
        var up_fit = $(this).parent().parent().find('.up_fit').val();
        var m = $(this).offsetParent().find('.upfiterror');
        var mess = $(this).parent().parent().find('.upduplica').html();
        if (up_fit == '' || up_fit == null || up_fit.trim().length == 0) {
            m.html('Required Field');
            i = 1;
        } else {
            m.html('');
        }
        if ((mess.trim()).length > 0) {
            i = 1;
        }
        if (i == 1) {
            return false;
        } else {
            for_loading('Loading Data Please Wait...');
            $.ajax({
                url: BASE_URL + 'masters/user_roles/update_user_role',
                type: 'POST',
                data: {value1: id, value2: up_fit, value3: up_per},
                success: function (result) {
                    window.location.reload(BASE_URL + 'masters/user_roles');
                    for_response('Updated Successfully...');
                }
            });
        }
        $('.modal').css('display', 'none');
        $('.fade').css('display', 'none');
    });

    $('#no').on('click', function () {
        var h_fit = $(this).parent().parent().parent().find('.h_fit').val();
        $(this).parent().parent().find('.up_fit').val(h_fit);
        var m = $(this).offsetParent().find('.upfiterror');
        var message = $(this).offsetParent().find('.upduplica');
        m.html('');
        message.html('');

    });
</script>