<?php
echo form_open('tkdus/save/' . $var_info->id, array('id' => 'assets_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
    <legend><?php echo lang("common_info"); ?></legend>

    <div class="field_row clearfix">	
        <?php echo form_label(lang('common_id_tk') . ':', ' tkdu_id', array('class' => 'required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'tkdu_id',
                'id' => 'tkdu_id',
                'value' => $var_info->id)
            );
            ?>
        </div>
    </div>

    <div class="field_row clearfix">	
        <?php echo form_label(lang('common_name_tk') . ':', ' chungtu_name', array('class' => 'required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'chungtu_name',
                'id' => 'chungtu_name',
                'value' => $var_info->name)
            );
            ?>
        </div>
    </div>

    <!-- longdk loại tkdu -->
    <div class="field_row clearfix">
        <?php echo form_label(lang('cat_tk') . ':', 'id_cat', array('class' => '')); ?>
        <div class='form_field'>
            <?php echo form_dropdown('id_cat', $list_acc_cat, $var_info->acc_cat_id); ?>
        </div>
    </div>

    <div id="cat_tk" class="field_row clearfix">
        <?php echo form_label(lang('cat_tk_sup') . ':', 'id_parent', array('class' => '')); ?>
        <div class='form_field'>
            <select name="id_parent" id="id_parent">
                <option value="">Chọn làm tài khoản cha</option>
                <?php foreach ($list_tkdu_parents as $parent1){
                    if($var_info->id_parent == $parent1['id']){?>
                        <option value="<?=$parent1['id']?>" selected="selected"><?=$parent1['id'].'-'.$parent1['name'] ?></option>
                    <?php }else{?>
                        <option value="<?=$parent1['id']?>"><?=$parent1['id'].'-'.$parent1['name'] ?></option>
                    <?php }
                    $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                    foreach ($parents2 as $parent2){
                        if($parent2->id == $var_info->id_parent){?>
                            <option value="<?=$parent2->id?>" selected="selected"><?='----'.$parent2->id.'-'.$parent2->name ?></option>
                        <?php }
                        else{?>
                           <option value="<?=$parent2->id?>"><?='----'.$parent2->id.'-'.$parent2->name ?></option> 
                        <?php }}?>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="field_row clearfix">	
        <?php echo form_label(lang('common_remark') . ':', ' comment'); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'comment',
                'id' => 'comment',
                'value' => $var_info->comment)
            );
            ?>
        </div>
    </div>
    <!-- end loai tkdu -->

    <?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function ()
    {
        $("#tktk").autocomplete({
            source: '<?php echo site_url("assets/tkdu_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui)
            {
                $("#tktk").val(ui.item.value);
                return false;
            }
        });
        $("#tkkh").autocomplete({
            source: '<?php echo site_url("assets/tkdu_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui)
            {
                $("#tkkh").val(ui.item.value);
                return false;
            }
        });
        $("#tkcp").autocomplete({
            source: '<?php echo site_url("assets/tkdu_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui)
            {
                $("#tkcp").val(ui.item.value);
                return false;
            }
        });
        $('#date_tang').datePicker({startDate: '01-01-1950'});
        $('#date_kh').datePicker({startDate: '01-01-1950'});
        setTimeout(function () {
            $(":input:visible:first", "#customer_type_form").focus();
        }, 100);
        var submitting = false;        
        $('#assets_form').validate({
            submitHandler: function (form)
            {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        submitting = false;
                        tb_remove();
                        post_type_cus_form_submit(response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        tkdu_id: "required",
                        chungtu_name: "required",
//                        id_cat: "required",
                    },
            messages:
                    {                        
                        tkdu_id: "Bạn cần nhập số hiệu tài khoản",
                        chungtu_name: "Bạn cần nhập tên tài khoản",
//                        id_cat: "Bạn cần chọn loại tài khoản",
                    }
        });
    });
</script>