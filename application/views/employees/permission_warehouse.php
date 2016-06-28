<ul id="error_message_box"></ul>
<?php echo form_open('employees/save_permission_warehouse/' . $person_id, array('id' => 'permission_warehouse_form')); ?>
<fieldset id="item_basic_info">
    <legend>Thông tin phân quyền kho</legend>
    <div class="field_row clearfix">
        <?php echo form_label('Kho bán' . ':', 'warehouse_sale', array('class' => 'wide')); ?>
        <div class='form_field'>
            <select name="warehouse_sale">
                <option value="">Chọn kho bán</option>
                <?php
                
                foreach ($warehouse as $val) {
                    if ($val->id == $info_emp->warehouse_sale) {
                        echo "<option value='" . $val->id . "' selected='selected'>" . $val->name_inventory . "</option>";
                    } else {
                        echo "<option value='" . $val->id . "'>" . $val->name_inventory . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Kho nhập' . ':', 'warehouse_import', array('class' => 'wide')); ?>
        <div class='form_field'>
            <select name="warehouse_import">
                <option value="">Chọn kho nhập</option>
                <?php
                foreach ($warehouse as $val) {
                    if ($val->id == $info_emp->warehouse_import) {
                        echo "<option value='" . $val->id . "' selected='selected'>" . $val->name_inventory . "</option>";
                    } else {
                        echo "<option value='" . $val->id . "'>" . $val->name_inventory . "</option>";
                    }
                }
                ?>
            </select>
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
            $(":input:visible:first", "#permission_warehouse_form").focus();
        }, 100);

        var submitting = false;
        $('#permission_warehouse_form').validate({/*sau khi them submit no se goi lai manage*/
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_person_form_submit(response);
                    },
                    dataType: 'json'
                });

            }
        });
    });
</script>