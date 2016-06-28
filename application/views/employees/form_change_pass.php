<style type="text/css">
    .field{
        float: left;
        text-align: left;
        width: 115px;
        color: black; 
    }
    label{
        display: inline-block;
        width: 130px;
        float: left;
        height: 25px;
    }
    input[type=password],
    input[type=date],
    input[type=text],select{
        border: 1px inset #D0D0D0;
        display: inline-block;
        height: 26px;
        width: 170px;
        padding-left: 3px;
        float: left;
    }
    select{
        width: 171px !important;
        text-transform: capitalize;
        font-size: 12px;
    }
    p{
        clear: both;
        line-height: 20px;
        padding: 5px;
        width: 330px;
        overflow: hidden;
    }
    #employ_info,#careers_employees{
        width: 100%;
        height: auto;
        float: left;
    }
    #fist_info{
        width: 300px;
    }
    #second_info{
        margin: -200px 344px -1px 27px;
        margin-left: 5px;
        float: right;
        width: 300px;
    }
    #thirt_info{
        float: right;
        margin-top: -200px;
        margin-left: 16px;
        margin-right: 15px;
    }
    #second_careers_info{
        margin: -202px 344px -1px 27px;
        margin-left: 5px;
        float: right;
        width: 300px;
    }
    #thirt_careers_info{
        float: right;
        margin-top: -212px;
        margin-left: 16px;
        margin-right: 15px;
    }

    p{
        font-family: "Arial",sans-serif;
        font-size : 13px;
    }
    ul li input[type=checkbox]{
        width: 13px;
        height: 13px;
    }
    ul li ul li input[type=checkbox] {
        height: 12px;
        width: 12px;
        margin: 0 10px;
    }

</style>
<style>
	.face_img img{
		width: 150px;
		height:175px;
	    border: 1px solid #CCCCCC;
		padding:1px;
		margin-top:-20px;
	}
	label{
		width: 200px;
 		float: none;
	}
</style>
<ul id="error_message_box"></ul>
 <?php echo form_open_multipart('secure_area/save_change_pass/' . $user_info2->person_id, 
 				array('id' => 'employee_form',
 					  'style'=> 'margin-top:30px'
 				));?>
         <div class="lable" style="width:320px;display: block;height: 40px">
        	<div style="float:left;display: inline-block;width:135px;margin-left: 5px">
            	<?php echo form_label('Mật khẩu cũ:', 'password_old') ?>
            </div>
            <div class='form_field' style="float: left">
                <?php echo form_password(array(
                    'name'=>'password_old',
                    'id'=>'password_old',
                    'style'=>'margin-top: -7px',
                ));?>
            </div>
        </div>
        <div class="lable" style="width:320px;display: block;height: 40px">
        	<div style="float:left;display: inline-block;width:135px;margin-left: 5px">
            	<?php echo form_label('Mật khẩu mới:', 'password') ?>
            </div>
            <div class='form_field' style="float: left">
                <?php echo form_password(array(
                    'name'=>'password',
                    'id'=>'password',
                    'style'=>'margin-top: -7px',                    
                ));?>
            </div>
        </div>
		<div class="lable" style="width:320px;display: block;height: 40px">
         	<div style="float:left;display: inline-block;width:135px;margin-left: 5px">
            	<?php echo form_label('Nhập lại mật khẩu mới:', 'password') ?>
            </div>
            <div class='form_field' style="float: left">
                <?php echo form_password(array(
                    'name'=>'repeat_password',
                    'id'=>'repeat_password',
                    'style'=>'margin-top: -6px',
                ));?>
            </div>
        </div>
<fieldset style="border: none;float: right;margin-top: -15px">
	
    <?php
    echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    echo form_close();
    ?>	
    </fieldset>
<script type="text/javascript">
$(document).ready(function(){
    $('#employee_form').validate({
        submitHandler:function(form3) {
            $(form3).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form3).ajaxSubmit({
            	success:function(response){
	            	tb_remove();
					post_person_form_submit(response);
            	},
				dataType:'json'
        	});
 		},
 		errorLabelContainer: "#error_message_box",
		wrapper: "li",
		rules:{
 			password_old:{
				required:true,
				remote: { 
					//url: "<?php //echo site_url('employees/checkpass_old/'. $user_info2->person_id);?>", 
                                        url: "<?php echo site_url('home/checkpass_old/'. $user_info2->person_id);?>",
					type: "post"
				}
			},
			password:{
				required:true,
				minlength: 8,
				remote: { 
					//url: "<?php //echo site_url('employees/checkpass_same/'. $user_info2->person_id);?>", 
                                        url: "<?php echo site_url('home/checkpass_same/'. $user_info2->person_id);?>", 
					type: "post"
				}
			},
			repeat_password:{
				equalTo:'#password'
			}
		},
		messages:{
			password_old:{
				required:'Vui lòng nhập mật khẩu cũ',
				remote: 'Mật khẩu cũ không đúng',
			},
			password:{
				required: 'Vui lòng nhập mật khẩu mới',
				minlength: 'Mật khẩu mới ít nhất 8 ký tự',
				remote: 'Mật khẩu mới phải khác mật khẩu cũ',		
			},
			repeat_password: {
				equalTo: 'Mật khẩu mới không khớp với nhau'
			}
		}
	});
});
</script>