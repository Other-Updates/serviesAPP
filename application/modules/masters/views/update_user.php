<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/select2/select2.min.css">
<style type="text/css">
    .select2-container { border:0px #fff solid; }
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel">
        <div class="media">
            <h4>Update User</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#update-user" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="update-user">
                        <!--  <h4 align="center" class="sup-align">Update Supplier</h4>-->
                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'masters/users/update_user'; ?>">
                            <?php
                            if (isset($agent) && !empty($agent)) {
                                $i = 0;
                                foreach ($agent as $val) {
                                    $i++
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Firm Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="firm_id[]" multiple="" class="form-align required select2" id="firm" tabindex="1">
                                                        <?php
                                                        $firm_id = array();
                                                        if (isset($firms) && !empty($firms)) {
                                                            $firm_id = array_column($val['firm'], 'firm_id');
                                                            foreach ($firms as $firm) {
                                                                $select = (in_array($firm['firm_id'], $firm_id)) ? 'selected' : '';
                                                                ?>
                                                                <option value="<?php echo $firm['firm_id']; ?>" <?php echo $select; ?> > <?php echo $firm['firm_name']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="name" id="name"  class="name form-align" value="<?= $val['name'] ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" class="id id_dup form-control" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                                    <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">User Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="username" class="form-align" id="username" value="<?php echo $val['username']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                    <span id="duplica_user" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Password <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="password" name="pass" class="form-align" autocomplete="off" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Nick Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="nick_name" class=" form-align" id="nickname" value="<?php echo $val['nick_name']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <span id="nick" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="number" class="number form-align" id="number" value="<?php echo $val['mobile_no']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                    </div>
                                                    <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Role <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="role" class="form-control form-align" id="role" tabindex="1">
                                                        <?php
                                                        if (isset($user) && !empty($user)) {
                                                            foreach ($user as $users) {
                                                                ?>
                                                                <option value="<?php echo $users['id']; ?> " <?php echo ($users['id'] == $val['role']) ? 'selected' : ''; ?>> <?php echo $users['user_role']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                    <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Email Id <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="mail" class="mail email_dup form-align" id="mail" value="<?= $val['email_id'] ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </div>
                                                    </div>
                                                    <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                    <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <textarea name="address1" id="address" class="form-control form-align" tabindex="1"><?php echo $val['address']; ?></textarea>
                                                    <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Signature <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <?php
                                                            $thumbnail = $this->config->item('base_url') . 'attachement/sign/no-img.gif';
                                                            if (file_exists(base_url() . 'attachement/sign/' . $val['signature'])) {
                                                                $thumbnail = $this->config->item('base_url') . 'attachement/sign/' . $val['signature'];
                                                            }
                                                            ?>
                                                            <img id="blah" class="add_staff_thumbnail" width="32px" height="33px" src="<?php echo $thumbnail; ?>" tabindex="1"/>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="file" name="signature" class="margin0 imgInp form-control email_dup form-align" id="signature" tabindex="1"/>
                                                            <span id="sign" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>

                            <div class="frameset_table action-btn-align">
                                <input type="submit" value="Update" class="submit btn btn-info1" id="edit" tabindex="1"/>
                                <input type="reset" value="Clear" class="submit btn btn-danger1" id="reset" tabindex="1"/>
                                <a href="<?php echo $this->config->item('base_url') . 'masters/users/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

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

    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#cuserror1").html("");
        }
    });
    $("#username").live('blur', function ()
    {
        var store = $("#username").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
        } else
        {
            $("#cuserror8").html("");
        }
    });
    $("#nickname").live('blur', function ()
    {
        var nick_name = $("#nickname").val();
        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
        {
            $("#nick").html("Required Field");
        } else
        {
            $("#nick").html("");
        }
    });

    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
        } else
        {
            $("#cuserror4").html("");
        }
    });
    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
        } else
        {
            $("#cuserror5").html("");
        }
    });
    $('#role').live('blur', function ()
    {
        var bank = $('#role').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror6').html("Required Field");
        } else
        {
            $('#cuserror6').html("");
        }
    });

    $('#edit').live('click', function ()
    {
        var m = 0;

        $('select.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr('id');

            if (this_val == '') {
                $('#cuserror9').text('Required Field');
                m = 1;
            } else {
                $('#cuserror9').text('');

            }
        });

        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
            m = 1;
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
            m = 1;
        } else
        {
            $("#cuserror1").html("");
        }

        var user_name = $("#username").val();
        if (user_name == "" || user_name == null || user_name.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
            m = 1;
        } else
        {
            $("#cuserror8").html("");
        }


        var nick_name = $("#nickname").val();
        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
        {
            $("#nick").html("Required Field");
            m = 1;
        } else
        {
            $("#nick").html("");
        }

        var number = $("#number").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
            m = 1;
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
            m = 1;
        } else
        {
            $("#cuserror4").html("");
        }

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
            m = 1;
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
            m = 1;
        } else
        {
            $("#cuserror5").html("");
        }
        var bank = $('#role').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror6').html("Required Field");
            m = 1;
        } else
        {
            $('#cuserror6').html("");
        }

        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
            m = 1;
        } else
        {
            $('#cuserror3').html("");
        }
        var mess = $('#duplica').html();
        if ((mess.trim()).length > 0)
        {
            m = 1;
        }

        var user = $('#duplica_user').html();
        if ((user.trim()).length > 0)
        {
            m = 1;
        }

        if (m == 1)
        {

            return false;
        } else
        {
            return true;
        }

    });


</script>
<script>
    $(".email_dup").live('blur', function ()
    {
        email = $("#mail").val();
        id_dup = $(".id_dup").val();

        $.ajax(
                {
                    url: BASE_URL + "masters/users/update_duplicate_email",
                    type: 'post',
                    data: {value1: email, value2: id_dup},
                    success: function (result)
                    {
                        $("#duplica").html(result);
                    }
                });
    });
    $("#username").live('blur', function ()
    {
        email = $("#username").val();
        id_dup = $(".id_dup").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/users/update_duplicate_user",
                    type: 'post',
                    data: {value1: email, value2: id_dup},
                    success: function (result)
                    {
                        $("#duplica_user").html(result);
                    }
                });
    });
</script>



<?php
if (isset($agent) && !empty($agent)) {
    foreach ($agent as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This user?<strong><?php echo $val['name']; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#firm').select2();
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "masters/users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "masters/users/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>