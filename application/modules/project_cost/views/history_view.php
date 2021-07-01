<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
 	.text_right
	{
		text-align:right;
	}
        .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
	#top_heading_fix h3 {top: -57px;left: 6px;}
	#TB_overlay { z-index:20000 !important; }
	#TB_window { z-index:25000 !important; }
	.dialog_black{ z-index:30000 !important; }
	#boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;} 
.auto-asset-search ul#country-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#country-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
ul li {
    list-style-type: none;
}
</style>
<div class="mainpanel">
<div class="media">
 <h4>View Quotation History</h4>
</div>
        <!--    <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                        </ul>
                       
                        <h4>View Quotation History</h4>                       
                
                    </div>
                </div>
            </div> -->                
        </div><!-- mainpanel -->
<div class="nav-tabs-custom" style="margin-bottom:45px;">
    
    <ul class="nav nav-tabs">
         <?php      
        if(isset($his_quo) && !empty($his_quo))
        {
            $i=1;
            foreach($his_quo as $val)
            {
            ?>
                <li class="<?php echo ($i==1)?'active':''?>"><a href="#fa-icons<?php echo $val['id']?>" data-toggle="tab" aria-expanded="true"><?php echo $val['created_date']?></a></li>
            <?php
            $i++;
            }
        }
        ?>
    </ul>
    <div class="tab-content tabsborder">
      <!-- Font Awesome Icons -->
       <?php      
        if(isset($his_quo) && empty($his_quo))
        {?>
      <div style="text-align:center"> No History data found...</div>
       <div class="hide_class action-btn-align mb-bot4">        
           <a href="<?php echo $this->config->item('base_url').'quotation/quotation_list/'?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
        </div>
      <?php  }
        ?>
    <?php      
        if(isset($his_quo) && !empty($his_quo))
        {
            $j=1;
            foreach($his_quo as $val)
            {
            ?>
            <div class="tab-pane <?php echo ($j==1)?'active':'';?>" id="fa-icons<?php echo $val['id']?>">
                <?php
                    $datas["quotation"]= $quotation =$this->Gen_model->get_all_quotation_history_by_id($val['id']);
                    $datas["quotation_details"]=$quotation_details =$this->Gen_model->get_all_quotation_history_details_by_id($val['id']);
                    $datas["category"]=$category = $this->master_category_model->get_all_category();
                    $datas["brand"]=$brand = $this->master_brand_model->get_brand();
                    $datas['company_details']=$this->admin_model->get_company_details();
                    $this->load->view('view_only',$datas);
                ?>
            </div>
            <?php
            $j++;                            
            }
                            
        }
    ?>
    </div>
</div>
        