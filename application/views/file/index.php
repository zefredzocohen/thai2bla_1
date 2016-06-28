<?php $this->load->view("partial/header");?>
<div id="content_demo">
    <ul id="warning"></ul>
    <script type="text/javascript">
        $(document).ready(function()
        {
            enable_select_all();
            enable_checkboxes();
            enable_row_selection();
            var table_columns_status = ['','jobs_regions_name','jobs_status_id','jobs_status_show',''];
            enable_sorting("<?php echo site_url($controller_name."/sorting"); ?>",table_columns_status, <?php echo $per_page; ?>);
            enable_search('<?php echo site_url($controller_name."/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
            enable_delete(<?php echo json_encode(lang("confirm_delete_status"));?>,<?php echo json_encode(lang("none_selected"));?>);
            enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
            $("#tab_show li").click(function(){
                $('#tab_show li a').removeClass('active');
                $(this).toggleClass('active');
            });
        });

        function clickRegions(){
            var url = $('#manager_1').attr('href');
            $.post(url,{},function(data){
                $('#content_demo').html(data);
            });
        }
        function clickIndex(){
            var url = $('#manager_2').attr('href');
            $.post(url,{},function(data){
                $('#content_demo').html(data);
            });
        }

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


    <table id="title_bar_new">
        <tr>
            <td id="title_icon" style="visibility: hidden">
                <img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
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
    <li class="active"><a href="<?php echo base_url()?>jobs">Quản lý dự án</a></li>
    <li><a href="<?php echo base_url()?>jobs_employee">Quản lý công việc</a></li>
    <li><a href="<?php echo base_url()?>jobs_report">Quản lý báo cáo</a></li>
	<li><a href="<?php echo base_url()?>file">Quản lý tài liệu</a></li>
</ul>

    <table id="contents">
        <tr>
            <td id="commands">

                <div class="module_employee">
                    <h4><?php echo $this->lang->line($controller_name) ?></h4>
                    <ul class="module_action">
                        <li>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php echo anchor("$controller_name",
                                    $this->lang->line($controller_name.'_index'),
                                    array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_index')));
                            }
                            ?>
                        </li>
                        <li>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php echo anchor("$controller_name/view/-1/width~$form_width_module",
                                    $this->lang->line($controller_name.'_insert'),
                                    array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_insert')));
                            }
                            ?>
                        </li>
                        <li>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
                                <?php
                                echo anchor("$controller_name/delete",$this->lang->line($controller_name."_delete_".$controller_name),array('id'=>'delete', 'class'=>'delete_inactive'));
                                ?>
                            <?php } ?>
                        </li>
                    </ul>
                </div><!--end module status-->
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