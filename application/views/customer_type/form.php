<?php
echo form_open('customer_type/save/' . $customer_type_info->customer_type_id, array('id' => 'customer_type_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
    <legend><?php echo lang("customer_type_information"); ?></legend>
    <div class="field_row clearfix">	
        <?php echo form_label(lang('customer_type_code') . ':', ' customer_type_name', array('class' => 'required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'customer_type_code',
                'id' => 'customer_type_code',
                'value' => $customer_type_info->code)
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
            <?php echo form_label(lang('customer_type_name') . ':', ' customer_type_name', array('class' => 'required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'customer_type_name',
                'id' => 'customer_type_name',
                'value' => $customer_type_info->name)
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
            <?php echo form_label(lang('customer_type_desc') . ':', 'customer_type_desc', array('class' => '')); ?>
        <div class='form_field'>
<?php
echo form_textarea(array(
    'name' => 'customer_type_desc',
    'value' => $customer_type_info->desc)
);
?>
        </div>
    </div>
    <div class="field_row clearfix">	
            <?php echo form_label('Kích hoạt' . ':', 'common_customer_type_agent', array('class' => '')); ?>
        <div class='form_field'>
            <?php
            echo form_checkbox(array(
                'name' => 'customer_type_agent',
                'id' => 'customer_type_agent',
                'value' => 'customer_type_agent',
                'checked' => $this->input->post('customer_type_agent')));
            ?>
        </div>
    </div>
    <?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'style' => 'margin-right:20px',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function ()
    {
        setTimeout(function () {
            $(":input:visible:first", "#item_form").focus();
        }, 100);
        var submitting = false;
        $('#customer_type_form').validate({/*sau khi them submit no se goi lai manage*/
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
                        customer_type_code: 'required',
                        customer_type_name:
                                {
                                    required: true,
                                    remote:
                                            {
                                                url: "<?php echo site_url('customer_type/checkname/' . $customer_type_info->customer_type_id); ?>",
                                                type: "post"
                                            }
                                },
                    },
            messages:
                    {
                        customer_type_code: 'Vui lòng nhập mã loại khách hàng',
                        customer_type_name: {
                            required: 'Vui lòng nhập tên loại khách hàng',
                            remote: 'Tên đã tồn tại, vui lòng chọn tên khác'
                        },
                    }
        });
    });
</script>