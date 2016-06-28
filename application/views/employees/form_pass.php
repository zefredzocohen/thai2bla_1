<style>
	.face_img img{
		width: 150px;
		height:175px;
	    border: 1px solid #CCCCCC;
		padding:1px;
		margin-top:-20px;
	}
</style>
<fieldset id="item_basic_info">
    <legend><h4 style="color:red;">Thông tin tài khoản</h4></legend>
	<div style="float:left; width:300px">
    <div id="login_form" style="margin-top: 20px;padding-bottom: 10px">
    
        <div class="lable" style="width:300px;display: block;height: 40px">
		<?php if(empty($person_info->person_id)){ ?> 
			 <?php echo form_label(lang('employees_username').':', 'username',array('class'=>'required','style'=>'float:left;display: inline-block;width:110px;margin-left: 5px;')); ?>
            <div class='form_field' style="float: left;display: block;">
                <?php echo form_input(array(
                    'name'=>'username',
                    'id'=>'username',
                    'style'=>'margin-top: -6px',
                    'value'=>$person_info->username
                ));?>
            </div>
		<?php }else{ ?>
            <?php echo form_label(lang('employees_username').':', 'username',array('class'=>'required','style'=>'float:left;display: inline-block;width:110px;margin-left: 5px;')); ?>
            <div class='form_field' style="float: left;display: block;">
                <?php echo form_input(array(
                    'name'=>'username',
                    'id'=>'username',
                    'style'=>'margin-top: -6px',
                    'value'=>$person_info->username
                ));?>
            </div>
		<?php } ?>
        </div>
        
        <?php
        $password_label_attributes = $person_info->person_id == "" ? array('class'=>'required') : array();
        ?>
        <div class="lable" style="width:300px;display: block;height: 40px">
        	<div style="float:left;display: inline-block;width:110px;margin-left: 5px">
            	<?php echo form_label(lang('employees_password').':', 'password',$password_label_attributes) ?>
            </div>
            <div class='form_field' style="float: left">
                <?php echo form_password(array(
                    'name'=>'password',
                    'id'=>'password',
                    'style'=>'margin-top: -7px'
                ));?>
            </div>
        </div>

        <div class="lable" style="width:300px;display: block;height: 40px">
         	<div style="float:left;display: inline-block;width:110px;margin-left: 5px">
            	<?php echo form_label(lang('employees_repeat_password').':', 'password',$password_label_attributes) ?>
            </div>
            <div class='form_field' style="float: left">
                <?php echo form_password(array(
                    'name'=>'repeat_password',
                    'id'=>'repeat_password',
                    'style'=>'margin-top: -6px',
                ));?>
            </div>
        </div>
    </div>
	</div>
	<div style="float:left; width:670px" class="face_img">
			<!--- phan lam anh -->

<div style="float: left;width: 440px;padding: 20px 0 0 10px;margin-left: 10px">
            <label class="field" style="width: 150px;border: none;float: left">Tải lên ảnh nhân viên : </label>
	<div class='form_field'>
		<?php echo form_input(array(
			'name'=>'image_face',
			'id'=>'image_face',
			'type'=>'file'
		));?>
	</div>
</div>
<div style="float: left;width: 200px;margin-left: 10px">
		 <?php if($person_info->image_face == ''){?>
                <div class="field_row clearfix" style="border: none">                    
                    <div class='form_field'>
                           <img src="<?php echo base_url() .'images/noimage.gif'?>" />
                    </div>
                </div>
				<?php } else{?>
                <div class="field_row clearfix" style="border-bottom:none">
                    <div class='form_field'>
                        <img src="<?php echo base_url() .'file/' .$person_info->image_face ?>" />
                     </div>
                </div>
            <?php }?>
</div>

<!-- end phan lam anh -->
	</div>
</fieldset>