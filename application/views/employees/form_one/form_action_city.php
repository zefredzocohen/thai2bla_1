<div id="city_show">
    <p>
        <?php echo form_label(lang('common_affiliates_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='jobs_affiliates_id' id='jobs_affiliates_id'  required="" onchange="clickSendAffiliates()">
            <option value="" style="display: none">--- Chọn chi nhánh ---</option>
            <?php foreach($affiliates_info AS $key => $values): ?>
                <?php if($values->jobs_affiliates_id == $jobs_affiliates->jobs_affiliates_id ){?>
                    <option value="<?php echo $values->jobs_affiliates_id;?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->jobs_affiliates_id;?>"><?php echo $values->jobs_affiliates_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </p>
    <div id="affiliates_show">
        <p>
            <?php echo form_label(lang('common_department_name').':', 'jobs_name',array('class'=>'')); ?>
            <select name='department_id' id='department_id' required="required" onchange="clickSendDepartment()">
                <option value="" style="display: none">--- Chọn phòng ban ---</option>
                <?php foreach($department_info AS $key => $values): ?>
                    <?php if($values->department_id == $jobs_employees->department_id ){?>
                        <option value="<?php echo $values->department_id;?>" selected="selected"><?php echo $values->department_name; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values->department_id;?>"><?php echo $values->department_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </p>
    </div><!--end #affiliates_show-->
</div><!--end #city_show-->