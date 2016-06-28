<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<div>* <?php echo lang('item_kits_advise_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_production_flow_template/' . $info_production_flow_template->id_production_flow_template, array('id' => 'form_production_flow_template')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_production_processes_info"); ?></legend>
    <?php echo form_hidden("id_design_template", $id_design_template); ?>   
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_name_processes").": ", "processes", array("class" => "wide required", "style" => "width: 200px"));?>
        <div class='form_field'>
            <select name="processes" id="processes">
                <option value="">Công đoạn sản xuất</option>
                <?php foreach ($processes as $value){
                    if($info_production_flow_template->id_processes == $value['id_processes']){?>
                <option value="<?= $value['id_processes']?>" selected="selected"><?= $value['name_processes'];?></option>
                <?php }else{ ?>
                    <option value="<?= $value['id_processes']?>"><?= $value['name_processes'];?></option>
                <?php }
                }?>
            </select>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_time_processes").": ", "time_processes", array("class" => "wide required", "style" => "width: 200px"));?>
        <div class='form_field'>            
            <?php echo form_input(array(
                'name' => 'time_processes',
                'id' => 'time_processes',
                'type' => 'text',
                'value' => $info_production_flow_template->time_processes,
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_unit_time").": ", "unit_time", array("class" => "wide required", "style" => "width: 200px"));?>
        <div class="form_field">
            <select name="unit_time" id="unit_time">
                <option value="">Đơn vị thời gian</option>
                <?php if($info_production_flow_template->unit_time == 0){ ?>
                <option value="0" selected="selected">Giờ</option>
                <option value="1">Ngày</option>
                <?php }else{ ?>
                <option value="0">Giờ</option>
                <option value="1" selected="selected">Ngày</option>                
                <?php }?>
            </select>
        </div>
    </div>
    <?php if($info_production_flow_template->id_production_flow_template){?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_production_order").": ", "production_order", array("class" => "wide", "style" => "width: 200px"));?>
        <div class="form_field">
            <?php echo form_input(array(
                "name" => "production_order",
                "id" => "production_order",
                "type" => "text",
                "class" => "production_order",
                "value" => $info_production_flow_template->production_order
            ));?>
        </div>
    </div>
    <?php }?>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_design_template'
    ));?>
</fieldset>    
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function () {
            $(":input:visible:first", "#form_production_flow_template").focus();
        }, 100);
        var submitting = false;
        $('#form_production_flow_template').validate({  
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
            rules:{
                processes:{
                    required: true
                },
                time_processes:{
                    required: true
                },
                unit_time:{
                    required: true
                }
            },
            messages:{
                processes:{
                    required: <?php echo json_encode(lang('item_kits_input_name_processes')); ?>
                },
                time_processes:{
                    required: <?php echo json_encode(lang('item_kits_input_time_processes')); ?>
                },
                unit_time:{
                    required: <?php echo json_encode(lang('item_kits_input_unit_time_proceses')); ?>
                }
            }
        }); 
    });
</script>