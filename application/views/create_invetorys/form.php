<?php echo form_open('create_invetorys/save/' . $create_invetorys->id, array('id' => 'inventory_form')); ?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
    <legend><?php echo 'Thông tin kho'; ?></legend>
    <div class="field_row clearfix">    
        <?php echo form_label('Tên kho' . ':', ' name_inventory', array('class' => 'required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'name_inventory',
                'id' => 'name_inventory',
                'size' => '35',
                'value' => $create_invetorys->name_inventory)
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Địa chỉ' . ':', 'inventory_address', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'name_address',
                'id' => 'name_address',
                'size' => '35',
                'value' => $create_invetorys->address
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">    
        <?php echo form_label('Mô tả kho' . ':', 'desc_inventory', array('class' => '')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'desc_inventory',
                'size' => '35',
                'value' => $create_invetorys->description)
            );
            ?>
        </div>
    </div>   
    <?php if (!$check_store_materials && !$check_product_inventory) { ?>
        <div class="field_row clearfix">
            <?php echo form_label('Loại kho lưu trữ:', 'type_waehouse', array('class' => '')); ?>
            <div class='form_field'>
                <select name="type_warehouse">
                    <option value="0">--- Chọn loại kho lưu trữ ---</option>                  
                    <option value="1">Kho lưu trữ thành phẩm</option>                   
                    <option value="2">Kho lưu trữ nguyên vật liệu để sản xuất</option>
                </select>
            </div>
        </div>
    <?php } else if ($check_store_materials && !$check_product_inventory) { ?>
        <div class="field_row clearfix">
            <?php echo form_label('Loại kho lưu trữ:', 'type_waehouse', array('class' => '')); ?>
            <div class='form_field'>
                <select name="type_warehouse">
                    <option value="0">--- Chọn loại kho lưu trữ ---</option>                  
                    <option value="1">Kho lưu trữ thành phẩm</option>
                </select>
            </div>
        </div>
    <?php } else if (!$check_store_materials && $check_product_inventory) { ?>
        <div class="field_row clearfix">
            <?php echo form_label('Loại kho lưu trữ:', 'type_waehouse', array('class' => '')); ?>
            <div class='form_field'>
                <select name="type_warehouse">
                    <option value="0">--- Chọn loại kho lưu trữ ---</option>                  
                    <option value="2">Kho lưu trữ nguyên vật liệu để sản xuất</option>
                </select>
            </div>
        </div>
    <?php
    } else {
        echo "";
    }
    ?>

<!-- GOOGLE MAPS PLACES -->
    <div class="field_row clearfix">
        <p style="color:red;padding:5px">Infomation Google Maps</p>
        <?php echo form_label('ID_Province Tỉnh' . ':', 'id_province', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'id_province',
                'id' => 'id_province',
                'size' => '35',
                'value' => $create_invetorys->id_province
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Tên Tỉnh' . ':', 'name_province', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'name_province',
                'id' => 'name_province',
                'size' => '35',
                'value' => $create_invetorys->name_province
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('ID Quận' . ':', 'id_district', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'id_district',
                'id' => 'id_district',
                'size' => '35',
                'value' => $create_invetorys->id_district
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Map x' . ':', 'map_x', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'map_x',
                'id' => 'map_x',
                'size' => '35',
                'value' => $create_invetorys->map_x
            ));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Map Y' . ':', 'map_y', array('class' => '')); ?>
        <div class="form_field">
            <?php
            echo form_input(array(
                'name' => 'map_y',
                'id' => 'map_y',
                'size' => '35',
                'value' => $create_invetorys->map_y
            ));
            ?>
        </div>
    </div>

    <?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?>
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#inventory_form").focus();
        }, 100);
        var submitting = false;
        $('#inventory_form').validate({
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_inventory_form_submit(response);
                    },
                    dataType: 'json'
                });
            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                name_inventory: {
                    required: true,
                    remote: {
                        type: 'post',
                        url: '<?php echo site_url('/create_invetorys/check_name/' . $create_invetorys->id); ?>',
                    }
                }
            },
            messages: {
                name_inventory: {
                    required: "Bạn cần nhập tên kho",
                    remote: 'Tên kho đã tồn tại'
                }
            }
        });
        $("#store_material").click(function () {
            if ($("#store_material").is(":checked")) {
                $("#product_store").not(":checked");
            }
        });
        $("#product_store").click(function () {
            if ($("#product_store").is(":checked")) {
                $("#store_material").not(":checked");
            }
        });
    });
</script>