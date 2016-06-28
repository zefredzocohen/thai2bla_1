<?php $this->load->view('jobs/inc/jobs_header.php'); ?>
<div id="container">
    <div id="title_bar_new">
        <div  id="title" style="color:#fff;line-height: 47px;padding-left: 10px;">
            <?php echo lang('common_jobs_manger_insert');?>
        </div>
    </div>

    <div id="body" style="position: relative">

        <div class="field_row clearfix" id="status_module" style="display: block">

        </div>


        <div class="field_row clearfix status_module_none" id="status_module" style="height: 100px;width: 100%;display: block">
            <div class='form_field'></div>
        </div>

        <div class="field_row clearfix" id="status_module" style="display: block">
            <label style="color: #009900;font-size: 15px;padding-left: 13px;display: block;margin-top: 500px"><?php echo lang('common_jobs_name_manager_employees_label')?>:</label>
        </div>


        <div class="field_row clearfix status_module_none" id="status_module" style="height: 150px;width: 100%;display: block">
            <div class='form_field'></div>
        </div>
        <style>
            #all_show{
                margin-top: 200px;
            }
        </style>

  <div id="all_show">
        <div class="field_row clearfix" id="status_module" style="display:block">
            <?php echo form_label(lang('common_jobs_start_manager_date').':', 'jobs_status_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                        'name'=>'employees_jobs_date',
                        'id'=>'employees_jobs_date',
                        'value'=>$employees_jobs_info->jobs_start_date != '1950-01-01'? date('Y-m-d',strtotime($jobs_info->jobs_start_date != '' ? $jobs_info->jobs_start_date : date('Y-m-d'))) : ''
                    )
                )
                ;?>
            </div>
        </div>
        <div id="error"></div>
        <div class="field_row clearfix" id="status_modules" style="width: 100%;border: none;" >
            <div class='form_field'>
                <p style="display: block;margin: 10px 0"><?php echo lang('common_jobs_my_content');?> : </p>
                <?php echo form_textarea(array(
                        'name'=>'employees_jobs_content',
                        'id'=>'employees_jobs_content',
                        'class'=>'ckeditor',
                        'value'=>$employees_jobs_info->employees_jobs_content,
                    )
                );?>

            </div>
        </div>

        <div class="field_row clearfix" id="status_module" style="position: relative;bottom:10px" >
            <?php echo form_label(lang('common_jobs_file').':', 'employees_jobs_file'); ?>
            <div class='form_field' >
                <?php echo form_input(array(
                    'name'=>'employees_jobs_file',
                    'id'=>'jobs_file_url',
                    'style'=>'border:none;',
                    'type'=>'file',
                    'value'=>$employees_jobs_info->employees_jobs_file
                ));?>
            </div>
        </div>

    </div>
    <input type="hidden" value="" id="jobs_id_hidden" name="jobs_id_hidden[]" />
    <input type="hidden" value="" id="person_id_hidden" name="person_id_hidden[]" />
    <?php
    echo form_submit(array(
//            'name'=>'submit',
//            'id'=>'submit',
            'value'=>lang('common_submit'),
            'class'=>'submit_buttonss float_right')
    );
    ?>
    <button type="button" id="button" onclick="previousPage()" style="top:-50px"  class="submit_buttons float_right"><?php echo lang('common_cancer_back')?></button>
    </div><!--end div#all-->
 <?php $this->load->view('jobs/inc/jobs_footer.php'); ?>

