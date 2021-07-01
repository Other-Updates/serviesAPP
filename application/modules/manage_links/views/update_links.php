<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    a:focus, a:hover {
        color: #fff;
    }
    .addstbl, .addstbl tr th, .addstbl tr td{border:1px solid #ccc;}
    .addstbl tr th{font-weight:bold;}
    .error_msg {
        font-size: 13px;
        color: #ff5252 !important;
        text-align: left;
    }
    #delete_group, #add_data, #delete_label {
        color: #fff;
    }
    #add_quotation .form-control {
        font-size: 12px !important;
        border-radius: 2px !important;
        border: 1px solid #cccccc !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-3">
                    <a class="nav-link active" data-toggle="tab" href="#update-links" role="tab">Update Links</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-links" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update Link</h5>
                    </div>
                    <div class="card-block">
                        <table class="static1" style="display:none">
                            <tr>
                                <td style="text-align:right;font-weight:bold;"><input type="text" name="link_name[]" tabindex="-1" class="link_name form-control " ><span class="error_msg"></span></td>
                                <td> <input name="description[]" class="description form-control"><span class="error_msg"></span></td>
                                <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                            </tr>
                        </table>
                        <form class="" method="post"  name="form1" action="<?php echo $this->config->item('base_url') . 'manage_links/edit/' . $links_details[0]['id']; ?>" enctype="multipart/form-data" >
                            <?php
                            if (isset($links_details) && !empty($links_details)) {
                                $i = 0;
                                foreach ($links_details as $val) {
                                    $i++
                                    ?>
                                    <div class="form-material row">
                                        <div class="col-md-6">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <input type="text" name="link[name]" class="form-control required" id="link_name"  value="<?php echo ucfirst($links_details[0]['name']); ?>"/>
                                                    <label class="float-label">Link Name</label>

                                                    <span class="form-bar"></span>
                                                    <span class="error_msg"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary ">
                                                    <select name="link[status]" class="form-control">
                                                        <option value="1" <?php if ($links_details[0]['status'] == 1) echo "selected"; ?>>Active</option>
                                                        <option value="0" <?php if ($links_details[0]['status'] == 0) echo "selected"; ?>>Inactive</option>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                        <div class="col-lg-12">
                                            <label><strong>Link Details:</strong></label><span class="req">*</span>
                                            <table class="addstbl" id="add_quotation">
                                                <thead id="add_header">
                                                <th width="3%" class="first_td1">Link Data</th>
                                                <th width="3%" class="first_td1">Link Description</th>
                                                <th width="1%" class="action-btn-align" style="text-align:center;"><a id='add_data' data-type="0" class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus" style="color:white;"></span> </a></th>
                                                </thead>
                                                <tbody id="add_body">
                                                    <?php foreach ($val['link_datas'] as $key => $valu) {
                                                        ?>
                                                        <tr>
                                                            <td style="text-align:right;font-weight:bold;"><input type="text" name="link_name[]" tabindex="-1" class="link_name form-control required" value="<?php echo $valu['link_data']; ?>" ><span class="error_msg"></span></td>
                                                            <td><input type="text"name="description[]" tabindex="-1" class="description form-control required" value="<?php echo $valu['description']; ?>" ><span class="error_msg"></span></td>
                                                            <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini waves-effect waves-light"><span class="fa fa-trash"></span></a></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group row text-center m-10 col-md-12">
                                            <div class="col-md-12 text-center">
                                                <input type="submit" id="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="edit" tabindex="1"/>
                                                <a href="<?php echo $this->config->item('base_url') . 'manage_links/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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


    $(document).ready(function () {
        $('#submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_class = $(this).attr('class');
                this_ele = $(this);
                if (this_val == '') {

                    $(this).closest('div.form-group').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }

            });
            $('#add_quotation .required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr("id");
                if (this_val == "") {
                    $(this).closest('td').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                    m++;
                } else {
                    $(this).closest('td').find('.error_msg').text('');
                }
            });

            if (m > 0)
                return false;
        });
    });

    $('#add_data').click(function () {
        var tables = $(".static1").find('tr:last').clone();
        $(tables).closest('tr').find('.link_name').addClass('required');
        $('#add_body').append(tables);

    });
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
    });
</script>