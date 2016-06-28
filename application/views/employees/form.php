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
    #error_message_box li{
        float: left;
    }
    #error_message_box li label{
        width: 300px;
    }
</style>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
$region = $this->Jobs_regions->get_region_id($this->Employee->get_logged_in_employee_info()->person_id);
$city = $this->Jobs_city->get_city_id($this->Employee->get_logged_in_employee_info()->person_id);
$aff = $this->Jobs_affiliates->get_aff_id($this->Employee->get_logged_in_employee_info()->person_id);
$dep = $this->Jobs_department->get_dep_id($this->Employee->get_logged_in_employee_info()->person_id);

if ($this->Employee->get_logged_in_employee_info()->person_id != 1 && $region->num_rows() == 0 && $city->num_rows() == 0 && $aff->num_rows() == 0 && $dep->num_rows() == 0
) {
    $current_employee_editing_self = $this->Employee->get_logged_in_employee_info()->person_id == $person_info->person_id;
    echo form_open_multipart('employees/save2/' . $person_info->person_id, array('id' => 'employee_form'));
    ?>
    <div id="employ_info">
    <?php
    $this->load->view("employees/form_pass");
    $this->load->view("employees/form_information");
    $this->load->view("employees/form_work");
    $this->load->view("employees/form_file");
    $this->load->view("employees/form_permission2");
    ?>
    </div>
    <?php
    } else {
        $current_employee_editing_self = $this->Employee->get_logged_in_employee_info()->person_id == $person_info->person_id;
        echo form_open_multipart('employees/save/' . $person_info->person_id, array('id' => 'employee_form'));
    ?>
    <div id="employ_info">
    <?php
    $this->load->view("employees/form_pass");
    $this->load->view("employees/form_information");
    $this->load->view("employees/form_work");
    $this->load->view("employees/form_file");
    $this->load->view("employees/form_permission");
    ?>
    </div>
    <?php } ?>

<fieldset style="border: none;float: right;margin: 20px 0">
<?php
echo form_submit(array(
    'value' => lang('common_submit'),
    'class' => 'submit_button float_right')
);
echo form_close();
?>
</fieldset>

<div id="feedback_bar"></div>

<link href="<?php echo base_url() ?>css/indexJobs.css" rel="stylesheet" type="text/css" />

<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function(){
        setTimeout(function(){$(":input:visible:first", "#employee_form").focus(); }, 100);
        $(".module_checkboxes").change(function(){
            if ($(this).attr('checked')){
                $(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
            } else {
                $(this).parent().find('input[type=checkbox]').attr('checked', '');
            }
        });
        var submitting = false;
        $('#employee_form').validate({
            submitHandler:function(form) {
            if (submitting) return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success:function(response){
                        tb_remove();
                        post_person_form_submit(response);
                        submitting = false;
                    },
                    dataType:'json'
                });
            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                id_employees: {
                    required:true,
                    remote: {
                        url: "<?php echo site_url('employees/check_emp_code/' . $person_info->person_id); ?>",
                        type: "post"
                    }
                },
                first_name:{
                    required:true,
                    remote: {
                        url: "<?php echo site_url('employees/checkname/' . $person_info->person_id); ?>",
                        type: "post"
                    }
                },
                last_name: "required",
                username: {
                    <?php if (!$person_info->person_id) { ?>
                    remote: {
                        url: "<?php echo site_url('employees/exmployee_exists'); ?>",
                        type: "post"
                    },
                    <?php } ?>
                    required:true,
                    minlength: 5
                },
                password: {
                    <?php if ($person_info->person_id == "") { ?>
                        required:true,
                    <?php } ?>
                    minlength: 8
                },
                repeat_password:{
                    equalTo: "#password"
                },
                email: "email"
            },
            messages: {
                id_employees:{
                    required: 'Vui lòng nhập mã nhân viên',
                    remote: 'Mã đã tồn tại, vui lòng chọn mã khác'
                },
                first_name:{
                    required: <?php echo json_encode(lang('common_last_name_required')); ?>
                },
                last_name: 'Vui lòng nhập tên nhân viên',
                username: {
                    <?php if (!$person_info->person_id) { ?>
                    remote: <?php echo json_encode(lang('employees_username_exists')); ?>,
                    <?php } ?>
                    required: <?php echo json_encode(lang('employees_username_required')); ?>,
                    minlength: <?php echo json_encode(lang('employees_username_minlength')); ?>
                },
                password: {
                    <?php if ($person_info->person_id == "") { ?>
                    required:<?php echo json_encode(lang('employees_password_required')); ?>,
                    <?php } ?>
                    minlength: <?php echo json_encode(lang('employees_password_minlength')); ?>
                },
                repeat_password: {
                    equalTo: <?php echo json_encode(lang('employees_password_must_match')); ?>
                },
                email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#start_work_date_employees').datePicker({startDate: '01-01-1950'});
        $('#date_identity_card').datePicker({startDate: '01-01-1950'});
        $('#birth_date').datePicker({startDate: '01-01-1950'});
        $('#date_working').datePicker({startDate: '01-01-1950'});
        $('#end_working').datePicker({startDate: '01-01-1950'});
        $('#ngaycap').datePicker({startDate: '01-01-1950'});
        $("#em_business").hide();
        $('#input_check').click(function(){
            $("#em_business").slideDown("slow");
        });
        $(".jobs_city").change(function(){
            var job_city = $(".jobs_city").val();
            jQuery.ajax({
                type:'Post',
                url:'<?php echo site_url("employees/get_affliate"); ?>',
                data:'jobcity=' + job_city,
                dataType: 'json',
                success:function(data){
                var str = "";
                    $.each(data, function(i, items){
                    str += "<option value='" + items.jobs_affiliates_id + "'>" + items.jobs_affiliates_name + "</option>";
                    });
                    $('.affiliate_job').html(str);
                }
            });
        });
    // chi nhanh
        $(".affiliate_job").change(function(){
            var department_city = $(".affiliate_job").val();
            jQuery.ajax({
                type:'Post',
                url:'<?php echo site_url("employees/get_department"); ?>',
                data:'departmentcity=' + department_city,
                dataType: 'json',
                success:function(data){
                    var str = "";
                    $.each(data, function(i, items){
                    str += "<option value='" + items.department_id + "'>" + items.department_name + "</option>";
                    });
                    $('.department_job').html(str);
                }
            });
        });
    });
</script>

