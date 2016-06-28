<div style="float:left; width: 100%">
    <fieldset id="employee_permission_info" style="color: #000; width: 100%;padding: 0; margin: 0">
        <legend><h4 style="color:red;height: 35px;line-height: 38px"><?php echo lang("employees_permission_info")." ( ". lang("employees_permission_desc"). " )"; ?></h4></legend>
        <label><p style="height:40px;line-height: 20px;display: block;margin: -4px 0 0 6px">
			 <input type="checkbox" id="select_one" style='float: left;margin-right: 7px'/><span style='margin-top: -2px;float:left;display: inline-block'> Chọn phân quyền toàn bộ cho nhân viên này. </span>
		</p></label>
		  <script>
                $(document).ready(function(){
                    // add multiple select / deselect functionality
                    $("#select_one").click(function () {
                        $('#permission_list :checkbox').attr('checked', this.checked);
                    });
                });
          </script>
		<ul id="permission_list" style="float: left;">
            <?php
            $all_modules = $this->load->Module->get_all_modules();
            foreach($all_modules->result() as $module)
            {
            	//echo 'aa';
                $checkbox_options = array(
                    'name' => 'permissions[]',
                	"id"=>"check1$module->module_id",
                    'value' => $module->module_id,
                	
                    'checked' => $this->Employee->has_module_permission($module->module_id,$person_info->person_id),
                    'class' => 'module_checkboxes'
                );

                if($current_employee_editing_self && $checkbox_options['checked'])
                {
                    $checkbox_options['disabled'] = 'disabled';
                    echo form_hidden('permissions[]', $module->module_id);
                }
                ?>
                <li style="float: left;width: 200px;height: 260px;font-family: Arial, Geneva,sans-serif;border: 1px solid #F5F5F5;">
                    
                	<?php echo form_checkbox($checkbox_options); ?>
                    <div style="font-size: 13px;font-weight: bold;width: 200px;padding-left: 18px;margin-top: -18px">
                        <span class="medium">
                         <label for="<?php echo "check1$module->module_id" ?>">
                         	&nbsp;<?php echo $this->lang->line('module_'.$module->module_id);?>:
                         </label>
                        </span>
                    </div>
                    
                    <ul style="margin-top: 10px">
                        <?php
                        foreach($this->Module_action->get_module_actions($module->module_id)->result() as $module_action)
                        {
                            $checkbox_options = array(
                                'name' => 'permissions_actions[]',
                            	"id"=>"check2$module_action->module_id",
                            	
                                'value' => $module_action->module_id."|".$module_action->action_id,
                                'checked' => $this->Employee->has_module_action_permission($module->module_id, $module_action->action_id, $person_info->person_id)
                            );

                            if($current_employee_editing_self && $checkbox_options['checked'])
                            {
                                $checkbox_options['disabled'] = 'disabled';
                                echo form_hidden('permissions_actions[]', $module_action->module_id."|".$module_action->action_id);
                            }
                            ?>
                            <li style="float: left">
                            	<label >
                                <?php echo form_checkbox($checkbox_options); ?>
                                <span class="medium" style="font-size: 12px;width: 180px;height:18px;line-height: 18px;display:block;padding-left: 25px;margin-top: -19px;">
                                	&nbsp;<?php echo $this->lang->line($module_action->action_name_key);?>
                                </span> 
                                </label>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                     
                </li>
            <?php
            }
            ?>
        </ul>
    </fieldset>
</div>
