<div id="affiliates_show">
    <div class="field_row clearfix_city" style="border: none" >
        <div class='form_field'>
            <?php echo form_label(lang('common_department_name').':', 'jobs_name',array('class'=>'')); ?>
            <select name='department_id' id='department_id' required="required" onchange="clickSendDepartment()">
                <?php foreach($department_info AS $key => $values): ?>
                    <?php if($values->department_id == $all_info->department_id ){?>
                        <option value="<?php echo $values->department_id;?>" selected="selected"><?php echo $values->department_name; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values->department_id;?>"><?php echo $values->department_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>
    <div id="showEmployees">
        <div class="field_row clearfix">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_employees_name').':', 'jobs_person_name',array('class'=>'required')); ?>
                <select name='person_id' id="jobs_person_name">
                    <?php foreach($employees_info AS $key => $values): ?>
                        <?php if($values['person_id'] == $all_info->person_id){ ?>
                            <option value="<?php echo $values['person_id'];?>" selected="selected"><?php echo $values['first_name'] ?></option>
                        <?php }else{?>
                            <option value="<?php echo $values['person_id'];?>"><?php echo $values['first_name'] ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>
    </div><!--end #showEmployees-->

</div><!--end #affiliates_show-->