
<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
    <div class="media">

    </div>
    <div class="contentpanel">
        <div class="media">
            <h4>Customer Details</h4>
        </div>
        <div class="panel-body  mb-25">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#customer-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Customer List</a></li>
                    <li role="presentation" class=""><a href="#customer" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Customer</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane" id="customer">
                        <!-- <h4 align="center" class="sup-align">Add Customer</h4>-->
                        <form action="<?php echo $this->config->item('base_url'); ?>customer/insert_customer" enctype="multipart/form-data" name="form" method="post">
                            <table  class="table table-striped responsive no-footer dtr-inline">
                                <tr>
                                    <td width="15%">State</td>
                                    <td width="15%">
                                        <select id="state_id" name='state_id' class="state_id form-control form-align"  >
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($all_state) && !empty($all_state)) {
                                                foreach ($all_state as $val) {
                                                    ?>
                                                    <option value="<?= $val['id'] ?>"><?= $val['state'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>                                         
                                        </select><span id="cuserror" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">City</td>
                                    <td width="15%">
                                        <input type="text" name="city" class=" form-control form-align" id="city" />
                                        <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">Account No</td>
                                    <td width="15%">
                                        <input type="text" name="acnum" class="form-control form-align" id="acnum" />
                                        <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>

                                </tr>
                              <!--  <tr>
                                  
                                  <td width="15%">Agent Commission(%)</td>
                                  <td width="15%">
                                      <input type="text"  name="agent_comm" id="agent_comm"  class="form-control form-align"/>
                                      <span id="cuserror13" class="val"  style="color:#F00; font-style:oblique;"></span>
                                  </td>
                                 
                                </tr>-->
                                <tr>
                                    <td width="15%">Company Name</td>
                                    <td width="15%">
                                        <input type="text" name="store" class="store form-control form-align" id="store" />
                                        <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">Contact Person</td>
                                    <td width="15%">
                                        <input type="text" name="name" class="name form-control form-align" id="name" />
                                        <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">Payment Terms</td>
                                    <td width="15%">
                                        <input type="text"  name="payment_terms"  class="form-control form-align" id="payment_terms"/>
                                        <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td> 



                                </tr>
                                <tr>
                                    <td width="15%">Bank Name</td>
                                    <td width="15%">
                                        <input type="text" name="bank" class="form-control form-align" id="bank" />
                                        <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">Bank Branch</td>
                                    <td width="15%">
                                        <input type="text" name="branch" class="form-control form-align" id="branch" />
                                        <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="15%">Email Id</td>
                                    <td width="15%">
                                        <input type="text" name="mail" class="mail form-control email_dup form-align" id="mail" />
                                        <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                <!--    <td width="15%">Pin Code</td>
                                    <td width="15%">
                                        <input type="text" name="pin" class=" form-control form-align" id="pincode" />
                                                <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>-->

                                </tr>
                               <!-- <tr>
                                  
                                  <td width="15%">Selling %</td>
                                  <td width="15%">
                                      <input type="text" name="percentage" class="percentage form-control form-align" id="percentage" /><span id="cuserror7" class="val"  style="color:#F00; font-style:oblique;"></span>
                                  </td>
                                  <td width="15%">Tax</td>
                                  <td >
                                      <span>
                                      
                                       <input type="hidden"  name="st"  id='c_st'  style="width:70px;"/>
                                      CST <input type="text"  name="cst" id='c_cst' class="dot_val form-align" style="width:56px;"/>
                                      VAT <input type="text"  name="vat" id='c_vat' class="dot_val form-align" style="width:56px;"/>
                                      </span>
                                  </td>
                              
                                </tr>
                                <tr>-->
                                <tr>
                                    <td width="15%">IFSC Code</td>
                                    <td width="15%">
                                        <input type="text" name="ifsc" class="form-control form-align" id="" />
                                    </td>
                                    <td width="15%">Agent Name</td>
                                    <td width="15%">
                                        <select id='agent'  name="agent_name"  class="form-control form-align">
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($all_agent) && !empty($all_agent)) {
                                                foreach ($all_agent as $val) {
                                                    ?>
                                                    <option value='<?= $val['id'] ?>'><?= $val['name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>
                                     <td width="15%">Mobile Number</td>
                                    <td width="15%">
                                        <input type="text" name="number" class="number form-control form-align" id="number" />
                                        <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                   
                                </tr>
                                <tr>
                                 <td width="15%">Address1</td>
                                    <td width="15%">
                                        <textarea name="address1" id="address" class="form-control form-align"></textarea>
                                        <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>

                                    <td width="15%">Address2</td>
                                    <td width="15%"><textarea name="address2" id="address"  class="form-control form-align"></textarea></td>
                                    </td>
                                   
                                    <td width="15%">Tin / Vat No</td>
                                    <td width="15%"><input type="text"  name="tin"  class="form-control form-align" id="tin_vat" />
                                        <span id="cuserror15" class="val"  style="color:#F00; font-style:oblique;"></span></td>

                                </tr>
                            </table>


                            <div class="frameset_table action-btn-align">
                                <table>
                                    <tr>
                                        <td width="570">&nbsp;</td>
                                        <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>
                                        <td>&nbsp;</td>
                                        <td><input type="reset" value="Clear" class=" btn btn-danger" id="reset" /></td><td>&nbsp;</td>
                                        <td><a href="<?php echo $this->config->item('base_url') . 'customer/' ?>" class="btn btn-defaultback1"><span class="glyphicon"></span> Back </a></td>
                                    </tr> 
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="customer-details">
                        <div class="frameset_big1">
                            <!--<h4 align="center" class="sup-align">Customer Details</h4>-->
                            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="list">
                                <thead>
                                <th>S.No</th>
                                <th>Customer #</th>
                                <th>State</th>
                                <th>Contact Person</th>
                                <th>Company Name</th>
                                <th>City</th>
                                <!--<th>Address1</th>
                                <th>Address2</th>
                                <th>Pin Code</th>-->
                                <th>Mobile Number</th>
                                <th>Email Id</th>
                                <th  style="display:none;">Bank Details</th>
                                <!--<th>Selling %</th>-->
                                <th class="action-btn-align">Action</th>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($customer) && !empty($customer)) {
                                    $i = 0;
                                    foreach ($customer as $val) {
                                        $i++
                                        ?>
                                            <tr>
                                                <td class="first_td"><?php echo "$i"; ?></td>
                                                <td>CUST_ID_<?= $val['id'] ?></td>
                                                <td><?= $val['state'] ?></td>
                                                <td><?= $val['name'] ?></td>
                                                <td><?= $val['store_name'] ?></td>
                                                <td><?= $val['city'] ?></td>
                                                <!--<td><?= $val['address1'] ?></td>
                                                <td><?= $val['address2'] ?></td>
                                                <td><?= $val['pincode'] ?></td>-->
                                                <td><?= $val['mobil_number'] ?></td>
                                                <td><?= $val['email_id'] ?></td>
                                                <td style="display:none;">
                                                    <strong>NAME:</strong><?= $val['bank_name'] ?><br />	
                                                    <strong>BRANCH:</strong><?= $val['bank_branch'] ?><br />
                                                    <strong>A/C NO:</strong><?= $val['account_num'] ?><br />
                                                    <strong>IFSC CODE:</strong><?= $val['ifsc'] ?>
                                                </td>
                               <!--                <td><?= $val['selling_percent'] ?></td>-->

                                                <td class="action-btn-align">
                                                    <a href="<?= $this->config->item('base_url') . 'customer/edit_customer/' . $val['id'] ?>" class="tooltips btn btn-info btn-xs" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>
                                                </td>
                                            </tr>   
                                        <?php }
                                    } ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <br />
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
            $('.state_id').live('blur', function ()
            {
                var state = $('.state_id').val();
                if (state == "37")
                {
                    $('#cuserror').html('<input type="text" name="state" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
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
            $('#bank').live('blur', function ()
            {
                var bank = $('#bank').val();
                if (bank == "" || bank == null || bank.trim().length == 0)
                {
                    $('#cuserror6').html("Required Field");
                } else
                {
                    $('#cuserror6').html("");
                }
            });
            $('#percentage').live('blur', function ()
            {
                var percentage = $('#percentage').val();
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
            });

            $('#agent').live('change', function ()
            {
                var agent = $('#agent').val();
                if (agent == "")
                {
                    $('#cuserror12').html("Required Field");
                } else
                {
                    $('#cuserror12').html("");
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
            $("#payment_terms").live('blur', function ()
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
            $('#tin_vat').live('blur', function ()
            {
                var tin = $('#tin_vat').val();
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
            });
            $('#reset').live('click', function ()
            {
                $('.val').html("");
            });
        </script>
        <script type="text/javascript">
            $('#submit').live('click', function ()
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
                var address = $('#address').val();
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
                //	var percentage=$('#percentage').val();
                //	var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
                //	if(percentage=="" || percentage==null || percentage.trim().length==0)
                //	{
                //		$('#cuserror7').html("Required Field");
                //		i=1;
                //	}
                //	else if(!pefilter.test(percentage))
                //	{
                //		$("#cuserror7").html("Enter Valid Percentage");
                //		i=1;
                //	}
                //	else
                //	{
                //		$('#cuserror7').html("");
                //	}

                //	var pincode=$("#pincode").val();
                //	if(pincode=="")
                //	{
                //		$("#cuserror9").html("Required Field");
                //		i=1;
                //	}
                //	else if (pincode.length!=6) 
                //    {
                //	    $("#cuserror9").html("Maximum 6 characters");
                //		i=1;	
                //    }
                //	else
                //	{
                //		$("#cuserror9").html("");
                //	}
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
                }
                var agent = $('#agent').val();
                if (agent == "")
                {
                    $('#cuserror12').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cuserror12').html("");
                }
                //	var agent_comm=$('#agent_comm').val();
                //	var apefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
                //	if(agent_comm=="" || agent_comm==null || agent_comm.trim().length==0)
                //	{
                //		$('#cuserror13').html("Required Field");
                //		i=1;
                //	}
                //	else if(!apefilter.test(agent_comm))
                //	{
                //		$("#cuserror13").html("Enter Valid Percentage");
                //		i=1;
                //	}
                //	else
                //	{
                //		$('#cuserror13').html("");
                //	}
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
                //	var cst=$('#c_cst').val();
                //	if(cst=="")
                //	{
                //		$("#c_cst").css('border-color','red');
                //		i=1;
                //	}
                //	else
                //	{
                //		$("#c_cst").css('border-color','');
                //	}
                //	var vat=$('#c_vat').val();
                //	if(vat=="")
                //	{
                //		$("#c_vat").css('border-color','red');
                //		i=1;
                //	}
                //	else
                //	{
                //		$("#c_vat").css('border-color','');
                //	}
                var mess = $('#duplica').html();
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
            $(".email_dup").live('blur', function ()
            {
                email = $("#mail").val();
                $.ajax(
                        {
                            url: BASE_URL + "customer/add_duplicate_email",
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
if (isset($customer) && !empty($customer)) {
    foreach ($customer as $val) {
        ?>   
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                                <h3 id="myModalLabel" class="inactivepop">In-Active Customer</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This Customer? <?= $val['name']; ?> <strong>(<?= $val['store_name']; ?>)</strong>
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                                <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
                            </div>
                        </div>
                    </div>  
                </div>
    <?php }
} ?>
    </div>
</div>


<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="close1" data-dismiss="modal">×</a>
            <div class="modal-body">
                <img src="<?= $this->config->item('base_url') . '/cust_image/thumb/' . $val['cus_image'] ?>" width="50%" />

            </div>
        </div>
    </div>
</div> 


<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "customer/delete_customer",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "customer/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>