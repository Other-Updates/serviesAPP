
<tr>
<input type="hidden" class="is_delete">
<input type="hidden" class="is_remove_id">
<input type="hidden" class="ads_detail_id" name="" value="0">
<input type="hidden" name="old[ads_detail_id][]" value="0"/>
<input type="hidden" name="old[ads_detail_data][]" value=""/>
<td align="center" class="s_no"></td>
<td>
    <div class="col-md-12 form-group" >
        <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type required" id="">
            <option value=" ">Select Type</option>
            <option value="1">Images</option>
            <option value="3">Content</option>
        </select>
        <span class="error_msg adds_file_type_error"></span>
    </div>
</td>
<td class="file_type_content">
    <div class="ads_image_div" >
        <div class="col-md-9 form-group add-img-upload flt-left">
            <fieldset _ngcontent-c7="" class="form-group">
                <div _ngcontent-c7="" class="custom-file center-block d-block">
                    <input _ngcontent-c7="" class="add_data_images custom-file-input adsdata required" id="ads" name="ads_data_image[]" data-type="image" type="file">
                    <label _ngcontent-c7="" class="custom-file-label" for="inputGroupFile01">Choose File</label>	
                </div>
				<span class="error_msg file_error"></span>
            </fieldset>
            

        </div>
        <div class="col-md-3 flt-left">
            <img src="<?php echo base_url('/') . 'themes/incsol/assets/images/default_image.png'; ?>"  class="img_src img_video_tbl" width="40px" height="40px" />
        </div>
    </div>

    <div class="ads_content_div" style="display:none">
        <div class="col-md-12 form-group">
            <textarea   placeholder="Content" class="add_data_contents form-control txt_area_height " name=""></textarea>
            <span class="error_msg file_error"></span>
        </div>
    </div>
</td>

<td>
    <div class="col-md-12 form-group">
        <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="form-control required ads_sort_order "/>
        <span class="error_msg sort_order_error"></span>
    </div>
</td>

<td width="5%" class="action-btn-align" style="text-align:center;">
    <a  class="remove_data del btn btn-danger btn-mini">
        <span class="fa fa-trash" style="color:white;"></span>
    </a>
</td>
</tr>


