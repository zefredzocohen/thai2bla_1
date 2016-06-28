<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_production_template/' . $info_design_template->id_design_template, array('id' => 'item_kit_request_production_template')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_request_production_template"); ?></legend>    
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_code_design_template").": ", "code_design_template", array("class" => "wide"));?>
        <div class='form_field'><span style="font-weight: normal; color: #000FFF"><?= $info_design_template->code_design_template;?></span></div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_image_design_template").": ", "image_design_template", array("class" => "wide"));?>
        <div class='form_field'>            
            <img src="./item_kit/design_template/<?= $info_design_template->image_design_template; ?>">          
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_description_design_template").": ", "description_design_template", array("class" => "wide"));?>
        <div class="form_field">
            <span style="font-weight: normal"><?php echo $info_design_template->description; ?></span>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend>Thông tin mẫu thiết kế</legend>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Số lượng:', 'quantity_request', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <?php echo form_label($request_production_template->quantity_request, 'quantity_request');?>
        </div>
    </div>    
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Tên công thức:', 'item_kit_feature', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <?php echo $name_feature ?>
        </div>
    </div>  
    <?php if($request_production_template->request_id){?>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
        <?php echo form_label('Công thức NVL:', 'item_kit_feature', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <table id="item_kit_items">
                <tr>
                    <th><?= lang('item_kits_item'); ?></th>
                    <th><?= lang('item_kits_unit'); ?></th>
                    <th><?= lang("item_kits_norms"); ?></th>
                </tr>
                <?php 
                if($info_formula_material){
                    foreach ($info_formula_material as $formula_material) { ?>
                    <tr>
                        <?php
                        $info_store = $this->Create_invetory->check_exist_store_materials();
                        $item_info = $this->Item->get_info_in_store_material($formula_material['item_id'], $info_store['id']);
                        $unit_info = $this->Unit->get_info($formula_material['unit']);
                        ?>
                        <td style='text-align: left'> <?= $item_info->name; ?></td>
                        <td style="text-align: left"><?= $unit_info->name;?></td>
                        <td style="width: 25%"><?= format_quantity($formula_material['quantity']); ?></td>
                    </tr>
                    <?php }
                }?>
            </table>
        </div>
    </div>  
    <?php }?>
</fieldset>
<fieldset>
    <legend>Thông tin mẫu SX</legend>    
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label("Mã mẫu sản xuất: ", "code_production_template", array("class" => "required wide"));?>
        <div class='form_field'>
            <?php echo $production_template->status == 0
                ? form_input(array(
                    'name' => 'code_production_template',
                    'id' => 'code_production_template',
                    'type' => 'text',
                    'value' => $production_template->code_production_template
                ))
                : $production_template->code_production_template;
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label("Ngày bắt đầu: ", "time", array("class" => "required wide"));?>
        <div class='form_field'>
            <?php
            echo $production_template->status == 0
                ? form_input(array(
                    'name' => 'start_date',
                    'id' => 'start_date',
                    'class' => 'date-pick',
                    'value' => $production_template->start_date ? date('d-m-Y', strtotime($production_template->start_date)) : ''
                ))
                : $production_template->start_date ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label("Ngày kết thúc: ", "time", array("class" => "required wide"));?>
        <div class='form_field'>
            <?php
            echo $production_template->status == 0
                ? form_input(array(
                    'name' => 'end_date',
                    'id' => 'end_date',
                    'class' => 'date-pick',
                    'value' => $production_template->end_date ? date('d-m-Y', strtotime($production_template->end_date)) : ''
                ))
                : $production_template->end_date ?>
        </div>
    </div>    
    <?php 
    if($production_template->id_production_template){ ?>
        <div class="field_row clearfix">
            <?php echo form_label('Trạng thái:', 'item_kit_feature', array('class' => 'wide')); ?>
            <div class='form_field'>
                <?php echo $production_template->status != 0 ? 'Đã xác nhận' : 'Chưa xác nhận' ?>
            </div>
        </div> 
    <?php 
        if($production_template->status == 0){
            echo form_submit(array(
                'value' => lang('common_submit'),
                'class' => 'submit_button float_right',
                'name' => 'save_design_template'
            ));
        }
    } else {
        echo form_submit(array(
            'value' => lang('common_submit'),
            'class' => 'submit_button float_right',
            'name' => 'save_design_template'
        ));
    }
    ?>
    <?php echo form_close(); ?>
</fieldset><br>
<script type="text/javascript">
$(document).ready(function(){
    $(".input_number").maskMoney();
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
            code_production_template:{
                required: true,
                remote: {
                    url: "<?= site_url('item_kits/check_code_production_template/'.$info_design_template->id_design_template)?>",
                    type: "POST"
                },       
            },  
            start_date:{
                required: true,
            },
            end_date:{
                required: true,
            }
        },
        messages: {
            code_production_template: {
                required: "Bạn chưa nhập mã mẫu sản xuất",
                remote: "Mã mẫu sản xuất đã tồn tại. Vui lòng nhập mã khác",
            },
            start_date:{
                required: 'Bạn chưa chọn ngày bắt đầu',
            },
            end_date:{
                required: 'Bạn chưa chọn ngày kết thúc',
            }
        }
    });
});
$('#start_date').datePicker({startDate: '01-01-1950'}).bind(
    'dpClosed',
    function(e, selectedDates){
                var d = selectedDates[0];
        if (d) {
                d = new Date(d);
            $('#end_date').dpSetStartDate(d.addDays(0).asString());
                }
        }
);
$('#end_date').datePicker().bind(
        'dpClosed',
        function(e, selectedDates){
                var d = selectedDates[0];
        if (d) {
                        d = new Date(d);
            $('#start_date').dpSetEndDate(d.addDays(0).asString());
                }
        }
);
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
#start_date, #end_date{
    width: 80px; 
    font-size: 14px;
}
#code_production_template{
    width: 100px;
}
.submit_button{
    margin-bottom:20px
}
</style>