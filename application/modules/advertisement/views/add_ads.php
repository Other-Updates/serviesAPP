<?php $theme_path = $this->config->item('theme_locations') . 'display'; ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/app-assets/vendors/js/core/jquery-3.3.1.min.js"></script>


<style type="text/css">
    .ad_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        cursor: pointer;
    }
    .ad_tree_structure .checkbox {
        min-height: 35px;
    }
    .zone_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        cursor: pointer;
    }
    .state_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
    }
    .state_tree {
        margin-bottom: 7px;
    }
    .state_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .region_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        margin-bottom: 10px;
    }
    .region_tree {
        margin-bottom: 7px;
    }
    .region_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .group_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        margin-bottom: 10px;
    }
    .group_tree {
        margin-bottom: 7px;
    }
    .group_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .device_list {
        list-style-type: none;
    }
    .zone_tree_structure .checkbox {
        min-height: 35px;
    }
    .form-horizontal .form-group {
        margin-left: 0px;
        margin-right: 0px;
    }
    .bg-selected-mem {
        background-color: #009688;
        border-color: #009688;
        color: white;
    }
    .add-img-upload {
        margin-top: 9px;
        border: 0px solid #DDD;
        padding: 7PX;
        border-radius: 7px;
    }
    table tr td:last-child {
        width:.5% !important;
    }
    table tr td:nth-child(1) {
        text-align:center !important;
    }

    .img_video_tbl {
        margin-top:4px;}
    .txt_area_height {
        height:40px !important;
    }
    .timepicker .btn {
        border:1px solid #ccc;
    }
