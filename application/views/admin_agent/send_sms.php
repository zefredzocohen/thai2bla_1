<?php echo form_open('customers/do_send_sms',array('id'=>'send_sms_form'));?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="send_mail_form">
<legend><?php echo 'Lựa chọn SMS để gửi'; ?></legend>
<div class="field_row clearfix">	
<?php echo form_label('Danh sách SMS:'); ?>
    <div class='form_field'>
        <select name="sms_id">
            <option value="">--Chọn SMS---</option>
            <?php
            foreach ($list_sms->result_array() as $sms){
            ?>    
            <option value="<?php echo $sms['id']?>"><?php echo $sms['title'];?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>
<?php
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
    setTimeout(function(){$(":input:visible:first","#send_sms_form").focus();},100);
    var submitting = false;
    $('#send_sms_form').validate({
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
                        $.get('<?php echo site_url("customers/get_number_sms");?>',{},function(data){
                            $("#spansms").html(data.quantity_sms);
                        },'json');
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
            sms_id: "required"
        },
        messages: 
        {			
            sms_id: <?php echo json_encode('Vui lòng chọn SMS để gửi!'); ?>,
        }
    });    
});
</script>