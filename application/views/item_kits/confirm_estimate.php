<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_confirm_estimate/' . $info_design_template->id_design_template, array('id' => 'item_kit_request_production_template')); ?>
<fieldset id="item_kit_info">
    <legend>Xác nhận mẫu sản xuất</legend>  
    <label style="font-weight: bold; margin-left: 8px">Mã mẫu TK: </label>
        <span style="font-weight: normal; color: #000FFF"><?= $info_design_template->code_design_template ?></span>
    <?php if($name_feature){?>
        <label style="font-weight: bold;"> &nbsp; - &nbsp; Tên công thức NVL: </label>
            <span style="font-weight: normal; color: #000FFF"><?= $name_feature;?></span> 
    <?php }?>
    <div class="field_row clearfix" style="border-bottom:none; margin-top: 20px; font-size: 13px">
        <?php echo form_label(lang("item_kits_image_design_template").": ", "image_design_template", 
                array("class" => "required wide"));?>
        <div class='form_field' >     
            <?php $css = 'style="height: 120px; width: 120px"';
            $no_image = base_url() . 'images/noImage.gif';
            $image = "./item_kits/design_template/$production_template->image_production_template";
            if($production_template->status == 0)
                echo "<img $css src='$no_image'> ";
            else if($production_template->status == 2)
                echo form_input(array(
                        'name' => 'estimate_image',
                        'id' => 'estimate_image',
                        'type' => 'file'
                    ));
            else
                echo "<img $css src='$image'> ";    
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none; font-size: 13px">
        <?php echo form_label(lang("item_kits_description_design_template").": ", "description_design_template", array("class" => "wide"));?>
        <div class="form_field">
            <span style="font-weight: normal"><?php echo $info_design_template->description; ?></span>
        </div>
    </div>

    <div class="field_row clearfix" style="font-size: 13px">
        <?php echo form_label('Số lượng:', 'quantity_request', array('class' => 'wide')); ?>
        <div class='form_field'>
            <?php echo form_label($request_production_template->quantity_request, 'quantity_request');?>
        </div>
    </div>     
    <div class="field_row clearfix" style="font-size: 13px">
        <label class="required wide" for="status" ><?php echo $production_template->status == 0 ? 'Xác nhận sản xuất' : 'Xác nhận hoàn thành' ?>
        </label>
        <div class='form_field'>
            <input type="checkbox" name="status" id="status"
                <?php 
                if($production_template->status == 0)//chờ xác nhận
                    echo 'value="2" ';
                else if($production_template->status == 2)//đang sản xuất
                    echo 'value="3" ';
                else//hoàn thành
                    echo 'value="3" checked';
                ?> >    
        </div>
    </div> 
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));?>
    <?php echo form_close(); ?>        
</fieldset>
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_request_production_template").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_request_production_template').validate({
        submitHandler: function (form) {
            if (submitting)
                return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success: function (response) {
                    submitting = false;
                    tb_remove();
                    post_item_kit_form_submit(response);
                },
                dataType: 'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules: {
            estimate_image:{
                required: true,
            },            
            status:{
                required: true,
            },
        },
        messages: {
            estimate_image:{
                required: 'Bạn chưa chọn ảnh để xác nhận hoàn thành',
            },           
            status:{
                required: 'Bạn chưa tích vào ô xác nhận',
            },
        }
    });
});
</script>   
<style type="text/css">   
#item_kit_items{
    width:86%;	
    font: 13px solid;
}
#item_kit_items tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_items tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.quantity{
    text-align: right;
    padding: 2px 10px;
    width: 80%;
}
</style>