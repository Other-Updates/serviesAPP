<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    a:focus, a:hover {
        color: #fff;
    }
</style>

<table class="static" style="display: none;">
    <tr>

    <input type="hidden" class="ads_detail_id" name="" value="0">
    <input type="hidden" class="is_delete" name="ads_delete[<?php echo $j; ?>][is_delete]" value="0">
    <input type="hidden" class="is_remove_id" name="ads_remove_id[<?php echo $j; ?>][is_delete]" value="">

    <td align="center" class="s_no"></td>
    <td>
        <div class="col-md-12" >
            <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type ads_req" id="">
                <option value="1">Images</option>
            </select>
            <span class="error_msg adds_file_type_error"></span>
        </div>
    </td>
    <td class="file_type_content">
        <div class="ads_image_div" >
            <div class="col-md-9 add-img-upload flt-left">
                <fieldset _ngcontent-c7="" class="">
                    <div _ngcontent-c7="" class="custom-file center-block d-block">
                        <input _ngcontent-c7="" class="add_data_images custom-file-input adsdata ads_req" id="ads" name="ads_data_image[]" data-type="image" type="file">
                        <label _ngcontent-c7="" class="custom-file-label" for="inputGroupFile01">Choose File</label>
                    </div>
                    <span class="error_msg file_error"></span>
                </fieldset>


            </div>
            <div class="col-md-3 flt-left">
                <img src="<?php echo base_url('/') . '/attachement/product/no-img.gif'; ?>"  class="img_src img_video_tbl" width="40px" height="40px" />
            </div>
        </div>
    </td>
    <td>
        <div class="col-md-12">
            <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="ads_req form-control ads_sort_order "/>
            <span class="error_msg sort_order_error"></span>
        </div>
    </td>

    <td width="5%" class="action-btn-align" style="text-align:center;">
        <a  class="remove_data del btn btn-round btn-danger btn-mini" onclick="remove_data($(this))">
            <span class="fa fa-trash" style="color:white;"></span>
        </a>
    </td>
</tr>
</table>

