<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<?php
$serial_no_json = array();
if (!empty($serial_number)) {
    foreach ($serial_number as $list) {
        $serial_no_json[] = '{ value: "' . $list['product_serial_no'] . '", id: "' . $list['id'] . '"}';
    }
}
?>
<style>
.form-control {
    padding: 0.3rem .2rem !important;
}
.btn-mini {
    padding: 7px 9px;
}
</style>
<div class="card">
    <div class="card-header">
        <h5>Check Warranty Services</h5>
    </div>
    <div class="card-block">
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Reference Id</label>
                <select name='quotation[]' class="quotation form-control style" tabindex="1">
                    <option>Select</option>
                    <?php
                    if (isset($job_id) && !empty($job_id)) {
                        foreach ($job_id as $val) {
                            ?>
                            <option value='<?php echo $val['id'] ?>' class="q_o" q_no="<?php echo $val['inv_id'] ?>"> <?php echo $val['inv_id'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
			<label class="col-form-label">Serial No</label>
			<div class="row col-md-12">              
                <div class="col-md-10 p-0"><input type="text" class="form-control" value="" id="serial_no"></div>
                <span class="col-md-2 p-0"> <input type="button" class="btn btn-mini btn-success " id='view_po' value='View'/></div>
                <span id="poerror" style="color:#F00;"></span>
			</div>
            </div>
        </div>
        <div class="row card-block table-border-style" id="service">

        </div>
        <div  id='grn_html'>

        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $('#serial_no').on('keydown', function () {
            $('body').on('keydown', 'input#serial_no', function (e) {
                var c_data = [<?php echo implode(',', $serial_no_json); ?>];
                $("#serial_no").autocomplete({
                    source: function (request, response) {
                        // filter array to only entries you want to display limited to 10
                        var outputArray = new Array();
                        for (var i = 0; i < c_data.length; i++) {
                            if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                                outputArray.push(c_data[i]);
                            }
                        }
                        response(outputArray.slice(0, 10));
                    },
                    minLength: 0,
                    autoFill: false,
                    select: function (event, ui) {
                        gen_id = ui.item.id;
                        $.ajax({
                            type: 'POST',
                            data: {gen_id: gen_id},
                            url: "<?php echo $this->config->item('base_url'); ?>" + "grn/get_serial_number_list/",
                            success: function (data) {
                                result = JSON.parse(data);
                                if (result != null && result.length > 0) {
                                    $("#serial_no").val(result[0].po_no);
                                    $("#gen_id").val(result[0].gen_id);
                                }
                            }
                        });
                    }
                });
            });
        });
        $('#view_po').on('click', function () {
            var i = 0;
            var serial_no = $("#serial_no").val();
            if (serial_no == '')
            {
                $("#poerror").html("Enter Serial NO");
                i = 1;

            } else
            {
                $("#poerror").html("");
            }
            $.ajax({
                url: BASE_URL + "grn/get_serial_number",
                type: 'GET',
                data: {
                    serial_no: $('#serial_no').val()
                },
                success: function (result) {
                    //                    for_response();
                    $('#grn_html').html(result);
                }
            });

            if (i == 1)
            {
                return false;
            } else
            {
                return true;
            }
        });

        $('.quotation').on('change', function () {

            $.ajaxPrefilter(function (options, original_Options, jqXHR) {
                options.async = true;
            });
            if ($(this).val() != 'Select')
            {
                var this_ = $(this).closest('div').next('div');
                var option = $('option:selected', this).attr('q_no');

                $.ajax({
                    url: BASE_URL + "service/get_invoice",
                    type: 'GET',
                    data: {
                        q_id: $(this).val(),
                        q_no: option
                    },
                    beforeSend: function () {
//                        for_loading(' Warranty Services Loading...');
                    },
                    success: function (result) {
//                        for_response('Success...');
                        $('#service').html(result);
                    }
                });
            }
        });
        // xml.async = "false";
    });

</script>
