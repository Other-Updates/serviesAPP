<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
    td a {
        border: 0px solid #cbced4 !important;
    }
    .ui-datepicker td.ui-datepicker-today a {
        background:999999;
    }
    #ui-datepicker-div {
        z-index: 4 !important;
    }
    table tr td:nth-child(5) {
        text-align:center;
    }

    table tr td:nth-child(7) {
        text-align:center !important;
    }
    table tr td:nth-child(6) {
        text-align:center !important;
    }
    table tr th {
        text-align:center;
    }
    table tr td:nth-child(2) {
        text-align:center !important;
    }
    table tr td:nth-child(3) {
        text-align:center !important;
    }
    table tr td:nth-child(4) {
        text-align:center !important;
    }
    table tr td:nth-child(5) {
        text-align:right !important;
    }
    .mtop4{margin-top:-10px;}
</style>
<?php
$model_no_json = array();
if (!empty($model_number)) {
	

    foreach ($model_number as $list) {
        $model_no_json[] = '{ value: "' . $list['model_no'] . '", id: "' . $list['id'] . '"}';
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Dead Stock</h5>
            </div>
            <div class="card-block">
                <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>stock/death_stock/add" enctype="multipart/form-data" name="form" method="post" novalidate>
                    <div class="form-material row">
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-contact-add"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Model Number <span class="req">*</span></label>
                                    <input type="text" name="stock[model_no]"  class="form-control" id="m_no" tabindex="1">
                                    <input type="hidden"  name="stock[product_id]" id="product_id" class='form-control required' />
                                    <span class="form-bar"></span>
                                     <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
						<div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-money-bag"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Quantity <span class="req">*</span></label>
                                            <input type="text" name="stock[quantity]" class=" form-align required form-control" id="quantity" maxlength="10"/>
											  <span class="form-bar"></span>
                                            <span class="error_msg"></span>

                                        </div>
                                    </div>
                                </div>

                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-calendar"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label"> Date <span class="req">*</span></label>
                                    <!--<input type="date" name="followup_date" class="form-control" id="date" tabindex="1"/>-->
                                    <input id="dropper-default" name="stock[created_date]" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control" type="text" placeholder="" />
                                    <!--<span class="form-bar"></span>-->
                                      <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-primary">
                                <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-tasks-alt"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">Remarks </label>
                                        <input type="text" name="stock[remarks]" class="number form-control" id="remarks" tabindex="1"/>
                                        <span class="form-bar"></span>
                                        <span id="cuserror_remarks" class="val text-danger" ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                    
                    <div class="form-group row text-center m-10">
                        <div class="col-md-12 text-center">
                            <input type="submit" name="submit" class="btn btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Save" id="submit" tabindex="1"/>
                            <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $(document).ready(function () {
		
        $('#submit').on('click', function() {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
            
            if(m == 0 ) {
                if($("#quantity").val()>0){
                    $.ajax({
                        url: BASE_URL + "stock/death_stock/validate_quantity",
                        type: "POST",
                        async: false,
                        data:{
                            quantity:$("#quantity").val(), 
                            product_id : $("#product_id").val()
                        },
                        success: function(result)
                        {
                            result = JSON.parse(result);
                            if(result['result']=='fail'){
                                $("#quantity").closest('div.form-group').find('.error_msg').text(result['message']).slideDown('500').css('display', 'inline-block');
                                m++;
                            }   
                            else{
                                $("#quantity").closest('div.form-group').find('.error_msg').text('').slideUp('500');
                            }
                        }
                    });
                }
                else{
                    $("#quantity").closest('div.form-group').find('.error_msg').text('Invalid Quantity').slideDown('500').css('display', 'inline-block');
                    m++;
                }
            }  
            if (m > 0){
                return false;
            }
            
        });
$('body').on('keydown', 'input#m_no', function (e) {
        var c_data = [<?php echo implode(',', $model_no_json); ?>];
console.log(c_data);
        $("#m_no").autocomplete({
//            source: c_data,
            source: function (request, response) {
                // filter array to only entries you want to display limited to 10
                var outputArray = new Array();
                for (var i = 0; i < c_data.length; i++) {
                    if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                        outputArray.push(c_data[i]);
					
                    }
                }
                if (outputArray.length == 0) {
                    var nodata = 'Model Number Not Found';
                    outputArray.push(nodata);
                    $('#product_id').val('');
                }
                response(outputArray.slice(0, 10));
            },
            minLength: 0,
            autoFill: false,
            select: function (event, ui) {
				product_id = ui.item.id;
					$('#product_id').val(product_id);
                if (ui.item.value == "Add new Customer") {
					                    
                    clear_data();
                    
                    return false;

                } 
            }
        });
    });
       }); 
	</script>

<script>

    onload = function () {
        var quantity = document.querySelectorAll('#quantity')[0];
        quantity.onkeypress = function (e) {
            if (isNaN(this.value + "" + String.fromCharCode(e.charCode)))
                return false;
        }
        quantity.onpaste = function (e) {
            e.preventDefault();
        }
    }
</script>

