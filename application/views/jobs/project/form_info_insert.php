<?php $this->load->view('jobs/inc/jobs_header.php'); ?>
<div id="container">
    <div id="title_bar_new">
        <div  id="title" style="color:#fff;line-height: 47px;padding-left: 10px;">
            <?php echo lang('common_project_manger_insert') ?>
        </div>
    </div>

    <div id="body">

        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_jobs_project_name').':', 'jobs_name',array('class'=>'required')); ?>
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
            <label style="color: #009900;font-size: 13px"><?php echo lang('common_jobs_name_label') ?></label>
            <ul id="radio_result">
                <li><span>  <?php echo lang('common_lang_jobs_name_find')?> </span><input type="radio" name="jobs_status" id="jobs_reports_status" value="3" onclick="hideForm()"/></li>
                <li><span style="display: inline-block;margin-left: -34px"><?php echo lang('common_lang_jobs_name_select') ?></span><input type="radio" name="jobs_status" id="jobs_reports_status" value="4" onclick="showForm()"/></li>
            </ul>
        </div>


        <div class="field_row clearfix status_module_none" id="status_module" style="height: 100px;width: 100%;display: none">

            <div class='form_field'>

            </div>
        </div>
        <div class="field_row clearfix select_jobs_parent" id="status_module" style="border: none;display: none" id="status_module">
            <div class='form_field'>
                <?php echo form_label(lang('common_jobs_project_name').':', 'jobs_name',array('class'=>'')); ?>
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
        <style>
            #status_module label{
                margin-left: -1px;
                font-size: 13px;
                font-weight: bold;
            }
        </style>

        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_start_date').':', 'jobs_status_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                        'name'=>'jobs_start_date',
                        'id'=>'jobs_start_date',
                        'value'=>$jobs_info->jobs_start_date == '' ? date('d-m-Y') : $jobs_info->jobs_start_date,
                        'required'=>'required'
                    )
                )
                ;?>
            </div>
        </div>

        <div class="field_row clearfix" id="status_module">
            <?php echo form_label(lang('common_end_date').':', 'jobs_status_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                        'name'=>'jobs_end_date',
                        'id'=>'jobs_end_date',
                        'value'=>$jobs_info->jobs_end_date == '' ? date('d-m-Y') : $jobs_info->jobs_end_date,
                        'required'=>'required'
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
                <p style="display: block;margin: 10px 0; width: 194px;"><?php echo lang('common_jobs_my_content');?> :</p>
                <?php echo form_textarea(array(
                        'name'=>'jobs_content',
                        'id'=>'jobs_content',
                        'class'=>'ckeditor',
                        'value'=>$jobs_info->jobs_content,
                    )
                );?>

            </div>
        </div>

         <div class="field_row clearfix" id="" style="position: relative;bottom:10px; height:70px !important" >
            <?php echo form_label(lang('common_jobs_file').':', 'jobs_reports_content'); ?>
			 <?php if($jobs_info->jobs_url_file == null){?>              
                  <div class='form_field' style="margin:10px 0;"> <span style="font-size:0.81em;font-style:italic;font-weight: normal;line-height: 22px;">Chưa cập nhật tài liệu!</span> </div>
                <?php } else{?>
                <div class='form_field' style="margin:10px 0;"><a href="<?php echo base_url() . 'file/project/' . $jobs_info->contract_file ?>"><?php echo $jobs_info->jobs_url_file ?></a></div>
                <?php }?>
            <div class='form_field' style="margin-left: 173px;">
                <?php echo form_input(array(
                    'name'=>'jobs_url_file',
                    'id'=>'jobs_url_file',
                    'style'=>'border:none;',
                    'type'=>'file',
                    'value'=>$jobs_info->jobs_url_file
                ));?>
            </div>
        </div>

    </div>
    <input type="hidden" value="" id="parent_id_hidden" name="parent_id_hidden" />
    <div style="width: 200px; height: 60px;position: relative;left:300px ">
        <?php
        echo form_submit(array(
                /* 'name'=>'submit',
                'id'=>'submit', */
                'value'=>lang('common_submit'),
                'class'=>'submit_buttons float_right')
        );
        ?>

        <button type="button" id="button" style="top:-50px" onclick="previousPage()" class="submit_buttons float_right"><?php echo lang('common_cancer_back')?></button>
    </div>
    <?php $this->load->view('jobs/inc/jobs_footer.php'); ?>