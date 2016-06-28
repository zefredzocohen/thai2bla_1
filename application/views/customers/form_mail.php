<?php echo form_open('customers/save_mail/'.$mail_info->mail_id,array('id'=>'customer_mail_form')); ?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Nhập thông tin để gửi mail</legend>
<div class="field_row clearfix">	
<?php echo form_label('Tiêu đề gửi mail :', ' title_mail', array('class'=>'required')); ?>
    <div class='form_field'>
    <?php echo form_input(array(
        'name'=>'title_mail',
        'id'=>'title_mail',
        'value'=>$mail_info->mail_title)
    );?>
    </div>
</div>
<div class="field_row clearfix">	
    <label style="display: inline-block;text-indent:-1px; width: 65px;">Ghi chú :</label>
    <span style="font-size: 12px; font-style: italic; font-weight: initial;">(Dùng các từ gợi ý dưới đây để thay thế cho các từ ngữ tương ứng)</span>
    <div class="clearfix"></div>
    <style>
        .note_one{
            font-weight: normal !important;font-size: 0.77em;
            margin-top: 10px;
            width: 235px;
            float: left;
            margin-left: 2px;                                
        }
        .note_one p{
            display: block;
            margin-top: 3px;
        }                            
    </style> 
    <div class="note_one">
        <strong>Khách hàng</strong>                                   
        <p>__FIRST_NAME__ = <strong>HỌ</strong></p>                            
        <p>__LAST_NAME__ = <strong>TÊN</strong></p>                             
        <p>__PHONE_NUMBER__ = <strong>SỐ ĐIỆN THOẠI</strong></p>                           
        <p>__EMAIL__ = <strong>EMAIL</strong></p>
    </div>   
    <div class="note_one">        
        <strong>Nhân viên</strong>                                   
        <p>__FIRST_NAME_EMPLOYEE__ = <strong>HỌ</strong></p>
        <p>__LAST_NAME_EMPLOYEE__ = <strong>TÊN</strong></p>                                  
        <p>__PHONE_NUMBER_EMPLOYEE__ = <strong>SỐ ĐIỆN THOẠI</strong></p>
        <p>__EMAIL_EMPLOYEE__ = <strong>EMAIL</strong></p>
    </div>
    <div class="note_one">
        <strong>Công ty</strong>
        <p>__NAME_COMPANY__ = <strong>TÊN</strong></p>
        <p>__ADDRESS_COMPANY__ = <strong>ĐỊA CHỈ</strong></p>
        <p>__EMAIL_COMPANY__ = <strong>EMAIL</strong></p>
        <p>__FAX_COMPANY__ = <strong>FAX</strong></p>
        <p>__WEBSITE_COMPANY__ = <strong>WEBSITE</strong></p>
    </div>
    <div class="note_one">
        <strong>Hợp đồng</strong>
        <p>__NAME_CONTRACT__ = <strong>TÊN HĐ</strong></p>
        <p>__NUMBER_CONTRACT__ = <strong>SỐ HĐ</strong></p>
        <p>__START_DATE__ = <strong>NGÀY KÝ</strong></p>
        <p>__EXPIRATION_DATE__ = <strong>NGÀY HẾT HẠN</strong></p>
    </div>  
    <div class="clear"></div>
</div>
<div class="field_row clearfix">
<?php echo form_label('Nội dung gửi mail:', ' mail_content', array('class'=>'required')); ?>
    <div class='form_field'>
    <?php echo form_input(array(
        'name'=>'mail_content',
        'id'=>'mail_content',
        'value'=>$mail_info->mail_content)
    );?>
    </div>
</div>
<?php
echo form_submit(array(
    'name'=>'submit',
    'id'=>'submit',
    'style'=>'margin-right:20px',
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
    setTimeout(function(){$(":input:visible:first","#customer_mail_form").focus();},100);
    var submitting = false;
    $('#customer_mail_form').validate({ /*sau khi them submit no se goi lai manage*/
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
            title_mail: 'required',                   
        },
        messages:{
            title_mail: 'Vui lòng nhập tieu de mail',		    	
        }
    });
});
</script>