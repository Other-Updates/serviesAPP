<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" href="<?= $theme_path; ?>/bower_components/select2/css/select2.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css" />
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/multiselect/css/multi-select.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js">
</script>
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?= $theme_path; ?>/assets/js/jquery.quicksearch.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/autocomplete.css">
<?php
$job_type_arr = array(
    'leads' => 'Leads',
    'project' => 'Project',
    'services' => 'Services'
);
?>
<style>
    #service_table tbody tr td:nth-child(6){text-align:center;}
    #service_table tbody tr td:nth-child(7){text-align:center;}
    #leads_table tbody tr td:nth-child(9){text-align:center;}
    #leads_table tbody tr td:nth-child(6){text-align:center;}
    #leads_table tbody tr td:nth-child(5){text-align:center;}
    #project_table tbody tr td:nth-child(3){text-align:center;}
    #project_table tbody tr td:nth-child(4){text-align:right;}
    .label-warning {
        background-color: #ff9800;
    }

</style>
<div class="card">
    <div class="card-header">
        <h5>Service List</h5>
    </div>
    <div class="card-block  table-border-style">
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th width="33">S.No</th>
                        <!-- <th width="35">Inv #</th> -->
                        <th width="35">Ticket #</th>
                        <!--<th width="35">Product Image</th>-->
                        <th width="35">Description</th>
                        <!-- <th width="35">Warranty</th> -->
                        <th width="35">Employee Name</th>
                        <th width="35">Inv Date</th>
                        <th width="75">Status</th>
                        <th width="107" class="action-btn-align">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <?php
        if (isset($service) && !empty($service)) {
            foreach ($service as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor">
                                <h3 id="myModalLabel" class="inactivepop">In-Active service</h3>
                                <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This Service?
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-round btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                                <button type="button" class="btn btn-round btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
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
<script>
    function delete_service(val) {
        $('#test3_' + val).modal('show');
    }
    $(document).ready(function () {
        table = $('#service_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "service/to_do_service/service_ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
        });
        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "service/to_do_service/service_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {
                    window.location.reload(BASE_URL + "service/to_do_service");
                }
            });

        });
    });

</script>