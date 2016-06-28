<?php
echo form_open_multipart('file/save/'.$jobs_file->jobs_file_id,array('id'=>'jobs_file_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<div id="error"></div>
<fieldset id="jobs_basic_info" style="width: 100%;height: 600px">
    <legend><?php echo lang("file_information_infos"); ?></legend>
    <?php $this->load->view("jobs/file/form_info");
    echo form_submit(array(
            'style'=>'margin-left: 278px',
            'value'=>lang('common_submit'),
            'class'=>'submit_button float_right')
    );

    ?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>

        $(document).ready(function()
        {
            setTimeout(function(){$(":input:visible:first","#jobs_file_form").focus();},100);
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
            checkRegionsName();
            $('#jobs_file_date').datePicker({startDate: '01-01-1960'});

            var submitting = false;

            $('#jobs_file_form').validate({
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
    function checkRegionsName()
    {
        $('#jobs_file_name').change(function(){
            var jobs_file_name = $('#jobs_file_name').val();
            var url = $('#jobs_file_form').attr('action');

            $.post(url,{jobs_file_name:jobs_file_name},function(data,success){
                $('#jobs_file_name').focus();
                if(success){
                    var regions_name = $.parseJSON(data);
                    _smallMessage('alert_warning',regions_name.message);
                }else{
                    _smallMessage('alert_error',regions_name.message);
                }
            });
        });
    }

</script>
<script type="text/javascript" src="<?php echo base_url()?>js/jsForm.js"></script>
<style>
    #error h4.alert_warning {
        display: block;
        width: 100%;
        background-position: 10px 10px;
        border: 1px solid #F5F5F5;
        color: #796616;
        text-indent: 10px;
        font-size: 13px;
        position: relative;
        height: 25px;
        line-height: 25px;
        left: 0px;
        top: -1px;
    }
</style>