<div class="row">
    <div class="col-lg-12">
        <div class="md-tabs-main">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#update-ads" role="tab">Update Advertisement</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-ads" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update List</h5>
                    </div>

                    <div class="card-block">
                        <form class="" method="post"  name="form1" action="<?php echo $this->config->item('base_url') . 'advertisement/edit/' . $ads_details[0]['id']; ?>" enctype="multipart/form-data" >
                            <?php
                            if (isset($ads_details) && !empty($ads_details)) {
                                $i = 0;
                                foreach ($ads_details as $val) {
                                    $i++
                                    ?>
                                    <div class=" row">
                                        <div class="col-md-6">
                                            <div class="material-group">
                                                <div class="form-group form-primary">
                                                <label class="float-label">Ads Name</label>
                                                    <input type="text" name="ads[ads_name]" class="form-control required " id="ads_name" placeholder="Enter Ads Name" value="<?php echo ucfirst($ads_details[0]['name']); ?>"/>
                                                    

                                                    <span class="form-bar"></span>
                                                    <span class="error_msg"></span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-12">
                                            <label><strong>Ads Content/File Details:</strong></label><span class="req">*</span>
                                            <table class="addstbl table table-bordered" id="add_data_table">
                                                <thead id="add_header">
                                                <th width="1%" class="first_td1">S.No</th>
                                                <th width="15%" class="first_td1 ads_file_type" >File Type</th>
                                                <th width="40%" class="first_td1 add_title_datatype"> Ads Data</th>
                                                <th width="3%" class="first_td1">Sort Order</th>
                                                <th width="1%" class="action-btn-align" style="text-align:center;"><a id='add_data' onclick="ads_content_clone()" data-type="0" class="btn btn-round btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus" style="color:white;"></span> </a></th>
                                                </thead>
                                                <tbody id="add_body">

                                                    <?php
                                                    if (isset($ads_content_details) && $ads_content_details != '') {
                                                        foreach ($ads_content_details as $ads_key => $list_content) {
                                                            $j = $ads_key;
                                                            ?>
                                                            <tr class="ads_row<?php echo $j; ?>" data-rowid="<?php echo $ads_key; ?>">
                                                        <input type="hidden" class="ads_detail_id" name="" value="<?php echo $list_content['id']; ?>">
                                                        <input type="hidden" class="is_delete" name="ads_delete[<?php echo $j; ?>][is_delete]" value="0">
                                                        <input type="hidden" class="is_remove_id" name="ads_remove_id[<?php echo $j; ?>][is_delete]" value="<?php echo $list_content['id']; ?>">
                                                        <?php if ($list_content['file_type'] != '3') { ?>
                                                            <input type="hidden" name="old[ads_detail_id][]" value="<?php echo $list_content['id']; ?>"/>
                                                            <input type="hidden" name="old[ads_detail_data][]" value="<?php echo $list_content['ads_data_link']; ?>"/>
                                                        <?php } ?>
                                                        <td class="s_no" align="center"><?php echo $ads_key + 1; ?></td>
                                                        <td>
                                                            <div class="col-md-12" >
                                                                <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type ads_req" id="">
                                                                    <?php if ($list_content['file_type'] == 1) { ?>
                                                                        <option value="1" <?php if ($list_content['file_type'] == 1) echo "selected"; ?>>Images</option>
                                                                    <?php } else { ?>
                                                                        <option value="3" <?php if ($list_content['file_type'] == 3) echo "selected"; ?>>Content</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <span class="error_msg adds_file_type_error"></span>
                                                            </div>
                                                        </td>
                                                        <td class="file_type_content">
                                                            <?php if ($list_content['file_type'] == 1): ?>
                                                                <div class="ads_image_div" >
                                                                    <?php
                                                                    if ($list_content['ads_data'] != '')
                                                                        $image_url = $list_content['ads_data_link'];
                                                                    else
                                                                        $image_url = base_url('/') . 'themes/incsol/assets/images/default_image.png';
                                                                    ?>
                                                                    <div class="col-md-9 add-img-upload flt-left">
                                                                        <fieldset _ngcontent-c7="" class=""><div _ngcontent-c7="" class="custom-file center-block d-block">
                                                                                <input type="file" name="ads_data_image[<?php echo $ads_key; ?>]"  value="<?php echo $image_url; ?>" class="ads_req custom-file-input add_data_images  adsdata" id="ads_image<?php echo $j; ?>" data-type="image" onchange="loadImageFileAsURL(<?php echo $j; ?>)"/>
                                                                                <label _ngcontent-c7="" class="custom-file-label" for="inputGroupFile01">Choose File</label></div></fieldset>


                                                                        <span class="error_msg file_error"></span>
                                                                    </div>

                                                                    <div class="col-md-3 flt-left">
                                                                        <img src="<?php echo $image_url; ?>"  class="img_src" width="40px" height="40px"/>
                                                                    </div>
                                                                </div>

                                                            <?php elseif ($list_content['file_type'] == 3): ?>
                                                                <div class="ads_content_div">
                                                                    <div class="col-md-12">
                                                                        <textarea name="ads_data[<?php echo $ads_key; ?>]"  class="add_data_contents ads_req form-control required txt_area_height"><?php echo $list_content['ads_data']; ?></textarea>
                                                                        <span class="error_msg file_error"></span>
                                                                    </div>

                                                                </div>

                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-12">
                                                                <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="ads_req form-control ads_sort_order required" value="<?php echo $list_content['sort_order']; ?>"/>
                                                                <span class="error_msg sort_order_error"></span>
                                                            </div>
                                                        </td>

                                                        <td width="5%" class="action-btn-align" style="text-align:center;">
                                                            <?php if ($list_content['file_type'] == 1): ?>
                                                                <a  class="remove_data del btn btn-round btn-danger btn-mini" onclick="remove_data($(this))">
                                                                    <span class="fa fa-trash" style="color:white;"></span>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" class="submit btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="edit" tabindex="1"/>
                                            <input type="reset" value="Clear" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'advertisement/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                        </div>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    setTimeout(function () {
        $('.ft-disc').attr('data-toggle', 'collapsed');
        $('.ft-disc').addClass('ft-circle');
        $('.ft-disc').removeClass('ft-disc');
        $('.wrapper').addClass('nav-collapsed');
        $('.wrapper').addClass('menu-collapsed');
    }, 1000);

    $(document).ready(function () {
        BASE_URL = "<?php echo $this->config->item('base_url'); ?>";
        $('.submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_class = $(this).attr('class');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('Field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }

            });

            if (m > 0)
                return false;

        });
    });
    function ads_content_clone() {
        var table_data = $(".static").find('tr').clone();
        table_data.find('.adds_file_type ,.add_data_images,.ads_sort_order').addClass('required');
        $('#add_body').append(table_data);
        loop_set();
    }
    function loop_set() {
        var i = 0;
        var inc_id = 1;
        $('#add_body tr').each(function () {
            $(this).closest("tr").attr('class', '');
            $(this).closest("tr").attr('data-rowid', i);
            $(this).closest("tr").addClass('ads_row' + i);
            $(this).closest("tr").find('.s_no').html(inc_id++);
            $(this).closest("tr").find('.add_data_contents').attr('id', 'ads_content' + i + '');
            $(this).closest("tr").find('.add_data_contents').attr('name', 'ads_data[' + i + ']');
            $(this).closest("tr").find('.add_data_images').attr('id', 'ads_image' + i + '');
            $(this).closest("tr").find('input.add_data_images').attr('name', 'ads_data_image[' + i + ']');
            $(this).closest("tr").find('.add_data_images').attr('onchange', 'loadImageFileAsURL(' + i + ')');
            i++;
        });
    }
    function remove_data(_this) {
        _this.closest("tr").find('.ads_req').removeClass('required');
        _this.closest("tr").find('.is_delete').val(1);
        _this.closest("tr").hide();
        loop_set();
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && ((charCode != 46 && charCode != 45 && charCode != 43 && charCode < 48) || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }

    function loadImageFileAsURL(inc_id) {
        var tr_class = '.ads_row' + inc_id + '';
        var type = $('' + tr_class + '').find('.adds_file_type').val();
        $('' + tr_class + '').find('.adds_file_type_error').text('');
        if (type != undefined && type == 1) {
            if (type == 1)
                var id = "ads_image" + inc_id + '';
            var filesSelected = document.getElementById('' + id + '').files;
            var img = document.getElementById('' + id + '');
            if (filesSelected.length > 0)
            {
                var fileExtension = ['jpeg', 'jpg', 'png', 'mp4'];
                var fileUpload = $('#' + id + '')[0];
                var file_type_split = fileUpload.files[0].type.split('/');
                var file_type = file_type_split[1];


                //Read the contents of Image File.
                var reader = new FileReader();
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    if (type == 1) {

                        if ($.inArray(file_type, fileExtension) == -1) {
                            $('' + tr_class + '').find('.file_error').text('Invalid file format..only allowed:jpeg,jpg,png').slideDown('500').css('display', 'inline-block');
                            return false;
                        } else {
                            image.onload = function () {
                                //Determine the Height and Width.

                                var height = this.height;
                                var width = this.width;
                                if (height == 1060 || width == 1300)
                                {
                                    $('' + tr_class + '').find('.file_error').text('Width and Height must be in 1300 X 1060 px.').slideDown('500').css('display', 'inline-block');
                                    $('#' + id + '').val('');
                                    return false;
                                } else
                                {
                                    $('' + tr_class + '').find('.file_error').text(' ').slideDown('500').css('display', 'inline-block');
                                    $('' + tr_class + '').find('.img_src').attr('src', e.target.result);
                                    return true;
                                }
                            };
                        }

                    }
                }

            } else {
                $('' + tr_class + '').find('.file_error').text('Please Select file').slideDown('500').css('display', 'inline-block');
            }
        } else {
            if (type == '')
                $('' + tr_class + '').find('.adds_file_type_error').text('Select file Type').slideDown('500').css('display', 'inline-block');
        }
    }

</script>