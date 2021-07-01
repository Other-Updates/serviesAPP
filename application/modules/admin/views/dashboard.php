<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/sweetalert.css">
<script src="<?php echo $theme_path; ?>/assets/js/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/pages/chart/loader.js"></script>
<!--BAR chart-->
<script type="text/javascript" src="<?php echo $theme_path; ?>/bower_components/chart.js/js/Chart.js"></script>
<!--Pie Chart-->
<link rel="stylesheet" href="<?php echo $theme_path; ?>/bower_components/c3/css/c3.css" type="text/css" media="all">
<!--Extra Area Chart-->
<link rel="stylesheet" type="text/css"  href="<?php echo $theme_path; ?>/bower_components/morris.js/css/morris.css">
<script src="<?php echo $theme_path; ?>/bower_components/raphael/js/raphael.min.js"></script>
<script src="<?php echo $theme_path; ?>/bower_components/morris.js/js/morris.js"></script>
<?php
$this->load->model('enquiry/enquiry_model');
$this->load->model('quotation/gen_model');
$this->load->model('project_cost/project_cost_model');
$this->load->model('service/service_model');
$pending_leads_count = $this->enquiry_model->get_pending_leads_count();
$pending_quotation_count = $this->gen_model->get_pending_quotation_count();
$pending_projects_count = $this->project_cost_model->get_pending_project_count();
$service_and_repair_count = $this->service_model->get_service_repair_count();
?>
<style>
    .scroll_list{
        Overflow-y:auto;
        max-height:100px;
    }
    .pettycsh{margin:0 auto; display:flex;}
    #morris-extra-area svg, #morris-site-visit svg{width:100% !important;}
    #morris-site-visit svg{width:100% !important; padding-right:0px;}

    select,option{
    font-weight: bold;
}
</style>
<div class="row">
    <?php if ($this->user_auth->is_section_allowed('quotation', 'quotation')) { ?>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-purple">
                                <?php if ($pending_quotation_count != 0) { ?>
                                    <?php echo $pending_quotation_count; ?>
                                <?php } ?>
                            </h4>
                            <h6 class="text-muted m-b-0">Quotation</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fa fa-bar-chart f-28"></i>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list' ?>">
                    <div class="card-footer bg-c-purple">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">View</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fa fa-line-chart text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->user_auth->is_section_allowed('enquiry', 'enquiry')) { ?>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">
                                <?php if ($pending_leads_count != 0) { ?>
                                    <?php echo $pending_leads_count; ?>
                                <?php } ?>
                            </h4>
                            <h6 class="text-muted m-b-0">Leads</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fa fa-file-text-o f-28"></i>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list' ?>">
                    <div class="card-footer bg-c-green">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">View</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fa fa-line-chart text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->user_auth->is_section_allowed('project_cost', 'project_cost')) { ?>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red">
                                <?php if ($pending_projects_count != 0) { ?>
                                    <?php echo $pending_projects_count; ?>
                                <?php } ?>
                            </h4>
                            <h6 class="text-muted m-b-0">Projects</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fa fa-calendar-check-o f-28"></i>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list' ?>">
                    <div class="card-footer bg-c-red">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">View</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fa fa-line-chart text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->user_auth->is_section_allowed('service', 'service')) { ?>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue">
                                <?php if ($service_and_repair_count != 0) { ?>
                                    <?php echo $service_and_repair_count; ?>
                                <?php } ?>
                            </h4>
                            <h6 class="text-muted m-b-0">Service and Repair</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fa fa-hand-o-down f-28"></i>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $this->config->item('base_url') . 'service/to_do_service' ?>">
                    <div class="card-footer bg-c-blue">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">View</p>
                            </div>
                            <div class="col-3 text-ri
                            ght">
                                <i class="fa fa-line-chart text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    
    <?php if ($this->user_auth->is_section_allowed('project_cost', 'project_cost')): ?>
        <input type="hidden" id="year" value="" class="">
       <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                <div>
                    <select class="form-control  pull-right" id="" style="width:8%;">
                        <?php  for($month=1;$month<=12;$month++) { ?>
                            <option value="<?php echo $month; ?>"><?php echo date('F', mktime(0, 0, 0, $month,10)) ?></option>
                        <?php } ?>
                    </select>

                    <select class="form-control year pull-right" id="" style="width:8%;">
                        <?php  for($year=2020;$year<=date('Y');$year++) { ?>
                            <option value="<?php echo $year; ?>"> <?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                        
                <div>
                    <select class="form-control  pull-right" id="" style="width:8%;">
                        <?php  for($month=1;$month<=12;$month++) { ?>
                            <option value="<?php echo $month; ?>"><?php echo date('F', mktime(0, 0, 0, $month,10)) ?></option>
                        <?php } ?>
                    </select>
                    <select class="form-control year pull-right" id="" style="width:8%;">
                        <?php  for($year=2020;$year<=date('Y');$year++) { ?>
                            <option value="<?php echo $year; ?>"> <?php echo $year; ?></option>
                        <?php } ?>
                                
                    </select>
                </div>
                    <h5>Sales Graph</h5>
                    <span>Invoice Amount Vs Month</span>
                   
                </div>
                

                <div class="card-block">
                    <div id="sales_chart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-block" style="height:165px;">
                    <div class="row">
                        <div class="col">
                            <h6>Pending sales</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <canvas id="this-month" style="height: 200px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->user_auth->is_module_allowed('services')): ?>
            <div class="card quater-card">
                <div class="card-block" style="height:210px;">
                    <h6 class="text-muted m-b-15">Service Chart</h6>
                    <p class="text-muted">Completed<span class="f-right"><?php echo $service['completed_per'] ?>%</span></p>
                    <div class="progress">
                        <div class="progress-bar bg-c-green" style="width: <?php echo $service['completed_per'] ?>%"></div>
                    </div>
                    <p class="text-muted">Pending<span class="f-right"><?php echo $service['pending_per'] ?>%</span></p>
                    <div class="progress">
                        <div class="progress-bar bg-c-red" style="width: <?php echo $service['pending_per'] ?>%"></div>
                    </div>
                    <p class="text-muted">Inprogress<span class="f-right"><?php echo $service['inprogress_per'] ?>%</span></p>
                    <div class="progress">
                        <div class="progress-bar bg-c-blue" style="width: <?php echo $service['inprogress_per'] ?>%"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($this->user_auth->is_section_allowed('report', 'profit_list')): ?>
        <div class="col-xl-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Profit & Loss Chart</h5>
                </div>
                <div class="card-block">
                    <div id="chart_stacking" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth->is_section_allowed('project_cost', 'project_cost') && ($this->user_auth->is_section_allowed('quotation', 'quotation'))): ?>
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Conversion Chart</h5>
                    <span>Quotation Vs Project Count</span>
                </div>
                <div class="card-block">
                    <div id="chart_area" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth->is_module_allowed('services')): ?>
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Service Graph</h5>
                    <span>Pending Service Vs Completed Service</span>
                </div>
                <div class="card-block">
                    <canvas id="barChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth->is_module_allowed('expense', 'expense')): ?>
        <div class="col-lg-12">
            <div class="col-md-12 p-0">
                <div class="card">
                    <div class="card-header">
                        <h5>Balance Sheet Chart </h5>
                        <!--<span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>-->
                    </div>
                    <div class="card-block pettycsh">
                        <canvas id="pettyCashgraph" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth->is_section_allowed('project_cost', 'project_cost') && ($this->user_auth->is_section_allowed('quotation', 'quotation')) && ($this->user_auth->is_section_allowed('enquiry', 'enquiry'))): ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Leads Vs quotation Vs Projects graph</h5>
                    <!--<span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>-->
                </div>
                <div class="card-block">
                    <canvas id="lqp_barChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth->is_section_allowed('enquiry', 'enquiry')): ?>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Pending Leads</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                            <li><i class="fa fa-trash close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="scroll_list">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>Leads#</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($report['enquiry']) && !empty($report['enquiry'])) {
                                        foreach ($report['enquiry'] as $enquiry) {
                                            ?>
                                            <tr>
                                                <td><?php echo $enquiry['enquiry_no']; ?></td>
                                                <td><?php echo $enquiry['customer_name']; ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($enquiry['created_date'])); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No pending Enquiry</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
    $this->load->model('admin/admin_model');
    $data['pending_invoice'] = $this->admin_model->get_pending_invoice();


    if ($this->user_auth->is_section_allowed('project_cost', 'project_cost')) {
        ?>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Pending Invoice</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                            <li><i class="fa fa-trash close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <div class="scroll_list">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>Invoice#</th>
                                        <th>Company Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
    <!--                                        <tbody>
                                <?php
                                if (isset($data['pending_invoice']) && !empty($data['pending_invoice'])) {
                                    foreach ($data['pending_invoice'] as $receipt) {
                                        ?>
                                                                                                                                                                                                                    <tr>

                                                                                                                                                                                                                    <td><?php echo ucfirst($receipt['store_name']); ?></td>
                                                                                                                                                                                                                    <td><?php echo $receipt['balance']; ?></td>
                                                                                                                                                                                                                    </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="2">No pending Invoice</td></tr>';
                                }
                                ?>
                                </tbody>-->
                                <tbody>
                                    <?php
                                    if (isset($pending_invoice) && !empty($pending_invoice)) {
                                        foreach ($pending_invoice as $receipt) {
                                            if ($receipt['balance_amount'] > 0) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $receipt['inv_id']; ?></td>
                                                    <td><?php echo $receipt['store_name']; ?></td>
                                                    <td><?php echo $receipt['balance_amount']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No pending Invoice</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->user_auth->is_section_allowed('stock', 'stock')) { ?>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Shortage Quantity</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                            <li><i class="fa fa-trash close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <div class="scroll_list">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>Model Number</th>
                                        <th>Brand</th>
                                        <th>Product</th>
                                        <th>QTY/MinQTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($report['stock']) && !empty($report['stock'])) {
                                        foreach ($report['stock'] as $stock) {
                                            ?>
                                            <tr>
                                                <td><?php echo $stock['model_no']; ?></td>
                                                <td><?php echo $stock['brands']; ?></td>
                                                <td><?php echo $stock['product_name']; ?></td>
                                                <td><?php echo $stock['quantity'] . '/' . $stock['min_qty']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="4">No shortage stock</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->user_auth->is_module_allowed('services')): ?>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>Pending Service</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                            <li><i class="fa fa-window-maximize full-card"></i></li>
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            <li><i class="fa fa-refresh reload-card"></i></li>
                            <li><i class="fa fa-trash close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <div class="scroll_list">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>Ticket No</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($report['service']) && !empty($report['service'])) {
                                        foreach ($report['service'] as $service) {
                                            ?>
                                            <tr>
                                                <td><?php echo $service['ticket_no']; ?></td>
                                                <td><?php echo ucfirst($service['customer_name']); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($service['created_date'])); ?></td>

                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No Pending Service</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function () {
        get_service_details_data();
        get_leads_quo_pc_data();
        pieChart();
    });

    function pieChart() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/pettyCashpieChart',
            success: function (data) {
                var cData = JSON.parse(data);
                //                var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                var ctx = $("#pie-chart-booking");

                //pie chart data
                var pieElem = document.getElementById("pettyCashgraph");
                var data4 = {
                    labels: cData.label,
                    datasets: [
                        {
                            label: "Petty Cash Details",
                            data: cData.data,
                            backgroundColor: [
                                "#25A6F7",
                                "#FB9A7D",
                                "#01C0C8",
                                "#ffd658"
                            ],
                            borderColor: [
                                "#6cc4fb",
                                "#ffb59f",
                                "#0dedf7",
                                "#ffd658"
                            ],
                            borderWidth: [1, 1, 1, 1, 1]
                        }
                    ]
                };

                var myPieChart = new Chart(pieElem, {
                    type: 'pie',
                    data: data4
                });
            }
        });
    }

    function get_service_details_data(){
        service();
            $( "#yearchange" ).on('change',function() {
                service();
            });
        }
        function service() {
           var year = $("select.year").val();
           var frommonth = $("select.year").val();
           var toyear = $("select.year").val();
           var tomonth = $("select.year").val();
               $.ajax({
                    type: 'POST',
                    data: {year: year,frommonth:frommonth,toyear:toyear,tomonth:tomonth},
                    url: '<?php echo base_url(); ?>admin/get_service_details',
                    success: function (data) {
                        var data = JSON.parse(data);
                        console.log(data);
                        var pending = [];
                        var completed = [];
                        var inprogress = [];
                        var month = [];

                        $.each(data.service, function (key, value) {
                            pending.push(value.pending);
                            completed.push(value.completed);
                            inprogress.push(value.inprogress);
                            month.push(value.month);

                        });

                        service_graph(pending, completed, month, inprogress);
                    }
                });
           }
    function service_graph(pending, completed, month, inprogress) {
        console.log(completed);
        var data1 = {
            labels: month,
            datasets: [{
                    label: "Completed Service",
                    backgroundColor: 'rgba(95, 190, 170, 0.99)',
                    hoverBackgroundColor: 'rgba(26, 188, 156, 0.88)',
                    data: completed,
                }, {
                    label: "Pending Service",
                    backgroundColor: 'rgba(93, 156, 236, 0.93)',
                    hoverBackgroundColor: 'rgba(103, 162, 237, 0.82)',
                    data: pending,
                },
                {
                    label: "Inprogress Service",
                    backgroundColor: 'rgb(255, 0, 0)',
                    hoverBackgroundColor: 'rgb(255, 0, 0)',
                    data: inprogress,
                }]

        };

        var bar = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(bar, {
            type: 'bar',
            data: data1,
            options: {
                barValueSpacing: 5
            }
        });
    }

    function get_leads_quo_pc_data(){
        leads_quotion_project();
        $( "#yearchange" ).on('change',function() {
            leads_quotion_project();
        });
    }

    function leads_quotion_project() {
        var year = $("select.year").val();
        $.ajax({
            type: 'POST',
            data: {year: year},
            url: '<?php echo base_url(); ?>admin/get_leads_quo_pc_details',
            success: function (data) {
                var data = JSON.parse(data);
                var leads = [];
                var quotation = [];
                var project_cost = [];
                var month = [];

                $.each(data.laeds_quo_pc, function (key, value) {
                    leads.push(value.leads);
                    quotation.push(value.quotation);
                    project_cost.push(value.project_cost);
                    month.push(value.month);


                });

                leads_quo_pc_graph(leads, quotation, project_cost, month);
            }
        });
    }
    function leads_quo_pc_graph(leads, quotation, project_cost, month) {
        var lqp_data = {
            labels: month,
            datasets: [{
                    label: "Leads",
                    backgroundColor: 'rgba(228, 127, 79, 0.83)',
                    hoverBackgroundColor: 'rgba(228, 127, 79, 0.83)',
                    data: leads,
                },
                //  {
                //     label: "Quotation",
                //     backgroundColor: 'rgba(35, 177, 191, 0.92)',
                //     hoverBackgroundColor: 'rgba(35, 177, 191, 0.92)',
                //     data: quotation,
                // },
                // {
                //     label: "Project Cost",
                //     backgroundColor: 'rgba(243, 172, 65, 0.91)',
                //     hoverBackgroundColor: 'rgba(243, 172, 65, 0.91)',
                //     data: project_cost,
                // }
                ]

        };

        var bar = document.getElementById("lqp_barChart").getContext('2d');
        var myBarChart = new Chart(bar, {
            type: 'bar',
            data: lqp_data,
            options: {
                barValueSpacing: 5
            }
        });
    }

