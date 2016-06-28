
<div style="height:200px;">
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>

    <?php
    echo form_open('currencys/save/' . $info_currency->id, array('id' => 'categories_form'));
   
    ?>
    <fieldset id="item_basic_info">
        <legend><?php echo 'Thông tin ngoại tệ'; ?></legend>

        <div class="field_row clearfix">
            <?php echo form_label('Mã ngoại tệ' . ':', 'currency_id', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'currency_id',
                    'id' => 'currency_id',
                    'value' => $info_currency->currency_id)
                );
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Tên ngoại tệ' . ':', 'currency_name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'currency_name',
                    'id' => 'currency_name',
                    'value' => $info_currency->currency_name)
                );
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Giá ngoại tệ' . ':', 'currency_name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'currency_rate',
                    'id' => 'currency_rate',
                    'value' => $info_currency->currency_rate)
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
                       currency_id:
                                {
                                    required: true,
                                    remote:
                                            {
                                                url: "<?php echo site_url('currencys/check_id/' . $info_currency->id); ?>",
                                                type: "post"
                                            }
                                },
                        
                        currency_name:
                                {
                                    required: true,
                                    remote:
                                            {
                                                url: "<?php echo site_url('currencys/check_name/' . $info_currency->id); ?>",
                                                type: "post"
                                            }
                                },
                              
                       currency_rate:
                                {
                                    required: true,
                                    number:true
                                },
                    },
            messages:
                    {
                        currency_id: {
                            required: 'Vui lòng nhập mã ngoại tệ',
                            remote: 'Mã ngoại tệ đã tồn tại, vui lòng chọn mã khác'
                        },
                        currency_name: {
                            required: 'Vui lòng nhập tên ngoại tệ',
                            remote: 'Tên ngoại tệ đã tồn tại, vui lòng chọn tên khác'
                        },
                        currency_rate: {
                            required: 'Vui lòng nhập giá ngoại tệ',
                            number:"Giá ngoại tệ phải là số"
                        },
                    }
        });
    });
    

</script>