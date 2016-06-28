<?php $this->load->view("partial/header"); ?>
    <script type="text/javascript">
        $(document).ready(function()
        {
            var table_columns = ['','jobs_name','jobs_start_date','jobs_end_date','jobs_important'];
            enable_sorting("<?php echo site_url("$controller_name/my_sorting"); ?>",table_columns, <?php echo $per_page; ?>);
            enable_select_all();
            enable_checkboxes();
            enable_row_selection();
            enable_search('<?php echo site_url("$controller_name/my_suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
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
                if(jQuery.inArray(response.jobs_id,get_visible_checkbox_ids()) != -1)
                {
                    update_row(response.jobs_id,'<?php echo site_url("$controller_name/get_row")?>');
                    set_feedback(response.message,'success_message',false);
                }
                else //refresh entire table
                {
                    do_search(true,function()
                    {
                        //highlight new row
                        highlight_row(response.jobs_id);
                        set_feedback(response.message,'success_message',false);
                    });
                }
            }
        }
    </script>

<div id="content_area_wrapper">
<div id="content_area">
    <table id="title_bar_new" style="position: relative">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
            </td>
            <td id="title">
                <?php echo lang('module_'.$controller_name); ?>
            </td>

            <div id="right_config_number" style="position: absolute;right: 200px;top: 107px;display: none">
                <label style="font-size: 13px;display: inline-block;margin-right: 10px"><?php echo lang('common_config_number') ?>:</label>
                <?php echo form_input(array(
                    'name'=>'config_number',
                    'id'=>'config_number',
                    'value'=>'1',
                    'type'=>'',
                    'style'=>'width:40px;height:20px;text-align:center;border:1px solid yallow;color:red',
                ))?>
            </div>


            <td id="title_search_new">
                <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
                <input type="text" name ='search' id='search'/>
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
                </form>
            </td>
        </tr>
    </table>
<ul id="tab_show" style="float: left;  margin-bottom: 10px;  ">
	<div style="display:none">
    <li class="active"><a href="<?php echo base_url()?>jobs">Quản lý dự án</a></li>
    <li><a href="<?php echo base_url()?>jobs_employee">Quản lý công việc</a></li>
	</div>
    <li><a href="<?php echo base_url()?>jobs_report">Quản lý báo cáo</a></li>
	<li><a href="<?php echo base_url()?>file">Quản lý tài liệu</a></li>
</ul>



    <link href="<?php echo base_url()?>css/indexJobs.css" rel="stylesheet" type="text/css" />


<style>
    #tab_show li{
        float: left;
        list-style: none;
        border-right: 2px solid #FFF;
        cursor: pointer;
        background: CORNFLOWERBLUE;
        padding: 10px;
        color: #FFF;
        font-size: 14px;
        font-weight: bold;
    }
    #tab_show li a{
        color: #FFF;
    }
    #tab_show li a:hover{
        color: #000;
    }
    #tab_show li:hover{
        color: #000;
    }
    #tab_show li.active{
        background: #048CAD;

    }
</style>

    <table id="contents">
        <tr>

            <td id="commands">
                <div class="module_employee">
                    <h4>Công việc của tôi</h4>
                    <ul class="module_action">

                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name",
                                $this->lang->line($controller_name.'_my_index'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_my_index')));
                            //}
                            ?>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_approve",
                                $this->lang->line($controller_name.'_view_approve'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_view_approve')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_view_approve > 0) echo '('.$total_view_approve.')'; else echo '(0)'; ?></span>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_not_approve",
                                $this->lang->line($controller_name.'_view_not_approve'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_view_not_approve')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_view_not_approve > 0) echo '('.$total_view_not_approve.')'; else echo '(0)'; ?></span>
                        </li>

                        <li>
                            <?php// if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/my_view/",
                                $this->lang->line($controller_name.'_my_new'),
                                array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_my_new')));
                            // }
                            ?>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php echo anchor("jobs_project/delete",$this->lang->line("common_jobs_employee_my_delete"),array('id'=>'delete', 'class'=>'none delete_inactive')); ?>
                            <?php //} ?>

                        </li>
                    </ul>
                </div>


                <div class="module_employee">
                    <h4>Công việc được giao</h4>
                    <ul class="module_action">
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_doing",
                                $this->lang->line($controller_name.'_doing'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_doing')));
                            // }
                            ?>
                            <span class="count_number" style=""><?php if($total_rows_doing > 0) echo '('.$total_rows_doing.')'; else echo '(0)'; ?></span>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_success",
                                $this->lang->line($controller_name.'_success'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_success')));
                            // }
                            ?>
                            <span class="count_number" style=""><?php if($total_rows_success > 0) echo '('.$total_rows_success.')'; else echo '(0)'; ?></span>

                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_start",
                                $this->lang->line($controller_name.'_start'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_start')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_rows_start> 0) echo '('.$total_rows_start.')'; else echo '(0)'; ?></span>

                        </li>

                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_expired",
                                $this->lang->line($controller_name.'_expired'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_expired')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_rows_expired > 0) echo '('.$total_rows_expired.')'; else echo '(0)'; ?></span>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_near_expired",
                                $this->lang->line($controller_name.'_near_expired'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_expired')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_rows_expired > 0) echo '('.$total_rows_expired.')'; else echo '(0)'; ?></span>
                        </li>
                    </ul>
                </div>

                <div class="module_employee">
                    <h4>Công việc quản lý</h4>
                    <ul class="module_action">
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php echo anchor("$controller_name/view_manager",
                                    $this->lang->line($controller_name.'_index'),
                                    array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_index')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php // if($this->session->userdata('total_number') > 0) echo '('.$this->session->userdata('total_number').')'; else echo '(0)'; ?></span>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_manager_not_approve",
                                $this->lang->line($controller_name.'_view_manager_not_approve'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_view_manager_not_approve')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_view_manager_not_approve > 0) echo '('.$total_view_manager_not_approve.')'; else echo '(0)'; ?></span>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view_manager_approve",
                                $this->lang->line($controller_name.'_view_manager_approve'),
                                array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_view_manager_approve')));
                            //}
                            ?>
                            <span class="count_number" style=""><?php if($total_view_manager_approve > 0) echo '('.$total_view_manager_approve.')'; else echo '(0)'; ?></span>
                        </li>
                        <li>

                            <?php// if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                            <?php echo anchor("$controller_name/view/-1/width~$form_width",
                                $this->lang->line($controller_name.'_new'),
                                array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));
                            // }
                            ?>
                        </li>
                        <li>
                            <?php //if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php echo anchor("$controller_name/delete",$this->lang->line("common_jobs_employee_delete"),array('id'=>'delete', 'class'=>'none delete_inactive')); ?>
                            <?php //} ?>
                        </li>
                    </ul>
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
	</div></div>
<?php $this->load->view("partial/footer"); ?>
<link href="<?php echo base_url()?>css/indexJobs.css" rel="stylesheet" type="text/css" />