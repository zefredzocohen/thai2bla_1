<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function()
    {
        var table_columns = ['','jobs_name','first_name','jobs_start_date','jobs_end_date','jobs_important'];
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

<table id="title_bar_new">
    <tr>
        <td id="title_icon">
		<a href="<?php echo base_url()?>employees">
            <img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
			</a>
        </td>
        <td id="title">
            <?php echo lang('module_'.$controller_name); ?>
        </td>

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
                <h4>Báo cáo của tôi</h4>
                <ul class="module_action">
                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name",
                            $this->lang->line($controller_name.'_my_index'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_my_index')));
                        // }
                        ?>
                    </li>
                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/index_success",
                            $this->lang->line($controller_name.'_success'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_success')));
                        // }
                        ?>
                    </li>
                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/index_error",
                            $this->lang->line($controller_name.'_error'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_start')));
                        //}
                        ?>
                    </li>

                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/report/-1/width~$form_width",
                            $this->lang->line($controller_name.'_date'),
                            array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_date')));
                        //}
                        ?>
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
                        <?php echo anchor("$controller_name/delete",$this->lang->line("common_jobs_project_my_delete"),array('id'=>'delete', 'class'=>'none delete_inactive')); ?>
                        <?php //} ?>
                    </li>

                </ul>
            </div>
            <div class="module_employee">

                <?php $total_manager = $total_manager_success + $total_manager_error ; ?>

                <h4>Báo cáo quản lý</h4>
                <ul class="module_action">
                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/view_manager",
                            $this->lang->line($controller_name.'_manager_index'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_manager_index')));
                        //}
                        ?>
                        <span class="count_number" style=""><?php if($total_manager > 0) echo '('.$total_manager.')'; else echo '(0)'; ?></span>
                    </li>

                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/view_success",
                            $this->lang->line($controller_name.'_success'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_success')));
                        // }
                        ?>
                        <span class="count_number" style=""><?php if($total_manager_success > 0) echo '('.$total_manager_success.')'; else echo '(0)'; ?></span>

                    </li>
                    <li>
                        <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                        <?php echo anchor("$controller_name/view_error",
                            $this->lang->line($controller_name.'_error'),
                            array('class'=>'none new action', 'title'=>$this->lang->line($controller_name.'_start')));
                        //}
                        ?>
                        <span class="count_number" style=""><?php if($total_manager_error > 0) echo '('.$total_manager_error.')'; else echo '(0)'; ?></span>
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
<style type="text/css">
    #item_table #table_holder #sortable_table tr td a :hover{
        color: red;
        text-decoration: underline;
    }
    #commands .module_employee{
        margin-bottom: 5px;
        overflow: hidden;
        padding: 5px 0 15px 0;
        margin-top: -4px;
    }
    #commands .module_action li{
        list-style: none;
        position: relative;
        height: 30px;
    }
    #commands .module_employee h4{
        background-color: cornflowerblue;
        height: 32px;
        line-height: 32px;
        padding-left: 5px;
        color: #FFF;
        font-size: 14px;
        font-weight: bold;
    }
    #commands .module_action li .count_number{
        font-size: 11px;
        font-weight: bold;
        position: absolute;
        top: 7px;
        right: 1px;
        color:red;
    }
    #commands .module_action li{
        border: 1px solid #F5F5F5;
    }
    #commands .module_action li a{
        background: none;
        color: #333;
        display: block;
        height: 15px;
        font-size: 12px;
        margin-left: -5px;
    }
    #commands .module_action li .none:hover{
        text-decoration: underline;
    }
        /*
            Style for table
        */
    
    #contents th{
        background: cornflowerblue;
    }
    #contents tr{
        background: #F5F5F5;
    }
    #contents tr td{
        background: #FFFFFF;
    }
    #contents #item_table tr td a{
        font-size: 11px;
    }
    #contents #item_table tr td{
        font-size: 13px;
    }
    #contents #item_table tr input[type=checkbox]{
        width: 11px;
        height: 11px;
        border: 1px solid #f5f5f5;
    }
    #contents #item_table tr td{
        border-bottom: 1px dotted #D0D8DF;
        border-right: 1px solid #F1F1F1;
    }
    #contents #item_table tr:last-child td{
        border-bottom: none ;
    }
    #contents #item_table tr td:last-child{
        border-right: none ;
    }
    #pagination{
        background: #D0D8DF;
    }
</style>
