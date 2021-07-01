<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>

    @media print {

        .barcode_details { page-break-before: auto;page-break-inside:avoid;line-height:7px !important;letter-spacing: 0.5px;width:100%; -webkit-print-color-adjust: exact;}
        .barcode_details { font-size:7px; margin-bottom: 5px; margin-right: 10px;}
        .barcode_details span { font-size:5px; font-weight:700;}
        .barcode_details small { line-height:8px; font-size:5px;}
        @page{size:A4 landscape;}
    }
    .barcode_details small { line-height:8px; }
    @page {size:A4, landscape !important;}
    .barcode_details {
        font-size: 8px;
        margin-bottom: 10px;
        text-transform: uppercase;
        float: left;
        width: 145px;
        margin-right: 10px;
        color: #000;
        font-weight: 500;
        padding: 5px 5px 5px 15px;
    }
    td, th {
        white-space: unset;
    }
    table tr td:first-child, table tr td:last-child {
        text-align: left;
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>View Goods Receive Note
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <table style="margin:0 auto;">
                <tr>
                    <td>
                        <?php
                        if (isset($gen) && !empty($gen)) {
                            foreach ($gen as $key => $val) {
                                $qr_code = explode(",", $val['product_serial_no']);
                                foreach ($qr_code as $qr_key => $qr_val) {
                                    ?>
                                    <div class="barcode_details hide_class">
                                        <span class="hide_class"><input type="checkbox" name="qrcode_check" value="<?php echo $val['id'] ?>" /></span><br/>
                                        <!--<span><?php echo $val['model_no']; ?></span><br />-->
                                        <img src="<?php echo base_url() . 'attachement/grn_qr_code/' . $qr_val . '.png'; ?>" height="120px" width="120px" ><br />
                                        <span style="padding:10px;">S.No: <?php echo $qr_val; ?></span><br />
                                        <?php
                                        ?>

                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="hide_class text-center">
            <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
        </div>

        <script>
            $('#export_excel').live('click', function () {

                fnExcelReport();
                //window.location.href=BASE_URL+'report/pl_excel_file1';
            });
            $(document).ready(function () {
                $('.print_header').addClass("");
            });
            $('.print_btn').click(function () {
                get_checked_qr();
                window.print();
            });
            function get_checked_qr() {
                $.each($(".barcode_details"), function () {
                    if ($(this).find("input[name='qrcode_check']").prop('checked') == true) {
                        $(this).removeClass('hide_class');
                    } else {
                        $(this).addClass('hide_class');
                    }
                });
            }

        </script>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
<style type="text/css">
    .right_td
    {
        text-align:right;
    }
</style>
<script>
    function fnExcelReport()
    {
        var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('pl'); // id of table
        for (j = 0; j < tab.rows.length; j++)
        {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
        } else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        return (sa);
    }
</script>