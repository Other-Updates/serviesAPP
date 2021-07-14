<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
.new-style-form1 {
    top: -9px;
    font-size: 11px;
    font-weight: 600 !important;
	margin-left:-14px;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="md-tabs-main">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#update-cat-sub" role="tab">Update Category</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-cat-sub" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Category List</h5>
                    </div>
                    <div class="card-block">
                        <form class="" name="defect" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>master_category/update_category "method="post" enctype="multipart/form-data">
                            <input type="hidden" id="cats" name="cat_id" value="<?php echo $defect_type[0]['cat_id'] ?>" >
                            <?php if (isset($defect_type[0]) && !empty($defect_type[0])) { ?>
                                <div class=" row">
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="form-group form-primary">
                                                <label class="float-label">Category Name <span class="req">*</span></label>
                                                <input type="text" class="form-control required cat_dup" org_name="<?php echo $defect_type[0]['categoryName'] ?>" name="categoryName" value="<?php echo $defect_type[0]['categoryName'] ?>" id="defect_type" tabindex="1">
                                                <span class="form-bar"></span>
                                                <span class="error_msg val text-danger"></span>
                                                <span id="duplica" class="val text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <label class="help-block">Warranty <span class="req">*</span></label>
                                        <div class="form-radio">
                                            <div class="radio radiofill radio-primary radio-inline">
                                                <label>
                                                    <input type="radio" name="is_warranty" value="1" <?php if ($defect_type[0]['is_warranty'] == '1') echo 'checked="checked"'; ?> id="warranty" data-bv-field="warranty">
                                                    <i class="helper"></i>Yes
                                                </label>
                                            </div>
                                            <div class="radio radiofill radio-primary radio-inline">
                                                <label>
                                                    <input type="radio" name="is_warranty" value="2" <?php if ($defect_type[0]['is_warranty'] == '2') echo 'checked="checked"'; ?> id="warranty" data-bv-field="warranty">
                                                    <i class="helper"></i>No
                                                </label>
                                            </div>
                                        </div>
                                        <span id="warranty_err" class="val text-danger"></span>
                                    </div>
                                    <div class="col-md-3">
                                    <label class="help-block">Category Image <span class="req">*</span></label>
                                        <div class="row">
                                            <div class="col-md-2 pr-0">
                                                <?php if ($defect_type[0]['category_image'] != '') { ?>
                                                    <img id="blah" src="<?= $this->config->item("base_url") . 'attachement/category/' . $defect_type[0]['category_image']; ?>" width="100%" alt="" width="40px;"height="40px;">
                                                <?php } else { ?>
                                                    <img id="blah" src="<?= $this->config->item("base_url") . 'themes/incsol/assets/images/default_image.png' ?>" width="100%" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="file" name="category_image" class=" imgInp form-control" id="category_image" tabindex="1"/>
                                            </div>
                                        </div>
                                        <span id="cat_img" class="val text-danger"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border-checkbox-section">
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox grand_category" type="checkbox"  name="is_checked" id="checkbox1" <?php echo ($defect_type[0]['is_checked'] == '1') ? 'checked' : '' ?>>
                                                <label class="border-checkbox-label" for="checkbox1">What We Do</label>
                                                <span class="form-bar"></span>
                                                <span class="check_err text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row text-center m-10">
                                    <div class="col-md-12 text-center">
                                        <input type="button" class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="save_defect" tabindex="1"/>
                                        <input type="reset" value="Clear" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                        <a href="<?php echo $this->config->item('base_url') . 'master_category/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10">Back </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.cat_dup').live('blur', function ()
    {
        var men = $('.cat_dup').val();
        if (men == '' || men == null || men.trim().length == 0)
        {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
        } else
        {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp("500");
        }
    });

    $('.icon-defeaut').css('background', 'rgba(47, 166, 0, 0.39)');
    $('.select-icon').live('click', function () {
        $('.select-icon').css('background', '');
        $(this).css('background', 'rgba(47, 166, 0, 0.39)');
        $('#asset_colors').val($(this).attr('icon_image'));
    });
    $(document).ready(function () {
        $("#addfile").on('click', function (e) {
            e.preventDefault();
            var sub_categoryName = $('.action_nmae').val();
            m = 0;
            if (sub_categoryName == "") {
                $(this).closest('td').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text('').slideUp("500");
            }
            if (m > 0)
                return false;
            $.ajax({
                type: "POST",
                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/save_action",
                data: {sub_categoryName: sub_categoryName},
                success: function (data) {
                    $("#action_table").append(data);
                    $('#action_name').val('').removeAttr('id');
                    //$("#action_name").trigger("reset");
                    // $("#table2").append('<tr class="clone_tr"><td width="5%"><input type="checkbox" name="" value="" checked="checked"/></td><td width="95%"><div class="input-group"><input type="text" placeholder="Enter Action Name" class="form-control" name="actionName"><span class="input-group-addon" id="addfile"><i class="fa fa-plus" aria-hidden="true"></i></span></div></td></tr>');
                    //$("#dynamicfieldsdata").trigger("chosen:updated");
                }
            });
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);
                $(input).closest('div').find('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".imgInp").live('change', function () {
        readURL(this);
    });
    $("#save_defect").on('click', function (e) {
        e.preventDefault();
        m = 0;
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr("id");
            if (this_val == "") {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp("500");
            }
        });
        if ($('#duplica').html() == 'Category Name already Exist')
        {
            m++;
        } else
        {
            $('#duplica').html('');
        }

        if ($('input[name=is_warranty]:checked').length <= 0)
        {
            $('#warranty_err').text('This field is required').css('display', 'inline-block');
            m++;
        } else
        {
            $('#warranty_err').text('');
        }
//        var category_img = $("#category_image").val();
//        if (category_img == "" || category_img == null || category_img.trim().length == 0)
//        {
//            $("#cat_img").html("This field is required");
//            m++;
//        } else
//        {
//            $("#cat_img").html("");
//        }
        if (m > 0)
            return false;
        document.getElementById("add_defect").submit();
        var cat = $.trim($("#defect_type").val());
        var id = $("#cats").val();
        $.ajax(
                {
                    url: BASE_URL + "master_category/update_duplicate_category",
                    type: 'post',
                    async: false,
                    data: {value1: cat, value2: id},
                    success: function (result)
                    {
                        if ($('#defect_type').attr('org_name') != cat)
                            $("#duplica").html(result);
                    }
                });
    });

    $(".delete_corrective_action").live('click', function () {
        var element = $(this);
        var del_id = element.attr("id");
        $.ajax({
            type: "POST",
            url: '<?php echo $this->config->item('base_url') ?>' + "master_category/delete_action_by_id",
            data: {del_id: del_id},
            success: function (data) {

                console.log(data);
                $('#' + del_id).closest('tr').fadeOut();
                $('#' + del_id).closest('tr').hide();

            }
        });
    });
    $(".edit_corrective_action").live('click', function () {
        $("#action_table").find("input[type=text]")
                .removeClass('editme')
                .prop("disabled", true);
        $(event.target).closest('tr').find("input[type=text]")
                .addClass('editme')
                .prop("disabled", false);
    });

    $(document).on('blur', 'input[type=text]', function () {
        var val = $(this).val();
        var element = $(this);
        var edit_id = element.attr("id");
        if (val != '')
        {
            $.ajax({
                type: "POST",
                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/edit_action_by_id",
                data: {actionId: edit_id, sub_categoryName: val},
                success: function (data) {
                    $("#action_table").find("input[type=text]")
                            .removeClass('editme')
                            .prop("disabled", true);
                }
            });
        }
    });
</script>
<script>
    $(".cat_dup").live('blur', function ()
    {
        var cat = $.trim($("#defect_type").val());
        var id = $("#cats").val();
        $.ajax(
                {
                    url: BASE_URL + "master_category/update_duplicate_category",
                    type: 'post',
                    data: {value1: cat, value2: id},
                    success: function (result)
                    {
                        if ($('#defect_type').attr('org_name') != cat)
                            $("#duplica").html(result);
                    }
                });
    });
    $('input[type="text"]').live('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });
</script>

