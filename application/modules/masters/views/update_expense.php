<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(8){text-align:center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#update-customer" role="tab">Update Category</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-customer" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update List</h5>
                    </div>
                    <div class="card-block">
                        <?php echo form_open_multipart('masters/expense_category/edit/' . $expense[0]['id'], 'name="add_device" id="add_device" method="post" class="new-added-form" enctype="multipart/form-data"'); ?>
                        <?php
                        if (isset($expense) && !empty($expense)) {

                            $i = 0;
                            foreach ($expense as $val) {
                                $i++
                                ?>
                                <input type='hidden' value="<?= $val['id'] ?>" id='hidden_category_id'>
                                <div class="form-material row">
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-briefcase-alt-1"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">Spending Category <span class="req">*</span></label>
                                                <input type="text" name="exp[category_name]" class="required form-control" id="exp_category"  value="<?= $val['category_name'] ?>"/>
                                                <span class="form-bar"></span>
												<span class="error_msg"></span>


                                            </div>
                                        </div>
                                    </div>
									<!--<div class="col-md-3">
                                                <div class="form-group form-primary">
                                                    <div class="col-md-12 new-style-form">
                                                        <span class="help-block">Expense Type<span class="req">*</span></span>
                                                    </div>

                                                    <div class="form-radio col-lg-12">

                                                        <div class="radio radiofill radio-primary radio-inline">
                                                            <label>
                                                                <input type="radio" name="exp[exp_type]" data-bv-field="type" class="form-check-input exp_type required" value="fixed" <?php echo($val['exp_type'] == 'fixed') ? 'checked="checked"' : ''; ?>  name="exp[exp_type]">
                                                                <i class="helper"></i>Fixed
                                                            </label>
                                                        </div>
                                                        <div class="radio radiofill radio-primary radio-inline">
                                                            <label>
                                                                <input type="radio" name="exp[exp_type]" data-bv-field="type" class="form-check-input exp_type required" value="variable" <?php echo($val['exp_type'] == 'variable') ? 'checked="checked"' : ''; ?> name="exp[exp_type]" >
                                                                <i class="helper"></i>Variable
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <span class="error_msg"></span>
                                                </div>
                                            </div>-->
                                    </div>

                                <div class="form-group row text-center m-10">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" name="submit" class="btn btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Update" id="submit" tabindex="1"/>
                                        <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                        <a href="<?php echo $this->config->item('base_url') . 'masters/expense_category' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
        $('#submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
            exp_category = $.trim($('#exp_category').val())
            if (exp_category != '') {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {exp_category: $.trim($('#exp_category').val()), id: $.trim($('#hidden_category_id').val())},
                    url: '<?php echo base_url(); ?>masters/expense_category/edit_is_expense_category_available/',
                    success: function (data) {

                        if (data == 'yes') {
                            $('#exp_category').closest('div.form-group').find('.error_msg').text('This Category name is already taken').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#exp_category').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });

    $('#exp_category').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if ($.trim($(this).val()) == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });


</script>



