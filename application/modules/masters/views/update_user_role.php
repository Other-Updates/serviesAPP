<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#update-user" role="tab">Update User Role</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-user" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update List</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>masters/user_roles/user_role_edit/<?php echo $role[0]['id']; ?>">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">User Role <span class="req">*</span></label>
                                            <input type="text" name="user_role" id="user_role" class="form-control" placeholder="" id="fit" maxlength="30" value="<?php echo $role[0]['user_role']; ?>"/>
                                            <span class="form-bar"></span>
                                            <span id="user_role_error" class="val text-danger"></span>
                                            <span id="duplica_user" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="submit btn hor-grd btn-grd-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn hor-grd btn-grd-danger waves-effect m-b-10 btn-sm waves-light" id="cancel" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>" class="btn btn-grd-inverse hor-grd btn-sm waves-effect waves-light m-b-10"> Back </a>
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

</script>