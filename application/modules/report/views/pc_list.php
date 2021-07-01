<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tr td:nth-child(8){text-align:center;}
</style>
<div class="card">
<?php 
	$this->load->view("admin/main-printheader");

?>

    <div class="card-header">
        <h5>Project Cost List
        </h5>
    </div>
    <div class="card-block table-border-style">
        <form>
            <div class="form-material row">
                <div class="col-md-3">
				<div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-address-book"></i>
                                    </div>
									 <div class="form-group form-primary">
                  
                    <select id='job_id'  class="form-control">
                        <option>Select Job Id</option>
                        <?php
                        if (isset($all_style) && !empty($all_style)) {
                            foreach ($all_style as $val) {
                                ?>
                                <option value='<?= $val['job_id'] ?>'><?= $val['job_id'] ?></option>
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
                                        <i class="icofont icofont-address-book"></i>
                                    </div>
									 <div class="form-group form-primary">
                   
                    <select id='customer'  class="form-control" >
                        <option>Select Customer</option>
                        <?php
                        if (isset($all_supplier) && !empty($all_supplier)) {
                            foreach ($all_supplier as $val) {
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
                <div class="col-md-2">
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
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <label class="float-label hide-color">Search</label>
                    <div>
                        <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <div class="card-block table-border-style">
        <div  class="table-responsive">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Job #</td>
                        <td>Customer</td>
                        <td class="action-btn-align">Tot.Qty</td>
                        <td class="action-btn-align">Tot.Tax</td>
                        <td>Sub Tot.Qty</td>
                        <td>Project Cost.Amt</td>
                        <td>Project Cost Date</td>
                        <td>Remarks</td>

                    </tr>
                </thead>
                <tbody  id='result_div' >
                    <?php
                    if (isset($quotation) && !empty($quotation)) {
                        $i = 1;
                        foreach ($quotation as $val) {
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td><?= $val['job_id'] ?></td>
                                <td><?= $val['name'] ?></td>
                                <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                <td class="text_right"><?= number_format($val['tax_details'][0]['tot_tax'], 2) < 0 ? 0 : number_format($val['tax_details'][0]['tot_tax'], 2); ?></td>
                                <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                <td class="text_right"><?= number_format($val['net_total'], 2) ?></td>
                                <td><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                <td><?= $val['remarks'] ?></td>

                                <?php
                                $i++;
                            }
                        }
                        ?>
                </tbody>
            </table>
            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
            </div>
        </div>

    </div>
</div>
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
<script type="text/javascript">
    $('.complete_remarks').on('blur', function ()
    {
        var complete_remarks = $(this).parent().parent().find(".complete_remarks").val();
        var ssup = $(this).offsetParent().find('.remark_error');
        if (complete_remarks == '' || complete_remarks == null)
        {
            ssup.html("Required Field");
        } else
        {
            ssup.html("");
        }
    });
//
//    $(document).ready(function () {
//        jQuery('.datepicker').datepicker();
//    });
//    $().ready(function () {
//        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
//            width: 260,
//            autoFocus: true,
//            matchContains: true,
//            selectFirst: false
//        });
//    });
    $('#search').on('click', function () {
//        for_loading();
        $.ajax({
            url: BASE_URL + "report/pc_search_result",
            type: 'GET',
            data: {
                job_id: $('#job_id').val(),
                customer: $('#customer').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
//                for_response();
                $('#result_div').html('');
                $('#result_div').html(result);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "Project_cost_model/quotation_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "Project_cost_model/quotation_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
