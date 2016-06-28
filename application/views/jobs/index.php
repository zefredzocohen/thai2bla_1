<?php $this->load->view("partial/header"); ?>

    <script type="text/javascript">
        $(document).ready(function()
        {
            var table_columns = ['','last_name','first_name','email','phone_number','birth_date'];
            enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
            enable_select_all();
            enable_checkboxes();
            enable_row_selection();
            enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
            enable_email('<?php echo site_url("$controller_name/mailto")?>');
            enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
            enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
        });


        function post_person_form_submit(response)
        {
            if(!response.success)
            {
                set_feedback(response.message,'error_message',true);
            }
            else
            {
                //This is an update, just update one row
                if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
                {
                    update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
                    set_feedback(response.message,'success_message',false);

                }
                else //refresh entire table
                {
                    do_search(true,function()
                    {
                        //highlight new row
                        highlight_row(response.person_id);
                        set_feedback(response.message,'success_message',false);
                    });
                }
            }
        }
    </script>

    <table id="title_bar">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
            </td>
            <td id="title">
                <?php echo lang('common_list_test').' '.lang('module_'.$controller_name); ?>
            </td>

            <td id="title_search">
                <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>

                <input type="text" name ='search' id='search'/>
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />

                </form>
            </td>
        </tr>
    </table>

    <table id="contents">
        <tr>
            <td id="commands">
                <div id="new_button">
                    <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("jobs_project",
                            $this->lang->line($controller_name.'_project_name'),
                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_project_name')));
                    }
                    ?>

                    <?php if ($this->Employee->has_module_action_permission($controller_name, 'report', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("jobs_employee",
                            $this->lang->line($controller_name.'_employees_name'),
                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_employees_name')));
                    }
                    ?>

                    <?php if ($this->Employee->has_module_action_permission($controller_name, 'jobs_end', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("jobs_report",
                            $this->lang->line($controller_name.'_report_name'),
                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_report_name')));
                    }
                    ?>

                    <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("jobs_statistic",
                            $this->lang->line($controller_name.'_statistic_name'),
                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_statistic_name')));
                    }
                    ?>
                </div>
            </td>
            <td style="width:10px;"></td>
            <td>
                <div id="item_table">
                    <div id="table_holder">
                        <?php echo $manage_table; ?>
                    </div>
                </div>
                <div id="pagination">
                    <?php echo $pagination;?>
                </div>
            </td>
        </tr>
    </table>
    <div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>