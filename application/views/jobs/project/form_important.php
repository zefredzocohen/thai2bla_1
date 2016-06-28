<?php
echo form_open('jobs/save_important/'.$jobs_important->jobs_important_id,array('id'=>'jobs_status_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>

<fieldset id="jobs_basic_info" style="width: 100%;height: 400px">
    <legend><?php echo lang("jobs_basic_information_status"); ?></legend>
    <?php $this->load->view("jobs/project/form_important_info");
    echo form_submit(array(
            'name'=>'submit',
            'id'=>'submit',
            'style'=>'margin-left: 240px',
            'value'=>lang('common_submit'),
            'class'=>'submit_button float_right')
    );

    ?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function()
    {
        setTimeout(function(){$(":input:visible:first","#jobs_status_form").focus();},100);
        $(".module_checkboxes").change(function()
        {
            if ($(this).attr('checked'))
            {
                $(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
            }
            else
            {
                $(this).parent().find('input[type=checkbox]').attr('checked', '');
            }
        });

        var submitting = false;

        $('#jobs_status_form').validate({
            submitHandler:function(form) {
                if (submitting) return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);

                $(form).ajaxSubmit({
                    success:function(response)
                    {
                        tb_remove();
                        post_person_form_submit(response);
                        submitting = false;
                    },
                    dataType:'json'
                });

            }
        })
    });
</script>