</script>
<script>
    $(document).ready(function () {

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(){
            sales();
            $( ".yearchange" ).on('change',function() {
                sales();
            });    
        }

        function sales() {
            var year = $("select.year").val();
            var frommonth = $("select.frommonth").val();
            var toyear = $("select.toyear").val();
            var tomonth = $("select.tomonth").val();
                $.ajax({
                    type: 'POST',
                    data: {year: year,frommonth:frommonth,toyear:toyear,tomonth:tomonth},
                    url: '<?php echo base_url(); ?>admin/get_payment_data/',
                    success: function (data1) {

                        var data = new google.visualization.DataTable();

                        data.addColumn('string', 'Month');
                        data.addColumn('number', 'Invoice Amount');

                        var jsonData = $.parseJSON(data1);

                        for (var i = 0; i < jsonData.length; i++) {
                            data.addRow([jsonData[i].month, parseInt(jsonData[i].payment)]);
                        }
                        //
                        var legend = {
                            container: '#sales_chart',
                            noColumns: 0
                        };

                        var options = {
                            vAxis: {minValue: 0},
                            colors: ['#11c15b', '#ff5252'],
                            title: 'Sales Graph-' + year,
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('sales_chart'));
                        chart.draw(data, options);

                    }
                });
        }
        var ctx = document.getElementById('this-month').getContext("2d");

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: avgvalchart('#11c15b', [<?php echo $get_pending_inv; ?>], '#11c15b'),
            options: buildchartoption(),
        });
        function avgvalchart(a, b, f) {
            if (f == null) {
                f = "rgba(0,0,0,0)";
            }
            return {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                        label: "",
                        borderColor: a,
                        borderWidth: 2,
                        hitRadius: 30,
                        pointHoverRadius: 4,
                        pointBorderWidth: 50,
                        pointHoverBorderWidth: 12,
                        pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                        pointBorderColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                        pointHoverBackgroundColor: a,
                        pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.1).rgbString(),
                        fill: true,
                        backgroundColor: f,
                        data: b,
                    }]
            };
        }
        function buildchartoption() {
            return {
                title: {
                    display: !1
                },
                tooltips: {
                    position: 'nearest',
                    mode: 'index',
                    intersect: false,
                    yPadding: 10,
                    xPadding: 10,
                },
                legend: {
                    display: !1,
                    labels: {
                        usePointStyle: !1
                    }
                },
                responsive: !0,
                maintainAspectRatio: !0,
                hover: {
                    mode: "index"
                },
                scales: {
                    xAxes: [{
                            display: !1,
                            gridLines: !1,
                            scaleLabel: {
                                display: !0,
                                labelString: "Month"
                            }
                        }],
                    yAxes: [{
                            display: !1,
                            gridLines: !1,
                            scaleLabel: {
                                display: !0,
                                labelString: "Value"
                            },
                            ticks: {
                                beginAtZero: !0
                            }
                        }]
                },
                elements: {
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            };
        }
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(conversionhart);
        
        //area chart
        function conversionhart(){
            conversion();
            $( "#yearchange" ).on('change',function() {
                conversion();
            });    
        }
        function conversion() {
           year = $("select.year").val();
            $.ajax({
                type: 'POST',
                data: {year: year},
                url: '<?php echo base_url(); ?>admin/get_conversion_data/',
                success: function (data1) {
                    var jsonData = $.parseJSON(data1);
                    var arr = new Array();
                    arr.push(['Month', 'Quotation', 'Project Count']);
                    
                    $.each(jsonData, function (i, obj) {
                        var quotation = (obj.quotation) ? parseFloat(obj.quotation) : 0;
                        var project_cost = (obj.project_cost) ? parseFloat(obj.project_cost) : 0;
                        arr.push([obj.month, quotation, project_cost])
                    });
                    var data = google.visualization.arrayToDataTable(arr);
                    var options = {
                        vAxis: {minValue: 0},
                        colors: ['#11c15b', '#ff5252']
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_area'));
                    chart.draw(data, options);
                }
            });
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChartStacking);

        function drawChartStacking(){
            profitloss();
            $( "#yearchange" ).on('change',function() {
                profitloss();
            });    
        }

        function profitloss() {
            year = $("select.year").val();
            $.ajax({
                type: 'POST',
                data: {year: year},
                url: '<?php echo base_url(); ?>admin/get_profit_loss_data/',
                success: function (data1) {

                    var jsonData = $.parseJSON(data1);

                    var arr = new Array();
                    arr.push(['Month', 'Profit Amt', 'Inv Amt']);
                    $.each(jsonData, function (i, obj) {
                        var profit_amount = (obj.profit_amount) ? parseFloat(obj.profit_amount) : 0;
                        var inv_amount = (obj.inv_amount) ? parseFloat(obj.inv_amount) : 0;
                        arr.push([obj.month, profit_amount, inv_amount])
                    });
                    var data = google.visualization.arrayToDataTable(arr);
                    var options_stacked = {
                        isStacked: true,
                        height: 300,
                        legend: {position: 'top', maxLines: 3},
                        vAxis: {minValue: 0},
                        colors: ['#11c15b', '#536dfe']
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_stacking'));
                    chart.draw(data, options_stacked);
                }
            });
        }

    });
</script>

<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });

</script>
<script type="text/javascript">
    var mytextbox = document.getElementById('year');
    var mydropdown = document.getElementById('yearchange');
    $(document).on('change', '#yearchange', function () {
        var val = $(this).val();
        $('#year').val(val);
    });
   /* mydropdown.onchange = function(){
          mytextbox.value = this.value; //to appened
         //mytextbox.innerHTML = this.value;
    }*/
</script>