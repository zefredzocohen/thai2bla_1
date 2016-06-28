<div class="field_row clearfix_affiliates" style="border: none;position: relative;left: -20px" id="status_module">
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