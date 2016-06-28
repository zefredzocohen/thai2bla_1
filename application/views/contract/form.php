

<!--Không dùng form này-->


<div style="height:200px;">
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>
    <?php
    echo form_open('contracts/save/' . $contract_info->id_hopdong, array('id' => 'contract_form'));
    ?>
    <fieldset id="contracts_info">
        <legend><?php echo lang("contracts_info"); ?></legend>
        <div class="field_row clearfix" style="border: none" id="status_module">
            <?php echo form_label(lang('employees_city') . ':', 'city', array('class' => 'required')); ?>
            <div class='form_field'>
                <select name='city' class="jobs_city" style="padding-top: 4px; height: 31px; width: 163px;" >
                    <?php foreach ($jobs_city as $jobs_citys) { ?>
                        <option value="<?php echo $jobs_citys['jobs_city_id']; ?>" ><?php echo $jobs_citys['jobs_city_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix" style="border: none" id="status_module">
            <?php echo form_label(lang('employees_chinhanh') . ':', 'chinhanh', array('class' => 'required')); ?>
            <div class='form_field'>
                <select name='chinhanh' class="affiliate_job" style="padding-top: 4px; height: 31px; width: 163px;" name="affiliate" >

                </select>
            </div>
        </div>
        <div class="field_row clearfix" style="border: none" id="status_module">
            <?php echo form_label(lang('employees_phongban') . ':', 'phongban', array('class' => 'required')); ?>
            <div class='form_field'>
                <select name='phongban' class="department_job" style="padding-top: 4px; height: 31px; width: 163px;" name="department">

                </select>
            </div>
        </div>

        <div class="field_row clearfix" style="border: none" id="status_module">
            <?php echo form_label(lang('employees_chucvu') . ':', 'chucvu', array('class' => 'required')); ?>
            <div class='form_field'>
                <select name='chucvu' class="em_chucvu">
                    <?php foreach ($jobs_position as $jobs_positions) { ?>
                        <option value="<?php echo $jobs_positions['jobs_positions_id']; ?>" ><?php echo $jobs_positions['jobs_positions_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="field_row clearfix" style="border: none" id="status_module">
            <?php echo form_label(lang('employees_full_name') . ':', 'nhanvien', array('class' => 'required')); ?>
            <div class='form_field'>
                <select name='first_name' class="first_name">
                </select>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label(lang('contracts_id') . ':', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'ma_hopdong',
                    'id' => 'ma_hopdong'
                   )
                );
                ?>
            </div>
        </div>

        <div class="field_row clearfix">
                    <?php echo form_label(lang('contracts_type') . ':', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <select name='contracts_type'>
                    <?php foreach ($loai_hopdong as $loai_hopdongs) { ?>
                        <option value="<?php echo $loai_hopdongs['id_ma_hopdong']; ?>" ><?php echo $loai_hopdongs['ten_maloai_hopdong']; ?></option>
<?php } ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix">
                <?php echo form_label(lang('contracts_start_date') . ':', 'start_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contracts_start_date',
                    'id' => 'contracts_start_date1'
                        )
                );
                ?>
            </div>
        </div>

        <div class="field_row clearfix">
        <?php echo form_label(lang('contracts_end_date') . ':', 'end_date'); ?>
            <div class='form_field'>
                <input type="text" name="contract_end_date" class="end_date1">
            </div>
        </div>
			<div class="field_row clearfix">
                    <label>Hợp đồng:</label>
                    <div class='form_field'>
                        <a href="<?php echo base_url() .'file/'.$loai_hopdongs['file_name'] ?>">
                            <span style="font-size: 11px;font-style:italic;font-weight: normal;line-height: 22px;"><?php echo $loai_hopdongs['file_name']  ?></span> </a></div>
            </div>
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
</div>
<script type='text/javascript'>
    $(document).ready(function()
            {
            $('.end_date1').datePicker({startDate: '01-01-1950'});
                    $('#contracts_start_date1').datePicker({startDate: '01-01-1950'});
                    $(".jobs_city").change(function(){
            var job_city = $(".jobs_city").val();
                    //alert(job_city);
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
// ten nhan vien
                    $(".em_chucvu").change(function(){
            var chucvunhanvien = $(".em_chucvu").val();
                    jQuery.ajax({
                    type:'Post',
                            url:'<?php echo site_url("employees/get_first_name"); ?>',
                            data:'machucvu=' + chucvunhanvien,
                            dataType: 'json',
                            success:function(data){
                            var str = "";
                                    $.each(data, function(i, items){
                                    str += "<option value='" + items.person_id + "'>" + items.first_name + "</option>";
                                    });
                                    $('.first_name').html(str);
                            }
                    });
            });
            });</script>
<script type='text/javascript'>

//validation and submit handling
            $(document).ready(function()
            {
            setTimeout(function(){$(":input:visible:first", "#item_form").focus(); }, 100);
                    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function()
            {
            $("#hdn_start_date").val($("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val());
                    $("#hdn_end_date").val($("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val());
            });
                    $("#category").autocomplete({
            source: "<?php echo site_url('categories/suggest_category'); ?>",
                    delay: 10,
                    autoFocus: false,
                    minLength: 0
            });
                    var submitting = false;
                    $('#contract_form').validate({ /*sau khi them submit no se goi lai manage*/
            submitHandler:function(form)
            {
            if (submitting) return;
                    submitting = true;
                    $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                    $(form).ajaxSubmit({
            success:function(response)
            {
            submitting = false;
                    tb_remove();
                    post_item_form_submit(response);
            },
                    dataType:'json'
            });
            },
                    errorLabelContainer: "#error_message_box",
                    wrapper: "li",
                    rules:
            {
<?php if (!$item_info->id_cat) { ?>
                item_number:
                {
                remote:
                {
                url: "<?php echo site_url('categories/item_number_exists'); ?>",
                        type: "post"

                }
                },
<?php } ?>
            name:"required",
                    category:"required",
                    // cost_price:
                    // {
                    // number:true
                    // },

                    // unit_price:
                    // {
                    // required:true,
                    // number:true
                    // },
                    tax_percent:
            {
            required:true,
                    number:true
            },
                    quantity:
            {
            required:true,
                    number:true
            },
                    reorder_level:
            {
            required:true,
                    number:true
            }
            },
                    messages:
            {
<?php if (!$item_info->item_id) { ?>
                item_number:
                {
                remote: <?php echo json_encode(lang('items_item_number_exists')); ?>

                },
<?php } ?>
            name:<?php echo json_encode(lang('items_name_required')); ?>,
                    category:<?php echo json_encode(lang('items_category_required')); ?>,
                    // cost_price:
                    // {
                    // number:<?php echo json_encode(lang('items_cost_price_number')); ?>
                    // },
                    // unit_price:
                    // {
                    // required:<?php echo json_encode(lang('items_unit_price_required')); ?>,
                    // number:<?php echo json_encode(lang('items_unit_price_number')); ?>
                    // },
                    tax_percent:
            {
            required:<?php echo json_encode(lang('items_tax_percent_required')); ?>,
                    number:<?php echo json_encode(lang('items_tax_percent_number')); ?>
            },
                    quantity:
            {
            required:<?php echo json_encode(lang('items_quantity_required')); ?>,
                    number:<?php echo json_encode(lang('items_quantity_number')); ?>
            },
                    reorder_level:
            {
            required:<?php echo json_encode(lang('items_reorder_level_required')); ?>,
                    number:<?php echo json_encode(lang('items_reorder_level_number')); ?>
            }

            }
            });
                    });
</script>
