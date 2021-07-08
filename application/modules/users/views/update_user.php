<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
    <div class="contentpanel">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                        <li class="nav-item col-md-2">
                            <a class="nav-link active" data-toggle="tab" href="#update-user" role="tab">Update User</a>
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
                                <form class="form-material" method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'users/update_user'; ?>">
                                    <?php
                                    if (isset($agent) && !empty($agent)) {
                                        $i = 0;
                                        foreach ($agent as $val) {
                                            $i++
                                            ?>
                                            <div class="form-material row">
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-building-alt"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">User ID</label>
                                                            <input type="text" name="user_code" value="<?php echo $val["emp_code"]; ?>" class=" form-control" id="user_code" readonly tabindex="1"/>
                                                            <span class="form-bar"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Name <span class="req">*</span></label>
                                                            <input type="text" name="name" id="name"  class="name form-control form-align uppercase_class" value="<?= $val['name'] ?>"  tabindex="1"/>
                                                            <input type="hidden" name="id" class="id id_dup form-control" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                                            <span class="form-bar"></span>
                                                            <span id="cuserror1" class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Nick Name <span class="req">*</span></label>
                                                            <input type="text" name="nick_name" class="form-control form-align uppercase_class" id="nickname" value="<?= $val['nick_name'] ?>" tabindex="1" />
                                                            <span class="form-bar"></span>
                                                            <span id="nick"  class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">User Name</label>
                                                            <input type="text" name="username" class="mail form-control form-align uppercase_class" id="username" value="<?= $val['username'] ?>"  tabindex="1"/>
                                                            <span id="cuserror8" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-material row">
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Password <span class="req">*</span></label>
                                                            <input type="password" name="pass" class="mail form-control form-align" autocomplete="off"  tabindex="1"/>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-ui-call"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Mobile Number <span class="req">*</span></label>
                                                            <input type="text" name="number" class="number form-control form-align" id="number" value="<?= $val['mobile_no'] ?>"  tabindex="1"/>
                                                            <span class="form-bar"></span>
                                                            <span id="cuserror4" class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-address-book"></i>
                                                        </div>
                                                        <div class="form-group form-primary">

                                                            <select name="role" class="form-control form-align" id="role"  tabindex="1">
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
                                                            <span id="cuserror6" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-email"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Email Id <span class="req">*</span></label>
                                                            <input type="text" name="mail" class="mail form-control email_dup form-align" id="mail" value="<?= $val['email_id'] ?>"  tabindex="1"/>
                                                            <span class="form-bar"></span>
                                                            <span id="cuserror5" class="val text-danger"></span>
                                                            <span id="upduplica" class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-location-pin"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Address <span class="req">*</span></label>

                                                            <textarea name="address1" id="address" class="form-control form-align uppercase_class"  tabindex="1"><?php echo $val['address']; ?></textarea>
                                                            
                                                            <span id="cuserror3" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">ID Proof No: <span class="req">*</span></label>
                                                            <input type="text" name="id_proof_no" class="id_proof_no form-control uppercase_class" value="<?= $val['id_proof_no'] ?>" id="id_proof_no" tabindex="1" />
                                                            <span id="id_proof_no_err" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">ID Proof Type: <span class="req">*</span></label>
                                                            <input type="text" name="id_proof_type" class="id_proof_type form-control uppercase_class"  value="<?= $val['id_proof_type'] ?>" tabindex="1" id="id_proof_type" />
                                                            <span id="id_proof_type_err" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-address-book"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Account No</label>
                                                            <input type="text" name="acnum" class="form-control form-align uppercase_class" id="acnum" value="<?= $val['account_num'] ?>"  tabindex="1"/>
                                                            <span id="cuserror11"class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-bank"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Bank Name</label>
                                                            <input type="text" name="bank" class="bank form-control form-align uppercase_class" id="bank" value="<?= $val['bank_name'] ?>"  tabindex="1"/>
                                                            <span id="cuserror6" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-bank-alt"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Bank Branch</label>
                                                            <input type="text" name="branch" class="form-control form-align uppercase_class" id="branch" value="<?= $val['bank_branch'] ?>"  tabindex="1"/>
                                                            <span id="cuserror10" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-bank"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">IFSC Code</label>
                                                            <input type="text" name="ifsc" class="form-control form-align uppercase_class" id="" value="<?= $val['ifsc'] ?>"  tabindex="1"/>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="row">
                                                        <div class="col-md-12 new-style-form">
                                                            <span class="help-block">ID Proof Photo <span class="req">*</span></span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?php if ($val['signature'] != '') { ?>
                                                                <img id="blah" src="<?= $this->config->item("base_url") . 'attachement/sign/' . $val['signature']; ?>" class="img-40 add_staff_thumbnail" alt="">
                                                            <?php } else { ?>
                                                                <img id="blah" src="<?= $this->config->item("base_url") . 'attachement/sign/no-img.gif' ?>" class="img-40 add_staff_thumbnail" alt="">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-10 adminprofile">
                                                            <input type="file" name="signature" class=" imgInp form-control email_dup " id="signature" tabindex="1"/>
                                                        </div>
                                                    </div>
                                                    <span id="sign" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="form-group row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" name="submit" class="btn hor-grd btn-grd-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                            <input type="reset" value="Clear" class="btn hor-grd btn-grd-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'users/' ?>" class="btn btn-grd-inverse btn-sm waves-effect hor-grd waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
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
            var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
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
        $('.uppercase_class').live('keyup', function () {

            this_val = $(this).val();
            value = this_val.toUpperCase();
            $(this).val(value);

        });

        $('#edit').live('click', function ()
        {
            var m = 0;
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
            var id_proof_no = $('#id_proof_no').val();
            if (id_proof_no == "" || id_proof_no == null || id_proof_no.trim().length == 0)
            {
                $('#id_proof_no_err').html("Required Field");
                i = 1;
            } else
            {
                $('#id_proof_no_err').html("");
            }
            var id_proof_type = $('#id_proof_type').val();
            if (id_proof_type == "" || id_proof_type == null || id_proof_type.trim().length == 0)
            {
                $('#id_proof_type_err').html("Required Field");
                i = 1;
            } else
            {
                $('#id_proof_type_err').html("");
            }

            var number = $("#number").val();
            var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
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
            $.ajax(
                    {
                        url: BASE_URL + "users/add_duplicate_email",
                        type: 'get',
                        data: {value1: email},
                        success: function (result)
                        {
                            $("#duplica").html(result);
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
                            Do You Want In-Active This user?<strong><?= $val['name']; ?></strong>
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
</div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "users/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>