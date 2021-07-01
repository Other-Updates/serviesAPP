<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="row">
    <div class="col-sm-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#update-customer" role="tab">Update Customer</a>
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
                        <form class="form-material" method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'customer/update_customer'; ?>">
                            <?php
                            if (isset($customer) && !empty($customer)) {

                                $i = 0;
                                foreach ($customer as $val) {
                                    $i++
                                    ?>
                                    <div class="form-material row">

                                        <input type="hidden" name="id" class="id id_dup form-control form-align" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select id="state_id" name='state_id' class="state_id form-control form-align"   tabindex="1">
                                                        <option value="">Select State</option>
                                                        <?php
                                                        if (isset($all_state) && !empty($all_state)) {
                                                            foreach ($all_state as $bill) {
                                                                ?>
                                                                <option <?= ($bill['id'] == $customer[0]['state_id']) ? 'selected' : '' ?> value="<?= $bill['id'] ?>"><?= $bill['state'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="cuserror" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary">

                                                    <label class="float-label">City</label>
                                                    <input type="text" name="city" id="city"  class="form-control form-align" value="<?= $val['city'] ?>"  tabindex="1"/>
                                                    <span id="cuserror8" class="val text-danger"></span>
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
                                                    <label class="float-label">Company Name <span class="req">*</span></label>
                                                    <input type="text" name="store" class="store form-control form-align" id="store" value="<?= $val['store_name'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror2" class="val text-danger"></span>

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
                                                    <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?= $val['account_num'] ?>"  tabindex="1"/>
                                                    <span id="cuserror11"class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-user"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Contact Person <span class="req">*</span></label>
                                                    <input type="text" name="name" id="name"  class="name form-control form-align" value="<?= $val['name'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror1" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Payment Terms</label>
                                                    <input type="text"  name="payment_terms" class="form-control form-align"  id="payment_terms" value="<?= $val['payment_terms'] ?>"  tabindex="1"/>
                                                    <span id="cuserror14" class="val text-danger"></span>
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
                                                    <input type="text" name="mail" class="mail up_mail_dup form-control form-align" id="mail" value="<?= $val['email_id'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror5" class="val text-danger"></span>
                                                    <span id="upduplica" class="val text-danger"></span>

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
                                                    <input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?= $val['bank_name'] ?>"  tabindex="1"/>
                                                    <span id="cuserror6" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-call"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Mobile Number <span class="req">*</span></label>
                                                    <input type="text" name="number" class="mobile form-control form-align" id="number" value="<?= $val['mobil_number'] ?>" tabindex="1" />
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror4" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-call"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Mobile Number 2</label>
                                                    <input type="text" name="number2" class="phone2 form-control form-align" id="phone2" value="<?= $val['mobile_number_2'] ?>" />
                                                    <span class="form-bar"></span>
                                                    <span id="phone2_err" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-call"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Mobile Number 3</label>
                                                    <input type="text" name="number3" class="phone3 form-control form-align" id="phone3" value="<?= $val['mobile_number_3'] ?>" />
                                                    <span id="phone3_err" class="val text-danger"></span>
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
                                                    <input type="text" name="branch" class="form-control form-align" id="branch" value="<?= $val['bank_branch'] ?>"  tabindex="1"/>
                                                    <span id="cuserror10" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-user"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select id='staff_name'  name="staff_name"  class="form-control form-align"  tabindex="1">
                                                        <option value="">Select Staff Name</option>
                                                        <?php
                                                        if (isset($staff_name) && !empty($staff_name)) {
                                                            foreach ($staff_name as $va1) {
                                                                ?>
                                                                <option <?= ($val['staff_id'] == $va1['id']) ? 'selected' : '' ?> value='<?= $va1['id'] ?>'><?= $va1['name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror12" class="val text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Address1 <span class="req">*</span></label>
                                                    <textarea  name='address1' id="address" class="form-control form-align"  tabindex="1"><?= $val['address1'] ?></textarea>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror3" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Address2 </label>
                                                    <textarea  name='address2' id="address" class="form-control form-align"  tabindex="1"><?= $val['address2'] ?></textarea>
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
                                                    <input type="text" name="ifsc" class="form-control form-align" id="" value="<?= $val['ifsc'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                        <div class="col-md-3">
                                                                                    <div class="material-group">
                                                                                        <div class="material-addone">
                                                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                                                        </div>
                                                                                        <div class="form-group form-primary">
                                                                                            <label class="float-label">Nick Name</label>
                                                                                            <input type="text" name="nick_name" class="form-control form-align" id="nickname" value="<?= $val['nick_name'] ?>" tabindex="1" />
                                                                                            <span id="nick"  class="val text-danger"></span>
                                                                                            <span class="form-bar"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>-->
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-briefcase-alt-1"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Password <span class="req">*</span></label>
                                                    <input type="password" name="password" class=" form-control " autocomplete="off"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class=""></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label" >GSTIN No</label>
                                                    <input  type="text" class="form-control form-align"   name="tin" id="tin" value="<?= $val['tin'] ?>"/>
                                                    <span id="cuserror15" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="edit" tabindex="1"/>
                                            <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'customer/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
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
    $('#state_id').live('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
        } else
        {
            $('#cuserror').html("");
        }
    });
//    $("#nickname").live('blur', function ()
//    {
//        var nick_name = $("#nickname").val();
//        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
//        {
//            $("#nick").html("Required Field");
//        } else
//        {
//            $("#nick").html("");
//        }
//    });

    $('.state_id').live('blur', function ()
    {
        var state = $('.state_id').val();
        if (state == "37")
        {
            $('#cuserror').html('<input type="text" name="state_id" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
                <span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');
        }
    });

    $('#state').live('blur', function () {

        var this_ = $(this).val();
        if (this_ == "")
        {
            $('#cuserror_state').html("Required Field");
        } else
        {
            $('#cuserror_state').html("");
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "customer/add_state",
                data: {state: this_},
                success: function (datas) {

                }
            });
        }

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
    $("#store").live('blur', function ()
    {
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
        } else
        {
            $("#cuserror2").html("");
        }
    });
    $('input[name!="mail"], textarea').live('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });
    /* $('#address').live('blur', function ()
     {
     var address = $('#address').val();
     if (address == "" || address == null || address.trim().length == 0)
     {
     $('#cuserror3').html("Enter Address");
     } else
     {
     $('#cuserror3').html("");
     }
     });
     $("#mobile").live('blur', function ()
     {
     var number = $("#mobile").val();
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
     $('#bank').live('blur', function ()
     {
     var bank = $('#bank').val();
     if (bank == "" || bank == null || bank.trim().length == 0)
     {
     $('#cuserror6').html("Enter Details");
     } else
     {
     $('#cuserror6').html("");
     }
     });
     $('#percent').live('blur', function ()
     {
     var percentage = $('#percent').val();
     var pefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
     if (percentage == "" || percentage == null || percentage.trim().length == 0)
     {
     $('#cuserror7').html("Required Field");
     } else if (!pefilter.test(percentage))
     {
     $("#cuserror7").html("Enter Valid Percentage");
     } else
     {
     $('#cuserror7').html("");
     }
     });
     $('#city').live('blur', function ()
     {
     var city = $('#city').val();
     if (city == "")
     {
     $('#cuserror8').html("Required Field");
     } else
     {
     $('#cuserror8').html("");
     }
     });
     $("#pincode").live('blur', function ()
     {
     var pincode = $("#pincode").val();
     if (pincode == "")
     {
     $("#cuserror9").html("Required Field");
     } else if (pincode.length != 6)
     {
     $("#cuserror9").html("Maximum 6 characters");
     } else
     {
     $("#cuserror9").html("");
     }
     });
     $("#branch").live('blur', function ()
     {
     var branch = $("#branch").val();
     if (branch == "" || branch == null || branch.trim().length == 0)
     {
     $("#cuserror10").html("Required Field");
     } else
     {
     $("#cuserror10").html("");
     }
     });
     $("#acnum").live('blur', function ()
     {
     var acnum = $("#acnum").val();
     var acfilter = /^[a-zA-Z0-9]+$/;
     if (acnum == "")
     {
     $("#cuserror11").html("Required Field");
     } else if (!acfilter.test(acnum))
     {
     $("#cuserror11").html("Numeric or Alphanumeric");
     } else
     {
     $("#cuserror11").html("");
     }
     });*/
    $('#staff_name').live('change', function ()
    {
        var staff_name = $('#staff_name').val();
        if (staff_name == "")
        {
            $('#cuserror12').html("Required Field");
        } else
        {
            $('#cuserror12').html("");
        }
    });
    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "") {
            $("#cuserror5").html("Required Field");
        } else if (mail != "" && !efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
        } else
        {
            $("#cuserror5").html("");
        }
    });
    $('#address').on('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Enter Address");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#cuserror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
        } else if (number != "") {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val()), id: $('.id').val()},
                url: '<?php echo base_url(); ?>customer/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#cuserror4").html('This Mobile Number is already taken');
                    } else {
                        $("#cuserror4").html('');
                    }
                }
            });
        } else
        {
            $("#cuserror4").html("");
        }
    });
    $("#phone2").live('blur', function ()
    {
        var number = $("#phone2").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "")
        {
            if (!nfilter.test(number))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
        }
    });
    $("#phone3").live('blur', function ()
    {
        var number = $("#phone3").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "")
        {
            if (!nfilter.test(number))
            {
                $("#phone3_err").html("Enter Valid Mobile Number");
            } else
            {
                $("#phone3_err").html("");
            }
        } else {
            $("#phone3_err").html("");
        }
    });
    $('#agent_comm').live('blur', function ()
    {
        var agent_comm = $('#agent_comm').val();
        var apefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
        if (agent_comm == "" || agent_comm == null || agent_comm.trim().length == 0)
        {
            $('#cuserror13').html("Required Field");
        } else if (!apefilter.test(agent_comm))
        {
            $("#cuserror13").html("Enter Valid Percentage");
        } else
        {
            $('#cuserror13').html("");
        }
    });
    /* $("#payment_terms").live('blur', function ()
     {
     var payment_terms = $("#payment_terms").val();

     if (payment_terms == "")
     {
     $("#cuserror14").html("Required Field");
     } else
     {
     $("#cuserror14").html("");
     }
     });
     $('#tin').live('blur', function ()
     {
     var tin = $('#tin').val();
     if (tin == "" || tin == null || tin.trim().length == 0)
     {
     $('#cuserror15').html("Required Field");
     } else
     {
     $('#cuserror15').html("");
     }
     });
     $('#c_cst').live('blur', function ()
     {
     var cst = $('#c_cst').val();
     if (cst == "")
     {
     $("#c_cst").css('border-color', 'red');
     } else
     {
     $("#c_cst").css('border-color', '');
     }
     });
     $('#c_vat').live('blur', function ()
     {
     var vat = $('#c_vat').val();
     if (vat == "")
     {
     $("#c_vat").css('border-color', 'red');
     } else
     {
     $("#c_vat").css('border-color', '');
     }
     });*/
    $('#reset').live('click', function ()
    {
        $('.val').html("");
    })
