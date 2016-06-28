<div id="showEmployees">
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
</div><!--end #showEmployees-->