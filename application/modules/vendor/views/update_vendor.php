<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    a:focus, a:hover {
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#update-supplier" role="tab">Update Vendor</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-supplier" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update List</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" method="post"  name="form1" action="<?php echo $this->config->item('base_url') . 'vendor/update_vendor'; ?>">

                            <?php
                            if (isset($vendor) && !empty($vendor)) {
                                $i = 0;
                                foreach ($vendor as $val) {
                                    $i++
                                    ?>


                                    <div class="form-material row">
                                        <div class="col-md-3">

                                            <input type="hidden" name="id" class="id form-control" value="<?php echo $val['id']; ?>" />
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select id="state_id" name='state_id' class="state_id form-control form-align" tabindex="1">
                                                        <option value="">Select State</option>
                                                        <?php
                                                        if (isset($all_state) && !empty($all_state)) {
                                                            foreach ($all_state as $bill) {
                                                                ?>
                                                                <option <?= ($bill['id'] == $vendor[0]['state_id']) ? 'selected' : '' ?> value="<?= $bill['id'] ?>"><?= $bill['state'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="superror" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-building-alt"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <input type="text" name="city" class="form-control form-align" id="city" value="<?= $val['city'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror7" class="val text-danger"></span>

                                                    <label class="float-label">City</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-briefcase-alt-1"></i>
                                                </div>
                                                <div class="form-group form-primary">

                                                    <input type="text" name="store" class="store form-control form-align" id="store" value="<?= $val['store_name'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror2" class="val text-danger"></span>

                                                    <label class="float-label">Company Name <span class="req">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?= $val['account_num'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror10" class="val text-danger"></span>

                                                    <label class="float-label">Account No</label>
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
                                                    <input type="text" name="number" class="mobile form-control form-align" id="number" value="<?= $val['mobil_number'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror4" class="val text-danger"></span>
                                                    <label class="float-label">Mobile Number <span class="req">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-call"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <input type="text" name="number2" class="phone2 form-control form-align" value="<?= $val['mobile_number_2'] ?>" id="phone2"/>
                                                    <span class="form-bar"></span>
                                                    <span id="phone2_err" class="val text-danger" ></span>

                                                    <label class="float-label">Mobile Number 2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-ui-call"></i>
                                                </div>
                                                <div class="form-group form-primary">

                                                    <input type="text" name="number3" class="phone3 form-control form-align" value="<?= $val['mobile_number_3'] ?>" id="phone3" />
                                                    <span class="form-bar"></span>
                                                    <span id="phone3_err" class="val text-danger"></span>

                                                    <label class="float-label">Mobile Number 3</label>
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
                                                    <span class="form-bar"></span>
                                                    <span id="superror6" class="val text-danger"></span>

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
                                                    <span id="superror1" class="val text-danger"></span>

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
                                                    <input type="text" name="payment_terms" class="mobile form-control form-align" id="payment_terms" value="<?= $val['payment_terms'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror11" class="val text-danger"></span>

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
                                                    <input type="text" name="mail" class="mail form-control form-align" id="mail" value="<?= $val['email_id'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror5" class="val text-danger"></span>
                                                    <span id="upduplica" class="val text-danger"></span>

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
                                                    <span class="form-bar"></span>
                                                    <span id="superror9" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Address1 <span class="req">*</span></label>
                                                    <textarea  name='address1' id="address" class="form-control form-align"  tabindex="1"><?= $val['address1'] ?></textarea>
                                                    <span class="form-bar"></span>
                                                    <span id="superror3" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Address2</label>
                                                    <textarea  name='address2' id="" class="form-control form-align"  tabindex="1"><?= $val['address2'] ?></textarea>
                                                    <span class="form-bar"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-location-pin"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Pin Code</label>
                                                    <input type="text" name="pin" class="form-control form-align" id="pincode" value="<?= $val['pincode'] ?>"  tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="superror8" class="val text-danger"></span>

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
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-briefcase-alt-1"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Nick Name <span class="req">*</span></label>
                                                    <input type="text" name="nick_name" class="form-control form-align" id="nickname" value="<?= $val['nick_name'] ?>" tabindex="1" />
                                                    <span class="form-bar"></span>
                                                    <span id="nick"  class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class=""></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">GSTIN No</label>
                                                    <input  type="text" name="tin" class="mobile form-control form-align" id="tin" value="<?= $val['tin'] ?>" />
                                                    <span class="form-bar"></span>
                                                    <span id="superror12" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Update" id="edit" tabindex="1"/>
                                            <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'vendor/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
    $('#reset').live('click', function () {
        $('.val').html("");
    });
    $('#state_id').live('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').html("Select State");
        } else
        {
            $('#superror').html("");
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
    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#superror1").html("Required Field");
        } else if (!filter.test(name))
        {
            $("#superror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#superror1").html("");
        }
    });
    $("#store").live('blur', function ()
    {
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").html("Required Field");
        } else
        {
            $("#superror2").html("");
        }
    });
    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").html("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#superror5").html("Enter Valid Email");
        } else
        {
            $("#superror5").html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#superror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#superror4").html("Enter Valid Mobile Number");
        } else if (number != '') {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val()), id: $('.id').val()},
                url: '<?php echo base_url(); ?>vendor/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#superror4").html('This Mobile Number is already taken');
                    } else {
                        $("#superror4").html('');
                    }
                }
            });
        } else
        {
            $("#superror4").html("");
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
    $('input[name!="mail"], textarea').live('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });
    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').html("Enter Address");
        } else
        {
            $('#superror3').html("");
        }
    });
    /*
     $("#mobile").live('blur', function ()
     {
     var number = $("#mobile").val();
     var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
     if (number == "")
     {
     $("#superror4").html("Required Field");
     } else if (!nfilter.test(number))
     {
     $("#superror4").html("Enter valid Mobile Number");
     } else
     {
     $("#superror4").html("");
     }
     });
     $("#mail").live('blur', function ()
     {
     var mail = $("#mail").val();
     var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
     if (mail == "")
     {
     $("#superror5").html("Required Field");
     } else if (!efilter.test(mail))
     {
     $("#superror5").html("Enter Valid Email");
     } else
     {
     $("#superror5").html("");
     }
     });
     $('#bank').live('blur', function ()
     {
     var bank = $('#bank').val();
     if (bank == "" || bank == null || bank.trim().length == 0)
     {
     $('#superror6').html("Enter Details");
     } else
     {
     $('#superror6').html("");
     }
     });
     $('#city').live('blur', function ()
     {
     var city = $('#city').val();
     if (city == "" || city == null || city.trim().length == 0)
     {
     $('#superror7').html("Required Field");
     } else
     {
     $('#superror7').html("");
     }
     });
     $("#pincode").live('blur', function ()
     {
     var pincode = $("#pincode").val();
     if (pincode == "")
     {
     $("#superror8").html("Required Field");
     } else if (pincode.length != 6)
     {
     $("#superror8").html("Maximum 6 Numbers");
     } else
     {
     $("#superror8").html("");
     }
     });
     $("#branch").live('blur', function ()
     {
     var branch = $("#branch").val();
     if (branch == "" || branch == null || branch.trim().length == 0)
     {
     $("#superror9").html("Required Field");
     } else
     {
     $("#superror9").html("");
     }
     });
     $("#acnum").live('blur', function ()
     {
     var acnum = $("#acnum").val();
     var acfilter = /^[a-zA-Z0-9]+$/;
     if (acnum == "")
     {
     $("#superror10").html("Required Field");
     } else if (!acfilter.test(acnum))
     {
     $("#superror10").html("Numeric or Alphanumeric");
     } else
     {
     $("#superror10").html("");
     }
     });
     $("#payment_terms").live('blur', function ()
     {
     var payment_terms = $("#payment_terms").val();

     if (payment_terms == "")
     {
     $("#superror11").html("Required Field");
     } else
     {
     $("#superror11").html("");
     }
     });*/
    /* $('#tin').live('blur', function ()
     {
     var tin = $('#tin').val();
     if (tin == "" || tin == null || tin.trim().length == 0)
     {
     $('#superror12').html("Required Field");
     } else
     {
     $('#superror12').html("");
     }
     });*/
