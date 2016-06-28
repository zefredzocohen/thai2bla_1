<script type="text/javascript" src="<?php echo base_url(); ?>js/add_textbox/bootstrap.js"></script>
<link href="<?php echo base_url(); ?>js/add_textbox/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
<?php
echo form_open('projects_tasks/save/' . $projects_tasks->id, array('id' => 'projects_tasks_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info" style="width: 100%;height:100%;">
    <legend><?php echo lang("customer_type_information"); ?></legend>
    <div class="field_row clearfix">	
        <?php echo form_label('Mã dự án / công việc:', ' projects_tasks_name', array('class' => 'required', 'style' => 'width:200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'projects_tasks_code',
                'id' => 'projects_tasks_code',
                'value' => $projects_tasks->id,
                'readonly' => 'readonly'
                    )
            );
            ?>
        </div>
    </div>

    <div class="field_row clearfix">
        <?php echo form_label(lang('projects_tasks_name') . ':', ' projects_tasks_name', array('class' => 'required', 'style' => 'width:200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'projects_tasks_name',
                'id' => 'projects_tasks_name',
                'value' => $projects_tasks->text)
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
            <?php echo form_label('Tên nhân viên thực hiện', 'emp_name', array('class' => 'required wide', 'style' => 'width:200px')); ?>
            <div class='form_field'>
                <?php
                echo form_input(
                        array(
                            'name' => 'emp_name',
                            'id' => 'emp_name',
                            'value' => $projects_tasks->first_name
                        )
                );
                ?>
            </div>
        </div>
    <div style="width: 400px;padding-left: 20px;">
    <table id="value_person_id">
        <tr>
            <th><div style="width: 75px;"><?php echo lang('common_delete'); ?></div></th>
            <th><?php echo 'Tên nhân viên' ?></th>
        </tr>
        <tr>
            <td><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
            <td><?php echo $projects_tasks->first_name; ?></td>
    </table>
    </div>
    <div class="field_row clearfix">	
            <?php echo form_label('Ngày bắt đầu:', 'project_task_start_date', array('style' => 'width:200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'project_task_start_date',
                'id' => 'project_task_start_date',
                'value' => $projects_tasks->end_date != '1950-01-01' ? date(get_date_format(), strtotime($projects_tasks->end_date != '' ? $projects_tasks->end_date : date('d-m-Y'))) : ''
                    )
            )
            ;
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
            <?php echo form_label('Thời hạn hoàn thành (ngày):', 'duration', array('style' => 'width:200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'duration',
                'id' => 'duration',
                'value' => $projects_tasks->duration)
            )
            ;
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
            <?php echo form_label('Tiến độ (%):', 'progress', array('style' => 'width:200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'progress',
                'id' => 'progress',
                'value' => $projects_tasks->progress * 100)
            )
            ;
            ?>
        </div>
    </div>
    <div class="field_row clearfix"> <?php echo form_label(lang('contract_file') . ':', 'contract_file'); ?>
            
            <?php if($projects_tasks->attachments == null){?>              
                  <div class='form_field'> <span style="font-size:0.81em;font-style:italic;font-weight: normal;line-height: 22px;">Chưa cập nhật file hợp đồng!</span> </div>
                <?php } else{?>
                <div class='form_field'><a href="<?php echo base_url() . 'file/contract/' . $projects_tasks->attachments ?>"><?php echo $projects_tasks->attachments ?></a></div>
                <?php }?>
            <div class='form_field'>
                <input name="contract_file" style="margin-left: 174px;width: 93px;margin-top: 10px;" type="file"/>
            </div>
        </div>
    <?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'style' => 'margin-right:16px;',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?>
</fieldset>
<?php
echo form_close();
?>

<script type='text/javascript'>
 $("#emp_name").autocomplete({
        source: '<?php echo site_url("employees/suggest"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function(event, ui)
        {
            $("#value_person_id").val("");
            
                $("#value_person_id").append("<tr><td><div style='width: 145px;'><a href='#' onclick='return deleteItemKitRow(this);'>X</a></div></td><td><input type='text' name='emp_name' value='" + ui.item.label + "' /></td></tr>");

            return false;
        }
    });
    function deleteItemKitRow(link)
    {
        $(link).parent().parent().remove();
        return false;
    }
//validation and submit handling
    $(document).ready(function()
    {

        $('#project_task_start_date').datePicker({startDate: '01-01-1950'});
        setTimeout(function() {
            $(":input:visible:first", "#projects_tasks_form").focus();
        }, 100);
        var submitting = false;

        $('#projects_tasks_form').validate({
            submitHandler: function(form)
            {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function(response)
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
                        customer_type_name: "required"
                    },
            messages:
                    {
                        customer_type_name: "Bạn cần nhập tên loại khách hàng"
                    }
        });
    });
</script>