<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>

<div class="mainpanel">
    <div class="media">

    </div>
    <div class="contentpanel">
        <div class="media">
            <h4>Update Spending</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">

                <div class="tab-pane" id="userrole" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Update List</h5>
                        </div>
                        <div class="card-block">
                            <form action="<?php echo $this->config->item('base_url') . 'expense/expense/edit/' . $expense[0]['id']; ?>" enctype="multipart/form-data" name="form" method="post">
                                <?php
                                if (isset($expense) && !empty($expense)) {
                                    $i = 0;
                                    foreach ($expense as $val) {

                                        $i++
                                        ?>
                                        <div class="form-material row">
                                            <!--<div class="col-md-3">
        <div class="material-group">
        <div class="material-addone">
        <i class="icofont icofont-ui-user"></i>
        </div>
        <div class="form-group form-primary">
        <select name="exp[exp_type]" id="exp_type" class="form-control form-align required">
            <option value="">Expense Type</option>
            <option value="fixed"  <?php echo ($val['exp_type'] == "fixed") ? 'selected' : ''; ?>>Fixed</option>
                                                            <option value="variable" <?php echo ($val['exp_type'] == "variable") ? 'selected' : ''; ?>>Variable</option>
        </select>

        <span class="error_msg"></span>

        </div>
        </div>
        </div>-->
                                            <div class="col-md-3">
                                                <div class="material-group">
                                                    <div class="material-addone">
                                                        <i class="icofont icofont-ui-user"></i>
                                                    </div>
                                                    <div class="form-group form-primary">
                                                        <select name="exp[exp_cat_type]" id="exp_cat_type" class="form-control form-align required" >
                                                            <option value="">Select Category</option>
                                                            <?php
                                                            if (!empty($category)) {
                                                                foreach ($category as $cat_type) {
                                                                    ?>
                                                                    <option value="<?php echo $cat_type['id']; ?>"  <?php echo ($cat_type['id'] == $val['exp_cat_type']) ? 'selected' : ''; ?>><?php echo ucfirst($cat_type['category_name']); ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="form-bar"></span>
                                                        <span class="error_msg"></span>
                                                        <input type="hidden" name='exp_type' class="exp_type_val"/>
                                                        <input type="hidden" name='exp[old_amount]' class="old_amt" value="<?php echo $val['exp_amount']; ?>"/>
                                                        <input type="hidden" name='exp[balance]' class="balance_amt" value="<?php echo $val['balance']; ?>"/>
                                                        <input type="hidden" name="exp[company_amount]" id="company_amount" value="<?php echo $val['company_amount']; ?>" >
                                                        <input type="hidden" name="company_amount_details" value="<?php echo $company_amount[0]['company_amount']; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="material-group">
                                                    <div class="material-addone">
                                                        <i class="icofont icofont-money-bag"></i>
                                                    </div>
                                                    <div class="form-group form-primary">
                                                        <label class="float-label">Spending Amount <span class="req">*</span></label>
                                                        <input type="text" name="exp[exp_amount]" class=" form-align required form-control" id="exp_amount" maxlength="10" value="<?php echo $val['exp_amount'] ?>"/>
                                                        <span class="form-bar"></span>
                                                        <span class="error_msg"></span>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-3">
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
                                             </div>!-->

                                            <div class="col-md-3">
                                                <div class="form-group form-primary">
                                                    <div class="col-md-12 new-style-form">
                                                        <span class="help-block">Spending Mode</span>
                                                    </div>

                                                    <div class="form-radio col-lg-12">

                                                        <div class="radio radiofill radio-primary radio-inline">
                                                            <label>
                                                                <input type="radio" name="exp[exp_mode]" data-bv-field="type" class="form-check-input  required exp_mode" value="debit" <?php echo($val['exp_mode'] == 'debit') ? 'checked="checked"' : ''; ?>  name="exp[exp_mode]" checked="">
                                                                <i class="helper"></i>Expense
                                                            </label>
                                                        </div>
                                                        <div class="radio radiofill radio-primary radio-inline">
                                                            <label>
                                                                <input type="radio" name="exp[exp_mode]" data-bv-field="type" class="form-check-input  required exp_mode" value="credit" <?php echo($val['exp_mode'] == 'credit') ? 'checked="checked"' : ''; ?> name="exp[exp_mode]" >
                                                                <i class="helper"></i>Income
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <span class="error_msg"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="material-group">
                                                    <div class="material-addone">
                                                        <i class="fa fa-pencil"></i>
                                                    </div>
                                                    <div class="form-group form-primary">
                                                        <label class="float-label">Remarks </label>
                                                        <input type="text" name="exp[remarks]" class="store form-control" id="remarks" value="<?php echo $val['remarks'] ?>"/>
                                                        <span class="form-bar"></span>
                                                        <span class="error_msg"></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="material-group">
                                                    <div class="material-addone">
                                                        <i class="icofont icofont-ui-calendar"></i>
                                                    </div>
                                                    <div class="form-group form-primary">
                                                        <label class="float-label">Spending Date <span class="req">*</span></label>
                                                        <input id="dropper-default" class="form-control" name="exp[exp_date]" type="text" data-date="<?php echo date('d', strtotime($val['exp_date'])); ?>" data-month="<?php echo date('m', strtotime($val['exp_date'])); ?>" data-formats="<?php echo date('m/d/Y', strtotime($val['exp_date'])); ?>" data-year="<?php echo date('Y', strtotime($val['exp_date'])); ?>" placeholder="Select your date" value="<?php echo date('d-M-Y', strtotime($val['exp_date'])); ?>" />
                                                        <span class="form-bar"></span>
                                                        <span class="error_msg"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <div class="form-group row text-center m-10">
                                    <div class="col-md-12 text-center">
                                        <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="submit" tabindex="1"/>
                                        <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="cancel" tabindex="1"/>
                                        <a href="<?php echo $this->config->item('base_url') . 'expense' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

<br />


<script type="text/javascript">
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });

    $('#reset').on('click', function ()
    {
        $('.val').html("");
        $('.dup').html("");
    });
</script>
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

            if (m > 0)
                return false;
        });
    });
    //var expense_type = $('#exp_type').val();
    //$('.exp_type_val').val(expense_type);

    //$('#exp_type').change(function(){
    //	 exp_type=$('#exp_type option:selected').val() ;
    //	  $('.exp_type_val').val(exp_type);

    if (exp_type != '') {


        $.ajax({
            type: "POST",
            url: BASE_URL + "expense/expense/get_expense_categories",
            //data:{exp_type:exp_type},
            dataType: "json",
            success: function (data) {
                var html = '';
                var i;

                html = '<option value="">' + 'Select Category' + '</option>';
                for (i = 0; i < data.length; i++) {

                    html += '<option value=' + data[i].id + '>' + data[i].category_name + '</option>';
                }
                $('#exp_cat_typ').removeAttr("disabled");
                $('#exp_cat_type').html(html);

            }
        });
    }
//});
    /*$('.exp_type').on('change', function () {
     alert("test");
     var exp_type = $('.exp_type:checked').length;
     if (exp_type == 0) {
     $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
     } else {
     $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
     }
     });*/

    $('#exp_amount').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if ($.trim($(this).val()) == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });

    $('#exp_cat_type').on('change', function () {
        var category = $('#exp_cat_type').val();
        if (category == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#exp_cat_type').change(function () {

        $('#exp_amount').val('');
        $.ajax({
            url: BASE_URL + "expense/expense/get_company_amount",
            method: 'post',
            data: {firm_id: ''},
            dataType: 'json',
            success: function (result) {
                if (result[0].company_amount != null && result[0].company_amount > 0) {
                    $("#company_amount").val(result[0].company_amount);
                } else {
                    $("#company_amount").val('0');
                }
            }
        });
    });
</script>
<script>
    onload = function () {
        var exp_amount = document.querySelectorAll('#exp_amount')[0];
        exp_amount.onkeypress = function (e) {
            if (isNaN(this.value + "" + String.fromCharCode(e.charCode)))
                return false;
        }
        exp_amount.onpaste = function (e) {
            e.preventDefault();
        }



    }
</script>