</style>
<!-- Form horizontal -->
<section id="extended">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title-wrap bar-success">
                        <h5 class="card-title">Add New Ads</h5>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo form_open_multipart('advertisement/add', 'name="add_ads" id="add_ads" class="form-horizontal"'); ?>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback has-feedback-left">
                                        <label><strong>Ads Name :</strong></label><span class="req">*</span>
                                        <input type="text" name="ads[ads_name]" id="ads_name" class="form-control required" value="" >
                                        <span class="error_msg"></span>
                                    </div>
                                </div>
                                <!--                                <div class="col-md-6">
                                                                    <div class="form-group has-feedback">
                                                                        <label><strong>Status:</strong></label>
                                                                        <select name="ads[status]" class="form-control">
                                                                            <option value="1">Active</option>
                                                                            <option value="0">Inactive</option>
                                                                        </select>
                                                                        <span class="error_msg"></span>
                                                                    </div>
                                                                </div>-->
                            </div>
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="col-lg-12">
                            <label><strong>Ads Zone Details:</strong></label><span class="req">*</span>
                            <div class="well border-left-success border-left-lg" style="margin-bottom:15px;">
                                <ul class="ad_tree_structure">
                                    <?php
                                    if (!empty($zone_tree)) {
                                        foreach ($zone_tree as $state => $state_list) {
                                            $count_state = $zone_count['state'][$state];
                                            ?>
                                            <li class="state_tree">
                                                <div class="state_section">
                                                    <div class="checkbox">
                                                        <label class="state_label">
                                                            <input type="checkbox" name="ads_state[]" class="state_item" value="<?php echo $state; ?>"> <?php echo $state_arr[$state]['state_name']; ?>
                                                        </label>
                                                        <span class="badge bg-pink"><?php echo $count_state; ?></span>
                                                        <a href="javascript:void(0);" class="btn btn-round bg-teal btn-xs pull-right state_btn"><i class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <ul class="state_tree_structure" style="display: none;">
                                                    <?php
                                                    if (!empty($state_list)) {
                                                        foreach ($state_list as $region_id => $region_list) {
                                                            $count_region = $zone_count['region'][$region_id];
                                                            ?>
                                                            <li class="region_tree">
                                                                <div class="region_section">
                                                                    <div class="checkbox">
                                                                        <label class="region_label">
                                                                            <input type="checkbox" name="ads_region[<?php echo $state; ?>][]" class="region_item" value="<?php echo $region_id; ?>"> <?php echo $regions_arr[$region_id]['region_name']; ?>
                                                                        </label>
                                                                        <span class="badge bg-pink"><?php echo $count_region; ?></span>
                                                                        <a href="javascript:void(0);" class="btn btn-round bg-teal btn-xs pull-right region_btn"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                                <ul class="region_tree_structure" style="display: none;">
                                                                    <?php
                                                                    if (!empty($region_list)) {
                                                                        foreach ($region_list as $group_id => $store_group) {
                                                                            $count_group = $zone_count['group'][$group_id];
                                                                            ?>
                                                                            <li class="group_tree">
                                                                                <div class="group_section">
                                                                                    <div class="checkbox">
                                                                                        <label class="group_label">
                                                                                            <input type="checkbox" name="ads_group[<?php echo $state; ?>][<?php echo $region_id; ?>][]" class="group_item" value="<?php echo $group_id; ?>"> <?php echo ucfirst($groups_arr[$group_id]['group_name']); ?>
                                                                                        </label>
                                                                                        <span class="badge bg-pink"><?php echo $count_group; ?></span>
                                                                                        <a href="javascript:void(0);" class="btn btn-round bg-teal btn-xs pull-right group_btn"><i class="fa fa-plus"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                                <ul class="group_tree_structure" style="display: none;">
                                                                                    <?php
                                                                                    if (!empty($store_group)) {
                                                                                        foreach ($store_group as $device_id => $device_list) {
                                                                                            $count_device = $zone_count['device'][$device_id];
                                                                                            ?>
                                                                                            <li class="device_list"><input type="checkbox" name="ads_device[<?php echo $state; ?>][<?php echo $region_id; ?>][<?php echo $group_id; ?>][]" class="device_item" value="<?php echo $device_id; ?>"> <?php echo ucfirst($device_arr[$device_id]['deviceID']); ?></li>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <span class="error_msg device_zone_error"></span>
                        </div>
                        <div class="col-lg-12">

                            <label><strong>Ads Content/File Details:</strong></label><span class="req">*</span>
                            <table class="table table-striped table-bordered responsive" id="add_data_table">
                                <thead id="add_header">
                                <th width="1%" class="first_td1">S.No</th>
                                <th width="7%" class="first_td1 ads_file_type" >File Type</th>
                                <th width="20%" class="first_td1 add_title_datatype"> Ads Data</th>
                                <th width="4%" class="first_td1">Duration</th>
                                <th width="3%" class="first_td1">Sort Order</th>
                                <th width="7%" class="first_td1 add_direction_datatype">Position</th>
                                <th width="1%" class="action-btn-align" style="text-align:center;"><a id='add_data' data-type="0" class="btn btn-round btn-success btn-xs form-control pad10"><span class="fa fa-plus"></span> </a></td>
                                    </thead>
                                <tbody id="add_body">

                                </tbody>

                            </table>

                        </div>

                        <div class="clearfix"></div><br>

                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-round btn-raised btn-danger mr-1" onclick="window.location = '<?php echo base_url('advertisement'); ?>'" style="float:left;" title="Cancel"><i class="ft-thumbs-down position-left"></i> Cancel</button>
                                <button type="submit" class="btn btn-round btn-raised btn-success submit" style="float:right;" title="Submit">Submit <i class="ft-thumbs-up position-left"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="static_content" >
    
<tr>
<input type="hidden" class="is_delete">
<input type="hidden" class="is_remove_id">
<input type="hidden" class="ads_detail_id" name="" value="0">
<input type="hidden" name="old[ads_detail_id][]" value="0"/>
<input type="hidden" name="old[ads_detail_data][]" value=""/>
<td align="center" class="s_no"></td>
<td>
    <div class="col-md-12 form-group" >
        <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type required" id="">
            <option value=" ">Select Type</option>
            <option value="1">Images</option>
            <option value="3">Content</option>
        </select>
        <span class="error_msg adds_file_type_error"></span>
    </div>
</td>
<td class="file_type_content">
    <div class="ads_image_div" >
        <div class="col-md-9 form-group add-img-upload flt-left">
            <fieldset _ngcontent-c7="" class="form-group">
                <div _ngcontent-c7="" class="custom-file center-block d-block">
                    <input _ngcontent-c7="" class="add_data_images custom-file-input adsdata required" id="ads" name="ads_data_image[]" data-type="image" type="file">
                    <label _ngcontent-c7="" class="custom-file-label" for="inputGroupFile01">Choose File</label>	
                </div>
				<span class="error_msg file_error"></span>
            </fieldset>
            

        </div>
        <div class="col-md-3 flt-left">
            <img src="<?php echo base_url('/') . 'themes/incsol/assets/images/default_image.png'; ?>"  class="img_src img_video_tbl" width="40px" height="40px" />
        </div>
    </div>

    <div class="ads_content_div" style="display:none">
        <div class="col-md-12 form-group">
            <textarea   placeholder="Content" class="add_data_contents form-control txt_area_height " name=""></textarea>
            <span class="error_msg file_error"></span>
        </div>
    </div>
</td>

<td>
    <div class="col-md-12 form-group">
        <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="form-control required ads_sort_order "/>
        <span class="error_msg sort_order_error"></span>
    </div>
</td>

<td width="5%" class="action-btn-align" style="text-align:center;">
    <a  class="remove_data del btn btn-round btn-danger btn-mini">
        <span class="fa fa-trash" style="color:white;"></span>
    </a>
</td>
</tr>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

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
                                        ads_content_clone();
                                        remove_data();

                                        $(document).on('change', '.adds_file_type', function () {
                                            var val = $(this).val();
                                            var tr_class = $(this).closest('tr').attr('class');
                                            var inc_id = $(this).closest('tr').attr('data-rowid');
                                            $('.' + tr_class + '').find('.ads_postion').val('');
                                            $('.' + tr_class + '').find('.ads_postion').attr('disabled', false);

                                            if (val == " ") {
                                                $('.' + tr_class + '').find('.adds_file_type_error').text('Field is required').slideDown('500').css('display', 'inline-block');
                                            } else {
                                                $('.' + tr_class + '').find('.adds_file_type_error').text('').slideUp('500');
                                                if (val == 1) {
                                                    $('.' + tr_class + '').find('.ads_image_div').css('display', 'block');
                                                    $('.' + tr_class + '').find('.ads_video_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.ads_content_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.add_data_images').addClass('required');
                                                    $('.' + tr_class + '').find('.add_data_videos').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents_tamil').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_images').attr('id', 'ads_image' + inc_id + '');
                                                    $('.' + tr_class + '').find('.add_data_images').attr('onchange', 'loadImageFileAsURL(' + inc_id + ')');

                                                }
                                                if (val == 2) {
                                                    $('.' + tr_class + '').find('.ads_video_div').css('display', 'block');
                                                    $('.' + tr_class + '').find('.ads_image_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.ads_content_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.add_data_images').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_videos').addClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents_tamil').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_videos').attr('id', 'ads_video' + inc_id + '');
                                                    $('.' + tr_class + '').find('.videoload').attr('id', 'videoload' + inc_id + '');
                                                    $('.' + tr_class + '').find('.videoshow').attr('id', 'videoshow' + inc_id + '');
                                                    $('.' + tr_class + '').find('.add_data_videos').attr('onchange', 'loadImageFileAsURL(' + inc_id + ')');
                                                    $('.' + tr_class + '').find('.ads_postion').val(2);
                                                    $('.' + tr_class + '').find('.ads_postion').attr('readonly', true);

                                                }
                                                if (val == 3) {
                                                    $('.' + tr_class + '').find('.ads_content_div').css('display', 'block');
                                                    $('.' + tr_class + '').find('.ads_image_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.ads_video_div').css('display', 'none');
                                                    $('.' + tr_class + '').find('.add_data_images').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_videos').removeClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents_tamil').addClass('required');
                                                    $('.' + tr_class + '').find('.add_data_contents').addClass('required');
                                                    $('.' + tr_class + '').find('.ads_postion').val(3);
                                                    $('.' + tr_class + '').find('.ads_postion').attr('readonly', true);
                                                    $('.' + tr_class + '').find('.add_data_contents').attr('id', 'ads_content' + inc_id + '');
                                                    $('.' + tr_class + '').find('.add_data_contents_tamil').attr('id', 'ads_content_tamil' + inc_id + '');
                                                    var incid = parseInt(inc_id) - parseInt(1);
                                                    $('.' + tr_class + '').find('.add_data_contents_tamil').attr('name', 'ads_data_tamil[' + incid + ']');
                                                    $('.' + tr_class + '').find('.add_data_contents').attr('name', 'ads_data[' + incid + ']');
                                                }
                                            }
                                        });

                                        $(document).on('keyup', '.ads_sort_order', function () {
                                            var sort_order = $(this).val();
                                            var tr_class = $(this).closest('tr').attr('class');
                                            var test_sortorder = /^\d*$/.test(sort_order)
                                            if (test_sortorder == false) {
                                                $('.' + tr_class + '').find('.sort_order_error').text('Invalid Sort Order').slideDown('500').css('display', 'inline-block');
                                            } else {
                                                $('.' + tr_class + '').find('.sort_order_error').text('').slideUp('500');
                                            }
                                        });
                                        $(document).on('change', '.ads_postion', function () {
                                            var position = $(this).val();
                                            var tr_class = $(this).closest('tr').attr('class');
                                            if (position == '') {
                                                $('.' + tr_class + '').find('.ads_position_error').text('Field is required').slideDown('500').css('display', 'inline-block');
                                            } else {
                                                $('.' + tr_class + '').find('.ads_position_error').text('').slideUp('500');
                                            }
                                        });


                                        $('#add_data').on('click', function () {
                                            ads_content_clone();
                                            var this_val = $(this);
                                        });
                                        $('.submit').click(function () {
                                            m = 0;
                                            var check_required = $('.state_item:checkbox:checked').length;
                                            if (check_required == 0) {
                                                $('.device_zone_error').text('This field is required').slideDown('500').css('display', 'inline-block');
                                                m++;
                                            } else {
                                                $('.device_zone_error').text('').slideUp('500');
                                            }

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


                                        function ads_content_clone() {
                                            var clone_data=$('#static_content').clone();
                                            console.log(clone_data);
                                            $('#pageloader').show();
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/advertisement/addRow/',
                                                method: 'POST',
                                                success: function (data) {
                                                    $('#pageloader').hide();
                                                    $('#add_body').append(data);
                                                    var i = 1;
                                                    $('#add_body tr').each(function () {
                                                        $(this).closest("tr").attr('class', '');
                                                        $(this).closest("tr").attr('data-rowid', i);
                                                        $(this).closest("tr").addClass('ads_row' + i);
                                                        $(this).closest("tr").find('.s_no').html(i);
                                                        $(this).closest("tr").find('.add_data_images').attr('id', 'ads_image' + i + '');
                                                        $(this).closest("tr").find('.add_data_images').attr('onchange', 'loadImageFileAsURL(' + i + ')');
                                                        i++;
                                                    });
                                                    remove_data();

                                                    $('.timepicker').each(function () {
                                                        $(this).datetimepicker({
                                                            pickDate: false
                                                        });
                                                    });
                                                }
                                            });

                                        }
                                        function remove_data() {
                                            $('.remove_data').on('click', function () {
                                                $(this).closest("tr").remove();
                                                var i = 1;
                                                $('#add_body tr').each(function () {
                                                    $(this).closest("tr").attr('class', '');
                                                    $(this).closest("tr").attr('data-rowid', i);
                                                    $(this).closest("tr").addClass('ads_row' + i);
                                                    $(this).closest("tr").find('.s_no').html(i);
                                                    $(this).closest("tr").find('.add_data_images').attr('id', 'ads_image' + i + '');
                                                    $(this).closest("tr").find('.add_data_images').attr('onchange', 'loadImageFileAsURL(' + i + ')');
                                                    i++;
                                                });
                                            });
                                        }
                                        $('.group_section').click(function (e) {
                                            this_ele = $(this);
                                            if (!$(e.target).hasClass('group_item') && !$(e.target).hasClass('group_label')) {
                                                $(this).closest('.group_tree').find('a.group_btn i').toggleClass('fa-plus fa-minus');
                                                this_ele.closest('.group_tree').find('.group_tree_structure').slideToggle(500);
                                            }
                                        });
                                        $('.region_section').click(function (e) {
                                            this_ele = $(this);
                                            if (!$(e.target).hasClass('region_item') && !$(e.target).hasClass('region_label')) {
                                                $(this).closest('.region_tree').find('a.group_btn i').removeClass('fa-minus').addClass('fa-plus');
                                                $(this).closest('.region_tree').find('a.region_btn i').toggleClass('fa-plus fa-minus');
                                                this_ele.closest('.region_tree').find('.group_tree_structure').slideUp(500);
                                                this_ele.closest('.region_tree').find('.region_tree_structure').slideToggle(500);
                                            }
                                        });
                                        $('.state_section').click(function (e) {
                                            this_ele = $(this);
                                            if (!$(e.target).hasClass('state_item') && !$(e.target).hasClass('state_label')) {
                                                $(this).closest('.state_tree').find('a.group_btn i,a.region_btn i').removeClass('fa-minus').addClass('fa-plus');
                                                $(this).closest('.state_tree').find('a.state_btn i').toggleClass('fa-plus fa-minus');
                                                this_ele.closest('.state_tree').find('.region_tree_structure,.group_tree_structure').slideUp(500);
                                                this_ele.closest('.state_tree').find('.state_tree_structure').slideToggle(500);
                                            }
                                        });
                                        $('.state_item').change(function () {
                                            is_checked = $(this).prop('checked');
                                            if (is_checked) {
                                                $(this).closest('.state_tree').find('input[type="checkbox"]').prop('checked', true);
                                                $(this).closest('.state_tree').find('.device_list').addClass("bg-selected-mem");
                                            } else {
                                                $(this).closest('.state_tree').find('input[type="checkbox"]').prop('checked', false);
                                                $(this).closest('.state_tree').find('.device_list').removeClass("bg-selected-mem");
                                            }
                                        });
                                        $('.region_item').change(function () {
                                            is_checked = $(this).prop('checked');
                                            if (is_checked) {
                                                $(this).closest('.region_tree').find('input[type="checkbox"]').prop('checked', true);
                                                $(this).closest('.region_tree').find('.device_list').addClass("bg-selected-mem");
                                            } else {
                                                $(this).closest('.region_tree').find('input[type="checkbox"]').prop('checked', false);
                                                $(this).closest('.region_tree').find('.device_list').removeClass("bg-selected-mem");
                                            }
                                            total_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item').length);
                                            selected_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item:checked').length);
                                            if (selected_streets >= 1) {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', false);
                                            }
                                        });
                                        $('.group_item').change(function () {
                                            is_checked = $(this).prop('checked');
                                            if (is_checked) {
                                                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', true);
                                                $(this).closest('.group_tree').find('.device_list').addClass("bg-selected-mem");
                                            } else {
                                                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', false);
                                                $(this).closest('.group_tree').find('.device_list').removeClass("bg-selected-mem");
                                            }
                                            total_groups = Number($(this).closest('.region_tree_structure').find('input[type="checkbox"].group_item').length);
                                            selected_groups = Number($(this).closest('.region_tree_structure').find('input[type="checkbox"].group_item:checked').length);
                                            if (selected_groups >= 1) {
                                                $(this).closest('.region_tree').find('input[type="checkbox"].region_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.region_tree').find('input[type="checkbox"].region_item').prop('checked', false);
                                            }
                                            total_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item').length);
                                            selected_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item:checked').length);
                                            if (selected_streets >= 1) {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', false);
                                            }
                                        });
                                        $('.device_item').change(function () {
                                            is_checked = $(this).prop('checked');
                                            if (is_checked == true) {
                                                $(this).closest('.device_list').addClass("bg-selected-mem");
                                            } else {
                                                $(this).closest('.device_list').removeClass("bg-selected-mem");
                                            }
                                            total_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]').length);
                                            selected_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]:checked').length);
                                            if (selected_members >= 1) {
                                                $(this).closest('.group_tree').find('input[type="checkbox"].group_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.group_tree').find('input[type="checkbox"].group_item').prop('checked', false);
                                            }
                                            total_groups = Number($(this).closest('.region_tree_structure').find('input[type="checkbox"].group_item').length);
                                            selected_groups = Number($(this).closest('.region_tree_structure').find('input[type="checkbox"].group_item:checked').length);
                                            if (selected_groups >= 1) {
                                                $(this).closest('.region_tree').find('input[type="checkbox"].region_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.region_tree').find('input[type="checkbox"].region_item').prop('checked', false);
                                            }
                                            total_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item').length);
                                            selected_streets = Number($(this).closest('.state_tree_structure').find('input[type="checkbox"].region_item:checked').length);
                                            if (selected_streets >= 1) {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', true);
                                            } else {
                                                $(this).closest('.state_tree').find('input[type="checkbox"].state_item').prop('checked', false);
                                            }
                                        });

                                        $('.event_tree_structure').change(function () {
                                            var total = $('.member_item:checked').size();
                                            $('#mem_count').text(total);
                                        });
                                    });
                                    function isNumber(evt) {
                                        evt = (evt) ? evt : window.event;
                                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                                        if (charCode > 31 && ((charCode != 46 && charCode != 45 && charCode != 43 && charCode < 48) || charCode > 57)) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    }
                                    function get_time_round(time) {
                                        if (time.toString().length == 1)
                                            return time = "0" + time;
                                        else
                                            return time;
                                    }
                                    function loadImageFileAsURL(inc_id) {

                                        var tr_class = '.ads_row' + inc_id + '';
                                        var type = $('' + tr_class + '').find('.adds_file_type').val();
                                        $('' + tr_class + '').find('.adds_file_type_error').text('');

                                        if (type != undefined && type == 1 || type == 2) {

                                            if (type == 1)
                                                var id = "ads_image" + inc_id + '';
                                            if (type == 2)
                                                var id = "ads_video" + inc_id + '';


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

                                                    } else {

                                                        if ($.inArray(file_type, fileExtension) == -1) {
                                                            $('' + tr_class + '').find('.file_error').text('Invalid file format..only allowed:mp4').slideDown('500').css('display', 'inline-block');
                                                            return false;
                                                        } else {

                                                            $('' + tr_class + '').find('.videoshow').attr('src', e.target.result);
                                                            document.getElementById('videoshow' + inc_id + '').src = e.target.result;
                                                            document.getElementById('videoload' + inc_id + '').load();

                                                            var myVideoPlayer = document.getElementById('videoload' + inc_id + '');

                                                            myVideoPlayer.addEventListener('loadedmetadata', function () {
                                                                var duration = Math.round(myVideoPlayer.duration);
                                                                var duration = moment.duration(duration, "seconds");
                                                                var time = "";
                                                                var hours = get_time_round(duration.hours());
                                                                var minutes = get_time_round(duration.minutes());
                                                                var seconds = get_time_round(duration.seconds());
                                                                time = hours + ":" + minutes + ":" + seconds;

                                                                $('' + tr_class + '').find('.ads_duration').val(time);
                                                                $('' + tr_class + '').find('.ads_duration').attr('readonly', true);
                                                            });
                                                        }
                                                    }

                                                }

                                            } else {
                                                $('' + tr_class + '').find('.file_error').text('Please Select file').slideDown('500').css('display', 'inline-block');
                                            }
                                        } else {
                                            if (type != 1 || type != 2)
                                                $('' + tr_class + '').find('.adds_file_type_error').text('Select file Type').slideDown('500').css('display', 'inline-block');
                                        }
                                    }
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('.timepicker').each(function () {

            $(this).datetimepicker({
                pickDate: false
            });
        });

        $('.datetimepicker').each(function () {

            $(this).datetimepicker({
                language: 'pt-BR'
            });
        });
    });
</script>