</script>
<script type="text/javascript">
    $('#edit').live('click', function ()
    {
        var i = 0;
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
            i = 1;
        } else
        {
            $('#cuserror').html("");
        }
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
            i = 1;
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#cuserror1").html("");
        }
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror2").html("");
        }
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "") {
            $("#cuserror5").html("Required Field");
            i = 1;
        } else if (mail != "" && !efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
            i = 1;
        } else
        {
            $("#cuserror5").html("");
        }

        /* var address = $('#address').val();
         if (address == "" || address == null || address.trim().length == 0)
         {
         $('#cuserror3').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror3').html("");
         }
         var number = $("#number").val();
         var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
         if (number == "")
         {
         $("#cuserror4").html("Required Field");
         i = 1;
         } else if (!nfilter.test(number))
         {
         $("#cuserror4").html("Enter Valid Mobile Number");
         i = 1;
         } else
         {
         $("#cuserror4").html("");
         }
         var mail = $("#mail").val();
         var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if (mail == "")
         {
         $("#cuserror5").html("Required Field");
         i = 1;
         } else if (!efilter.test(mail))
         {
         $("#cuserror5").html("Enter Valid Email");
         i = 1;
         } else
         {
         $("#cuserror5").html("");
         }
         var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#cuserror6').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror6').html("");
         }
         var city = $('#city').val();
         if (city == "")
         {
         $('#cuserror8').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror8').html("");
         }
         var percentage=$('#percentage').val();
         var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
         if(percentage=="" || percentage==null || percentage.trim().length==0)
         {
         $('#cuserror7').html("Required Field");
         i=1;
         }
         else if(!pefilter.test(percentage))
         {
         $("#cuserror7").html("Enter Valid Percentage");
         i=1;
         }
         else
         {
         $('#cuserror7').html("");
         }

         var pincode=$("#pincode").val();
         if(pincode=="")
         {
         $("#cuserror9").html("Required Field");
         i=1;
         }
         else if (pincode.length!=6)
         {
         $("#cuserror9").html("Maximum 6 characters");
         i=1;
         }
         else
         {
         $("#cuserror9").html("");
         }
         var branch = $("#branch").val();
         if (branch == "" || branch == null || branch.trim().length == 0)
         {
         $("#cuserror10").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror10").html("");
         }
         var acnum = $("#acnum").val();
         var acfilter = /^[a-zA-Z0-9]+$/;
         if (acnum == "")
         {
         $("#cuserror11").html("Required Field");
         i = 1;
         } else if (!acfilter.test(acnum))
         {
         $("#cuserror11").html("Numeric or Alphanumeric");
         i = 1;
         } else
         {
         $("#cuserror11").html("");
         }*/
        var staff_name = $('#staff_name').val();
        if (staff_name == "")
        {
            $('#cuserror12').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror12').html("");
        }
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Enter Address");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
        }
