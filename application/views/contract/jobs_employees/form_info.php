<script type="text/javascript">
    $(document).ready(function() {
        $('#date_start').datePicker({startDate: '01-01-1960'});
        $('#date_end').datePicker({startDate: '01-01-1960'});
    });
</script>

<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_city_regions_name') . ':', 'jobs_name', array('class' => '')); ?>
        <select name='jobs_regions_id' id='jobs_regions_id'  required="required" onchange="clickSendRegions()">
            <option value="">--- Chọn khu vực ---</option>
            <?php foreach ($regions_info AS $key => $values): ?>
                <?php if ($values->jobs_regions_id == $jobs_affiliates->jobs_regions_id) { ?>
                    <option value="<?php echo $values->jobs_regions_id; ?>" selected="selected"><?php echo $values->jobs_regions_name; ?></option>
                <?php } else { ?>
                    <option value="<?php echo $values->jobs_regions_id; ?>"><?php echo $values->jobs_regions_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>

<div class="action_show">
    <div class="field_row clearfix_city" style="border: none" id="status_module">
        <div class='form_field'>
            <?php echo form_label(lang('common_affiliates_city_name') . ':', 'jobs_name', array('class' => '')); ?>
            <select name='jobs_city_id' id='jobs_city_id' required="required" onchange="clickSendCity();">
                <option value="">--- Chọn thành phố ---</option>
                <?php foreach ($city_info AS $key => $values): ?>
                    <?php if ($values->jobs_city_id == $jobs_affiliates->jobs_city_id) { ?>
                        <option value="<?php echo $values->jobs_city_id; ?>" selected="selected"><?php echo $values->jobs_city_name; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $values->jobs_city_id; ?>"><?php echo $values->jobs_city_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>
    <div id="city_show">
        <div class="field_row clearfix_affiliates" style="border: none;" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_affiliates_name') . ':', 'jobs_name', array('class' => '')); ?>
                <select name='jobs_affiliates_id' id='jobs_affiliates_id'  required="" onchange="clickSendAffiliates()">
                    <option value="">--- Chọn chi nhánh ---</option>
                    <?php foreach ($affiliates_info AS $key => $values): ?>
                        <?php if ($values->jobs_affiliates_id == $jobs_affiliates->jobs_affiliates_id) { ?>
                            <option value="<?php echo $values->jobs_affiliates_id; ?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $values->jobs_affiliates_id; ?>"><?php echo $values->jobs_affiliates_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>
        <div id="affiliates_show">
            <div class="field_row clearfix_city" style="border: none" id="status_module">
                <div class='form_field'>
                    <?php echo form_label(lang('common_department_name') . ':', 'jobs_name', array('class' => '')); ?>
                    <select name='department_id' id='department_id' required="required" onchange="clickSendDepartment()">
                        <option value="">--- Chọn phòng ban ---</option>
                        <?php foreach ($department_info AS $key => $values): ?>
                            <?php if ($values->department_id == $contact_info->department_id) { ?>
                                <option value="<?php echo $values->department_id; ?>" selected="selected"><?php echo $values->department_name; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $values->department_id; ?>"><?php echo $values->department_name; ?></option>
                            <?php }endforeach; ?>
                    </select>
                </div>
            </div>
            <div id="showEmployees">
                <div class="field_row clearfix" id="status_module" style="height: 50px">
                    <div class='form_field'>
                        <?php echo form_label(lang('common_jobs_employees_name') . ':', 'jobs_person_name', array('class' => 'required')); ?>
                        <select name='jobs_person_name[]' id="jobs_person_name"  multiple="multiple" size="15" style="height: 60px !important;margin-bottom: 10px " >
                            <?php foreach ($employees_info AS $key => $values): ?>
                                <?php if ($values['person_id'] == $contact_info->person_id) { ?>
                                    <option value="<?php echo $values['person_id']; ?>" selected="selected"><?php echo $values['first_name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $values['person_id']; ?>"><?php echo $values['first_name'] ?></option>
                                <?php }endforeach; ?>
                        </select>
                    </div>
                </div>
            </div><!--end #showEmployees-->

        </div><!--end #affiliates_show-->
    </div><!--end #city_show-->

</div><!--end #action_show-->

<div class="field_row clearfix" id="status_module" style="margin-top: 28px">
    <?php echo form_label('Mã hợp đồng : ', 'jobs_regions_name', array('class' => 'required')); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
            'name' => 'jobs_regions_name',
            'id' => 'jobs_regions_name',
            'required' => '',
            'value' => $contract_info->ma_hopdong)
        );
        ?>
    </div>
</div>
<?php $type_customers = $this->Contractemp_types->get_Contractemp_types(); ?>
<?php if ($contract_info->loai_hopdong != null) { ?>
    <div class="field_row clearfix">
        <?php echo form_label('Loại hợp đồng :', 'customer_type'); ?>
        <div class='form_field'>
            <select name="customer_type">
                <?php foreach ($type_customers as $type_customer) { ?>
                    <?php if ($contract_info->loai_hopdong == $type_customer['id_ma_hopdong']) { ?>
                        <option value="<?php echo $type_customer['id_ma_hopdong']; ?>" selected="selected"><?php echo $type_customer['ten_maloai_hopdong']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $type_customer['id_ma_hopdong']; ?>"><?php echo $type_customer['ten_maloai_hopdong']; ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <?php } else { ?>
    <div class="field_row clearfix">
    <?php echo form_label('Loại hợp đồng :', 'customer_type'); ?>
        <div class='form_field'>
            <select name="customer_type">
                <?php foreach ($type_customers as $type_customer) { ?>
                    <option value="<?php echo $type_customer['id_ma_hopdong']; ?>"><?php echo $type_customer['ten_maloai_hopdong']; ?></option>
    <?php } ?>
            </select>
        </div>
    </div>
    <?php } ?>
<div class="field_row clearfix" id="status_module">
        <?php echo form_label('Ngày bắt đầu : ', 'employees_jobs_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
            'name' => 'date_start',
            'id' => 'date_start',
            'value' => $contract_info->date_start != '1950-01-01' ? date(get_date_format(), strtotime($contract_info->date_start != '' ? $contract_info->date_start : date('d-m-Y'))) : ''
                )
        )
        ;
        ?>
    </div>
</div>
<!--<?php $file = $this->load->Employee->get_info_contractemp($contract_info->id_employess)->labor_contract;?>
<div class="field_row clearfix"> //<?php echo form_label(lang('contract_file') . ':', 'contract_file'); ?>
            
            //<?php if($file == null){?>              
                  <div class='form_field'> <span style="font-size:0.81em;font-style:italic;font-weight: normal;line-height: 22px;">Chưa cập nhật file hợp đồng!</span> </div>
                //<?php } else{?>
                <div class='form_field'><a href="//<?php echo base_url() . 'file/' . $file->labor_contract ?>"><?php echo $file->labor_contract ?></a></div>
                //<?php }?>
            
        </div>-->

<div class="field_row clearfix" id="status_module">
        <?php echo form_label('Ngày kết thúc: ', 'employees_jobs_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
            'name' => 'date_end',
            'id' => 'date_end',
            'value' => $contract_info->date_end != '1950-01-01' ? date(get_date_format(), strtotime($contract_info->date_end != '' ? $contract_info->date_end : date('d-m-Y'))) : ''
                )
        )
        ;
        ?>
    </div>
</div>

<a href="<?php echo site_url('jobs_employee/loadRegions/' . $contact_info->jobs_employees_id) ?>" style="display: none" id="hrefview"></a>
<a href="<?php echo site_url('jobs_employee/loadCity/' . $contact_info->jobs_employees_id) ?>" style="display: none" id="showCity"></a>
<a href="<?php echo site_url('jobs_employee/loadAffiliates/' . $contact_info->jobs_employees_id) ?>" style="display: none" id="showAffiliates"></a>
<a href="<?php echo site_url('jobs_employee/loadDepartment/' . $contact_info->jobs_employees_id) ?>" style="display: none" id="showDepartment"></a>

<script type="text/javascript">
    /*
     * Th?c  hi?n load toàn b? thông tin khi ta th?c hiên ch?n select Khu v?c
     * */
    function clickSendRegions()
    {
        var url = $("#hrefview").attr('href');
        var jobs_regions_id = $("#jobs_regions_id").val();

        $.post(url, {jobs_regions_id: jobs_regions_id}, function(data, success) {
            if (success) {
                $(".action_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendCity()
    {
        var jobs_city_id = $("#jobs_city_id").val();
        var url = $("#showCity").attr('href');
        $.post(url, {jobs_city_id: jobs_city_id}, function(data, success) {
            if (success) {
                $("#city_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendAffiliates()
    {
        var jobs_affiliates_id = $("#jobs_affiliates_id").val();
        var url = $("#showAffiliates").attr('href');
        $.post(url, {jobs_affiliates_id: jobs_affiliates_id}, function(data, success) {
            if (success) {
                $("#affiliates_show").html(data);
            }
        });
    }
    /*
     * Th?c hi?n load thông tin khi ch?n thành ph?
     */
    function clickSendDepartment()
    {
        var department_id = $("#department_id").val();
        var url = $("#showDepartment").attr('href');
        $.post(url, {department_id: department_id}, function(data, success) {
            if (success) {
                $("#showEmployees").html(data);
            }
        });
    }
    /*
     *  Function th?c hiên l?y ten department trong khu v?c
     * */
    function getDepartment()
    {
        var department_id = $("#department_id").val();

        alert(department_id);
    }
</script>
<style>
    fieldset div.field_row{
        border-bottom: none;
    }

    .field_row input{
        border: none;
        width: 150px;
        height: 15px;
    }
    .field_row select{
        height: 27px;
        padding: 0;
    }
    .field_row label{
        font-family: "Helvetica";
        font-size: 13px;
        display: inline-block;
    }
    #status_module input,textarea{
        width: 220px;
    }
    #status_module select{
        width: 232px;
    }

    #status_module label{
        float: left;
        display: inline-block;
        width: 120px;
    }

    fieldset div.field_row{
        border-bottom: none;
    }

    .field_row input{
        border: none;
        width: 150px;
        height: 15px;
    }
    .field_row select{
        height: 27px;
        padding: 0;
    }
    .field_row label{
        font-family: "Helvetica";
        font-size: 13px;
        display: inline-block;
    }
    label{
        float: left;
        display: inline-block;
        width: 150px;
    }
    #jobs_name{
        float: left;
        border: 1px solid #CCC;
        height: 27px;
        width: 325px;
        background-color: #F5F5F5;
    }
    #jobs_reports_result{
        width: 50px;
    }
    #jobs_reports_name{
        width: 313px;
    }
    .field_row #radio_result{
        position: relative;
        margin-left:  190px;
        list-style: none;
    }
    .field_row #radio_result li{
        float: left;
    }
    .field_row #radio_result li span{
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        float: left;
    }
    #jobs_reports_status{
        margin-left: -58px;
    }

    #radio_result{
        list-style: none;
    }

    #radio_result li{
        margin-left: -59px;
        margin-top: 5px;
    }

</style>