</script>
<script type="text/javascript">
    $('#edit').live('click', function ()
    {
        var i = 0;
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').html("Select State");
            i = 1;
        } else
        {
            $('#superror').html("");
        }
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#superror1").html("Required Field");
            i = 1;
        } else if (!filter.test(name))
        {
            $("#superror1").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#superror1").html("");
        }
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").html("Required Field");
            i = 1;
        } else
        {
            $("#superror2").html("");
        }

        var nick_name = $("#nickname").val();
        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
        {
            $("#nick").html("Required Field");
            i = 1;
        } else
        {
            $("#nick").html("");
        }

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").html("Required Field");
            i = 1;
        } else if (!efilter.test(mail))
        {
            $("#superror5").html("Enter Valid Email");
            i = 1;
        } else
        {
            $("#superror5").html("");
        }
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#superror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#superror4").html("Enter Valid Mobile Number");
            i = 1;
        } else
        {
            $("#superror4").html("");
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
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').html("Enter Address");
            i = 1;
        } else
        {
            $('#superror3').html("");
        }
        /*  var number = $("#mobile").val();
         var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
         if (number == "")
         {
         $("#superror4").html("Required Field");
         i = 1;
         } else if (!nfilter.test(number))
         {
         $("#superror4").html("Enter Valid Mobile Number");
         i = 1;
         } else
         {
         $("#superror4").html("");
         }
         var mail = $("#mail").val();
         var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if (mail == "")
         {
         $("#superror5").html("Required Field");
         i = 1;
         } else if (!efilter.test(mail))
         {
         $("#superror5").html("Enter Valid Email");
         i = 1;
         } else
         {
         $("#superror5").html("");
         }
         var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#superror6').html("Enter Details");
         i = 1;
         } else
         {
         $('#superror6').html("");
         }
         var city = $('#city').val();
         if (city == "" || city == null || city.trim().length == 0)
         {
         $('#superror7').html("Required Field");
         i = 1;
         } else
         {
         $('#superror7').html("");
         }
         var pincode = $("#pincode").val();
         if (pincode == "")
         {
         $("#superror8").html("Required Field");
         i = 1;
         } else if (pincode.length != 6)
         {
         $("#superror8").html("Maximum 6 Numbers");
         i = 1;
         } else
         {
         $("#superror8").html("");
         }
         var branch = $("#branch").val();
         if (branch == "" || branch == null || branch.trim().length == 0)
         {
         $("#superror9").html("Required Field");
         i = 1;
         } else
         {
         $("#superror9").html("");
         }
         var acnum = $("#acnum").val();
         var acfilter = /^[a-zA-Z0-9]+$/;
         if (acnum == "")
         {
         $("#superror10").html("Required Field");
         i = 1;
         } else if (!acfilter.test(acnum))
         {
         $("#superror10").html("Numeric or Alphanumeric");
         i = 1;
         } else
         {
         $("#superror10").html("");
         }
         var payment_terms = $("#payment_terms").val();

         if (payment_terms == "")
         {
         $("#superror11").html("Required Field");
         i = 1;
         } else
         {
         $("#superror11").html("");
         }*/
        /*var tin = $('#tin').val();
         if (tin == "" || tin == null || tin.trim().length == 0)
         {
         $('#superror12').html("Required Field");
         i = 1;
         } else
         {
         $('#superror12').html("");
         }
         */
        if (i == 0) {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val()), id: $('.id').val()},
                url: '<?php echo base_url(); ?>vendor/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#superror4").html('This Mobile Number is already taken');
                        i = 1;
                    } else {
                        $("#superror4").html('');
                    }
                }
            });
        }

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


    $(".mail").live('blur', function ()
    {
        mail = $("#mail").val();
        id = $('.id').val();
        if (mail != "") {
            $.ajax({
                url: BASE_URL + "vendor/update_duplicate_mail",
                type: 'POST',
                data: {value1: mail, value2: id},
                success: function (result)
                {
                    $("#upduplica").html(result);
                }
            });
        } else {
            $("#upduplica").html('');
        }
    });
</script>