
<div style="height:200px;">
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>

    <?php
    echo form_open('account_type/save/' . $type_info->type_id, array('id' => 'categories_form'));
    ?>
    <fieldset id="item_basic_info">
        <legend><?php echo 'Thông tin loại tài khoản'; ?></legend>

        <div class="field_row clearfix">
            <?php echo form_label('Tên loại tài khoản' . ':', 'type_name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'type_name',
                    'id' => 'type_name',
                    'value' => $type_info->type_name)
                );
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
    </fieldset><?php
    echo form_close();
    ?>
</div>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function ()
    {
        setTimeout(function () {
            $(":input:visible:first", "#item_form").focus();
        }, 100);
        var submitting = false;
        $('#categories_form').validate({/*sau khi them submit no se goi lai manage*/
            submitHandler: function (form)
            {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        submitting = false;
                        tb_remove();
                        post_item_form_submit(response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        type_name:
                                {
                                    required: true,
                                    remote:
                                            {
                                                url: "<?php echo site_url('account_type/check_name/' . $type_info->type_id); ?>",
                                                type: "post"
                                            }
                                },
                    },
            messages:
                    {
                        type_name: {
                            required: 'Vui lòng nhập tên loại tài khoản',
                            remote: 'Tên tài khoản đã tồn tại, vui lòng chọn tên khác'
                        },
                    }
        });
    });
</script>