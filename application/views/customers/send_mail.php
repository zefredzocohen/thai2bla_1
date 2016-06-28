<?php
echo form_open('customers/do_send_mail',array('id'=>'send_mail_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="send_mail_form">
<legend><?php echo 'Lựa chọn mail template để gửi'; ?></legend>
<div class="field_row clearfix">	
<?php echo form_label('Danh sách mail template:'); ?>
    <div class='form_field'>
        <?php  echo form_dropdown('mail_id', $list_mail, '');?>        
    </div>
</div>
<?php
echo form_hidden('type_send',substr($_GET['type_send'],0,1));
echo form_submit(array(
    'name'=>'submit',
    'id'=>'submit',
    'style'=>'margin-right: 370px',
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
$(document).ready(function(){
    setTimeout(function(){$(":input:visible:first","#send_mail_form").focus();},100);
    var submitting = false;
    $('#send_mail_form').validate({
        submitHandler:function(form)
        {
            if (submitting) return;
            var selected_cutomer_ids=get_selected_values();
            for(k=0;k<selected_cutomer_ids.length;k++)
            {
                $(form).append("<input type='hidden' name='customer_ids[]' value='"+selected_cutomer_ids[k]+"' />");
            }
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success:function(response)
                {
                    tb_remove();
                    submitting = false;
                    if(response.success)
                    {
                        set_feedback(response.message,'success_message',false);                        
                        $(".number_mail").remove();
                        $(".table_mail tr td").remove();
                        $(".table_mail").append("<tr><td colspan='3' style='text-align: center'>Không có mail nào</td></tr>");
                    }
                    else
                    {
                        set_feedback(response.message,'error_message',true);	
                    }                    
                },
                dataType:'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules: 
        {			
            mail_id: "required"
        },
        messages: 
        {			
            mail_id: <?php echo json_encode('Vui lòng lựa chọn mail template để gửi!'); ?>,
        }
    });    
});
</script>