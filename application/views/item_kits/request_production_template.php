<script src="<?php echo base_url(); ?>js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_request_production_template/' . $info_design_template->id_design_template, array('id' => 'item_kit_request_production_template')); ?>
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
    <div class="field_row clearfix">
        <?php echo form_label('Số lượng:', 'quantity_request', array('class' => 'required wide')); ?>
        <div class='form_field'>
            <?php echo $request_production_template->status != 0
                ? $request_production_template->quantity_request 
                : form_input(array(
                    'name' => 'quantity_request',
                    'id' => 'quantity_request',
                    'value' => $request_production_template->quantity_request
                ));?>
        </div>
    </div>    
    <div class="field_row clearfix">
        <?php echo form_label('Tên công thức:', 'item_kit_feature', array('class' => 'required wide')); ?>
        <div class='form_field'>
            <?php echo $request_production_template->status != 0
                ? $name_feature
                : form_dropdown('item_kit_feature', $item_kit_feature, $request_production_template->feature_id, 'id="item_kit_feature"')
            ?>
        </div>
    </div>  
    <?php 
    if($request_production_template->request_id){?>
        <div class="field_row clearfix">
            <?php echo form_label('Trạng thái:', 'item_kit_feature', array('class' => 'wide')); ?>
            <div class='form_field'>
                <?php echo $request_production_template->status == 1 ? 'Đã tiếp nhận' : 'Chưa tiếp nhận' ?>
            </div>
        </div>  
    <?php 
        if($request_production_template->status == 0){
            echo form_submit(array(
                'value' => lang('common_submit'),
                'class' => 'submit_button float_right',
                'style' => 'margin-bottom:20px',
                'name' => 'save_design_template'
            ));
        }
    }else{
        echo form_submit(array(
            'value' => lang('common_submit'),
            'class' => 'submit_button float_right',
            'style' => 'margin-bottom:20px',
            'name' => 'save_design_template'
        ));
    }
    echo form_close(); ?>
</fieldset>
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
                quantity_request:{
                    required: true,
                    number: true,
                    remote: {
                        url: "<?= site_url('item_kits/check_number_request')?>",
                        type: "POST"
                    }
                },         
                item_kit_feature:{
                    required: true,
                }         
            },
            messages: {
                quantity_request: {
                    required: "<?= lang('item_kits_input_number_request')?>",
                    number: "<?= lang('item_kits_input_isnumber')?>",
                    remote: "<?= lang('item_kits_input_greater_zero')?>"
                },
                item_kit_feature:{
                    required: 'Bạn chưa chọn kiểu sản phẩm !',
                }   
            }
        });
        $("#request_table .input_number").each(function( index, element ) {
            $(element).blur(function(){
                var id_request = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                var number_begin = $("#input_" + id_request).val();
                if($(element).val() != number_begin){
                    if($(element).val() == 0){
                        alert("Số lượng yêu cầu phải lớn hơn 0");
                        return false;
                    }else{
                        if(confirm("Bạn có muốn cập nhật số lượng mẫu sản xuất của mã yêu cầu " + id_request + "?")){
                            $.post("<?= site_url('item_kits/update_request_production_template')?>",{id_request:id_request, number_request: $(element).val()},function(data){
                                if(data == true){
                                    var number_request = $("#input_" + id_request).val();
                                    $("#input_" + id_request).val(number_request);
                                }else{
                                    return false;
                                }
                            });
                        }else{
                            $(element).val(number_begin);
                        }
                        $("#number_request").focus();
                    }
                }
            });
        });
        $(".delete_request").click(function(){
            var id = $(this).attr("id");
            var parent = $(this).parent().parent();
            var data = "id=" + id;
            $.ajax({
                type: "post",
                url: "<?php echo site_url().'/item_kits/delete_request_production_template';?>",
                data: data,
                success: function(data){
                    if(data){
                        $(parent).remove();
                        alert("Xóa thành công");
                    }else{
                        alert("Lỗi xóa dữ liệu");
                    }
                }
            });
            return false;
        });
    });
</script>
<style type="text/css">
    .quantity{
        text-align: right;
        padding: 2px 10px;
        width: 30%;
    }
    #request_table{
        border-collapse: collapse;
        width: 99%;
        margin: 0px auto 10px auto;
    }
    #request_table td{
        padding: 5px 5px;
        border: 1px solid #CCCCCC;
    }
    .title_request{
        text-align: center;
        background: #5E5E5E;
        color: #FFFFFF;
        font-weight: bold;
    }
    .input_number{
        border: 1px solid #CCCCCC;        
    }    
</style>