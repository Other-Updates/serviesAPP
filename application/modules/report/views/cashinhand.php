<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tr td:nth-child(6){text-align:center !important;}
    table tr td:nth-child(8){text-align:right !important;}
    table tfoot tr td:nth-child(2){text-align:right !important;}
</style>
<div class="card">
<?php 
	$this->load->view("admin/main-printheader");

?>
    <div class="card-header">
        <h5>Cash In Hand ( Company / Agent ) </h5>
    </div>
    <div class="card-block table-border-style">
        <?php
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        if ($user_info[0]['role'] != 4) {
            ?>
            <form>
                <div class="form-material row">
                    <div class="col-md-3">
                       <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-address-book"></i>
                                    </div>
									 <div class="form-group form-primary">
                        
                        <select id='cah_option'  class="form-control">
                            <option>Select Cash In</option>
                            <option value="company" selected>Company</option>
                            <option value="agent">Agent</option>
                        </select>
						
                    </div>
                    <div class="col-md-3" style="display:none;">
                        <label class="col-form-label" id='agent_td' style="display:none;">Agent</label>
                        <select id='agent' style="display:none;" class="form-control">
                            <option>Select</option>
                            <?php
                            if (isset($all_agent) && !empty($all_agent)) {
                                foreach ($all_agent as $val) {
                                    ?>
                                    <option value='<?= $val['id'] ?>'><?= $val['name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
						<span class="form-bar"></span>
						</div>
						</div>
                    </div>
                    <div class="col-md-3">
                      <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-calendar"></i>
                                </div>
                                <div class="form-group form-primary">
                        <label class="float-label">From Date</label>
                        <input tabindex="1" id="from_date" name="inv_date" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control required dropper-default" type="text" placeholder="" />
						<span class="form-bar"></span>
						</div>
						</div>
                    </div>
                    <div class="col-md-3">
                        <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-calendar"></i>
                                </div>
                                <div class="form-group form-primary">
                        <label class="float-label">To Date</label>
						<input tabindex="1" id="to_date" name="inv_date" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control required dropper-default" type="text" placeholder="" />                      
						<span class="form-bar"></span>
						</div>
						</div>

                    </div>
                    <div class="">
                        
                        <div>
                            <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                        </div>
                    </div>

                </div>
            </form>
        <?php } ?>
    </div>
    <div class="card-block table-border-style">
        <div id='result_div'  class="table-responsive">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td colspan="2">Source</td>
                        <td colspan="2">Receiver</td>
                        <td>Date</td>
                        <td>Type</td>
                        <td>Amount</td>
<!--                            <td>Cash in Hand Amount</td>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($amount) && !empty($amount)) {
                        $i = 1;
                        foreach ($amount as $val) {
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td><?= $val['receiver_type'] ?></td><td><?= ($val['receipt_id']) ? $val['receipt_id'] : '-' ?></td>
                                <td><?= $val['recevier'] ?> </td><td><?= ($val['name']) ? $val['name'] : '-' ?></td>
                                <td><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                <td><?= ucfirst($val['type']); ?></td>
                                <td  class="text_right"><?= number_format($val['bill_amount'], 2, '.', ',') ?></td>
                            </tr>

                            <?php
                            $i++;
                        }
                    }
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td class="text_right" colspan="7"><b>Cash in Hand/ Company</b></td>
                        <td class="text_right" ><?= number_format($company_amount, 2, '.', ',') ?></td>
                    </tr>
                </tfoot>
                <input type="hidden" value="<?php echo $this->session->userdata['user_info'][0]['id']; ?>" id="val" />
                <input type="hidden" value="<?php echo $this->session->userdata['user_info'][0]['role']; ?>" id="role" />
            </table>
            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light "> Print</button>
                <button class="btn btn-success excel_btn btn-sm waves-effect waves-light">Excel</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
        if ($('#role').val() == 4)
        {
            var val = $('#val').val();
            jQuery('.datepicker').datepicker();
            $.ajax({
                url: BASE_URL + "report/search_cahsinhand",
                type: 'GET',
                data: {
                    cah_option: $('#cah_option').val(),
                    agent: val,
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val()
                },
                success: function (result) {
                    for_response();
                    $('#result_div').html(result);
                }
            });
            $('.print_btn').live('click', function () {
                window.print();
            });
        }
    });

    $('#cah_option').change(function () {
        if ($(this).val() == 'agent')
        {
            $('#agent_td').css('display', 'block');
        } else
        {
            $('#agent_td').css('display', 'none');
        }
    });
    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
//        for_loading();
        $.ajax({
            url: BASE_URL + "report/search_cahsinhand",
            type: 'GET',
            data: {
                cah_option: $('#cah_option').val(),
                agent: $('#agent').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
//                for_response();
                $('#result_div').html(result);
            }
        });
    });
</script>
<script>
$(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>