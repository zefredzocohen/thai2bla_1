<?php $this->load->view('jobs/inc/jobs_header.php'); ?>
<div id="container">
    <h1 ><?php echo lang('common_jobs_name_update');?></h1>

    <div id="body">
        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_jobs_employees_one_name').':', 'jobs_name',array('class'=>'required')); ?>
            <div class='form_field'>
                <?php echo form_input(array(
                        'name'=>'jobs_name',
                        'id'=>'jobs_name',
                        'required'=>'',
                        'value'=>$jobs_info->jobs_name)
                );?>
            </div>
        </div>
        <div id="error"></div>
        <div class="field_row clearfix" id="status_module" style="display: block">
            <label style="color: #009900;font-size: 15px"><?php echo lang('common_jobs_name_label')?>:</label>
            <ul id="radio_result">
                <li><span> <?php echo lang('common_lang_jobs_name_find')?>: </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="3" onclick="hideForm()"/></li>
                <li><span style="display: inline-block;margin-left: -62px"><?php echo lang('common_lang_jobs_name_select') ?>: </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="4" onclick="showForm()"/></li>
            </ul>
        </div>


        <div class="field_row clearfix status_module_none" id="status_module" style="height: 95px;width: 100%;display: none">

            <div class='form_field'>

            </div>
        </div>
        <div class="field_row clearfix select_jobs_parent" id="status_module" style="border: none;display: none" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_employees_one_parent').':', 'jobs_name',array('class'=>'')); ?>
                <select name='jobs_parent_id'>
                    <option value="" style="display: none"></option>
                    <?php foreach($jobs_parent AS $key => $values): ?>
                        <?php if($values->jobs_id == $jobs_info->jobs_id ){?>
                            <option value="<?php echo $values->jobs_id;?>" selected="selected"><?php echo $values->jobs_name; ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $values->jobs_id;?>"><?php echo $values->jobs_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_jobs_start_date').':', 'jobs_status_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                        'name'=>'jobs_start_date',
                        'id'=>'jobs_start_date',
                        'value'=>$jobs_info->jobs_start_date != '1950-01-01'? date('d-m-Y',strtotime($jobs_info->jobs_start_date != '' ? $jobs_info->jobs_start_date : date('Y-m-d'))) : ''
                    )
                )
                ;?>
            </div>
        </div>

        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_jobs_end_date').':', 'jobs_status_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                        'name'=>'jobs_end_date',
                        'id'=>'jobs_end_date',
                        'value'=>$jobs_info->jobs_end_date != '1950-01-01'? date('d-m-Y',strtotime($jobs_info->jobs_end_date != '' ? $jobs_info->jobs_end_date : date('Y-m-d'))) : ''
                    )
                )
                ;?>
            </div>
        </div>
        <div class="field_row clearfix" style="border: none" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_status_name').':', 'jobs_name',array('class'=>'')); ?>
                <select name='jobs_status_id'  required="required">
                    <?php foreach($jobs_status_info AS $key => $values): ?>
                        <?php if($values->jobs_status_id == $jobs_info->jobs_status_id ){?>
                            <option value="<?php echo $values->jobs_status_id;?>" selected="selected"><?php echo $values->jobs_status_name; ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $values->jobs_status_id;?>"><?php echo $values->jobs_status_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix" style="border: none" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_security_name').':', 'jobs_name',array('class'=>'')); ?>
                <select name='jobs_security_id'  required="required">
                    <?php foreach($jobs_security_info AS $key => $values): ?>
                        <?php if($values->jobs_security_id == $jobs_info->jobs_security_id ){?>
                            <option value="<?php echo $values->jobs_security_id;?>" selected="selected"><?php echo $values->jobs_security_name; ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $values->jobs_security_id;?>"><?php echo $values->jobs_security_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix" style="border: none" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_important_name').':', 'jobs_name',array('class'=>'')); ?>
                <select name='jobs_important_id'  required="required">
                    <?php foreach($jobs_important_info AS $key => $values): ?>
                        <?php if($values->jobs_important_id == $jobs_info->jobs_important ){?>
                            <option value="<?php echo $values->jobs_important_id;?>" selected="selected"><?php echo $values->jobs_important_name; ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $values->jobs_important_id;?>"><?php echo $values->jobs_important_name; ?></option>
                        <?php }endforeach; ?>
                </select>
            </div>
        </div>

        <div class="field_row clearfix" id="status_modules" style="width: 100%;border: none;" >
            <div class='form_field'>
                <p style="display: block;margin: 10px 0"><?php echo lang('common_jobs_my_content');?> : </p>
                <?php echo form_textarea(array(
                        'name'=>'jobs_content',
                        'id'=>'jobs_content',
                        'class'=>'ckeditor',
                        'value'=>$jobs_info->jobs_content,
                    )
                );?>

            </div>
        </div>

        <div class="field_row clearfix" id="status_module" style="position: relative;bottom:10px" >
            <?php echo form_label(lang('common_jobs_file').':', 'jobs_reports_content'); ?>
            <div class='form_field' >
                <?php echo form_input(array(
                    'name'=>'jobs_file_url',
                    'id'=>'jobs_file_url',
                    'style'=>'border:none;',
                    'type'=>'file',
                    'value'=>$jobs_info->jobs_url_file
                ));?>
            </div>
        </div>

    </div>
    <input type="hidden" value="" id="parent_id_hidden" name="parent_id_hidden" />
    <?php
    echo form_submit(array(
            'name'=>'submit',
            'id'=>'submit',
            'value'=>lang('common_submit'),
            'class'=>'submit_buttonss float_right')
    );

    ?>
    <button type="button" id="button" style="width: 90px;height: 40px;line-height: 40px;font-weight: bold;cursor: pointer" onclick="previousPage()"><?php echo lang('common_cancer_back')?></button>

 <?php $this->load->view('jobs/inc/jobs_footer.php'); ?>

