<style>
#tk_co, #tk_no{
    width: 269px
}
</style>
<?= form_open('account_plan/save/'.$id, array('id'=>'assets_form')) ?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Thông tin Hoạch định tài khoản </legend>
<div class="field_row clearfix">	
<?php echo form_label('Tên tài khoản:', 'name', array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$cost_info->name)
	);?>
	</div>
</div>
<div class="field_row clearfix">
    <?php  echo form_label('Tài khoản nợ:', 'tk_no',array('class'=>'required')); ?>
    <div class='form_field'>
        <select name="tk_no" id="tk_no">
            <option value="">Chọn tài khoản nợ</option>
            <?php 
            foreach ($list_tkdu_parents as $parent1){?>
                <option value="<?=$parent1['id']?>" <?= $cost_info->tk_no == $parent1['id'] ? 'selected' : '' ?> >
                    <?=$parent1['id'].' - '.$parent1['name'] ?>
                </option>
                <?php
                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                foreach ($parents2 as $parent2){?>
                    <option value="<?=$parent2->id?>" <?= $parent2->id == $var_info->id_parent ? 'selected' : '' ?> >
                        <?='---- '.$parent2->id.' - '.$parent2->name ?>
                    </option>
                    <?php
                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                    foreach ($parents3 as $parent3){?>
                        <option value="<?=$parent3->id?>" <?= $parent3->id == $var_info->id_parent ? 'selected' : '' ?> >
                            <?='----.---- '.$parent3->id.' - '.$parent3->name ?>
                        </option>
                        <?php
                    }
                }
            }?>
        </select>
    </div>
</div>
<div class="field_row clearfix">
    <?php  echo form_label('Tài khoản có:', 'tk_co',array('class'=>'required')); ?>
    <div class='form_field'>
        <select name="tk_co" id="tk_co">
            <option value="">Chọn tài khoản có</option>
            <?php 
            foreach ($list_tkdu_parents as $parent1){?>
                <option value="<?=$parent1['id']?>" <?= $cost_info->tk_co == $parent1['id'] ? 'selected' : '' ?> >
                    <?=$parent1['id'].' - '.$parent1['name'] ?>
                </option>
                <?php
                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                foreach ($parents2 as $parent2){?>
                    <option value="<?=$parent2->id?>" <?= $parent2->id == $var_info->id_parent ? 'selected' : '' ?> >
                        <?='---- '.$parent2->id.' - '.$parent2->name ?>
                    </option>
                    <?php
                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                    foreach ($parents3 as $parent3){?>
                        <option value="<?=$parent3->id?>" <?= $parent3->id == $var_info->id_parent ? 'selected' : '' ?> >
                            <?='----.---- '.$parent3->id.' - '.$parent3->name ?>
                        </option>
                        <?php
                    }
                }
            }?>
        </select>
    </div>
</div>
<?= form_submit(array(
        'name'=>'submit',
        'id'=>'submit',
        'value'=>lang('common_submit'),
        'class'=>'submit_button float_right'
    ));?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>
$(document).ready(function(){
    $( "#tk_co" ).change(function(){
        var tk_co = $("#tk_co").val();
        var tk_no = $("#tk_no").val();
        if(tk_co == tk_no){
            alert('Tài khoản có không được giống tài khoản nợ !');
            $("#tk_co").val('');
            return false;
        }
    });
    $( "#tk_no" ).change(function(){
        var tk_co = $("#tk_co").val();
        var tk_no = $("#tk_no").val();
        if(tk_co == tk_no){
            alert('Tài khoản có không được giống tài khoản nợ !');
            $("#tk_no").val('');
            return false;
        }
    });    
    
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
    var submitting = false;
    $('#assets_form').validate({
        submitHandler:function(form){
            if (submitting) return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success:function(response){
                        submitting = false;
                        tb_remove();
                        post_type_cus_form_submit(response);
                },
                dataType:'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules: {
            name: "required",
            tk_co: "required",
            tk_no: "required",
        },
        messages: {
            name: "Bạn cần nhập tên tài khoản",
            tk_co: "Bạn chưa chọn tài khoản có",
            tk_no: "Bạn chưa chọn tài khoản nợ",
        }
    });
});

</script>