//        var nick_name = $("#nickname").val();
//        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
//        {
//            $("#nick").html("Required Field");
//            i = 1;
//        } else
//        {
//            $("#nick").html("");
//        }
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#cuserror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
            i = 1;
        } else if (number != "") {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val()), id: $('.id').val()},
                url: '<?php echo base_url(); ?>customer/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#cuserror4").html('This Mobile Number is already taken');
                        i = 1;
                    } else {
                        $("#cuserror4").html('');
                    }
                }
            });
        } else
        {
            $("#cuserror4").html("");
        }

        var phone2 = $("#phone2").val();
        if (phone2 != "")
        {
            if (!nfilter.test(phone2))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
                i = 1;
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
        }
        var phone3 = $("#phone3").val();
        if (phone3 != "")
        {
            if (!nfilter.test(phone3))
            {
                $("#phone3_err").html("Enter Valid Mobile Number");
                i = 1;
            } else
            {
                $("#phone3_err").html("");
            }
        } else {
            $("#phone3_err").html("");
        }

        /* var agent_comm = $('#agent_comm').val();
         var apefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
         if (agent_comm == "" || agent_comm == null || agent_comm.trim().length == 0)
         {
         $('#cuserror13').html("Required Field");
         i = 1;
         } else if (!apefilter.test(agent_comm))
         {
         $("#cuserror13").html("Enter Valid Percentage");
         i = 1;
         } else
         {
         $('#cuserror13').html("");
         }
         var payment_terms = $("#payment_terms").val();

         if (payment_terms == "")
         {
         $("#cuserror14").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror14").html("");
         }
         var tin = $('#tin_vat').val();
         if (tin == "" || tin == null || tin.trim().length == 0)
         {
         $('#cuserror15').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror15').html("");
         }
         var cst=$('#c_cst').val();
         if(cst=="")
         {
         $("#c_cst").css('border-color','red');
         i=1;
         }
         else
         {
         $("#c_cst").css('border-color','');
         }
         var vat=$('#c_vat').val();
         if(vat=="")
         {
         $("#c_vat").css('border-color','red');
         i=1;
         }
         else
         {
         $("#c_vat").css('border-color','');
         }
         */

        var mess = $('#upduplica').html();
        if ((mess.trim()).length > 0)
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
</script>
<script>
    $("#mail").live('blur', function ()
    {
        //var fit=$(this).parent().parent().find('.up_fit').val();
        //var id=$(this).offsetParent().find('.id_dup').val();
        //var message=$(this).offsetParent().find('.upduplica');
        mail = $("#mail").val();
        id = $('.id').val();
        if (mail != "") {
            $.ajax({
                url: BASE_URL + "customer/update_duplicate_email",
                type: 'POST',
                data: {value1: mail, value2: id},
                success: function (result)
                {
                    $("#upduplica").html(result);
                }
            });
        } else {
            $("#upduplica").html("");
        }
    });
</script>
