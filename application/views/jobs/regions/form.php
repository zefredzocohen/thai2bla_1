<?php
echo form_open('regions/save/'.$jobs_regions->jobs_regions_id,array('id'=>'jobs_regions_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<div id="error"></div>
<fieldset id="jobs_basic_info" style="width: 102%;height: 460px">
    <legend><?php echo lang("regions_information"); ?></legend>

    <?php $this->load->view("jobs/regions/form_info");
    echo form_submit(array(
            'name'=>'submit',
            'id'=>'submit',
            'style'=>'margin-right: 26px',
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
        setTimeout(function(){$(":input:visible:first","#jobs_regions_form").focus();},100);
      
        var submitting = false;

        $('#jobs_regions_form').validate({
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
        $('#jobs_regions_name').change(function(){
            var jobs_regions_name = $('#jobs_regions_name').val();
            var url = $('#jobs_regions_form').attr('action');

            $.post(url,{jobs_regions_name:jobs_regions_name},function(data,success){
                $('#jobs_regions_name').focus();
                var regions_name = $.parseJSON(data);

                _smallMessage('alert_warning',regions_name.message);

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


