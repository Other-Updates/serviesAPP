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
    <div class="col-lg-12">
        <div class="md-tabs-main">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#category-details" role="tab">Category List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'master_category', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'master_category', 'add')): ?>#category<?php endif ?>" role="tab">Add Category</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="category-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Category Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="category_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Category</th>
                                        <th>image</th>
                                        <th class="action-btn-align">Action</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="category" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Category</h5>
                    </div>
                    <div class="card-block">
                        <form class="" name="defect" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>master_category/save_defect" method="post" enctype="multipart/form-data">
                            <div class=" row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="form-group form-primary">
                                            <label class="float-label">Category Name <span class="req">*</span></label>
                                            <input type="text" class="cat_dup form-control required" name="categoryName" id="defect_type" placeholder="Enter Category Name">
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
                                                <input type="radio" name="is_warranty" value="1" id="warranty" data-bv-field="warranty">
                                                <i class="helper"></i>Yes
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="is_warranty" value="2" id="warranty" data-bv-field="warranty">
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
                                            <img id="blah" src="<?= $this->config->item("base_url") . 'themes/incsol/assets/images/default_image.png' ?>" width="100%"  alt="" >
                                        </div>
                                        <div class="col-md-10 adminprofile">
                                            <input type="file" name="category_image" class=" imgInp form-control" id="category_image" />
                                        </div>
                                    </div>
                                    <span id="cat_img" class="val text-danger"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            <input class="border-checkbox grand_category" type="checkbox"  name="is_checked" id="checkbox1" checked="">
                                            <label class="border-checkbox-label" for="checkbox1">What We Do</label>
                                            <span class="form-bar"></span>
                                            <span class="check_err text-danger"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="button" class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="save_defect" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'master_category/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($detail) && !empty($detail)) {
    foreach ($detail as $billto) {//print_r($billto);exit;
        ?>
        <div id="test3_<?php echo $billto['cat_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog"><div class="modal-content modalcontent-top"><div class="modal-header modal-padding modalcolor">
                        <h4 class="inactivepop">In-Active Category</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div><div class="modal-body">
                        Do you want In-Active? &nbsp; <strong><?php echo $billto['categoryName']; ?></strong>
                        <input type="hidden" value="<?php echo $billto['cat_id']; ?>" id="hidin" class="hidin" />
                    </div><div class="modal-footer action-btn-align">
                        <button class="btn btn-primary btn-sm delete_yes yesin" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    function delete_category(val) {
        $('#test3_' + val).modal('show');
    }
    $('#asset_colors').val('defect-icon-gray.png');
    $('.icon-defeaut').css('background', 'rgba(47, 166, 0, 0.39)');
    $('.select-icon').on('click', function () {
        $('.select-icon').css('background', '');
        $(this).css('background', 'rgba(47, 166, 0, 0.39)');
        $('#asset_colors').val($(this).attr('icon_image'));
    });
    function readURL(input) {
        console.log(input);
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

    $(document).ready(function () {
        $('#category_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "language": {
                "infoFiltered": ""
            },
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "master_category/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
        $("#addfile").on('click', function (e) {
            e.preventDefault();
            var sub_categoryName = $('.action_nmae').val();
            m = 0;
            if (sub_categoryName == "") {
                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text('');
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

    $("#save_defect").on('click', function (e) {
        e.preventDefault();
        var cat = $.trim($("#defect_type").val());

        $.ajax(
                {
                    url: BASE_URL + "master_category/add_duplicate_category",
                    type: 'get',
                    async: false,
                    data: {value1: cat},
                    success: function (result)
                    {
                        // $(this).closest('div.form-group').find('.error_msg').text(result).slideDown("500").css('display','inline-block');
                        $("#duplica").html(result);
                    }
                });
        m = 0;
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr("id");
            if (this_val == "") {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('');

            }
        });
        if ($('#duplica').html() == 'Category Name already Exist')
        {
            m++;
        }

        if ($('input[name=is_warranty]:checked').length <= 0)
        {
            $('#warranty_err').text('This field is required').css('display', 'inline-block');
            m++;
        } else
        {
            $('#warranty_err').text('');
        }

        var category_img = $("#category_image").val();
        if (category_img == "" || category_img == null || category_img.trim().length == 0)
        {
            $("#cat_img").html("This field is required");
            m++;
        } else
        {
            $("#cat_img").html("");
        }
        if (m > 0)
            return false;
        document.getElementById("add_defect").submit();
    });

    $(".delete_corrective_action").on('click', function () {
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


</script>
<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.cat_dup').on('blur', function ()
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

    $('#submit').on('click', function ()
    {
        i = 0;
        var men = $('#men').val();

        if (men == '' || men == null || men.trim().length == 0)
        {
            $('#caterror').html("Required Field");
            i = 1;
        } else
        {
            $('#caterror').html(" ");
        }

        var m = $('#duplica').html();
        if ((m.trim()).length > 0)
        {
            i = 1;
        }

        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }
    });
    $('input[type="text"]').on('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });
</script>
<script>
    $(".cat_dup").on('blur', function ()
    {
        var cat = $.trim($("#defect_type").val());

        $.ajax(
                {
                    url: BASE_URL + "master_category/add_duplicate_category",
                    type: 'get',
                    data: {value1: cat},
                    success: function (result)
                    {
                        // $(this).closest('div.form-group').find('.error_msg').text(result).slideDown("500").css('display','inline-block');
                        $("#duplica").html(result);
                    }
                });
    });
</script>

</div>


<script type="text/javascript">
    $(document).ready(function ()
    {

        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.hidin').val();
            $.ajax({
                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/delete_master_category",
                type: 'get',
                data: {value1: hidin},
                success: function (result) {
                    window.location.reload(BASE_URL + "master_category/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
<!-- Update script  -->
<script type="text/javascript">
    $("#edit").on("click", function ()
    {

        var i = 0;
        var id = $(this).parent().parent().find('.id').val();
        var up_men = $(this).parent().parent().find(".up_men").val();
        var up_women = $(this).parent().parent().find(".up_women").val();
        var up_kids = $(this).parent().parent().find(".up_kids").val();
        var m = $(this).offsetParent().find('.upcategoryerror');
        var mess = $(this).parent().parent().find('.upduplica').html();
        if (up_men == '' || up_men == null || up_men.trim().length == 0)
        {
            m.html("Required Field");
            i = 1;
        } else
        {
            m.html("");
        }
        if ((mess.trim()).length > 0)
        {
            i = 1;
        }

        if (i == 1)
        {
            return false;
        } else
        {
            for_loading('Loading Data Please Wait...');
            $.ajax({
                url: BASE_URL + "master_category/update_category",
                type: 'POST',
                data: {value1: id, value2: up_men, value3: up_women, value4: up_kids},
                success: function (result)
                {
                    window.location.reload(BASE_URL + "master_category");
                    for_response('Updated Successfully...');
                }
            });
        }

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    });
    $("#no").on("click", function ()
    {


        var h_category = $(this).parent().parent().parent().find('.h_category').val();

        $(this).parent().parent().find('.up_category').val(h_category);
        var m = $(this).offsetParent().find('.upcategoryerror');
        var message = $(this).offsetParent().find('.upduplica');
        m.html("");
        message.html("");
    });

</script>

<script>
    $(".up_cat_dup").on('keyup', function ()
    {
        var cat = $(this).parent().parent().find('.up_men').val();
        var id = $(this).offsetParent().find('.id_dup').val();
        var message = $(this).offsetParent().find('.upduplica');


        $.ajax(
                {
                    url: BASE_URL + "master_category/update_duplicate_category",
                    type: 'POST',
                    data: {value1: cat, value2: id},
                    success: function (result)
                    {
                        message.html(result);
                    }
                });
    });
</script>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#cancel').on('click', function ()
        {
            $('.reset').html("");
            $('.dup').html("");
        });
    });
</script>