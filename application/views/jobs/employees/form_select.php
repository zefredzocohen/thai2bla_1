<div class="field_row clearfix_city" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_affiliates_city_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='jobs_city_id' id='jobs_city_id' required="required" onclick="clickSenCity();">
            <?php foreach($city_info AS $key => $values): ?>
                <?php if($values->jobs_city_id == $jobs_affiliates->jobs_city_id ){?>
                    <option value="<?php echo $values->jobs_city_id;?>" selected="selected"><?php echo $values->jobs_city_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->jobs_city_id;?>"><?php echo $values->jobs_city_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>

<div class="field_row clearfix_affiliates" style="border:none;" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_affiliates_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='jobs_affiliates_id' >
            <?php foreach($affiliates_parent AS $key => $values): ?>
                <?php if($values->jobs_affiliates_id == $jobs_affiliates->jobs_affiliates_id ){?>
                    <option value="<?php echo $values->jobs_affiliates_id;?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->jobs_affiliates_id;?>"><?php echo $values->jobs_affiliates_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>


<div class="field_row clearfix_city" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_department_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='department_id' id='department_id' required="required" onchange="getDepartment()">
            <?php foreach($department_info AS $key => $values): ?>
                <?php if($values->department_id == $jobs_employees->department_id ){?>
                    <option value="<?php echo $values->department_id;?>" selected="selected"><?php echo $values->department_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->department_id;?>"><?php echo $values->department_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>

<div class="field_row clearfix" id="status_module" style="height: 50px">
    <div class='form_field'>
        <?php echo form_label(lang('common_jobs_employees_name').':', 'jobs_person_name',array('class'=>'required')); ?>
        <select name='jobs_person_name[]' id="jobs_person_name"  multiple="multiple" size="5" style="height: 60px;margin-bottom: 10px " >
            <?php foreach($employees_info AS $key => $values): ?>
                <?php if($values['person_id'] == $jobs_employees->person_id){ ?>
                    <option value="<?php echo $values['person_id'];?>" selected="selected"><?php echo $values['first_name'] ?></option>
                <?php }else{?>
                    <option value="<?php echo $values['person_id'];?>"><?php echo $values['first_name'] ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>