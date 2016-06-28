<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<div style="font-style: italic; text-align: center">(Nội dung tin nhắn không từ tiếng việt có dấu, không vượt quá 460 ký tự, nên sử dụng các từ 'Chuc mung', 'Thong bao', 'Cam on' trước mỗi nội dung tin nhắn)</div>
<ul id="error_message_box"></ul>
<?php echo form_open('customers/save_sms/'.$info_sms->id,array('id'=>'sms_form'));?>
<fieldset id="item_basic_info">
    <legend>Thông tin SMS</legend>
    <table>
        <tr>
            <td>	
		<div class="field_row clearfix">
                    <?php echo form_label('Tiêu đề:', 'title',array('class'=>'required wide')); ?>
                    <div class='form_field'>
                    <?php echo form_input(array(
                        'name'=>'title',
                        'id'=>'title',
                        'value'=>$info_sms->title
                    ));?>
                    </div>
		</div>		
		<div class="field_row clearfix">
                    <?php echo form_label('Nội dung:', 'message',array('class'=>'required wide')); ?>
                    <div class='form_field'>
                        <textarea name="message" id="message" rows="5" cols="5" onkeyup="countChar(this)"><?php echo $info_sms->message;?></textarea>
                    </div>
		</div>	
                <div class="field_row clearfix">
                    <?php echo form_label('Số ký tự:', 'char',array('class'=>'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'char',
                            'id' => 'char',
                            'value' => $info_sms->number_char,
                            'style' => 'width: 30px !important; border: none; text-align: center;',
                            'readonly' => 'readonly'
                        ));                        
                        ?>
                    </div>
		</div>
                <div class="field_row clearfix">
                    <?php echo form_label('Số tin nhắn:', 'char',array('class'=>'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'number_message',
                            'id' => 'number_message',
                            'value' => $info_sms->number_message,
                            'style' => 'width: 30px !important; border: none; text-align: center;',
                            'readonly' => 'readonly'
                        ));                        
                        ?>                        
                    </div>     
		</div>
		<?php
		echo form_submit(array(
                    'value'=>lang('common_submit'),
		    'style'=>'margin-bottom: 20px',
                    'class'=>'submit_button float_right')
		);
		?>
            </td>
        </tr>
    </table>
</fieldset>
<?php echo form_close();?>
<script type='text/javascript'>
//validation and submit handling
$(document).ready(function(){
    setTimeout(function(){$(":input:visible:first","#sms_form").focus();},100);
    var submitting = false;
    $('#sms_form').validate({
        submitHandler:function(form){
            if (submitting) return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success:function(response){
                    submitting = false;
                    tb_remove();
                    post_item_form_submit(response);
                },
                dataType:'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules:{
            title:{
                required: true,                
            },
            message:{
                required: true,
                maxlength: 460
            },
        },
        messages:{
            title:{
                required: "Bạn chưa điền thông tin tiêu đề SMS",                
            },
            message:{
                required: "Bạn chưa điền thông tin nội dung SMS",
                maxlength: "Nội dung không vượt quá 460 ký tự"
            },
        }
    });
    
});
function countChar(input){
    var len = input.value.length;
    $("#char").val(len);
    if(len <= 156){
        $("#number_message").val(1);
    }else{
        var number_mess = (1 + Math.ceil((len - 156)/152));
        $("#number_message").val(number_mess);
    }
}
</script>